<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\Timestamp;
use Twilio\Rest\Client;
class CheckoutController extends Controller{
    public function index() {
        return view('user_view');
    }
    public function sendOtp() {
        helper(['text', 'session']);
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $phone = $this->request->getPost('phone');
        if (!$phone) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Phone number is required.']);
        }
        session()->set('name',$name);
        session()->set('email',$email);

        $otp = random_string('numeric', 6);
        session()->set('otp', $otp);
        session()->set('phone', $phone);
        session()->set('otp_time', time());
        $sid = getenv('TWILIO_SID');
        $token =getenv('TWILIO_AUTH_TOKEN');
        $from = getenv('TWILIO_PHONE_NUMBER');

        if (!$sid || !$token || !$from) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Twilio credentials not found! Check your .env file.',
            ]);
        }

        try {
            $client = new Client($sid, $token);
            $client->messages->create($phone, [
                'from' => $from,
                'body' => "Your OTP is: $otp"
            ]);

            return $this->verifyOtp();
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Twilio Error: ' . $e->getMessage(),
            ]);
        }
    }
    public function verifyOtp() {
        return view('verify_otp');
    }
    public function checkOtp() {
        $otp = $this->request->getPost('otp');
        $sessionOtp = session()->get('otp');
        $otpTime = session()->get('otp_time');
        if (!$sessionOtp || !$otpTime || (time() - $otpTime) > 300) {
            session()->remove('otp');
            session()->remove('otp_time');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'OTP expired. Please request a new one.',
            ]);
        }
        if ($otp == $sessionOtp) {
            session()->remove('otp');
            session()->remove('otp_time');
            session()->set('is_verified', true);
            return redirect()->to(base_url('payment'));
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid OTP!',
            ]);
        }
    }
}

?>
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Core\Timestamp;
use Razorpay\Api\Api;
use Config\Payment;

class PaymentController extends Controller
{
    public function __construct(){
        helper('Twiliohelper');
    }
    public function index()
    {
        return view('payment_view');
    }
    public function processPayment()
    {
        try {
            // Read JSON input
            $requestBody = file_get_contents("php://input");
            log_message('info', 'Raw Request Body: ' . $requestBody);
            $request = json_decode($requestBody, true);
            // Validate amount
            $amount = $request['amount'] ?? null;
            if (!$amount || !is_numeric($amount) || $amount < 1) { // Minimum ₹1 check
                log_message('error', 'Invalid payment request: Amount missing or below ₹1.');
                return $this->response->setJSON(['error' => 'Invalid payment amount. Minimum ₹1 required.'])
                    ->setStatusCode(400);
            }
            // Get Razorpay API Keys from Config
            $paymentConfig = new \Config\Payment();
            if (empty($paymentConfig->razorpayKeyId) || empty($paymentConfig->razorpaySecretKey)) {
                throw new \Exception('Razorpay API keys are missing in config.');
            }
            try {
                $api = new \Razorpay\Api\Api($paymentConfig->razorpayKeyId, $paymentConfig->razorpaySecretKey);
            } catch (\Exception $e) {
                log_message('error', 'Failed to initialize Razorpay API: ' . $e->getMessage());
                return $this->response->setJSON(['error' => 'Failed to initialize Razorpay', 'details' => $e->getMessage()])
                    ->setStatusCode(500);
            }
            // Create an order
            try {
                $order = $api->order->create([
                    'receipt' => uniqid(),
                    'amount' => $amount * 100, // Convert to paisa
                    'currency' => 'INR',
                    'payment_capture' => 1
                ]);
            } catch (\Exception $e) {
                log_message('error', 'Razorpay Order Creation Failed: ' . $e->getMessage());
                return $this->response->setJSON(['error' => 'Razorpay order creation failed', 'details' => $e->getMessage()])
                    ->setStatusCode(500);
            }
            return $this->response->setJSON([
                'order_id' => $order['id'],
                'amount' => $amount,
                'currency' => 'INR',
                'message' => 'Order created successfully.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Payment processing error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Payment processing failed',
                'details' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    public function confirmPayment()
    {
        try {
            $name = session()->get('name');
            $email = session()->get('email');
            $phone = session()->get('phone');
            $requestBody = file_get_contents("php://input");
            $request = json_decode($requestBody, true);
            $paymentId = $request['razorpay_payment_id'] ?? null;
            session()->set('paymentId',$paymentId);
            $amount = $request['amount'] ?? null;
            session()->set('amount',$amount);
            if (!$paymentId || !$amount) {
                return $this->response->setJSON(['error' => 'Invalid confirmation details'])->setStatusCode(400);
            }
            // Store transaction in Firestore
            $this->storeTransaction('razorpay', [
                'name'=> $name,
                'email'=>$email,
                'phone'=>$phone,
                'payment_id' => $paymentId,
                'amount' => $amount,
                'status' => 'confirmed'
            ]);
            $smsResponse = $this->success();
            return $this->response->setJSON([
            'message' => 'Payment confirmed and stored in Firestore.',
            'sms_status'=>$smsResponse ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Firestore error',
                'details' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    private function success() {
        $phone = session()->get('phone');
        $name = session()->get('name');
        $paymentid = session()->get('paymentId');
        $amount = session()->get('amount');
        if (!$phone) {
            log_message('error', 'Phone number not found in session.');
            return "Phone number not found in session.";
        }    
        $message = "Dear ". $name ." Payment successful! with transaction id ". $paymentid ." of amount ". $amount ." Thank you for your purchase.";
    
        if ($this->sendSms($phone, $message)) {
            return "Payment successful, confirmation SMS sent!";
        } else {
            return "Payment successful, but failed to send SMS.";
        }
    }
    
    
    private function storeTransaction($gateway, $data)
    {
    try {
        $keyFilePath = WRITEPATH . 'firestone-key.json';
        if (!file_exists($keyFilePath)) {
            throw new \Exception("Firestore key file not found at: " . $keyFilePath);
        }
        $firestore = new FirestoreClient([
            'keyFilePath' => $keyFilePath,
        ]);
        // Generate a unique transaction ID
        $transactionId = uniqid('txn_', true);
        $firestore->collection('transactions')->document($transactionId)->set([
            'transaction_id' => $transactionId,
            'gateway' => $gateway,
            'data' => $data,
            'timestamp' => new Timestamp(new \DateTime())
        ]);
        log_message('info', "Transaction stored successfully in Firestore with ID: $transactionId");
    } catch (\Exception $e) {
        log_message('error', 'Firestore transaction failed: ' . $e->getMessage());
    }
}
private function sendSms($phone, $message)
{
    $sid = getenv('TWILIO_SID');
    $token =getenv('TWILIO_AUTH_TOKEN');
    $from = getenv('TWILIO_PHONE_NUMBER');

    try {
        $client = new \Twilio\Rest\Client($sid, $token);
        $client->messages->create($phone, [
            'from' => $from,
            'body' => $message
        ]);
        log_message('info', "SMS sent successfully to $phone");
        return true;
    } catch (\Exception $e) {
        log_message('error', "Failed to send SMS: " . $e->getMessage());
        return false;
    }
}

}


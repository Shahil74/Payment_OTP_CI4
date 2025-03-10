# Payment-OTP-CI4

## Overview
This project is a **checkout and payment gateway integration** built using **CodeIgniter 4 (CI4)**. It includes **OTP verification via Twilio** and supports **Razorpay and Paytm** as payment gateways. The transaction details are stored in **Google Firestore**.

## Features
- **User Authentication with OTP Verification** (Twilio)
- **Payment Integration** (Razorpay & Paytm in test mode)
- **Firestore Database** for transaction storage
- **Secure Session Handling**

## Installation
### Prerequisites
- PHP 7.4+
- Composer
- CodeIgniter 4
- XAMPP (or any local server)

### Steps
1. **Clone the repository**
   ```sh
   git clone https://github.com/Shahil74/Payment-OTP-CI4.git
   cd Payment-OTP-CI4
   ```
2. **Install Dependencies**
   ```sh
   composer install
   ```
3. **Configure Environment**
   - Rename `.env.example` to `.env` and update the following values:
     ```env
     CI_ENVIRONMENT = development
     TWILIO_SID = "your_twilio_sid"
     TWILIO_AUTH_TOKEN = "your_twilio_auth_token"
     TWILIO_SERVICE_SID = "your_twilio_service_sid"
     RAZORPAY_KEY = "your_razorpay_key"
     RAZORPAY_SECRET = "your_razorpay_secret"
     FIRESTORE_PROJECT_ID = "your_firestore_project_id"
     ```

4. **Run Migrations (If required for session management)**
   ```sh
   php spark migrate
   ```

5. **Start the Server**
   ```sh
   php spark serve
   ```
   Open your browser and go to: `http://localhost:8080`

## Usage
1. **User enters details and requests an OTP**.
2. **User verifies OTP**.
3. **Redirects to the checkout page**.
4. **Selects payment method (Razorpay or Paytm) and completes the transaction**.
5. **Transaction details are stored in Firestore**.

## Routes
```php
$routes->get('/', 'PaymentController::index');
$routes->post('sendOtp', 'PaymentController::sendOtp');
$routes->get('verifyOtp', 'PaymentController::verifyOtp');
$routes->post('checkOtp', 'PaymentController::checkOtp');
$routes->get('checkout', 'PaymentController::checkout');
$routes->post('processPayment', 'PaymentController::processPayment');
$routes->post('storeTransaction', 'PaymentController::storeTransaction');
```

## Dependencies
- [CodeIgniter 4](https://codeigniter.com/)
- [Twilio SDK](https://www.twilio.com/docs/libraries/php)
- [Razorpay PHP SDK](https://razorpay.com/docs/payments/server-integration/php/)
- [Google Cloud Firestore](https://cloud.google.com/firestore/docs)

## License
This project is licensed under the **MIT License**.


<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout/send-otp', 'CheckoutController::sendOtp');
$routes->get('/checkout/verify', 'CheckoutController::verifyOtp');
$routes->post('/checkout/check-otp', 'CheckoutController::checkOtp');
$routes->get('payment', 'PaymentController::index');
$routes->post('payment/process', 'PaymentController::processPayment');
$routes->post('payment/webhook', 'PaymentController::webhook');
$routes->post('payment/confirm', 'PaymentController::confirmPayment');
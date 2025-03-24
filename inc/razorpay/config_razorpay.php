<?php
// config_razorpay.php
define('RAZORPAY_API_KEY', 'rzp_test_yVj0dg5ZvAfOiI');
define('RAZORPAY_API_SECRET', 'N2WEsuigCXtR46QCAPBPsBhb'); // Replace with your Razorpay API Key // Replace with your Razorpay API Secret
define('RAZORPAY_CALLBACK_URL', 'http://localhost/hotel-management/razorpay_response.php'); // Replace with your callback URL

function generateRazorpayOrderId($amount) {
    $api = new Razorpay\Api\Api(RAZORPAY_API_KEY, RAZORPAY_API_SECRET);

    $orderData = [
        'receipt'         => 'order_rcptid_' . time(),
        'amount'          => $amount * 100, // Amount in paise (e.g., 1000 paise = ₹10)
        'currency'        => 'INR',
        'payment_capture' => 1, // Auto capture payment
    ];

    $razorpayOrder = $api->order->create($orderData);
    return $razorpayOrder['id'];
}

function verifyRazorpayPayment($razorpayOrderId, $razorpayPaymentId, $razorpaySignature) {
    $api = new Razorpay\Api\Api(RAZORPAY_API_KEY, RAZORPAY_API_SECRET);

    try {
        $attributes = array('razorpay_order_id' => $razorpayOrderId, 'razorpay_payment_id' => $razorpayPaymentId, 'razorpay_signature' => $razorpaySignature);
        $api->utility->verifyPaymentSignature($attributes);
        return true;
    } catch (Razorpay\Api\Errors\SignatureVerificationError $e) {
        return false;
    }
}
?>
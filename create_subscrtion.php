<?php

ini_set("display_errors",1);
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type:application/json; charst= UTF-8");

require_once('../../libraries/strip/vendor/autoload.php');

// Set your Stripe API keys
$PublishableKey = "pk_test_51K7Ok1SImwf7DA0foroMnlRi3yVyjTPI9E5DrhxorvxQuGPF7yB2WU5FnwoFubbeqDQQT40hnsuVbZf6qVhSKauJ00cY5UgqbF";
$SecretKey = "sk_test_51K7Ok1SImwf7DA0fmyPO4NOhzT8h6MzeD8vDpt8PtXFpBim1ed711h2fpOeytQSZOpVmRgxwkb8ISccAB45BY9IB00ZxorWl3g";

\Stripe\Stripe::setApiKey($SecretKey);

// Create a new customer
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    try {
        $paymentMethod = \Stripe\PaymentMethod::create([
            'type' => 'card',
            'card' => [
                'number' => $data->card_number,
                'exp_month' => $data->card_exp_month,
                'exp_year' => $data->card_exp_year,
                'cvc' => $data->card_cvv,
            ]
        ]);
         // Create a new customer
         $customer = \Stripe\Customer::create([
            'email' => $data->email,
            'name' => $data->name,
            'phone' => $data->phone,
            'description' => $data->description,
            'payment_method' => $paymentMethod->id
        ]);
       
        // Create a new subscription
        $payment_intent = \Stripe\PaymentIntent::create([
            'amount' => $data->amount,
            'currency' => $data->currency,
            'payment_method' => $paymentMethod->id, // ID of the payment method to use
            'confirm' => true,
            'customer'=>$customer->id
        ]);
        $ephemeralKey = \Stripe\EphemeralKey::create([
            'customer' => $customer->id,
        ], [
          'stripe_version' => '2022-08-01',
        ]);
        echo json_encode(array(
            "Status"=>true,
            "message"=>"subscription created successfully",
            "customer"=>$customer->id,
            "payment_intent"=>$payment_intent->client_secret,
            "ephemeralKey"=>$ephemeralKey->secret,
            "publishableKey"=>$PublishableKey
        ));
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => $e->getError()->message]);
    }
};


?>

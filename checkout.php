<?php

ini_set("display_errors",1);
// Headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type:application/json; charst= UTF-8");

require_once('assets/vendor/autoload.php');

// Set your Stripe API keys
$PublishableKey = "pk_test_51K7Ok1SImwf7DA0foroMnlRi3yVyjTPI9E5DrhxorvxQuGPF7yB2WU5FnwoFubbeqDQQT40hnsuVbZf6qVhSKauJ00cY5UgqbF";
$SecretKey = "sk_test_51K7Ok1SImwf7DA0fmyPO4NOhzT8h6MzeD8vDpt8PtXFpBim1ed711h2fpOeytQSZOpVmRgxwkb8ISccAB45BY9IB00ZxorWl3g";

\Stripe\Stripe::setApiKey($SecretKey);

// Create a new customer
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $body = json_decode(file_get_contents("php://input"));
    try {
        $token = \Stripe\Token::create([
            'card' => [
              'number' => $body->card_number,
              'exp_month' => $body->card_exp_month,
              'exp_year' => $body->card_exp_year,
              'cvc' => $body->card_cvc,
            ],
          ]);
        $charge = \Stripe\Charge::create([
            'amount' => $body->amount,
            'currency' => $body->currency,
            'description' => $body->description,
            'source' => $token,
        ]);
        echo json_encode(array(
            "Status"=>true,
            "message"=>"Payment succeeded",
            "receipt"=>$charge["receipt_url"]
        ));
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => $e->getError()->message]);
    }
};


?>

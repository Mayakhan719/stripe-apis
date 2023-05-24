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
    
    try {
        $token = \Stripe\Token::create([
            'card' => [
              'number' => $_POST["number"],
              'exp_month' =>$_POST["exp_month"],
              'exp_year' =>$_POST["exp_year"],
              'cvc' =>$_POST["cvc"],
            ],
          ]);
        $charge = \Stripe\Charge::create([
            'amount' =>$_POST["amount"],
            'currency' =>$_POST["currency"],
            'description' =>$_POST["description"],
            'source' => $token,
        ]);
        header("location:Frontend.php?success=Successfully Payment done");
    } catch (\Stripe\Exception\CardException $e) {
        echo json_encode(['error' => $e->getError()->message]);
    }
};


?>

<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use Stripe\Stripe;

class PaymentController extends Controller
{
  use ResponseTrait;

  public function __construct()
  {
      Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
  }

  public function create()
  {
    try {
      $paymentIntent = \Stripe\PaymentIntent::create([
          'amount' => 100,
          'currency' => 'usd',
          'description' => 'Purchase ABC ITEM',
      ]);
      
      $response  = $this->respondCreated([
        'result' => 'success',
        'payment' => $paymentIntent
      ]);
    } catch (\Exception $e) {
      $response = $this->fail([
        'result' => 'errored',
        'error' => $e->getMessage()
      ], 400);
    }

    return $response;
  }
}
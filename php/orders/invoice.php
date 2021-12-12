<?php

  class Invoice {
    private $invoice_id;
    private $order_id;
    private $payment_method;
    private $date_of_payment;
    private $amount_to_pay;
    private $amount_paid;

    public function __construct() {

    }

    public static function create($invoice, $order_id) {
      include('../connect.php');

      $payment_method = $invoice['paymentMethod'];
      $amount_to_pay = $invoice['amountToPay'];
      $amount_paid = $invoice['amountPaid'];

      $query = "INSERT INTO invoice (order_id, payment_method, amount_to_pay, amount_paid)
                VALUES ($order_id, '$payment_method', $amount_to_pay, $amount_paid);";

      $result = mysqli_query($conn, $query);

      return $result;
    }
  }

?>
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

    public static function fetchAllValidOrders($user_id) {
      include('../connect.php');
      include('order.php');

      $query = "SELECT i.invoice_id, i.order_id, i.amount_to_pay, i.amount_paid, i.order_id
                FROM invoice i
                WHERE i.order_id IN(SELECT order_id 
                                    FROM orders 
                                    WHERE user_id = $user_id)
                ORDER BY i.order_id DESC;";
      
      $purchases = array();

      $result = mysqli_query($conn, $query);

      if(mysqli_num_rows($result) > 0) {
        while($invoice = mysqli_fetch_assoc($result)) {
          $order = new Order($invoice['order_id']);
          
          $purchase = array();
          $purchase['invoice'] = $invoice;
          $purchase['order'] = $order;

          array_push($purchases, $purchase);
        }
      }

      return $purchases;
    }
  }

?>
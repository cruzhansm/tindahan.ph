<?php

  class Voucher {
    private $voucher_id;
    private $voucher_code;
    private $voucher_type;
    private $voucher_discount;
    private $voucher_start;
    private $voucher_end;

    public static function fetchAllActiveVouchers() {
      include('../connect.php');

      $query = "SELECT *
                FROM vouchers
                WHERE NOW() < voucher_end;";

      $result = mysqli_query($conn, $query);

      $vouchers = array();

      if(mysqli_num_rows($result) > 0) {
        while($voucher = mysqli_fetch_assoc($result)) {
          array_push($vouchers, $voucher);
        }
      }
      
      return count($vouchers) > 0 ? $vouchers : false;
    }
  }

?>
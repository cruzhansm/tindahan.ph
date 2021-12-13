<?php

  include_once('./connect.php');

  session_start();

  echo $_SESSION['role'];
?>
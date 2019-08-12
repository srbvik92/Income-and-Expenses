<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
  }
  
include 'connect_db.php';

?>
<?php
session_start();
//session_destroy();
//print_r($_SESSION);

//สร้างเงื่อนไขตรวจสอบว่ามีการ login มาแล้วหรือยัง และเป็นสิทธิ์ admin หรือไม่
//ถ้าไม่มีการ login 
if(empty($_SESSION['m_level']) && empty($_SESSION['staff_id'])){
  header('Location: ../logout.php'); //ดีดออกไป
}

//เช็คว่าเป็น admin หรือไม่
if(isset($_SESSION['m_level']) && isset($_SESSION['staff_id']) && $_SESSION['m_level'] != 'admin'){
  header('Location: ../logout.php'); //ดีดออกไป
}

  include 'header_dashboard.php';
  include 'navbar.php';
  include 'sidebar_menu.php';
  include 'index_dashboard.php';
  include 'footer.php';
?>

  <!-- Preloader
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  


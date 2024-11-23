<?php
//session_start();
//session_destroy();
//print_r($_SESSION);

//สร้างเงื่อนไขตรวจสอบว่ามีการ login มาแล้วหรือยัง และเป็นสิทธิ์ admin หรือไม่
//ถ้าไม่มีการ login 
// if(empty($_SESSION['m_level']) && empty($_SESSION['staff_id'])){
//   header('Location: ../logout.php'); //ดีดออกไป
// }

// //เช็คว่าเป็น admin หรือไม่
// if(isset($_SESSION['m_level']) && isset($_SESSION['staff_id']) && $_SESSION['m_level'] != 'staff'){
//   header('Location: ../logout.php'); //ดีดออกไป
// }

  // include 'header.php';
  // include 'navbar.php';
  // include 'sidebar_menu.php';
  include 'case.php';
  // include 'footer.php';
?>


  


<?php
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขการเรียกไฟล์
  if($act=='add'){
    include 'report_form_list.php';
  }else{
    include 'report_test.php';
  }

  include 'footer.php';
?>



<?php
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขการเรียกไฟล์
  if($act=='edit'){
    include 'member_form_edit.php';
  }else if($act=='editPwd'){
    include 'member_form_edit_password.php';
  }else{
    include 'member_form_edit.php';
  }

  include 'footer.php';
?>



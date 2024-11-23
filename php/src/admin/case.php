<?php
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขการเรียกไฟล์
  if($act=='add'){
    include 'case_form_add.php';
  }else if($act=='delete'){
    include 'case_delete.php';
  }else if($act=='edit'){
    include 'case_form_edit.php';
  }else if($act=='image'){
    include 'case_form_upload_image.php';
  }else if($act=='manage'){
    include 'case_form_manage.php';
  }else{
    include 'case_list.php';
  }

  include 'footer.php';
?>



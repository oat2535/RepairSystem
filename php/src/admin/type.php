<?php 
  include 'header.php';
  include 'navbar.php';
  include 'sidebar_menu.php';

  $act = (isset($_GET['act']) ? $_GET['act'] : '');

  //สร้างเงื่อนไขในการเรียกใช้ไฟล์
  if($act == 'add'){
      include 'type_form_add.php';
  }else if($act == 'delete'){
      include 'type_delete.php';
  }else if($act == 'edit'){
        include 'type_form_edit.php';
  }else{
      include 'type_list.php';
  }

  include 'footer.php';
?>
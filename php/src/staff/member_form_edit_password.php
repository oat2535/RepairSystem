<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ฟอร์มแก้ไขรหัสผ่าน</h1>
        </div>

      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-outline card-info">

          <div class="card-body">


            <!-- form start -->
            <form action="" method="post">
              <div class="card-body">

                <div class="form-group row">
                  <label class="col-sm-2">Username</label>
                  <div class="col-sm-4">
                    <input type="text" name="username" class="form-control" value="<?php echo $memberData['username']; ?>" disabled>
                  </div>
                </div>
        
                <div class="form-group row">
                  <label class="col-sm-2">ชื่อ-สกุล</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" required placeholder="ชื่อ" value="<?php echo $memberData['title_name'] . ' '.$memberData['name'] . ' ' . $memberData['surname']; ?>" disabled>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">New Password</label>
                  <div class="col-sm-4">
                    <input type="password" name="New Password" class="form-control" required placeholder="New Password">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">Confirm Password</label>
                  <div class="col-sm-4">
                    <input type="password" name="Confirm Password" class="form-control" required placeholder="Confirm Password">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2"></label>
                  <div class="col-sm-4">
                    <button type="submit" class="btn btn-primary">แก้ไขรหัสผ่าน</button>
                    <a href="member.php" class="btn btn-danger">ยกเลิก</a>

                  </div>
                </div>
              </div>

              <!-- /.card-body -->

            </form>

            <?php
            // echo '<pre>';
            // print_r($_POST);
            // exit;
            ?>

          </div>
        </div>

      </div>
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->

<!-- ./row -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// echo '<pre>';
// print_r($_POST);
// exit;

if (isset($_SESSION['staff_id']) && isset($_POST['New_Password']) && isset($_POST['Confirm_Password'])) {


  //trigger exception in a "try" block
  try {
    // echo 'เข้ามาในเงื่อนไขได้';
    // exit;

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $New_Password = $_POST['New_Password'];
    $Confirm_Password = $_POST['Confirm_Password'];

    //สร้างเงื่อนไขตรวจสอบรหัสผ่านว่าตรงกันไหม
    if ($New_Password != $Confirm_Password) {
      //echo 'รหัสผ่านไม่ตรงกัน';
      echo '<script>
                            setTimeout(function() {
                             swal({
                                 title: "รหัสผ่านไม่ตรงกัน !!",
                                 text:"กรุณากรอกรหัสผ่านใหม่อีกครั้ง",
                                 type: "error"
                             }, function() {
                                 window.location = "member.php?act=editPwd"; //หน้าที่ต้องการให้กระโดดไป
                             });
                           }, 1000);
                       </script>';
    } else {
      //echo 'รหัสผ่านตรงกัน';
      $password = sha1($_POST['New_Password']);

      //sql update
      $stmtUpdate = $condb->prepare("UPDATE  tbl_member SET 
                                password='$password'
                                WHERE id=:id
                                ");

      //bindParam
      $stmtUpdate->bindParam(':id', $_SESSION['staff_id'], PDO::PARAM_INT);
      $result = $stmtUpdate->execute();

      $condb = null; //close connect db

      if ($result) {
        echo '<script>
                                 setTimeout(function() {
                                  swal({
                                      title: "แก้ไขรหัสผ่านสำเร็จ",
                                      type: "success"
                                  }, function() {
                                      window.location = "index.php"; //หน้าที่ต้องการให้กระโดดไป
                                  });
                                }, 1000);
                            </script>';
      } //sweet alert
    } //check password

  } //try
  //catch exception
  catch (Exception $e) {
    // echo 'Message: ' .$e->getMessage();
    // exit;
    echo '<script>
                                                     setTimeout(function() {
                                                      swal({
                                                          title: "เกิดข้อผิดพลาด",
                                                          text:"กรุณาติดต่อผู้ดูแลระบบ !!",
                                                          type: "error"
                                                      }, function() {
                                                          window.location = "member.php?act=editPwd"; //หน้าที่ต้องการให้กระโดดไป
                                                      });
                                                    }, 1000);
                                                </script>';
  } //catch          


} //isset

//window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>
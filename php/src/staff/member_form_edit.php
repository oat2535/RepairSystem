<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ฟอร์มแก้ไขโปรไฟล์</h1>
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
                  <label class="col-sm-2">สิทธิ์การใช้งาน</label>
                  <div class="col-sm-2">
                    <select name="m_level" class="form-control" disabled>
                      <option value="<?php echo $memberData['m_level']; ?>">-- <?php echo $memberData['m_level']; ?> --</option>                 
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">Username</label>
                  <div class="col-sm-4">
                    <input type="text" name="username" class="form-control" value="<?php echo $memberData['username']; ?>" required disabled>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">คำนำหน้า</label>
                  <div class="col-sm-2">
                    <select name="title_name" class="form-control" required>
                      <option value="<?php echo $memberData['title_name']; ?>">-- <?php echo $memberData['title_name']; ?> --</option>
                      <option disabled> -- เลือกข้อมูลใหม่ --</option>
                      <option value="นาย">-- นาย --</option>
                      <option value="นาง">-- นาง --</option>
                      <option value="นางสาว">-- นางสาว --</option>
                    </select>
                  </div>
                </div>


                <div class="form-group row">
                  <label class="col-sm-2">ชื่อ</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" required placeholder="ชื่อ" value="<?php echo $memberData['name']; ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">นามสกุล</label>
                  <div class="col-sm-4">
                    <input type="text" name="surname" class="form-control" required placeholder="นามสกุล" value="<?php echo $memberData['surname']; ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2"></label>
                  <div class="col-sm-4">
                   
                    
                    <button type="submit" class="btn btn-primary">บันทึก</button>
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

if (isset($_SESSION['staff_id']) && isset($_POST['name']) && isset($_POST['surname'])) {

  // echo 'เข้ามาในเงื่อนไขได้';
  // exit;

  //trigger exception in a "try" block
  try {

    //ประกาศตัวแปรรับค่าจากฟอร์ม
    $title_name = $_POST['title_name'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    
    //sql update
    $stmtUpdate = $condb->prepare("UPDATE  tbl_member SET 
                        title_name=:title_name, 
                        name=:name, 
                        surname=:surname
                        
                        WHERE id=:id
                        ");
    //bindParam
    $stmtUpdate->bindParam(':id', $_SESSION['staff_id'], PDO::PARAM_INT);
    $stmtUpdate->bindParam(':title_name', $title_name, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':name', $name, PDO::PARAM_STR);
    $stmtUpdate->bindParam(':surname', $surname, PDO::PARAM_STR);
    // $stmtUpdate->bindParam(':username', $username, PDO::PARAM_STR);
    $result = $stmtUpdate->execute();

    $condb = null; //close connect db

    if ($result) {
      echo '<script>
                                 setTimeout(function() {
                                  swal({
                                      title: "แก้ไขข้อมูลสำเร็จ",
                                      type: "success"
                                  }, function() {
                                      window.location = "member.php?act=edit"; //หน้าที่ต้องการให้กระโดดไป
                                  });
                                }, 1000);
                            </script>';
    }
  } //try
  //catch exception
  catch (Exception $e) {
    // echo 'Message: ' .$e->getMessage();
    // exit;
    echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "เกิดข้อผิดพลาด",
                                  text:"กรุณาติดต่อผู้ดูแลระบบ/Username ซ้ำ !!",
                                  type: "error"
                              }, function() {
                                  window.location = "member.php?act=edit"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
  } //catch          
} //isset
//window.location = "member.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>
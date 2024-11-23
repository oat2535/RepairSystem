<?php
if (isset($_GET['id']) && $_GET['act'] == 'edit') {

  //single row query แสดงแค่ 1 รายการ
  $stmtMemberDetail = $condb->prepare("SELECT * FROM tbl_member WHERE id=?");
  $stmtMemberDetail->execute([$_GET['id']]);
  $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

  // // echo '</pre>';
  // // print_r($row);
  // // exit;
  // echo $stmtMemberDetail->rowCount();
  // exit;


  //ถ้าคิวรี่ผิดพลาดให้หยุดการทำงาน
  if ($stmtMemberDetail->rowCount() == 0) { //คิวรี่ผิดพลาด
    echo '<script>
                        setTimeout(function() {
                        swal({
                            title: "เกิดข้อผิดพลาด",
                            type: "error"
                        }, function() {
                            window.location = "member.php?act=edit"; //หน้าที่ต้องการให้กระโดดไป
                        });
                        }, 1000);
                    </script>';
    exit;
  }
} //isset
?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>ฟอร์มแก้ไขข้อมูลพนักงาน</h1>
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
            <form action="" method="post" enctype="multipart/form-data">
              <div class="card-body">

                <div class="form-group row">
                  <label class="col-sm-2">สิทธิ์การใช้งาน</label>
                  <div class="col-sm-2">
                    <select name="m_level" class="form-control" disabled>
                      <option value="<?php echo $row['m_level']; ?>">-- <?php echo $row['m_level']; ?> --</option>
                      <!-- <option disabled>-- เลือกข้อมูลใหม่ --</option>
                      <option value="admin">-- admin --</option>
                      <option value="staff">-- staff --</option> -->
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">Username</label>
                  <div class="col-sm-4">
                    <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" disabled>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">คำนำหน้า</label>
                  <div class="col-sm-2">
                    <select name="title_name" class="form-control" required>
                      <option value="<?php echo $row['title_name']; ?>">-- <?php echo $row['title_name']; ?> --</option>
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
                    <input type="text" name="name" class="form-control" required placeholder="ชื่อ" value="<?php echo $row['name']; ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">นามสกุล</label>
                  <div class="col-sm-4">
                    <input type="text" name="surname" class="form-control" required placeholder="นามสกุล" value="<?php echo $row['surname']; ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2">ภาพโปรไฟล์</label>
                  <div class="col-sm-4">
                    ภาพเก่า <br>
                    <a data-fancybox href="../assets/product_img/<?= $row['member_image']; ?>">
                      <img src="..//assets/product_img/<?php echo $row['member_image']; ?>" width="200px">
                    </a>
                    <br><br>
                    เลือกภาพใหม่
                    <br>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="member_image" class="custom-file-input" id="exampleInputFile" accept="image/*">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
                </div>
                <script>
                  document.getElementById('exampleInputFile').addEventListener('change', function() {
                    var fileName = this.files[0] ? this.files[0].name : 'Choose file';
                    var label = this.nextElementSibling;
                    label.textContent = fileName;
                  });
                </script>
                <div class="form-group row">
                  <label class="col-sm-2"></label>
                  <div class="col-sm-4">
                    <input type="hidden" name="m_level" value="<?php echo $row['m_level']; ?>">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="oldImg" value="<?php echo $row['member_image']; ?>">
                    <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
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
            // echo '<hr>';
            // print_r($_FILES);
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
if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['surname'])) {

  // echo 'เข้ามาในเงื่อนไขได้';
  // exit;

  //trigger exception in a "try" block
  try {
    //ประกาศตัวแปรรับค่าจาก Form
    $id = $_POST['id'];
    $username = $_POST['username'];
    $title_name = $_POST['title_name'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $m_level = $_POST['m_level'];
    $upload = $_FILES['member_image']['name'];

    //สร้างเงื่อนไขตรวจสอบการอัพโหลดไฟล์
    if ($upload == '') {
      //sql update ไม่มีการอัพโหลดไฟล์
      $stmtMemberUpdate = $condb->prepare("UPDATE tbl_member SET 
        title_name=:title_name, 
        name=:name, 
        surname=:surname,
        m_level=:m_level                     
        WHERE id=:id              
    ");
      //bindParam
      $stmtMemberUpdate->bindParam(':id', $id, PDO::PARAM_INT);
      $stmtMemberUpdate->bindParam(':title_name', $title_name, PDO::PARAM_STR);
      $stmtMemberUpdate->bindParam(':name', $name, PDO::PARAM_STR);
      $stmtMemberUpdate->bindParam(':surname', $surname, PDO::PARAM_STR);
      $stmtMemberUpdate->bindParam(':m_level', $m_level, PDO::PARAM_STR);
      $result = $stmtMemberUpdate->execute();


      if ($result) {
        echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",
            type: "success"
        }, function() {
            window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
        });
        }, 1000);
    </script>';
      } //if

    } else {
      // echo 'มีการอัพโหลดไฟล์ใหม่';
      //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
      $date1 = date("Ymd_His");
      //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
      $numrand = (mt_rand());
      $member_image = (isset($_POST['member_image']) ? $_POST['member_image'] : '');

      //ตัดขื่อเอาเฉพาะนามสกุล
      $typefile = strrchr($_FILES['member_image']['name'], ".");

      //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
      if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {
        // echo 'อัพโหลดไฟล์ไม่ถูกต้อง';
        // exit;


        //ลบภาพเก่า
        if ($row['member_image'] !== 'avatar-4.jpg') {
          unlink('../assets/product_img/' . $row['member_image']);
      }

        //โฟลเดอร์ที่เก็บไฟล์
        $path = "../assets/product_img/";
        //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
        $newname = $numrand . $date1 . $typefile;
        $path_copy = $path . $newname;
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['member_image']['tmp_name'], $path_copy);

        //sql update with upload file
        $stmtMemberUpdate = $condb->prepare("UPDATE tbl_member SET 
            title_name=:title_name, 
            name=:name, 
            surname=:surname,
            m_level=:m_level,
            member_image=:member_image
            WHERE id=:id
                  
        ");

        //bindParam
        $stmtMemberUpdate->bindParam(':id', $id, PDO::PARAM_INT);
        $stmtMemberUpdate->bindParam(':title_name', $title_name, PDO::PARAM_STR);
        $stmtMemberUpdate->bindParam(':name', $name, PDO::PARAM_STR);
        $stmtMemberUpdate->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmtMemberUpdate->bindParam(':m_level', $m_level, PDO::PARAM_STR);
        $stmtMemberUpdate->bindParam(':member_image', $newname, PDO::PARAM_STR);
        $result = $stmtMemberUpdate->execute();

        if ($result) {
          echo '<script>
                  setTimeout(function() {
                  swal({
                      title: "บันทึกข้อมูลสำเร็จ",
                      type: "success"
                  }, function() {
                      window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
                  });
                  }, 1000);
              </script>';
        } //if
      } else { //อัพโหลดไฟล์ไม่ถูกต้อง
        echo '<script>
              setTimeout(function() {
              swal({
                  title: "คุณอัพโหลดไฟล์ไม่ถูกต้อง",
                  type: "error"
              }, function() {
                  window.location = "member.php?id=' . $id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
              });
              }, 1000);
          </script>';
        //exit;
      } //อัพโหลดไฟล์ที่อนุญาติ
    } //else ไม่มีการอัพโหลดไฟล์
  } //try
  //catch exception
  catch (Exception $e) {
    echo 'Message: ' .$e->getMessage();
    echo '<script>
setTimeout(function() {
swal({
    title: "เกิดข้อผิดพลาด",
    type: "error"
}, function() {
    window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
});
}, 1000);
</script>';
  } //catch  
} // isset
?>
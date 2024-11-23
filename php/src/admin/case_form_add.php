  <?php

  //คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว
  $memberdetail = $condb->prepare("SELECT * FROM tbl_member WHERE id=:id");

  //bindParam
  $memberdetail->bindParam(':id', $_SESSION['staff_id'], PDO::PARAM_INT);
  $memberdetail->execute();
  $memberData = $memberdetail->fetch(PDO::FETCH_ASSOC);


  //คิวรี่ข้อมูลประเภทงานซ่อม
  $queryType = $condb->prepare("SELECT * FROM tbl_type");
  $queryType->execute();
  $rsType = $queryType->fetchAll();

  //คิวรี่ข้อมูลสาขา
  $queryBranch = $condb->prepare("SELECT * FROM tbl_branch");
  $queryBranch->execute();
  $rsBranch = $queryBranch->fetchAll();

  //คิวรี่ข้อมูลสมาชิก
  $queryMember = $condb->prepare("SELECT * FROM tbl_member");
  $queryMember->execute();
  $rsMember = $queryMember->fetchAll();

  // //คิวรี่ข้อมูลสาขา
  // $queryStatus = $condb->prepare("SELECT * FROM tbl_status");
  // $queryStatus->execute();
  // $rsStatus = $queryStatus->fetchAll();

  ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มเพิ่มข้อมูลแจ้งซ่อม</h1>
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
                    <label class="col-sm-2">ประเภทงาน</label>
                    <div class="col-sm-2">
                      <select name="ref_type_id" class="form-control" required>
                        <option value="">-- เลือกข้อมูล --</option>
                        <?php foreach ($rsType as $row) { ?>
                          <option value="<?php echo $row['type_id']; ?>">-- <?php echo $row['type_name']; ?> --</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">สาขา</label>
                    <div class="col-sm-2">
                      <select name="ref_branch_id" class="form-control" required>
                        <option value="">-- เลือกข้อมูล --</option>
                        <?php foreach ($rsBranch as $row) { ?>
                          <option value="<?php echo $row['branch_id']; ?>">-- <?php echo $row['branch_name']; ?> --</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ชื่อผู้แจ้งซ่อม</label>
                    <div class="col-sm-4">
                      <input type="text" name="employee_name" class="form-control" required placeholder="ชื่อผู้แจ้งซ่อม">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">เบอร์โทร</label>
                    <div class="col-sm-4">
                      <input type="text" name="mobile" class="form-control" required placeholder="เบอร์โทร">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">รายละเอียดปัญหา</label>
                    <div class="col-sm-4">
                      <textarea name="case_detail" id="case_detail" class="form-control"> </textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">สถานที่</label>
                    <div class="col-sm-4">
                      <textarea name="place_detail" id="place_detail" class="form-control"> </textarea>
                    </div>
                  </div>


                  <div class="form-group row">
                    <label class="col-sm-2">IP Address</label>
                    <div class="col-sm-4">
                      <input type="text" name="ip_address" class="form-control" required placeholder="Ex. 192.168.xx.xx">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ชื่อเครื่อง</label>
                    <div class="col-sm-4">
                      <input type="text" name="computer_name" class="form-control" placeholder="ชื่อเครื่อง" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ภาพปัญหา</label>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="case_image" class="custom-file-input" required id="exampleInputFile" accept="image/*">
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
                      <input type="hidden" name="username" value="<?php echo $memberData['username']; ?>">
                      <button type="submit" class="btn btn-primary">บันทึก</button>
                      <a href="case.php" class="btn btn-danger">ยกเลิก</a>

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


  if (isset($_POST['employee_name']) && isset($_POST['ref_type_id']) && isset($_POST['computer_name'])) {
    //echo'ถูกเงื่อนไข ส่งข้อมูลมาได้';

    //trigger exception in a "try" block
    try {

      //ประกาศตัวแปรรับค่าจาก Form
      $ref_type_id = $_POST['ref_type_id'];
      $ref_branch_id = $_POST['ref_branch_id'];
      $employee_name = $_POST['employee_name'];
      $mobile = $_POST['mobile'];
      $case_detail = $_POST['case_detail'];
      $ip_address = $_POST['ip_address'];
      $computer_name = $_POST['computer_name'];
      $username = $_POST['username'];
      $place_detail = $_POST['place_detail'];

      //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
      $date1 = date("Ymd_His");
      //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
      $numrand = (mt_rand());
      $case_image = (isset($_POST['case_image']) ? $_POST['case_image'] : '');
      $upload = $_FILES['case_image']['name'];

      //มีการอัพโหลดไฟล์
      if ($upload != '') {
        //ตัดขื่อเอาเฉพาะนามสกุล
        $typefile = strrchr($_FILES['case_image']['name'], ".");

        //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
        if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {

          //โฟลเดอร์ที่เก็บไฟล์
          $path = "../assets/product_img/";
          //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
          $newname = $numrand . $date1 . $typefile;
          $path_copy = $path . $newname;
          //คัดลอกไฟล์ไปยังโฟลเดอร์
          move_uploaded_file($_FILES['case_image']['tmp_name'], $path_copy);


          //sql insert
          $stmtInsertCase = $condb->prepare("INSERT INTO tbl_case 
                    (
                        ref_type_id,
                        ref_branch_id,
                        employee_name,
                        mobile,
                        case_detail, 
                        ip_address,                       
                        computer_name,
                        create_username,
                        place_detail,
                        case_image
                    )
                    VALUES 
                    (
                        :ref_type_id,
                        :ref_branch_id,
                        :employee_name,
                        :mobile,
                        :case_detail, 
                        :ip_address,
                        :computer_name,
                        :username,
                        :place_detail,
                        '$newname'
                    )
                    ");

          //bindParam
          $stmtInsertCase->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
          $stmtInsertCase->bindParam(':ref_branch_id', $ref_branch_id, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':mobile', $mobile, PDO::PARAM_INT);
          $stmtInsertCase->bindParam(':case_detail', $case_detail, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':computer_name', $computer_name, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':username', $username, PDO::PARAM_STR);
          $stmtInsertCase->bindParam(':place_detail', $place_detail, PDO::PARAM_STR);

          $result = $stmtInsertCase->execute();

          // echo '<pre>';
          //     print_r($result);

          $condb = null; //close connect db

          //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
          if ($result) {
            echo '<script>
                            setTimeout(function() {
                            swal({
                                title: "เพิ่มข้อมูลสำเร็จ",
                                type: "success"
                            }, function() {
                                window.location = "case.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
          } //if
        } else { //ถ้าไฟล์ที่อัพโหลดไม่ตรงตามที่กำหนด
          echo '<script>
                                    setTimeout(function() {
                                    swal({
                                        title: "คุณอัพโหลดไฟล์ไม่ถูกต้อง",
                                        type: "error"
                                    }, function() {
                                        window.location = "case.php"; //หน้าที่ต้องการให้กระโดดไป
                                    });
                                    }, 1000);
                                </script>';
        } //else ของเช็คนามสกุลไฟล์
      } // if($upload !='') {
    } //try
    //catch exception
    catch (Exception $e) {
      // echo 'Message: ' . $e->getMessage();
      // exit;
      echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "เกิดข้อผิดพลาด",
                          type: "error"
                      }, function() {
                          window.location = "case.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
    } //catch
  } // isset
  ?>
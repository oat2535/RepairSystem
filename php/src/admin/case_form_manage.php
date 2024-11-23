  <?php

    $currentUser = isset($_SESSION['staff_id']) ? $_SESSION['staff_id'] : null; // ดึงค่าจากเซสชัน

    //คิวรี่รายละเอียดสินค้า single row
    $stmtCaseDetail = $condb->prepare("SELECT c.*, t.type_name, s.status_name, m.name, m.surname
    FROM tbl_case as c
    LEFT JOIN tbl_type as t ON c.ref_type_id = t.type_id
    LEFT JOIN tbl_status as s ON c.ref_status_id = s.status_id
    LEFT JOIN tbl_member as m ON c.assign_name = m.username
    WHERE c.id=:id");
    //bindParam
    $stmtCaseDetail->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtCaseDetail->execute();
    $rowcase = $stmtCaseDetail->fetch(PDO::FETCH_ASSOC);

    // echo '</pre>';
    // print_r($rowcase);
    // exit;
    // echo $stmtCaseDetail->rowCount();
    // exit;
    //     echo "ID: " . $_GET['id'];  // ตรวจสอบค่าที่ส่งมา
    // print_r($rowcase);  // ดูผลลัพธ์ของการดึงข้อมูล

    //สร้างเงื่อนไขการตรวจสอบคิวรี่
    if ($stmtCaseDetail->rowCount() == 0) { //คิวรี่ผิดพลาด
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
        exit;
    }
      //คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว
  $memberdetail = $condb->prepare("SELECT * FROM tbl_member WHERE id=:id");

  //bindParam
  $memberdetail->bindParam(':id', $_SESSION['staff_id'], PDO::PARAM_INT);
  $memberdetail->execute();
  $memberdata = $memberdetail->fetch(PDO::FETCH_ASSOC);

    //คิวรี่ข้อมูลเจ้าหน้าที่ Admin
    $queryAssign = $condb->prepare("SELECT * FROM tbl_member WHERE m_level='admin'");
    $queryAssign->execute();
    $rsAssign = $queryAssign->fetchAll();

    //คิวรี่ข้อมูลหมวดหมู่สินค้า
    $queryType = $condb->prepare("SELECT * FROM tbl_type");
    $queryType->execute();
    $rsType = $queryType->fetchAll();

    //คิวรี่ข้อมูลสาขา
    $queryBranch = $condb->prepare("SELECT * FROM tbl_branch");
    $queryBranch->execute();
    $rsBranch = $queryBranch->fetchAll();

    //คิวรี่ข้อมูลสาขา
    $queryStatus = $condb->prepare("SELECT * FROM tbl_status");
    $queryStatus->execute();
    $rsStatus = $queryStatus->fetchAll();

    // ตรวจสอบสถานะจากข้อมูล
$isCancelled = $rowcase['ref_status_id'] == '4'; // เปลี่ยนค่า 'your_cancelled_status_id' ให้ตรงกับค่าในฐานข้อมูลของสถานะ 'ยกเลิก'
    ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>ฟอร์มแก้ไขข้อมูลแจ้งซ่อม</h1>
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
                                      <!-- ประเภทงานซ่อม -->
                                      <label class="col-sm-2">ประเภทงานซ่อม</label>
                                      <div class="col-sm-3">
                                          <select name="ref_type_id" class="form-control" disabled>
                                              <option value="<?php echo $rowcase['ref_type_id']; ?>">-- <?php echo $rowcase['type_name']; ?> --</option>
                                              <option disabled>-- เลือกข้อมูลใหม่ --</option>
                                              <?php foreach ($rsType as $row) { ?>
                                                  <option value="<?php echo $row['type_id']; ?>">-- <?php echo $row['type_name']; ?> --</option>
                                              <?php } ?>
                                          </select>
                                      </div>

                                      <!-- สถานะล่าสุด -->
                                      <label class="col-sm-3 text-right">สถานะล่าสุด</label>
                                      <div class="col-sm-3">
                                          <select name="ref_status_id" class="form-control">
                                              <option value="<?php echo $rowcase['ref_status_id']; ?>">-- <?php echo $rowcase['status_name']; ?> --</option>
                                              <option disabled>-- เลือกสถานะ --</option>
                                              <?php foreach ($rsStatus as $row) { ?>
                                                  <option value="<?php echo $row['status_id']; ?>">-- <?php echo $row['status_name']; ?> --</option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <!-- สาขา -->
                                      <label class="col-sm-2">สาขา</label>
                                      <div class="col-sm-3">
                                          <select name="ref_branch_id" class="form-control" disabled>
                                              <option disabled>-- เลือกข้อมูล --</option>
                                              <?php foreach ($rsBranch as $row) { ?>
                                                  <option value="<?php echo $row['branch_id']; ?>">-- <?php echo $row['branch_name']; ?> --</option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                      <!-- ช่องบันทึกการอัพเดทงานซ่อม -->
                                      <label class="col-sm-3 text-right">Assign to</label>
                                      <!-- แสดง assign_name เป็น input ที่ไม่สามารถแก้ไขได้หากอยู่ในสถานะที่กำหนด -->

                                      <div class="col-sm-4">
                                          <select name="assign_name" class="form-control" required>
                                              <option value="<?php echo $rowcase['assign_name']; ?>">-- <?php echo $rowcase['name'] . ' ' . $rowcase['surname'];  ?> --</option>
                                              <option value="">-- เลือกข้อมูล --</option>
                                              <?php foreach ($rsAssign as $row) { ?>
                                                  <option value="<?php echo $row['username']; ?>">-- <?php echo $row['name'] . ' ' . $row['surname']; ?> --</option>
                                              <?php } ?>
                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ชื่อผู้แจ้งซ่อม</label>
                                      <div class="col-sm-3">
                                          <input type="text" name="employee_name" class="form-control" value="<?php echo $rowcase['employee_name']; ?>" disabled>
                                      </div>
                                      <!-- ช่องบันทึกการอัพเดทงานซ่อม -->
                                      <label class="col-sm-3 text-right">บันทึกการอัพเดทงานซ่อม</label>
                                      <div class="col-sm-4">
                                          <textarea name="update_note" class="form-control" placeholder="บันทึกข้อมูลเพิ่มเติม"><?php echo $rowcase['update_note']; ?></textarea>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">เบอร์โทร</label>
                                      <div class="col-sm-3">
                                          <input type="text" name="mobile" class="form-control" required placeholder="เบอร์โทร" value="<?php echo $rowcase['mobile']; ?>" disabled>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">รายละเอียดปัญหา</label>
                                      <div class="col-sm-4">
                                          <textarea disabled name="case_detail" id="case_detail" class="form-control"><?php echo $rowcase['case_detail']; ?></textarea>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">สถานที่</label>
                                      <div class="col-sm-4">
                                          <textarea disabled name="place_detail" id="place_detail" class="form-control"><?php echo $rowcase['place_detail']; ?></textarea>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">IP Address</label>
                                      <div class="col-sm-3">
                                          <input type="text" name="ip_address" class="form-control" value="<?php echo $rowcase['ip_address']; ?>" disabled>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ชื่อเครื่อง</label>
                                      <div class="col-sm-3">
                                          <input type="text" name="computer_name" class="form-control" value="<?php echo $rowcase['computer_name']; ?>" disabled>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ภาพประกอบ</label>
                                      <div class="col-sm-4">
                                          <a data-fancybox href="../assets/product_img/<?= $rowcase['case_image']; ?>">
                                              <img src="..//assets/product_img/<?php echo $rowcase['case_image']; ?>" width="200px">
                                          </a>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2"></label>
                                      <div class="col-sm-4">
                                          <input type="hidden" name="id" value="<?php echo $rowcase['id']; ?>">
                                          <input type="hidden" name="ref_type_id" value="<?php echo $rowcase['ref_type_id']; ?>">
                                          <input type="hidden" name="employee_name" value="<?php echo $rowcase['employee_name']; ?>">
                                          <input type="hidden" name="mobile" value="<?php echo $rowcase['mobile']; ?>">
                                          <input type="hidden" name="case_detail" value="<?php echo $rowcase['case_detail']; ?>">
                                          <input type="hidden" name="ip_address" value="<?php echo $rowcase['ip_address']; ?>">
                                          <input type="hidden" name="computer_name" value="<?php echo $rowcase['computer_name']; ?>">
                                          <input type="hidden" name="case_image" value="<?php echo $rowcase['case_image']; ?>">
                                          <input type="hidden" name="ref_branch_id" value="<?php echo $rowcase['ref_branch_id']; ?>">
                                          <input type="hidden" name="place_detail" value="<?php echo $rowcase['place_detail']; ?>">
                                          <input type="hidden" name="cancel_name" value="<?php echo $memberdata['username']; ?>">
                                          <button type="submit" class="btn btn-primary">บันทึก</button>
                                          <a href="case.php" class="btn btn-danger">ยกเลิก</a>

                                      </div>
                                  </div>
                                  <script>
                                      document.getElementById('exampleInputFile').addEventListener('change', function() {
                                          var fileName = this.files[0] ? this.files[0].name : 'Choose file';
                                          var label = this.nextElementSibling;
                                          label.textContent = fileName;
                                      });
                                  </script>
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
    // เช็ค Input ที่ส่งมาจาก Form
    // echo '<pre>';
    // print_r($_POST);
    //  exit;

    if (isset($_POST['employee_name']) && isset($_POST['ref_type_id']) && isset($_POST['computer_name'])) {
        //echo'ถูกเงื่อนไข ส่งข้อมูลมาได้';

        //trigger exception in a "try" block
        try {


            //ประกาศตัวแปรรับค่าจาก Form
            $ref_type_id = $_POST['ref_type_id'];
            $employee_name = $_POST['employee_name'];
            $case_detail = $_POST['case_detail'];
            $ip_address = $_POST['ip_address'];
            $computer_name = $_POST['computer_name'];
            $id = $_POST['id'];
            $ref_status_id = $_POST['ref_status_id'];
            $update_note = $_POST['update_note'];
            $place_detail = $_POST['place_detail'];
            $assign_name = $_POST['assign_name'];
            if ($_POST['ref_status_id'] == 4) {
                $cancel_name = $_POST['cancel_name']; // บันทึกชื่อผู้ที่เปลี่ยนสถานะเป็น 'ยกเลิก'
            }

                $stmtUpdateCase = $condb->prepare("UPDATE tbl_case SET 
                ref_type_id=:ref_type_id,
                employee_name=:employee_name,
                case_detail=:case_detail,
                ip_address=:ip_address,
                computer_name=:computer_name,
                ref_status_id=:ref_status_id,
                update_note=:update_note,
                assign_name=:assign_name,
                cancel_name=:cancel_name
                WHERE id=:id
                      
            ");

                //bindParam
                $stmtUpdateCase->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtUpdateCase->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
                $stmtUpdateCase->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':case_detail', $case_detail, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':computer_name', $computer_name, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':ref_status_id', $ref_status_id, PDO::PARAM_INT);
                $stmtUpdateCase->bindParam(':update_note', $update_note, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':assign_name', $assign_name, PDO::PARAM_STR);
                $stmtUpdateCase->bindParam(':cancel_name', $cancel_name, PDO::PARAM_STR);
                $result = $stmtUpdateCase->execute();

                if ($result) {
                    echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "บันทึกข้อมูลสำเร็จ",
                        type: "success"
                    }, function() {
                        window.location = "case.php"; //หน้าที่ต้องการให้กระโดดไป
                    });
                    }, 1000);
                </script>';
                } else{ //if
                // echo 'มีการอัพโหลดไฟล์ใหม่';
                //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
                $date1 = date("Ymd_His");
                //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
                $numrand = (mt_rand());
                $case_image = (isset($_POST['case_image']) ? $_POST['case_image'] : '');

                //ตัดขื่อเอาเฉพาะนามสกุล
                $typefile = strrchr($_FILES['case_image']['name'], ".");

                //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
                if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {
                    // echo 'อัพโหลดไฟล์ไม่ถูกต้อง';
                    // exit;


                    //ลบภาพเก่า
                    unlink('..//assets/product_img/' . $_POST['case_image']);

                    //โฟลเดอร์ที่เก็บไฟล์
                    $path = "../assets/product_img/";
                    //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                    $newname = $numrand . $date1 . $typefile;
                    $path_copy = $path . $newname;
                    //คัดลอกไฟล์ไปยังโฟลเดอร์
                    move_uploaded_file($_FILES['case_image']['tmp_name'], $path_copy);

                    //sql update with upload file
                    $stmtUpdateCase = $condb->prepare("UPDATE tbl_case SET 
                    ref_type_id=:ref_type_id,
                    employee_name=:employee_name,
                    case_detail=:case_detail,
                    ip_address=:ip_address,
                    computer_name=:computer_name,
                    update_note=:update_note,
                    ref_status_id=:ref_status_id,
                    assign_name=:assign_name,
                    cancel_name=:cancel_name
                    WHERE id=:id
                          
                ");

                    //bindParam
                    $stmtUpdateCase->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtUpdateCase->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
                    $stmtUpdateCase->bindParam(':employee_name', $employee_name, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':case_detail', $case_detail, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':ip_address', $ip_address, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':computer_name', $computer_name, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':ref_status_id', $ref_status_id, PDO::PARAM_INT);
                    $stmtUpdateCase->bindParam(':update_note', $update_note, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':assign_name', $assign_name, PDO::PARAM_STR);
                    $stmtUpdateCase->bindParam(':cancel_name', $cancel_name, PDO::PARAM_STR);
                    $result = $stmtUpdateCase->execute();

                    if ($result) {
                        echo '<script>
                                setTimeout(function() {
                                swal({
                                    title: "บันทึกข้อมูลสำเร็จ",
                                    type: "success"
                                }, function() {
                                    window.location = "case.php"; //หน้าที่ต้องการให้กระโดดไป
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
                                window.location = "case.php?id=' . $id . '&act=manage"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
                    //exit;
                } //อัพโหลดไฟล์ที่อนุญาติ
            } //else ไม่มีการอัพโหลดไฟล์
        } //try
        //catch exception
        catch (Exception $e) {
            // echo 'Message: ' .$e->getMessage();
            // exit;
            echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  type: "error"
              }, function() {
                  window.location = "case.php?id=' . $id . '&act=manage"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
        } //catch 
    } // isset

// เช็ค Input ที่ส่งมาจาก Form
// echo '<pre>';
// print_r($stmtUpdateCase->errorInfo()); // ดูรายละเอียดของ error (ถ้ามี)
// print_r($result);
// exit;
    ?>
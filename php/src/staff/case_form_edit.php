  <?php

    //คิวรี่รายละเอียดสินค้า single row
    $stmtProductDetail = $condb->prepare("
    SELECT p.*, t.type_name
    FROM tbl_product as p
    INNER JOIN tbl_type t ON p.ref_type_id = t.type_id
    WHERE p.id=:id");


    //bindParam
    $stmtProductDetail->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtProductDetail->execute();
    $rowProduct = $stmtProductDetail->fetch(PDO::FETCH_ASSOC);

    // echo '</pre>';
    // print_r($rowProduct);
    // exit;
    // echo $stmtProductDetail->rowCount();
    // exit;
    // echo $stmtProductDetail->rowCount();
    // exit;


    //สร้างเงื่อนไขการตรวจสอบคิวรี่
    if ($stmtProductDetail->rowCount() == 0) { //คิวรี่ผิดพลาด
        echo '<script>
                            setTimeout(function() {
                            swal({
                                title: "เกิดข้อผิดพลาด",
                                type: "error"
                            }, function() {
                                window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
        exit;
    }

    //คิวรี่ข้อมูลหมวดหมู่สินค้า
    $queryType = $condb->prepare("SELECT * FROM tbl_type");
    $queryType->execute();
    $rsType = $queryType->fetchAll();
    ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          <div class="container-fluid">
              <div class="row mb-2">
                  <div class="col-sm-6">
                      <h1>ฟอร์มแก้ไขข้อมูลสินค้า</h1>
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
                                      <label class="col-sm-2">หมวดหมู่สินค้า</label>
                                      <div class="col-sm-2">
                                          <select name="ref_type_id" class="form-control" required>
                                              <option value="<?php echo $rowProduct['ref_type_id']; ?>">-- <?php echo $rowProduct['type_name']; ?> --</option>
                                              <option disabled>-- เลือกข้อมูลใหม่ --</option>


                                              <?php foreach ($rsType as $row) { ?>
                                                  <option value="<?php echo $row['type_id']; ?>">-- <?php echo $row['type_name']; ?> --</option>
                                              <?php } ?>

                                          </select>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ชื่อสินค้า</label>
                                      <div class="col-sm-7">
                                          <input type="text" name="product_name" class="form-control" required placeholder="ชื่อสินค้า" value="<?php echo $rowProduct['product_name']; ?>">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">รายละเอียดสินค้า</label>
                                      <div class="col-sm-10">
                                          <textarea name="product_detail" id="summernote"><?php echo $rowProduct['product_detail']; ?></textarea>
                                      </div>
                                  </div>


                                  <div class="form-group row">
                                      <label class="col-sm-2">จำนวนสินค้า</label>
                                      <div class="col-sm-4">
                                          <input type="number" name="product_qty" class="form-control" min="0" max="999" value="<?php echo $rowProduct['product_qty']; ?>">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ราคาสินค้า</label>
                                      <div class="col-sm-4">
                                          <input type="number" name="product_price" class="form-control" min="0" max="999999" value="<?php echo $rowProduct['product_price']; ?>">
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2">ภาพสินค้า</label>
                                      <div class="col-sm-4">
                                          ภาพเก่า <br>
                                          <img src="..//assets/product_img/<?php echo $rowProduct['product_image']; ?>" width="200px">
                                          <br><br>
                                          เลือกภาพใหม่
                                          <br>
                                          <div class="input-group">
                                              <div class="custom-file">
                                                  <input type="file" name="product_image" class="custom-file-input" id="exampleInputFile" accept="image/*">
                                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                              </div>
                                              <div class="input-group-append">
                                                  <span class="input-group-text">Upload</span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group row">
                                      <label class="col-sm-2"></label>
                                      <div class="col-sm-4">
                                          <input type="hidden" name="id" value="<?php echo $rowProduct['id']; ?>">
                                          <input type="hidden" name="oldImg" value="<?php echo $rowProduct['product_image']; ?>">
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
    //เช็ค Input ที่ส่งมาจาก Form
    // echo '<pre>';
    // print_r($_POST);
    //  exit;

    if (isset($_POST['product_name']) && isset($_POST['ref_type_id']) && isset($_POST['product_price'])) {
        //echo'ถูกเงื่อนไข ส่งข้อมูลมาได้';

        //trigger exception in a "try" block
        try {


            //ประกาศตัวแปรรับค่าจาก Form
            $ref_type_id = $_POST['ref_type_id'];
            $product_name = $_POST['product_name'];
            $product_detail = $_POST['product_detail'];
            $product_qty = $_POST['product_qty'];
            $product_price = $_POST['product_price'];
            $id = $_POST['id'];
            $upload = $_FILES['product_image']['name'];

            //สร้างเงื่อนไขตรวจสอบการอัพโหลดไฟล์
            if ($upload == '') {
                //echo 'ไม่มีการอัพโหลดไฟล์';
                //sql update ไม่มีการอัพโหลดไฟล์
                $stmtUpdateProduct = $condb->prepare("UPDATE tbl_product SET 
                ref_type_id=:ref_type_id,
                product_name=:product_name,
                product_detail=:product_detail,
                product_qty=:product_qty,
                product_price=:product_price
                WHERE id=:id
                      
            ");

                //bindParam
                $stmtUpdateProduct->bindParam(':id', $id, PDO::PARAM_INT);
                $stmtUpdateProduct->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
                $stmtUpdateProduct->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':product_detail', $product_detail, PDO::PARAM_STR);
                $stmtUpdateProduct->bindParam(':product_qty', $product_qty, PDO::PARAM_INT);
                $stmtUpdateProduct->bindParam(':product_price', $product_price, PDO::PARAM_INT);
                $result = $stmtUpdateProduct->execute();

                if ($result) {
                    echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "บันทึกข้อมูลสำเร็จ",
                        type: "success"
                    }, function() {
                        window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
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
                $product_image = (isset($_POST['product_image']) ? $_POST['product_image'] : '');

                //ตัดขื่อเอาเฉพาะนามสกุล
                $typefile = strrchr($_FILES['product_image']['name'], ".");

                //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
                if ($typefile == '.jpg' || $typefile  == '.jpeg' || $typefile  == '.png') {
                    // echo 'อัพโหลดไฟล์ไม่ถูกต้อง';
                    // exit;


                    //ลบภาพเก่า
                    unlink('..//assets/product_img/' . $_POST['oldImg']);

                    //โฟลเดอร์ที่เก็บไฟล์
                    $path = "../assets/product_img/";
                    //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                    $newname = $numrand . $date1 . $typefile;
                    $path_copy = $path . $newname;
                    //คัดลอกไฟล์ไปยังโฟลเดอร์
                    move_uploaded_file($_FILES['product_image']['tmp_name'], $path_copy);

                    //sql update with upload file
                    $stmtUpdateProduct = $condb->prepare("UPDATE tbl_product SET 
                    ref_type_id=:ref_type_id,
                    product_name=:product_name,
                    product_detail=:product_detail,
                    product_qty=:product_qty,
                    product_price=:product_price,
                    product_image='$newname'
                    WHERE id=:id
                          
                ");

                    //bindParam
                    $stmtUpdateProduct->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmtUpdateProduct->bindParam(':ref_type_id', $ref_type_id, PDO::PARAM_INT);
                    $stmtUpdateProduct->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                    $stmtUpdateProduct->bindParam(':product_detail', $product_detail, PDO::PARAM_STR);
                    $stmtUpdateProduct->bindParam(':product_qty', $product_qty, PDO::PARAM_INT);
                    $stmtUpdateProduct->bindParam(':product_price', $product_price, PDO::PARAM_INT);
                    $result = $stmtUpdateProduct->execute();

                    if ($result) {
                        echo '<script>
                                setTimeout(function() {
                                swal({
                                    title: "บันทึกข้อมูลสำเร็จ",
                                    type: "success"
                                }, function() {
                                    window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
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
                                window.location = "product.php?id=' . $id . '&act=edit"; //หน้าที่ต้องการให้กระโดดไป
                            });
                            }, 1000);
                        </script>';
                    //exit;
                } //อัพโหลดไฟล์ที่อนุญาติ
            } //else ไม่มีการอัพโหลดไฟล์
        } //try
        //catch exception
        catch (Exception $e) {
            //echo 'Message: ' .$e->getMessage();
            echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  type: "error"
              }, function() {
                  window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
        } //catch  
    } // isset
    ?>
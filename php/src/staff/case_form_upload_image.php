<?php

//สร้างเงื่อนไขตรวจสอบการส่ง param
if (isset($_GET['id']) && isset($_GET['act']) && $_GET['act'] == 'image') {

    //คิวรี่ข้อมูลสมาชิก
    $queryproductImg = $condb->prepare("SELECT * FROM tbl_product_image WHERE ref_p_id=:id ORDER BY no DESC");

    //bindParam
    $queryproductImg->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $queryproductImg->execute();
    $rsImg = $queryproductImg->fetchAll();

    //print_r($rsImg);

    //สร้างเงื่อนไขการตรวจสอบคิวรี่
    // if ($queryproductImg->rowCount() == 0) { //คิวรี่ผิดพลาด
    //     echo '<script>
    //                     setTimeout(function() {
    //                     swal({
    //                         title: "เกิดข้อผิดพลาด",
    //                         type: "error"
    //                     }, function() {
    //                         window.location = "product.php"; //หน้าที่ต้องการให้กระโดดไป
    //                     });
    //                     }, 1000);
    //                 </script>';
    //     exit;
    // }
}
?>

<!-- js check file type -->
<script type="text/javascript">
    var _validFileExtensions = [".jpg", ".jpeg", ".png"]; //กำหนดนามสกุลไฟล์ที่สามรถอัพโหลดได้
    function ValidateTypeFile(oForm) {
        var arrInputs = oForm.getElementsByTagName("input");
        for (var i = 0; i < arrInputs.length; i++) {
            var oInput = arrInputs[i];
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        } // if (sFileName.substr(sFileName.length....
                    } // for (var j = 0; j < _validFileExtensions.length; j++) {

                    //ถ้าเลือกไฟล์ไม่ถุูกต้องจะมี Alert แจ้งเตือน   
                    if (!blnValid) {
                        // alert("คำเตือน , " + sFileName + "\n ระบบรองรับเฉพาะไฟล์นามสกุล   : " + _validFileExtensions.join(", "));
                        setTimeout(function() {
                            swal({
                                title: "อัพโหลดไฟล์ไม่ถูกต้อง ",
                                text: "รองรับ .jpg, .jpeg, .png เท่านั้น !!",
                                type: "error"
                            }, function() {
                                //window.location.reload();
                                //window.location = "product.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                            });
                        }, 1000);
                        return false;
                    } //if (!blnValid) {
                } //if (sFileName.length > 0) {
            } // if (oInput.type == "file") {
        } //for

        return true;
    } //function ValidateTypeFile(oForm) {
</script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ฟอร์มอัพโหลดภาพสินค้า</h1>
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
                        <form action="" method="post" onsubmit="return ValidateTypeFile(this);" enctype="multipart/form-data">
                            <div class="card-body">

                                <div class="form-group row">
                                    <label align="center" class="col-sm-2">ภาพสินค้า</label>
                                    <div class="col-sm-4">
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="upload[]" class="custom-file-input" required id="exampleInputFile" accept="image/*" multiple="multiple" />
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
                                        <input type="hidden" name="p_id" value="<?= $_GET['id']; ?>">
                                        <button type="submit" name="btn" value="upload" class="btn btn-primary">บันทึก</button>
                                        <a href="case.php" class="btn btn-danger">ยกเลิก</a>

                                    </div>
                                </div>
                            </div>

                            <!-- /.card-body -->

                        </form>
                        <!-- /.end form -->
                        <?php
                        // echo '<pre>';
                        // print_r($_POST);
                        // echo '<hr>';
                        // print_r($_FILES);
                        // exit;
                        ?>
                        <hr>
                        <h3>ภาพประกอบสินค้า</h3>
                        <table id="example1" class="table table-bordered table-striped table table-sm">
                            <thead>
                                <tr class="table-info">
                                    <th class="text-center">No.</th>
                                    <th class="text-center">ภาพ</th>
                                    <th class="text-center">โฟลเดอร์ที่เก็บไฟล์ภาพ</th>
                                    <th class="text-center">ลบ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($rsImg as $row) { ?>
                                    <tr>
                                        <td align="center"><?= $i++; ?></td>
                                        <td align="center">
                                            <a data-fancybox="gallery" href="../assets/product_gallery/<?= $row['product_image']; ?>">
                                                <img src="../assets/product_gallery/<?= $row['product_image']; ?>" width="100px">
                                            </a>
                                        </td>
                                        <td>../assets/product_gallery/<?= $row['product_image']; ?></td>
                                        <td align="center">
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                                                <input type="hidden" name="no" value="<?= $row['no']; ?>">
                                                <input type="hidden" name="product_image" value="<?= $row['product_image']; ?>">
                                                <input type="hidden" name="ref_p_id" value="<?= $_GET['id']; ?>">
                                                <button type="submit" name="act" value="deletImg" class="btn btn-danger">ลบข้อมูล</button>
                                            </form>

                                        </td>

                                    </tr>
                                <?php } ?>
                            </tbody>

                            <<script>
                                document.getElementById('exampleInputFile').addEventListener('change', function() {
                                var fileName = this.files[0] ? this.files[0].name : 'Choose file';
                                var label = this.nextElementSibling;
                                label.textContent = fileName;
                                });
                                </script>

                        </table>

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
// echo '<hr>';
// print_r($_FILES);
// exit;

if (isset($_POST['p_id']) && isset($_POST['btn']) && $_POST['btn'] == 'upload') {

    //trigger exception in a "try" block
    try {

        //ประกาศตัวแปรรับค่าจาก Form
        $ref_p_id = $_POST['ref_p_id'];

        // Count # of uploaded files in array
        $total = count($_FILES['upload']['name']);
        //echo $total;
        //exit();
        // Loop through each file
        for ($i = 0; $i < $total; $i++) {
            //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
            $date1 = date("YmdHis");
            //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
            $numrand = (mt_rand());
            $typefile = strrchr($_FILES['upload']['name'][$i], ".");
            //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a file path
            if ($tmpFilePath != "") {

                //โฟลเดอร์ที่เก็บไฟล์
                $path = "../assets/product_gallery/";
                //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
                $newname = $numrand . '_' . $date1 . $typefile;
                $path_copy = $path . $newname;

                //คัดลอกไฟล์ไปยังโฟลเดอร์
                //Upload the file into the temp dir
                if (move_uploaded_file($_FILES['upload']['tmp_name'][$i], $path_copy)) {

                    $stmtUpload = $condb->prepare("INSERT INTO tbl_product_image
                        (
                          ref_p_id,
                          product_image
                        )
                        VALUES 
                        (
                          :ref_p_id,
                          '$newname'
                        )
                        ");
                    //bindParam
                    $stmtUpload->bindParam(':ref_p_id', $_POST['p_id'], PDO::PARAM_INT);
                    $stmtUpload->execute();
                    //$condb = null; //close connect db

                    //echo '<pre>';
                    //$stmtUpload->debugDumpParams();

                    //Handle other code here
                    //echo '<pre>';
                    //print_r($newFilePath);

                } //if move
            } // ! impty
        } //for 

        if ($stmtUpload->rowCount() > 0) {
            echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "อัพโหลดภาพสำเร็จ",
                      text: "ไฟล์ที่ถูกอัพโหลด ' . $total . ' files",
                      type: "success"
                  }, function() {
                      window.location = "case.php?id=' . $_GET['id'] . '&act=image"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
        } //if

        //catch exception
    } catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        echo '<script>
                 setTimeout(function() {
                  swal({
                      title: "เกิดข้อผิดพลาด",
                      text: "กรุณาติดต่อผู้ดูแลระบบ",
                      type: "warning"
                  }, function() {
                      window.location = "case.php?id=' . $_GET['id'] . '&act=image"; //หน้าที่ต้องการให้กระโดดไป
                  });
                }, 1000);
            </script>';
    }
} // isset

//delete image file and data in table
// echo '<pre>';
// print_r($_POST);
// exit;

if (isset($_POST['id']) && isset($_POST['product_image']) && isset($_POST['act']) && $_POST['act'] == 'deletImg') {

    //ประกาศตัวแปรรับค่าจาก form
    $id = $_POST['id'];
    $no = $_POST['no'];
    $product_image = $_POST['product_image'];

    //sql delete
    $stmtDelProductImg = $condb->prepare('DELETE FROM tbl_product_image WHERE no=:no AND ref_p_id=:id');
    $stmtDelProductImg->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtDelProductImg->bindParam(':no', $no, PDO::PARAM_INT);
    $stmtDelProductImg->execute();

    $condb = null; //close connect db

    //echo 'จำนวน row ที่ลบได้' .$stmtDelProduct->rowCount();
    if ($stmtDelProductImg->rowCount() == 1) {

        //ลบไฟล์ภาพ
        unlink('../assets/product_gallery/' . $product_image);

        echo '<script>
        setTimeout(function() {
        swal({
            title: "ลบข้อมูลสำเร็จ",
            type: "success"
        }, function() {
            window.location = "case.php?id=' . $_GET['id'] . '&act=image"; //หน้าที่ต้องการให้กระโดดไป
        });
        }, 1000);
    </script>';
        exit();
    } else {
        echo '<script>
        setTimeout(function() {
        swal({
            title: "เกิดข้อผิดพลาด",
            type: "error"
        }, function() {
            window.location = "case.php?id=' . $_GET['id'] . '&act=image"; //หน้าที่ต้องการให้กระโดดไป
        });
        }, 1000);
    </script>';
    } //sweet alert


} //isset delete image

?>
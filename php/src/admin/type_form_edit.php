<?php
    if(isset($_GET['id']) && $_GET['act'] == 'edit'){

      //single row query แสดงแค่ 1 รายการ   
      $stmttypeDetail = $condb->prepare("SELECT * FROM tbl_type WHERE type_id=?");
      $stmttypeDetail->execute([$_GET['id']]);
      $row = $stmttypeDetail->fetch(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // print_r($row);    
        // exit;
        // echo $stmttypeDetail->rowCount();
        // exit;

      //ถ้าคิวรี่ผิดพลาดให้หยุดการทำงาน
      if($stmttypeDetail->rowCount() !=1){
          exit();
      }
    }//isset
    ?> 
 
 
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มแก้ไขข้อมูลหมวดหมู่สินค้า</h1>
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
              <div class="card card-primary">
                <!-- form start -->
                <form action="" method="post">
                  <div class="card-body">

                  <div class="form-group row">
                      <label class="col-sm-2">หมวดหมู่สินค้า</label>
                      <div class="col-sm-4">
                        <input type="text" name="type_name" class="form-control" required placeholder="หมวดหมู่สินค้า" value="<?php echo $row['type_name'];?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                         <input type="hidden" name="type_id" value="<?php echo $row['type_id'];?>">
                        <button type="submit" class="btn btn-primary"> ปรับปรุงข้อมูล </button>
                        <a href="type.php" class="btn btn-danger">ยกเลิก</a>
                      </div>
                    </div>

                  </div> <!-- /.card-body -->

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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php 
                // echo '<pre>';
                // print_r($_POST);
                //exit;

                if(isset($_POST['type_id']) && isset($_POST['type_name'])){

                  //trigger exception in a "try" block
try {
                    //ประกาศตัวแปรรับค่าจากฟอร์ม
                    $type_id = $_POST['type_id'];
                    $type_name = $_POST['type_name'];
 
                    //sql update
                    $stmtUpdate = $condb->prepare("UPDATE tbl_type SET 
                    type_name=:type_name
                    WHERE type_id=:type_id
                    ");
                    //bindParam
                    $stmtUpdate->bindParam(':type_id', $type_id , PDO::PARAM_INT);
                    $stmtUpdate->bindParam(':type_name', $type_name , PDO::PARAM_STR);

                    $result = $stmtUpdate->execute();

                    $condb = null; //close connect db

                    if($result){
                        echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "แก้ไขข้อมูลสำเร็จ",
                                  type: "success"
                              }, function() {
                                  window.location = "type.php";
                              });
                            }, 1000);
                        </script>';
                    } 
                    
} //try
//catch exception
catch(Exception $e) {
    //echo 'Message: ' .$e->getMessage();
    echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด || ข้อมูลซ้ำ !!",
              type: "error"
          }, function() {
              window.location = "type.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
  } //catch


                } //isset

                //window.location = "type.php?id='.$id.'&act=edit"; //หน้าที่ต้องการให้กระโดดไป
?>
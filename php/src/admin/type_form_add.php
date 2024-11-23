  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มเพิ่มข้อมูลหมวดหมู่สินค้า  </h1>
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
                        <input type="text" name="type_name" class="form-control" required placeholder="หมวดหมู่สินค้า">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary"> เพิ่มข้อมูล </button>
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
                  //เช็ค input ที่ส่งมาจากฟอร์ม
                  // echo '<pre>';
                  // print_r($_POST);
                  // exit;

                  if(isset($_POST['type_name'])){
                    //echo 'ถูกเงื่อนไข ส่งข้อมูลมาได้';

            //trigger exception in a "try" block
              try {
                    
                    //ประกาศตัวแปรรับค่าจากฟอร์ม
                    $type_name = $_POST['type_name'];
                    //เช็ค type_name ซ้ำ
                     //single row query แสดงแค่ 1 รายการ   
                      $stmttypeDetail = $condb->prepare("SELECT type_name FROM tbl_type 
                      WHERE type_name=:type_name
                      ");
                       //bindParam
                      $stmttypeDetail->bindParam(':type_name', $type_name, PDO::PARAM_STR);
                      $stmttypeDetail->execute();
                      $row = $stmttypeDetail->fetch(PDO::FETCH_ASSOC);

                      //นับจำนวนการคิวรี่ ถ้าได้ 1 คือ type_name ซ้ำ
                      // echo $stmttypeDetail->rowCount();
                      // echo '<hr>';
                    if($stmttypeDetail->rowCount() == 1){
                        //echo 'type_name ซ้ำ';
                        echo '<script>
                        setTimeout(function() {
                          swal({
                              title: "ชื่อหมวดหมู่สินค้า ซ้ำ !!",
                              text: "กรุณาเพิ่มข้อมูลใหม่อีกครั้ง",
                              type: "error"
                          }, function() {
                              window.location = "type.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                          });
                        }, 1000);
                    </script>';

                     }else{
                        //echo 'ไม่มี type_name ซ้ำ';
                         //sql insert
                    $stmtInserttype = $condb->prepare("INSERT INTO tbl_type
                    (type_name)
                    VALUES 
                    (:type_name)
                    ");

                    //bindParam
                    $stmtInserttype->bindParam(':type_name', $type_name, PDO::PARAM_STR);
                    $result = $stmtInserttype->execute();
                    
                    $condb = null; //close connect db
                    if($result){
                          echo '<script>
                              setTimeout(function() {
                                swal({
                                    title: "เพิ่มข้อมูลสำเร็จ",
                                    type: "success"
                                }, function() {
                                    window.location = "type.php"; //หน้าที่ต้องการให้กระโดดไป
                                });
                              }, 1000);
                          </script>';
                      }
                     } //เช็คข้อมูลซ้ำ                         
                    } //try
                    //catch exception
                    catch(Exception $e) {
                        //echo 'Message: ' .$e->getMessage();
                        echo '<script>
                             setTimeout(function() {
                              swal({
                                  title: "เกิดข้อผิดพลาด",
                                  type: "error"
                              }, function() {
                                  window.location = "type.php"; //หน้าที่ต้องการให้กระโดดไป
                              });
                            }, 1000);
                        </script>';
                      } //catch
                  } //isset
       ?> 
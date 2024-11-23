  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ฟอร์มเพิ่มข้อมูลพนักงาน</h1>
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
                      <select name="m_level" class="form-control" required>
                        <option value="">-- เลือกข้อมูล --</option>
                        <option value="admin">-- admin --</option>
                        <option value="staff">-- staff --</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ตำแหน่ง</label>
                    <div class="col-sm-2">
                      <select name="ref_position_id" class="form-control" required>
                        <option value="">-- เลือกข้อมูล --</option>
                        <option value="1">-- Manager --</option>
                        <option value="1">-- IT Application Support --</option>
                        <option value="2">-- IT Helpdesk Support --</option>
                        <option value="3">-- IT Network System Support --</option>
                        <option value="4">-- Staff Support --</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Username</label>
                    <div class="col-sm-4">
                      <input type="text" name="username" class="form-control" required placeholder="Username">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">Password</label>
                    <div class="col-sm-4">
                      <input type="password" name="password" class="form-control" required placeholder="Password">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">คำนำหน้า</label>
                    <div class="col-sm-2">
                      <select name="title_name" class="form-control" required>
                        <option value="">-- เลือกข้อมูล --</option>
                        <option value="นาย">-- นาย --</option>
                        <option value="นาง">-- นาง --</option>
                        <option value="นางสาว">-- นางสาว --</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">ชื่อ</label>
                    <div class="col-sm-4">
                      <input type="text" name="name" class="form-control" required placeholder="ชื่อ">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">นามสกุล</label>
                    <div class="col-sm-4">
                      <input type="text" name="surname" class="form-control" required placeholder="นามสกุล">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-sm-2">อัพโหลดรูป</label>
                    <div class="col-sm-4">
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" name="member_image" class="custom-file-input"  id="exampleInputFile" accept="image/*">
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

                  <!-- <div class="form-group row">
                    <label class="col-sm-2">Profile Picture</label>
                    <div class="col-sm-4">

                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose File</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>
                  </div> -->

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
  //เช็ค Input ที่ส่งมาจาก Form
  // echo '<pre>';
  // print_r($_POST);
  // exit;

  if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['surname'])) {
    try {
      // Get form input values
      $username = $_POST['username'];
      $password = sha1($_POST['password']);
      $title_name = $_POST['title_name'];
      $name = $_POST['name'];
      $surname = $_POST['surname'];
      $m_level = $_POST['m_level'];
      $ref_position_id = $_POST['ref_position_id'];
  
      // Set default values for image upload
      $newname = 'avatar-4.jpg';  // Default to an empty string if no image is uploaded
  



      if (!empty($_FILES['member_image']['name'])) {
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

        //โฟลเดอร์ที่เก็บไฟล์
        $path = "../assets/product_img/";
        //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
        $newname = $numrand . $date1 . $typefile;
        $path_copy = $path . $newname;
        //คัดลอกไฟล์ไปยังโฟลเดอร์
        move_uploaded_file($_FILES['member_image']['tmp_name'], $path_copy);
  
   }
    }







      // SQL insert
      $stmInsertMember = $condb->prepare("INSERT INTO tbl_member
                  (
                    username,
                    password,
                    title_name,
                    name, 
                    surname,
                    m_level,
                    ref_position_id,
                    member_image
                  )
                  VALUES 
                  (
                    :username,
                    '$password',
                    :title_name,
                    :name, 
                    :surname,
                    :m_level,
                    :ref_position_id,
                    :member_image
                  )");
  
      // Bind parameters
      $stmInsertMember->bindParam(':username', $username, PDO::PARAM_STR);
      $stmInsertMember->bindParam(':title_name', $title_name, PDO::PARAM_STR);
      $stmInsertMember->bindParam(':name', $name, PDO::PARAM_STR);
      $stmInsertMember->bindParam(':surname', $surname, PDO::PARAM_STR);
      $stmInsertMember->bindParam(':m_level', $m_level, PDO::PARAM_STR);
      $stmInsertMember->bindParam(':ref_position_id', $ref_position_id, PDO::PARAM_INT);
      $stmInsertMember->bindParam(':member_image', $newname, PDO::PARAM_STR);
  
      $result = $stmInsertMember->execute();
      $condb = null;
  
      if ($result) {
        echo '<script>
                setTimeout(function() {
                swal({
                    title: "เพิ่มข้อมูลสำเร็จ",
                    type: "success"
                }, function() {
                    window.location = "member.php";
                });
                }, 1000);
            </script>';
      }
    }// try
    // upload file
     
    catch (Exception $e) {
      // echo 'Message: ' .$e->getMessage();
      // exit;
      echo '<script>
               setTimeout(function() {
                swal({
                    title: "เกิดข้อผิดพลาด",
                    text: "กรุณาติดต่อผู้ดูแลระบบ Username ซ้ำ!!",
                    type: "error"
                }, function() {
                    window.location = "member.php?act=add";
                });
              }, 1000);
          </script>';
    }
  }
  ?>
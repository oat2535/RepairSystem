<?php
//เริ่มต้นการใช้ session
session_start();

//เรียกใช้ไฟล์เชื่อมต่อ database
require_once 'config/condb.php';

//ลบตัวแปร session
// unset($_SESSION['staff_name']);

//เคลีย session ทั้งหมด
//session_destroy();

//แสดงตัวแปร session
// echo '<pre>';
// print_r($_SESSION);



// exit;

//ประกาศตัวแปร session
// $_SESSION['staff_id'] = 1;
// $_SESSION['staff_name'] = 'nattchai';
// $_SESSION['staff_role'] = 'admin';

// echo '<pre>';
// print_r($_POST);

//สร้างเงื่อนไขตรวจสอบ input ที่ส่งมาจาก form
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['action']) && $_POST['action'] == 'login') {

  //ประกาศตัวแปรรับค่าจากฟอร์ม
  $username = $_POST['username'];
  $password = sha1($_POST['password']); //เก็บรหัสผ่านในรูปแบบ sha1 

  //check username  & password
  $stmtLogin = $condb->prepare("SELECT id, m_level FROM tbl_member WHERE username = :username AND password = :password");

  //bindParam STR, INT
  $stmtLogin->bindParam(':username', $username, PDO::PARAM_STR);
  $stmtLogin->bindParam(':password', $password, PDO::PARAM_STR);
  $stmtLogin->execute();

  //นับจำนวนข้อมูลที่คิวรี่ได้ = 0 ไม่เจอ, 1 = เจอ
  // echo $stmtLogin->rowCount();
  // exit;

  //กรอก username & password ถูกต้อง
  if ($stmtLogin->rowCount() == 1) {
    //fetch เพื่อเรียกคอลัมภ์ที่ต้องการไปสร้างตัวแปร session
    $row = $stmtLogin->fetch(PDO::FETCH_ASSOC); //query single row
    //สร้างตัวแปร session
    $_SESSION['staff_id'] = $row['id'];
    $_SESSION['m_level'] = $row['m_level'];

    //เช็คว่ามีตัวแปร session อะไรบ้าง
    // print_r($_SESSION);
    // exit();

    //$condb = null; //close connect db

    //สร้างเงื่อนไขตรวจสอบสิทธิ์การใช้งาน
    if ($_SESSION['m_level'] == 'admin') { //admin
      header('Location: admin/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
    } else if ($_SESSION['m_level'] == 'staff') {
      //staff
      header('Location: staff/'); //login ถูกต้องและกระโดดไปหน้าตามที่ต้องการ
    }
  } else { //ถ้า username or password ไม่ถูกต้อง

    echo '<script>
                     setTimeout(function() {
                      swal({
                          title: "เกิดข้อผิดพลาด",
                           text: "Username หรือ Password ไม่ถูกต้อง ลองใหม่อีกครั้ง",
                          type: "warning"
                      }, function() {
                          window.location = "index.php"; //หน้าที่ต้องการให้กระโดดไป
                      });
                    }, 1000);
                </script>';
  } //else
} //isset

?>
<!DOCTYPE html>
<html lang="en">

<style>
  body {
    background: url('assets/dist/img/5305323.jpg') no-repeat center center fixed;
    /* ใช้ URL ของภาพ */
    background-size:cover;
    /* ปรับขนาดให้เต็มจอ */
    /* background-color: #f3f3f3; ใช้สีพื้นหลังหากไม่มีภาพ */
  }

  .login-box {
    background: rgba(255, 255, 255, 0.8);
    /* เพิ่มพื้นหลังขาวโปร่งบาง */
    padding: 20px;
    border-radius: 8px;
  }
</style>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css?v=3.2.0">
  <!-- sweet alerts -->
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <b>Repair</b> <b>System<b>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">

        <p class="login-box-msg">Login เข้าใช้งานระบบแจ้งซ่อม</p>

        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-check mb-3">
            <input type="checkbox" id="showPassword" class="form-check-input">
            <label for="showPassword" class="form-check-label">แสดงรหัสผ่าน</label>
          </div>

          <script>
            document.getElementById('showPassword').addEventListener('change', function() {
              const passwordInput = document.getElementById('password');
              if (this.checked) {
                passwordInput.type = 'text';
              } else {
                passwordInput.type = 'password';
              }
            });
          </script>
          <div class="row">
            <!-- Login Button -->
            <div class="col-12">
              <button type="submit" name="action" value="login" class="btn btn-primary btn-block">Login</button>
            </div>
            <!-- Login Button -->
          </div>
          <!-- Forgot Password Link -->
      </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
  </div>
  <!-- /.login-box -->
</body>

</html>
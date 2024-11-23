  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
      <img src="../assets/dist/img/techsupport.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .9">
      <span class="brand-text font-weight-light">Repair System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="..//assets/product_img/<?= $memberData['member_image']; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="member.php?act=edit" class="d-block"><?= $memberData['name']. ' '.$memberData['surname'];?><br>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <!-- <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                หน้าหลัก
              </p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="case.php" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                แจ้งซ่อม
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="member.php?act=edit" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                แก้ไขโปรไฟล์
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="member.php?act=editPwd" class="nav-link">
              <i class="nav-icon fas fa-key"></i>
              <p>
                แก้ไขรหัสผ่าน
              </p>
            </a>
          </li>

          <li class="nav-item">
          <a href="../logout.php" class="nav-link" id="logout-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>
                ออกจากระบบ
              </p>
            </a>
            <script>
              $(document).ready(function() {
                $('#logout-link').on('click', function(e) {
                  e.preventDefault(); // ป้องกันการนำไปที่ลิงก์โดยตรง
                  swal({
                    title: "ยืนยันการออกจากระบบ?",
                    text: "คุณต้องการออกจากระบบหรือไม่?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ออกจากระบบ",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                  }, function() {
                    window.location.href = "../index.php"; // เปลี่ยนเส้นทางเมื่อยืนยัน
                  });
                });
              });
            </script>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
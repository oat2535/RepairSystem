  <?php
  //คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว
  $memberdetail = $condb->prepare("SELECT m.name, m.member_image, m.surname, p.position_name, m.m_level, p.position_name
  FROM tbl_member as m
  INNER JOIN tbl_position as p ON m.ref_position_id = p.position_id 
  WHERE id=:id");

  //bindParam
  $memberdetail->bindParam(':id', $_SESSION['staff_id'], PDO::PARAM_INT);
  $memberdetail->execute();
  $memberData = $memberdetail->fetch(PDO::FETCH_ASSOC);

  // echo '<pre>';
  // print_r($memberData);
  ?>


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
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
          <a href="member.php" class="d-block"><?= $memberData['name']. ' '.$memberData['surname'];?><br>
          <?=$memberData['position_name'];?></a>
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
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="form.php" class="nav-link">
              <i class="nav-icon far fa-edit"></i>
              <p>
                ฟอร์ม
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="datatable.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>
                ตาราง
              </p>
            </a>
          </li> -->

          <li class="nav-item">
            <a href="case.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                จัดการข้อมูลแจ้งซ่อม
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="member.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                จัดการข้อมูลพนักงาน
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="type.php" class="nav-link">
              <i class="fa fa-wrench"></i>
              <p>
                จัดการประเภทแจ้งซ่อม
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="report.php" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>
                รายงานการแจ้งซ่อม
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="../logout.php" class="nav-link" id="logout-link">
              <i class="nav-icon fas fa-lock"></i>
              <p>ออกจากระบบ</p>
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
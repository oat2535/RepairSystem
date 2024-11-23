  <?php
  //คิวรี่ข้อมูลสมาชิก
  $queryMember = $condb->prepare("SELECT *
  FROM tbl_member as m
  INNER JOIN tbl_position as p ON m.ref_position_id = p.position_id
  ORDER BY m.id DESC");
  $queryMember->execute();
  $rsMember = $queryMember->fetchAll();

  // echo '<pre>';
  // print_r($rsMember);
  // echo '<pre>';
  // $queryMember->debugDumpParams();
  // exit;
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>จัดการข้อมูลสมาชิก

              <a href="member.php?act=add" class="btn btn-primary">+ข้อมูล</a>
            </h1>

          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card -->

              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table table-sm">
                  <thead>
                    <tr class="table-info">
                      <th width="5%" class="text-center">No.</th>
                      <th width="5%" class="text-center">รูป</th>
                      <th width="33%">ชื่อ-นามสกุล</th>
                      <th width="10%">Username</th>
                      <th width="20%">ตำแหน่ง</th>
                      <th width="10%">Level</th>
                      <th width="7%" class="text-center">แก้รหัส</th>
                      <th width="5%" class="text-center">แก้ไข</th>
                      <th width="5%" class="text-center">ลบ</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 1; //ตัวเลขเริ่มต้น

                    foreach ($rsMember as $row) { ?>
                      <tr>
                        <td align="center"><?php echo $i++ ?></td>
                        <td>
                          <a data-fancybox href="../assets/product_img/<?= $row['member_image']; ?>">
                            <img src="../assets/product_img/<?= $row['member_image']; ?>" width="70px">
                          </a>
                        </td>
                        <td><?= $row['title_name'] . ' ' . $row['name'] . ' ' . $row['surname']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['position_name']; ?></td>
                        <td><?= $row['m_level']; ?></td>
                        <td align="center"><a href="member.php?id=<?= $row['id']; ?>&act=editPwd" class="btn btn-info btn-sm">แก้รหัส</a></td>
                        <td align="center"><a href="member.php?id=<?= $row['id']; ?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a></td>
                        <td align="center">
                          <a href="member.php?id=<?= $row['id']; ?>&act=delete" class="btn btn-danger btn-sm delete-link">ลบ</a>
                        </td>
                        <script>
                          $(document).ready(function() {
                            $('.delete-link').on('click', function(e) {
                              e.preventDefault(); // ป้องกันการนำไปที่ลิงก์โดยตรง
                              var url = $(this).attr('href'); // ดึง URL จากลิงก์
                              swal({
                                title: "ยืนยันการลบพนักงาน?",
                                text: "คุณต้องการลบพนักงานหรือไม่?",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "ลบ",
                                cancelButtonText: "ยกเลิก",
                                closeOnConfirm: false
                              }, function() {
                                window.location.href = url; // เปลี่ยนเส้นทางเมื่อยืนยัน
                              });
                            });
                          });
                        </script>
                        </td>
                      </tr>

                    <?php } ?>
                  </tbody>
                  <!-- <tfoot>
                  <tr>
                    <th>Rendering engine</th>
                    <th>Browser</th>
                    <th>Platform(s)</th>
                    <th>Engine version</th>
                    <th>CSS grade</th>
                  </tr>
                  </tfoot> -->
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
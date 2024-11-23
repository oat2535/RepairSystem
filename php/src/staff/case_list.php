<?php
 //คิวรี่ข้อมูลของคนที่ผ่านการ login มาแล้ว
 $memberdetail = $condb->prepare("SELECT * FROM tbl_member WHERE username=:username");

 //bindParam
 $memberdetail->bindParam(':username', $_SESSION['staff_id'], PDO::PARAM_INT);
 $memberdetail->execute();
 $memberData = $memberdetail->fetch(PDO::FETCH_ASSOC);

//  echo '<pre>';
// print_r($memberData);
// คิวรี่ข้อมูลตามสถานะ
$statusId = isset($_GET['status_id']) ? $_GET['status_id'] : null;

$sql = "SELECT c.id, c.case_image, t.type_name, c.case_detail, c.employee_name, s.status_name, b.branch_name, c.datecreate
        FROM tbl_case as c
        INNER JOIN tbl_type t ON c.ref_type_id = t.type_id
        INNER JOIN tbl_branch b ON c.ref_branch_id = b.branch_id
        INNER JOIN tbl_status s ON c.ref_status_id = s.status_id
        INNER JOIN tbl_member m ON c.create_username = m.username
        WHERE m.id=:staff_id";

if ($statusId) {
  $sql .= " AND c.ref_status_id = :status_id";
}

$sql .= " GROUP BY c.id, c.case_image, t.type_name, c.case_detail, c.employee_name, s.status_name, b.branch_name ORDER BY c.id DESC";

$queryCase = $condb->prepare($sql);

$params = ['staff_id' => $_SESSION['staff_id']];
if ($statusId) {
  $params['status_id'] = $statusId;
}

$queryCase->execute($params);
$rsCase = $queryCase->fetchAll();

// echo '<pre>';
// print_r($rsCase); // แสดงข้อมูลที่ดึงมา
// echo '</pre>';

//คิวรี่ข้อมูลเคสงานทั้งหมด
$queryCountCase = $condb->prepare("SELECT COUNT(c.*) AS totalcase 
FROM tbl_case as c
INNER JOIN tbl_member m ON c.create_username = m.username
WHERE m.id=:staff_id");
$queryCountCase->execute(['staff_id' => $_SESSION['staff_id']]); 
$rscounttotalcase = $queryCountCase->fetch(PDO::FETCH_ASSOC);

//คิวรี่ข้อมูลเคสแยกตามสถานะงานใหม่
$queryCountCase = $condb->prepare("SELECT COUNT(c.*) AS totalnewcase 
FROM tbl_case as c
INNER JOIN tbl_member m ON c.create_username = m.username
WHERE ref_status_id = :id
AND m.id=:staff_id");
$queryCountCase->execute(['id' => 1, 'staff_id' => $_SESSION['staff_id']]); // 1 คือรหัสสถานะงานใหม่ที่คุณต้องการ
$rscountnewcase = $queryCountCase->fetch(PDO::FETCH_ASSOC);

//คิวรี่ข้อมูลเคสแยกตามสถานะงานกำลังดำเนินการ
$queryCountCase = $condb->prepare("SELECT COUNT(*) AS totaldoingcase 
FROM tbl_case as c
INNER JOIN tbl_member m ON c.create_username = m.username
WHERE ref_status_id = :id
AND m.id=:staff_id");
$queryCountCase->execute(['id' => 2, 'staff_id' => $_SESSION['staff_id']]); // 1 คือรหัสสถานะงานใหม่ที่คุณต้องการ
$rscountdoingcase = $queryCountCase->fetch(PDO::FETCH_ASSOC);

//คิวรี่ข้อมูลเคสแยกตามสถานะงานดำเนินการเสร็จแล้ว
$queryCountCase = $condb->prepare("SELECT COUNT(*) AS totaldonecase 
FROM tbl_case as c
INNER JOIN tbl_member m ON c.create_username = m.username
WHERE ref_status_id = :id
AND m.id=:staff_id");
$queryCountCase->execute(['id' => 3, 'staff_id' => $_SESSION['staff_id']]); // 1 คือรหัสสถานะงานใหม่ที่คุณต้องการ
$rscountdonecase = $queryCountCase->fetch(PDO::FETCH_ASSOC);

//คิวรี่ข้อมูลเคสแยกตามสถานะยกเลิก
$queryCountCase = $condb->prepare("SELECT COUNT(*) AS totalcancelcase 
FROM tbl_case as c
INNER JOIN tbl_member m ON c.create_username = m.username
WHERE ref_status_id = :id
AND m.id=:staff_id");
$queryCountCase->execute(['id' => 4, 'staff_id' => $_SESSION['staff_id']]); // 1 คือรหัสสถานะงานใหม่ที่คุณต้องการ
$rscountcancelcase = $queryCountCase->fetch(PDO::FETCH_ASSOC);

// echo '<pre>';
// print_r($rsCase);
// echo '<pre>';
// $queryCase->debugDumpParams();
// exit;

// echo '<pre>';
// print_r($rscounttotalcase); // ดูค่าจำนวนเคสทั้งหมด
// print_r($rscountnewcase);    // ดูจำนวนเคสสถานะงานใหม่
// print_r($rscountdoingcase);  // ดูจำนวนเคสสถานะกำลังทำ
// print_r($rscountdonecase);   // ดูจำนวนเคสสถานะดำเนินการเสร็จสิ้น
// print_r($rscountcancelcase); // ดูจำนวนเคสสถานะยกเลิก
// echo '</pre>';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>จัดการเคสแจ้งซ่อม
            <a href="case.php?act=add" class="btn btn-primary">+ข้อมูล</a>
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
            <!-- เพิ่มปุ่มแถบสถานะในส่วน card-header -->
            <div class="card-body">
              <a href="case.php" class="btn btn-info">งานทั้งหมด <span class="badge badge-light"><?= $rscounttotalcase['totalcase'] ?? 0; ?></span></a>
              <a href="?status_id=1" class="btn btn-primary">งานใหม่ <span class="badge badge-light"><?= $rscountnewcase['totalnewcase'] ?? 0; ?></span></a>
              <a href="?status_id=2" class="btn btn-warning">กำลังทำ <span class="badge badge-light"><?= $rscountdoingcase['totaldoingcase'] ?? 0; ?></span></a>
              <a href="?status_id=3" class="btn btn-success">ดำเนินการเสร็จสิ้น <span class="badge badge-light"><?= $rscountdonecase['totaldonecase'] ?? 0; ?></span></a>
              <a href="?status_id=4" class="btn btn-danger">ยกเลิก <span class="badge badge-light"><?= $rscountcancelcase['totalcancelcase'] ?? 0; ?></span></a>
            </div>
            <!-- /.card-header -->

            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped table table-sm">
                <thead>
                  <tr class="table-info">
                    <th width="3%" class="text-center">No.</th>
                    <th width="5%" class="text-center">ภาพ</th>
                    <th width="17%" class="text-center">ประเภท</th>
                    <th width="40%" class="text-center">รายละเอียด</th>
                    <th width="10%" class="text-center">ชื่อผู้แจ้ง</th>
                    <th width="8%" class="text-center">วันที่แจ้ง</th>
                    <th width="10%" class="text-center">สาขา</th>
                    <th width="10%" class="text-center">สถานะ</th>
                    <th width="5%" class="text-center">+ภาพ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1; //ตัวเลขเริ่มต้น

                  foreach ($rsCase as $row) { ?>
                    <tr>
                      <td align="center"><?php echo $i++ ?></td>
                      <td>
                        <a data-fancybox href="../assets/product_img/<?= $row['case_image']; ?>">
                          <img src="../assets/product_img/<?= $row['case_image']; ?>" width="70px">
                        </a>
                      </td>

                      <td><?= $row['type_name']; ?></td>
                      <td align="left"><?= $row['case_detail']; ?></td>
                      <td><?= $row['employee_name']; ?></td>
                      <td><?= date('d/m/Y', strtotime($row['datecreate'])); ?></td>
                      <td align="center"><?= $row['branch_name']; ?></td>
                      <td align="center"><?= $row['status_name']; ?></td>
                      <td align="center"><a href="case.php?id=<?= $row['id']; ?>&act=image" class="btn btn-secondary btn-sm">+ภาพ</a></td>
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
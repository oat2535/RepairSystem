<?php
//คิวรี่ข้อมูลสาขา
$queryStatus = $condb->prepare("SELECT * FROM tbl_status");
$queryStatus->execute();
$rsStatus = $queryStatus->fetchAll();

//คิวรี่ข้อมูลเจ้าหน้าที่ Admin
$queryAssign = $condb->prepare("SELECT * FROM tbl_member WHERE m_level='admin'");
$queryAssign->execute();
$rsAssign = $queryAssign->fetchAll();

?>



<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>รายงานการแจ้งซ่อม</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">กรองข้อมูลรายงาน</h3>
      </div>
      <div class="card-body">
        <form method="post" action="report.php">
          <div class="form-group row">
            <label for="start_date" class="col-sm-2 col-form-label">วันที่เริ่มต้น</label>
            <div class="col-sm-3">
              <input type="date" name="start_date" class="form-control" required>
            </div>
            <label for="end_date" class="col-sm-2 col-form-label">วันที่สิ้นสุด</label>
            <div class="col-sm-3">
              <input type="date" name="end_date" class="form-control" required>
            </div>
          </div>

          <div class="form-group row">
            <label for="status_id" class="col-sm-2 col-form-label">สถานะแจ้งซ่อม</label>
            <div class="col-sm-3">
              <select name="status_id" class="form-control">
                <option value="">-- เลือกข้อมูล --</option>
                <?php foreach ($rsStatus as $row) { ?>
                  <option value="<?php echo $row['status_id']; ?>">-- <?php echo $row['status_name']; ?> --</option>
                <?php } ?>
              </select>
            </div>
            <label for="assign_name" class="col-sm-2 col-form-label">Assign Name</label>
            <div class="col-sm-3">
              <select name="assign_name" class="form-control">
                <option value="">-- เลือกข้อมูล --</option>
                <?php foreach ($rsAssign as $row) { ?>
                  <option value="<?php echo $row['username']; ?>">-- <?php echo $row['name'] . ' ' . $row['surname']; ?> --</option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
              <button type="submit" class="btn btn-primary">กรองข้อมูล</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>

<?php
// echo '<pre>';
// print_r($_POST);
// echo '<hr>';
// print_r($_FILES);
// exit;

?>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $ref_status_id = $_POST['status_id'];
  $assign_name = $_POST['assign_name'];

  // สร้าง SQL Query พร้อมเงื่อนไขตัวกรอง
  $sql = "SELECT * FROM tbl_case WHERE dateCreate BETWEEN :start_date AND :end_date";

  if (!empty($ref_status_id)) {
    $sql .= " AND ref_status_id = :ref_status_id";
  }

  if (!empty($assign_name)) {
    $sql .= " AND assign_name LIKE :assign_name";
  }

  $stmt = $condb->prepare($sql);
  $stmt->bindParam(':start_date', $start_date);
  $stmt->bindParam(':end_date', $end_date);

  if (!empty($ref_status_id)) {
    $stmt->bindParam(':', $ref_status_id);
  }

  if (!empty($assign_name)) {
    $assign_name = "%" . $assign_name . "%";
    $stmt->bindParam(':assign_name', $assign_name);
  }

  $stmt->execute();
  $reportData = $stmt->fetchAll();
}

echo '<pre>';
print_r($reportData);
// echo '<hr>';
// print_r($_FILES);
// exit;

?>
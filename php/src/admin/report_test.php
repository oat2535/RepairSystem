<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <br>
                    <h3>รายงานเคสแจ้งซ่อม</h3>
                </div>
            </div>
            <form action="" method="get">
                <div class="row g-9">
                    <div class="col-auto">
                        <label class="col-form-label">เริ่มต้น</label>
                    </div>
                    <div class="col-auto">
                        <!-- ใน value สร้างเงื่อนไขตรวจสอบถ้ามีการส่ง $_GET มาถึงจะแสดงค่าที่เคยเลือก ถ้าไม่มีจะแสดง 2021-08-06-->
                        <input type="date" name="start_date" data-date-format="YYYY-MM-DD HH:MM" class="form-control" required value="
                            <?php if (isset($_GET['start_date'])) {
                                echo $_GET['start_date'];
                            } else {
                                echo '2021-08-06';
                            } ?>">
                    </div>
                    <div class="col-auto">
                        <label class="col-form-label">ถึง</label>
                    </div>
                    <div class="col-auto">
                        <!-- ใน value สร้างเงื่อนไขตรวจสอบถ้ามีการส่ง $_GET มาถึงจะแสดงค่าที่เคยเลือก ถ้าไม่มีจะแสดง 2021-10-30-->
                        <input type="date" name="end_date" data-date-format="YYYY-MM-DD HH:MM" class="form-control" required value="
                            <?php if (isset($_GET['end_date'])) {
                                echo $_GET['end_date'];
                            } else {
                                echo '2021-10-30';
                            } ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">ค้นหาข้อมูล</button>
                        <a href="report.php" class="btn btn-warning">เคลียร์ข้อมูล</a>
                    </div>
                </div>
                <?php
                // echo '<pre>';
                // print_r($_GET);
                // echo '<hr>';
                // print_r($_FILES);
                // exit;

                ?>
            </form>
        </div>
    </section>




    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">

                            <?php
                            //ถ้ามีการส่ง $_GET 
                            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                                // ปรับค่าของวันสิ้นสุดให้ครอบคลุมทั้งวัน
                                $end_date = date('Y-m-d', strtotime($_GET['end_date'] . ' +1 day'));
                                //ไฟล์เชื่อมต่อฐานข้อมูล
                                require_once '..//config/condb.php';
                                //คิวรี่ข้อมูลมาแสดงในตาราง
                                $stmt = $condb->prepare("SELECT c.id, t.type_name, c.case_detail, c.employee_name, s.status_name, b.branch_name, c.datecreate, m.name, m.surname, c.update_note 
                                    FROM tbl_case as c
                                    LEFT JOIN tbl_type t ON c.ref_type_id = t.type_id
                                    LEFT JOIN tbl_branch b ON c.ref_branch_id = b.branch_id
                                    LEFT JOIN tbl_status s ON c.ref_status_id = s.status_id
                                    LEFT JOIN tbl_member m ON c.assign_name = m.username
                                    WHERE c.datecreate BETWEEN ? AND ? 
                                    ORDER BY c.datecreate DESC");
                                $stmt->execute(array($_GET['start_date'], $end_date));
                                $result = $stmt->fetchAll();
                                //ถ้าเจอข้อมูลมากกว่า 0
                                if ($stmt->rowCount() > 0) {
                            ?>

                                    <br>
                                    <h3>รายงานแจ้งซ่อมวันที่ : <?= date('d/m/Y', strtotime($_GET['start_date'])); ?>
                                        ถึง
                                        <?= date('d/m/Y', strtotime($_GET['end_date'])); ?>
                                    </h3>
                                    <div class="card-body"> <!-- เปิด div card-body ที่นี่ -->
                                        <table id="example1" class="table table-bordered table-striped table table-sm">
                                            <thead>
                                                <tr class="table-info">
                                                    <th width="1%" class="text-center">No.</th>
                                                    <th width="15%" class="text-center">ประเภท</th>
                                                    <th width="17%" class="text-center">รายละเอียด</th>
                                                    <th width="10%" class="text-center">ชื่อผู้แจ้ง</th>
                                                    <th width="10%" class="text-center">สาขา</th>
                                                    <th width="10%" class="text-center">สถานะ</th>
                                                    <th width="10%" class="text-center">Assign Name</th>
                                                    <th width="17%" class="text-center">Update Note</th>
                                                    <th width="10%" class="text-center">วันที่แจ้ง</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                //ประกาศตัวแปรแสดงลำดับ
                                                $i = 1;
                                                //ประกาศตัวแปรผลรวม
                                                $total = 0;
                                                foreach ($result as $row) {
                                                    //หาผลรวมยอดขายใน loop โดยใข้ +=
                                                    //$total += $row['price_total'];
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?= $i++; //แสดงลำดับแทนไอดี 
                                                                                ?></td>
                                                        <td><?= $row['type_name']; ?></td>
                                                        <td align="left"><?= $row['case_detail']; ?></td>
                                                        <td align="left"><?= $row['employee_name']; ?></td>
                                                        <td align="left"><?= $row['branch_name']; ?></td>
                                                        <td align="left"><?= $row['status_name']; ?></td>
                                                        <td align="left"><?= $row['name'] . ' ' . $row['surname']; ?></td>
                                                        <td align="left"><?= $row['update_note'] ?></td>
                                                        <td class="text-center"><?= date('d/m/Y', strtotime($row['datecreate'])); ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <!-- <tr class="table-danger">
                                <td colspan="2" class="text-center">Total</td>
                                <td align="right"><?= number_format($total, 2); ?></td>
                                <td class="text-center">บาท</td>
                            </tr> -->
                                            </tbody>
                                        </table>
                                        <br>
                                <?php } // if ($stmt->rowCount() > 0) {
                                else {
                                    echo '<center> -ไม่พบข้อมูล !! </center>';
                                }
                            } //isset 
                                ?>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
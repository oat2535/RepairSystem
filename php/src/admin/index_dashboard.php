<?php


//จำนวน Case แจ้งซ่อมทั้งหมด
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalview FROM tbl_case");
$stmtCountCounter->execute();
$rowC = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวน Case สถานะรอดำเนินการ
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalwating FROM tbl_case WHERE ref_status_id ='1'");
$stmtCountCounter->execute();
$rowSW = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวน Case สถานะกำลังดำเนินการ
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totaldoing FROM tbl_case WHERE ref_status_id ='2'");
$stmtCountCounter->execute();
$rowSD = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวน Case สถานะดำเนินการเสร็จสิ้น
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalfinish FROM tbl_case WHERE ref_status_id ='3'");
$stmtCountCounter->execute();
$rowSF = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวน Case สถานะยกเลิก
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalcancel FROM tbl_case WHERE ref_status_id ='4'");
$stmtCountCounter->execute();
$rowSC = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวนสมาชิก
$stmtCountMember = $condb->prepare("SELECT COUNT(*) as totalmember FROM tbl_member");
$stmtCountMember->execute();
$rowM = $stmtCountMember->fetch(PDO::FETCH_ASSOC);

//จำนวนสินค้า
$stmtCountPrd = $condb->prepare("SELECT COUNT(*) as totalcase FROM tbl_case");
$stmtCountPrd->execute();
$rowCase = $stmtCountPrd->fetch(PDO::FETCH_ASSOC);

//จำนวนผู้เข้าชมเว็บไซด์แยกตามวัน
$queryViewByDay = $condb->prepare("SELECT TO_CHAR(datecreate, 'DD/MM/YYYY') as datesave,  COUNT(*) as total 
FROM tbl_case 
GROUP BY datesave
ORDER BY datesave DESC;");
$queryViewByDay->execute();
$rsVd = $queryViewByDay->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data = array();
foreach ($rsVd as $rsD) {
    /*
โครงสร้างข้อมูลของกราฟ
    {
    name: "Chrome",
    y: 62.74,
    drilldown: "Chrome"
    },
*/
    //ทำข้อมูลให้ถูกโครงสร้างก่อนนำไปแสดงในกราฟ docs : https://www.highcharts.com/demo/column-drilldown
    $report_data[] = '
{
  name:' . '"' . $rsD['datesave'] . '"' . ',' //label
        . 'y:' . $rsD['total'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rsD['datesave'] . '"' . ',' //label ด้านล่าง
        . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data = implode(",", $report_data);

//ตรวจสอบข้อมูล
// echo '<pre>';
// print_r($report_data);


//จำนวนผู้ใช้แยกตามเดือน
$queryViewByMonth = $condb->prepare("SELECT TO_CHAR(datecreate, 'FMMonth') as monthnames, COUNT(*) as totalbymonth
FROM tbl_case
GROUP BY monthnames
ORDER BY monthnames DESC;");
$queryViewByMonth->execute();
$rsVm = $queryViewByMonth->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data_month = array();
foreach ($rsVm as $rsM) {
    $report_data_month[] = '
{
  name:' . '"' . $rsM['monthnames'] . '"' . ',' //label
        . 'y:' . $rsM['totalbymonth'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rsM['monthnames'] . '"' . ',' //label ด้านล่าง
        . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data_month = implode(",", $report_data_month);

//ตรวจสอบข้อมูล
// echo '<pre>';
// print_r($report_data_month);


//จำนวนผู้ใช้แยกตามปี
$queryViewByYear = $condb->prepare("SELECT EXTRACT(YEAR FROM datecreate) as years, 
COUNT(*) as totalbyyear
FROM tbl_case
GROUP BY years
ORDER BY years DESC;");
$queryViewByYear->execute();
$rsVy = $queryViewByYear->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data_year = array();
foreach ($rsVy as $rsY) {
    $report_data_year[] = '
{
  name:' . '"' . $rsY['years'] . '"' . ',' //label
        . 'y:' . $rsY['totalbyyear'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rsY['years'] . '"' . ',' //label ด้านล่าง
        . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data_year = implode(",", $report_data_year);

//ตรวจสอบข้อมูล
// echo '<pre>';
// print_r($report_data_year);


?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard รายงานภาพรวม</h1>

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
                        <!-- /.card-header -->
                        <div class="card-body">

                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                            <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3><?= $rowC['totalview']; ?></h3>
                                            <p>งานทั้งหมด</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-clipboard"></i>
                                        </div>
                                        <a href="case.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3><?= $rowSW['totalwating']; ?></h3>
                                            <p>รอดำเนินการ</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-clock"></i>
                                        </div>
                                        <a href="case.php?status_id=1" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><?= $rowSD['totaldoing']; ?></h3>
                                            <p>อยู่ระหว่างดำเนินการ</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-wrench"></i>
                                        </div>
                                        <a href="case.php?status_id=2" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?= $rowSF['totalfinish']; ?></h3>
                                            <p>ดำเนินการเสร็จสิ้น</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-thumbsup"></i>
                                        </div>
                                        <a href="case.php?status_id=3" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3><?= $rowSC['totalcancel']; ?></h3>
                                            <p>ยกเลิก</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-close"></i>
                                        </div>
                                        <a href="case.php?status_id=4" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <figure class="highcharts-figure">
                                        <div id="container"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        // Create the chart
                                        Highcharts.chart('container', {
                                            chart: {
                                                type: 'line'
                                            },
                                            title: {
                                                text: 'จำนวนการแจ้งเคสแยกตามวัน'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowC['totalview']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการแจ้งเคสแยกตามวัน'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวน Case แจ้งซ่อม",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data; ?>]
                                            }]
                                        });
                                    </script>

                                </div>

                                <div class="col-sm-8">
                                    <figure class="highcharts-figure">
                                        <div id="container2"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        // Create the chart
                                        Highcharts.chart('container2', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: 'จำนวนการแจ้งเคสแยกตามเดือน'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowC['totalview']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการแจ้งเคสแยกตามเดือน'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวน Case แจ้งซ่อม",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data_month; ?>]
                                            }]
                                        });
                                    </script>
                                </div>

                                <div class="col-sm-4">
                                    <figure class="highcharts-figure">
                                        <div id="container3"></div>
                                        <p class="highcharts-description">.</p>
                                    </figure>
                                    <script>
                                        // Create the chart
                                        Highcharts.chart('container3', {
                                            chart: {
                                                type: 'column'
                                            },
                                            title: {
                                                text: 'จำนวนการแจ้งเคสแยกตามปี'
                                            },
                                            subtitle: {
                                                text: 'รวมทั้งสิ้น <?= $rowC['totalview']; ?> ครั้ง '
                                            },
                                            accessibility: {
                                                announceNewData: {
                                                    enabled: true
                                                }
                                            },
                                            xAxis: {
                                                type: 'category'
                                            },
                                            yAxis: {
                                                title: {
                                                    text: 'จำนวนการแจ้งเคสแยกตามปี'
                                                }
                                            },
                                            legend: {
                                                enabled: false
                                            },
                                            plotOptions: {
                                                series: {
                                                    borderWidth: 0,
                                                    dataLabels: {
                                                        enabled: true,
                                                        format: '{point.y:.0f} ครั้ง'
                                                    }
                                                }
                                            },
                                            tooltip: {
                                                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                                                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.0f} ครั้ง</b> of total<br/>'
                                            },
                                            series: [{
                                                name: "จำนวน Case แจ้งซ่อม",
                                                colorByPoint: true,
                                                //เอาข้อมูลมา echo ตรงนี้
                                                data: [<?= $report_data_year; ?>]
                                            }]
                                        });
                                    </script>
                                </div>
                            </div>

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
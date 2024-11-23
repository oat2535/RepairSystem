<?php


//จำนวนผู้เข้าชมเว็บไซด์
$stmtCountCounter = $condb->prepare("SELECT COUNT(*) as totalView FROM tbl_counter");
$stmtCountCounter->execute();
$rowC = $stmtCountCounter->fetch(PDO::FETCH_ASSOC);

//จำนวนสมาชิก
$stmtCountMember = $condb->prepare("SELECT COUNT(*) as totalMember FROM tbl_member");
$stmtCountMember->execute();
$rowM = $stmtCountMember->fetch(PDO::FETCH_ASSOC);

//จำนวนสินค้า
$stmtCountPrd = $condb->prepare("SELECT COUNT(*) as totalProduct FROM tbl_product");
$stmtCountPrd->execute();
$rowP = $stmtCountPrd->fetch(PDO::FETCH_ASSOC);

//จำนวนผู้เข้าชมเว็บไซด์แยกตามวัน
$queryViewByDay = $condb->prepare("SELECT DATE_FORMAT(c_date,'%d/%m/%Y') as datesave,  COUNT(*) as total 
FROM tbl_counter 
GROUP BY DATE_FORMAT(c_date,'%Y-%m-%d')
ORDER BY DATE_FORMAT(c_date,'%Y-%m-%d') DESC;");
$queryViewByDay->execute();
$rsVd = $queryViewByDay->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data = array();
foreach ($rsVd as $rs) {
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
  name:' . '"' . $rs['datesave'] . '"' . ',' //label
        . 'y:' . $rs['total'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rs['datesave'] . '"' . ',' //label ด้านล่าง
        . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data = implode(",", $report_data);

//ตรวจสอบข้อมูล
// echo '<pre>';
// print_r($report_data);


//จำนวนผู้ใช้แยกตามเดือน
$queryViewByMonth = $condb->prepare("SELECT MONTHNAME(c_date) as monthNames, COUNT(*) as totalByMonth
FROM tbl_counter
GROUP BY MONTH(c_date)
ORDER BY DATE_FORMAT(c_date, '%Y-%m') DESC;");
$queryViewByMonth->execute();
$rsVm = $queryViewByMonth->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data_month = array();
foreach ($rsVm as $rs) {
    $report_data_month[] = '
{
  name:' . '"' . $rs['monthNames'] . '"' . ',' //label
        . 'y:' . $rs['totalByMonth'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rs['monthNames'] . '"' . ',' //label ด้านล่าง
        . '}';
}
//ตัด , ตัวสุดท้ายออก
$report_data_month = implode(",", $report_data_month);

//ตรวจสอบข้อมูล
// echo '<pre>';
// print_r($report_data_month);


//จำนวนผู้ใช้แยกตามปี
$queryViewByYear = $condb->prepare("SELECT YEAR(c_date) as years, 
COUNT(*) as totalByYear
FROM tbl_counter
GROUP BY YEAR(c_date)
ORDER BY YEAR(c_date) DESC;");
$queryViewByYear->execute();
$rsVy = $queryViewByYear->fetchAll();

//นำข้อมูลที่ได้จากคิวรี่มากำหนดรูปแบบข้อมุลให้ถูกโครงสร้างของกราฟที่ใช้ *อ่าน docs เพิ่มเติม
$report_data_year = array();
foreach ($rsVy as $rs) {
    $report_data_year[] = '
{
  name:' . '"' . $rs['years'] . '"' . ',' //label
        . 'y:' . $rs['totalByYear'] . //ตัวเลขยอดขาย
        ','
        . 'drilldown:' . '"' . $rs['years'] . '"' . ',' //label ด้านล่าง
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
                                            <h3><?= $rowC['totalView']; ?></h3>
                                            <p>เข้าชมเว็บไซด์</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-connection-bars"></i>
                                        </div>
                                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?= $rowM['totalMember']; ?></h3>
                                            <p>สมาชิก</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-person-stalker"></i>
                                        </div>
                                        <a href="member.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><?= $rowM['totalMember']; ?></h3>
                                            <p>ผู้ดูแลระบบ</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-person"></i>
                                        </div>
                                        <a href="admin.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3><?= $rowP['totalProduct']; ?></h3>
                                            <p>สินค้า</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion-bag"></i>
                                        </div>
                                        <a href="product.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
                                            text: 'จำนวนการเข้าชมเว็บไซด์แยกตามวัน'
                                        },
                                        subtitle: {
                                            text: 'รวมทั้งสิ้น <?= $rowC['totalView']; ?> ครั้ง '
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
                                                text: 'จำนวนการเข้าชมเว็บไซด์'
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
                                            name: "จำนวนการเข้าชมเว็บไซด์",
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
                                            text: 'จำนวนการเข้าชมเว็บไซด์แยกตามเดือน'
                                        },
                                        subtitle: {
                                            text: 'รวมทั้งสิ้น <?= $rowC['totalView']; ?> ครั้ง '
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
                                                text: 'จำนวนการเข้าชมเว็บไซด์'
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
                                            name: "จำนวนการเข้าชมเว็บไซด์",
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
                                            text: 'จำนวนการเข้าชมเว็บไซด์แยกตามปี'
                                        },
                                        subtitle: {
                                            text: 'รวมทั้งสิ้น <?= $rowC['totalView']; ?> ครั้ง '
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
                                                text: 'จำนวนการเข้าชมเว็บไซด์'
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
                                            name: "จำนวนการเข้าชมเว็บไซด์",
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
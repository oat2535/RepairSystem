<?php
if (isset($_GET['id']) && $_GET['act'] == 'delete') {

    //echo $id;

    //trigger exception in a "try" block
    try {
        $id = $_GET['id'];

        //single row query แสดงแค่ 1 รายการ จะเอาชื่อไฟล์ภาพไปลบ
        $stmtMemberDetail = $condb->prepare("SELECT member_image FROM tbl_member WHERE id=?");
        $stmtMemberDetail->execute([$_GET['id']]);
        $row = $stmtMemberDetail->fetch(PDO::FETCH_ASSOC);

        //แสดงชื่อภาพ
        //  echo 'image_name'. $row['member_image'];
        //  exit;

        // echo $stmtMemberDetail->rowCount();
        // exit;

        if ($stmtMemberDetail->rowCount() == 0) {
            echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
        } else {
            //echo 'เด้งออกไป';
            //sql delete
            $stmtMemberDetail = $condb->prepare('DELETE FROM tbl_member WHERE id=:id');
            $stmtMemberDetail->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtMemberDetail->execute();
            $condb = null; //close connect db
            //echo 'จำนวน row ที่ลบได้' .$stmtDelProduct->rowCount();
            if ($stmtMemberDetail->rowCount() == 1) {
                //ลบไฟล์ภาพ
                if ($row['member_image'] !== 'avatar-4.jpg') {
                    unlink('../assets/product_img/' . $row['member_image']);
                }
                echo '<script>
            setTimeout(function() {
            swal({
                title: "ลบข้อมูลสำเร็จ",
                type: "success"
            }, function() {
                window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
            });
            }, 1000);
        </script>';
                exit();
            } //if
        } //row ount
    } //try
    //catch exception
    catch (Exception $e) {
        //echo 'Message: ' .$e->getMessage();
        echo '<script>
         setTimeout(function() {
          swal({
              title: "เกิดข้อผิดพลาด",
              type: "error"
          }, function() {
              window.location = "member.php"; //หน้าที่ต้องการให้กระโดดไป
          });
        }, 1000);
    </script>';
    } //catch
} //isset
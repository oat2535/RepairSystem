<footer class="main-footer">
    <strong>Copyright &copy; 2024-2030 <a href="https://redmine.nonsoi4.dev/projects/">Thonglor Pet Hospital</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> UAT-1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Summernote -->
<script src="../assets/plugins/summernote/summernote-bs4.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()

    })
</script>



<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../assets/dist/js/pages/dashboard.js"></script>

<!-- DataTables  & ../assets/plugins -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- Page specific script -->
<script>
  $(function () {
    // ตรวจสอบว่าอยู่ที่หน้ารายงานหรือไม่ (เช่นผ่านการตรวจสอบ URL หรือค่าที่ใช้กำหนด)
    var isReportPage = window.location.href.includes("report.php"); // ตัวอย่างการตรวจสอบ URL
    
    if (isReportPage) {
      $("#example1").DataTable({
        "responsive": true, 
        "lengthChange": true, 
        "autoWidth": false,
        "buttons": [{
                      extend: 'csvHtml5',
                      charset: 'utf-8',
                      bom: true
                    }, "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  } else {
    $("#example1").DataTable({
        "responsive": true, 
        "lengthChange": true, 
        "autoWidth": false,
        // ไม่มีปุ่มเมื่อไม่ใช่หน้ารายงาน
      });
    }
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>
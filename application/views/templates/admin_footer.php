                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Website RT 9 Desa Sambiroto v1.0
            </div>
            <strong>Copyright &copy; 2025 <a href="#">RT 9 Desa Sambiroto</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/adminlte/js/adminlte.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/select2/js/select2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/ckeditor/ckeditor.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/chart.js/chart.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/admin.js'); ?>"></script>
    
    <script>
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
        
        // Initialize DataTables
        $('.data-table').DataTable({
            responsive: true,
            columnDefs: [
                { targets: 'no-sort', orderable: false }
            ]
        });
        
        // Initialize CKEditor
        CKEDITOR.replace('editor', {
            toolbar: [
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
                { name: 'paragraph', items: [ 'BulletedList', 'NumberedList', '-', 'Blockquote' ] },
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                { name: 'insert', items: [ 'Image' ] },
                { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] }
            ],
            height: 300
        });
    </script>
</body>
</html>

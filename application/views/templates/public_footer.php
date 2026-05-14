    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-content">
                    <h5>RT 9 Desa Sambiroto</h5>
                    <p>Website informasi dan manajemen untuk Rukun Tetangga 9 Desa Sambiroto dengan fitur lengkap pengelolaan data penduduk, iuran kas, artikel kegiatan, dan galeri.</p>
                </div>
                <div class="col-md-4 footer-content">
                    <h5>Menu Cepat</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo base_url('home'); ?>" class="footer-link">Beranda</a></li>
                        <li><a href="<?php echo base_url('penduduk'); ?>" class="footer-link">Data Penduduk</a></li>
                        <li><a href="<?php echo base_url('iuran'); ?>" class="footer-link">Iuran Kas</a></li>
                        <li><a href="<?php echo base_url('artikel'); ?>" class="footer-link">Artikel</a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-content">
                    <h5>Kontak Kami</h5>
                    <p class="footer-link">
                        <i class="fas fa-map-marker-alt"></i> Desa Sambiroto<br>
                        <i class="fas fa-phone"></i> <span id="footer_phone">-</span><br>
                        <i class="fas fa-envelope"></i> <span id="footer_email">-</span>
                    </p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="mb-0" id="footer_text">Copyright © 2025 RT 9 Desa Sambiroto. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/sweetalert/sweetalert2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/vendor/select2/js/select2.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
    
    <script>
        // Load footer settings
        $(document).ready(function() {
            $.ajax({
                url: '<?php echo base_url('api/pengaturan'); ?>',
                type: 'GET',
                success: function(data) {
                    if (data.no_telepon) $('#footer_phone').text(data.no_telepon);
                    if (data.email) $('#footer_email').text(data.email);
                    if (data.footer_text) $('#footer_text').text(data.footer_text);
                }
            });
        });
    </script>
</body>
</html>

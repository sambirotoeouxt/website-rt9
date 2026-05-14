<?php $this->load->view('templates/public_header'); ?>

<!-- Hero Section -->
<div class="hero-section">
    <h1>Selamat Datang di RT 9 Desa Sambiroto</h1>
    <p>Website Informasi dan Manajemen Rukun Tetangga</p>
</div>

<div class="container">
    <!-- Statistics -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-number" id="total_penduduk">-</div>
                <div class="stat-label">Total Penduduk</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-number" id="total_kas">Rp -</div>
                <div class="stat-label">Total Iuran Kas</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-box">
                <div class="stat-number" id="total_artikel">-</div>
                <div class="stat-label">Total Artikel</div>
            </div>
        </div>
    </div>
    
    <!-- Latest Articles -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">Artikel Terbaru</h2>
        </div>
        <div id="artikel-container" class="row">
            <p class="text-center text-muted col-12">Loading...</p>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border: none; color: white;">
                <div class="card-body text-center">
                    <h3>Punya Informasi Penting?</h3>
                    <p>Bagikan informasi atau berita terbaru tentang kegiatan RT kami</p>
                    <?php if ($this->auth->is_logged_in()): ?>
                        <a href="<?php echo base_url('admin/artikel/create'); ?>" class="btn btn-light">
                            <i class="fas fa-pencil-alt"></i> Tulis Artikel
                        </a>
                    <?php else: ?>
                        <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-light">
                            <i class="fas fa-sign-in-alt"></i> Login Terlebih Dahulu
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load statistics
        $.ajax({
            url: '<?php echo base_url('api/home/stats'); ?>',
            type: 'GET',
            success: function(data) {
                $('#total_penduduk').text(data.total_penduduk);
                $('#total_kas').text('Rp ' + number_format(data.total_kas));
                $('#total_artikel').text(data.total_artikel);
            }
        });
        
        // Load latest articles
        $.ajax({
            url: '<?php echo base_url('api/home/latest-articles'); ?>',
            type: 'GET',
            success: function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(function(artikel) {
                        html += `
                            <div class="col-md-4">
                                <div class="card article-card">
                                    <img src="${artikel.gambar ? '<?php echo base_url('assets/uploads/artikel/'); ?>' + artikel.gambar : '<?php echo base_url('assets/images/placeholder.jpg'); ?>'}"
                                         alt="${artikel.judul}" class="card-img-top article-image">
                                    <div class="card-body">
                                        <h5 class="card-title">${artikel.judul}</h5>
                                        <p class="article-meta">
                                            <i class="fas fa-calendar"></i> ${new Date(artikel.created_at).toLocaleDateString('id-ID')}
                                        </p>
                                        <p class="card-text">${artikel.isi.substring(0, 100)}...</p>
                                        <a href="<?php echo base_url('artikel/'); ?>${artikel.slug}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-arrow-right"></i> Baca Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    html = '<p class="text-center text-muted col-12">Belum ada artikel</p>';
                }
                $('#artikel-container').html(html);
            }
        });
    });
    
    function number_format(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<?php $this->load->view('templates/public_footer'); ?>

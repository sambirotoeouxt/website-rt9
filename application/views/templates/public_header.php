<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Website RT 9 Desa Sambiroto</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fontawesome/css/all.min.css'); ?>">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/css/adminlte.min.css'); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --success-color: #27ae60;
            --warning-color: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 40px;
            text-align: center;
        }
        
        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero-section p {
            font-size: 1.3rem;
            margin-bottom: 30px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 30px;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 10px 10px 0 0;
            border: none;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2980b9 100%);
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.4);
            background: linear-gradient(135deg, #2980b9 0%, #1abc9c 100%);
        }
        
        .btn-success {
            background: var(--success-color);
            border: none;
        }
        
        .btn-success:hover {
            background: #229954;
        }
        
        .btn-danger {
            background: var(--accent-color);
            border: none;
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .footer {
            background: var(--primary-color);
            color: white;
            padding: 40px 0 20px;
            margin-top: 60px;
        }
        
        .footer-content {
            margin-bottom: 30px;
        }
        
        .footer h5 {
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .footer-link {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        .stat-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .stat-box .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .stat-box .stat-label {
            color: #7f8c8d;
            margin-top: 10px;
        }
        
        .article-card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .article-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .article-card:hover .article-image {
            transform: scale(1.05);
        }
        
        .article-meta {
            font-size: 0.9rem;
            color: #95a5a6;
            margin-bottom: 10px;
        }
        
        .alert {
            border: none;
            border-radius: 8px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url('home'); ?>">
                <i class="fas fa-home"></i> RT 9 Sambiroto
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('home'); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('penduduk'); ?>">Data Penduduk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('iuran'); ?>">Iuran Kas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('artikel'); ?>">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url('galeri'); ?>">Galeri</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <?php if ($this->auth->is_logged_in()): ?>
                                <i class="fas fa-user"></i> <?php echo $this->auth->get_user_info()['full_name']; ?>
                            <?php else: ?>
                                <i class="fas fa-sign-in-alt"></i> Login
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <?php if ($this->auth->is_logged_in()): ?>
                                <a class="dropdown-item" href="<?php echo base_url('admin'); ?>">Dashboard Admin</a>
                                <a class="dropdown-item" href="<?php echo base_url('admin/user/profile'); ?>">Profil Saya</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?php echo base_url('auth/logout'); ?>">Logout</a>
                            <?php else: ?>
                                <a class="dropdown-item" href="<?php echo base_url('auth/login'); ?>">Login</a>
                                <a class="dropdown-item" href="<?php echo base_url('auth/register'); ?>">Registrasi</a>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Content -->
    <main>
        <div class="container my-4">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('warning'); ?>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

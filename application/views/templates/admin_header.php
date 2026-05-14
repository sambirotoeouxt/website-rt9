<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Admin Dashboard RT 9</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/fontawesome/css/all.min.css'); ?>">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/adminlte/css/adminlte.min.css'); ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/datatables/css/dataTables.bootstrap4.min.css'); ?>">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/select2/css/select2.min.css'); ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendor/sweetalert/sweetalert2.min.css'); ?>">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/admin.css'); ?>">
    
    <style>
        :root {
            --primary: #2c3e50;
            --info: #3498db;
            --success: #27ae60;
            --danger: #e74c3c;
            --warning: #f39c12;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Header -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background: linear-gradient(135deg, var(--primary) 0%, var(--info) 100%);">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-danger navbar-badge">0</span>
                    </a>
                </li>
                
                <!-- User -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user-circle"></i> <?php echo $this->auth->get_user_info()['full_name']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: auto; right: 0;">
                        <a href="<?php echo base_url('admin/user/profile'); ?>" class="dropdown-item">
                            <i class="fas fa-user"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="<?php echo base_url('auth/logout'); ?>" class="dropdown-item">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?php echo base_url('admin'); ?>" class="brand-link">
                <i class="fas fa-home"></i> <span>RT 9 Dashboard</span>
            </a>
            
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin'); ?>" class="nav-link <?php echo ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'dashboard') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    
                    <li class="nav-header">MANAJEMEN</li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/penduduk'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'penduduk' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Penduduk</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/iuran'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'iuran' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-money-bill-alt"></i>
                            <p>Iuran Kas RT</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/artikel'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'artikel' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Artikel</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/komentar'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'komentar' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Komentar</p>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a href="<?php echo base_url('admin/galeri'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'galeri' ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Galeri</p>
                        </a>
                    </li>
                    
                    <?php if ($this->auth->get_user_info()['role'] === 'superadmin'): ?>
                        <li class="nav-header">ADMINISTRASI</li>
                        
                        <li class="nav-item">
                            <a href="<?php echo base_url('admin/user'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'user' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Manajemen User</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?php echo base_url('admin/menu'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'menu' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>Manajemen Menu</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?php echo base_url('admin/pengaturan'); ?>" class="nav-link <?php echo $this->uri->segment(2) == 'pengaturan' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-cog"></i>
                                <p>Pengaturan Website</p>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </aside>
        
        <!-- Content Wrapper -->
        <div class="content-wrapper" style="background-color: #f5f5f5;">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0" style="color: var(--primary);"><?php echo isset($title) ? $title : 'Dashboard'; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                            <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $this->session->flashdata('error'); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('warning'); ?>
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

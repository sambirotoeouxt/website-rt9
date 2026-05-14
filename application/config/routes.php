<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
|
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The left side represents
| the URI request, and the right side represents the target
| controller class/method that should be invoked to handle the request.
|
| Keep in mind that the first parameter must always be the name of
| your controller class. If you use namespacing, the full class
| namespace & class name may be needed.
|
| Reserved routes:
|   $route['translate_uri_dashes'] = FALSE;
|   $route['404_override'] = 'errors/page_missing';
|   $route['default_controller'] = 'welcome';
|
*/

// Default route
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = TRUE;

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Admin routes
$route['admin'] = 'admin/dashboard';
$route['admin/dashboard'] = 'admin/dashboard';

// Public routes
$route['home'] = 'home/index';
$route['artikel'] = 'home/artikel';
$route['artikel/(:any)'] = 'home/artikel_detail/$1';
$route['penduduk'] = 'home/penduduk';
$route['iuran'] = 'home/iuran';
$route['galeri'] = 'home/galeri';
$route['tentang'] = 'home/tentang';
$route['kontak'] = 'home/kontak';

// API routes for AJAX
$route['api/like-artikel'] = 'home/like_artikel';
$route['api/komentar-artikel'] = 'home/komentar_artikel';

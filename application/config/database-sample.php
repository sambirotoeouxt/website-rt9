<?php
/**
 * CodeIgniter Database Configuration
 *
 * IMPORTANT: Make a copy of this file and name it as 'database.php'
 * Then configure your database settings below
 */

$active_group = 'default';
$query_builder = TRUE;

// DEVELOPMENT - LOCAL
// Uncomment this section when working locally
/*
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'rt9_sambiroto',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
*/

// HOSTING/PRODUCTION
// Uncomment and configure this section for your hosting
/*
$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'your_hosting_hostname',
    'username' => 'your_database_username',
    'password' => 'your_database_password',
    'database' => 'your_database_name',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
*/

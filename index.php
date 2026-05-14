<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Website RT 9 Desa Sambiroto
 */

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;
    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
        break;
    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * SYSTEM DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" directory.
 * Set the path if it is not in the same directory as this file.
 */
$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "application"
 * directory than the default one you can set its name here. This
 * directory can also be renamed or relocated anywhere on your server.
 * If you do, use an absolute (full) server path.
 * For more info please see the user guide:
 * https://codeigniter.com/user_guide/basics/file_structure.html
 *
 * NO TRAILING SLASH!
 */
$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * VIEW DIRECTORY NAME
 *---------------------------------------------------------------
 *
 * If you want to move the view directory out of the application
 * folder set the path to it here. The directory can also be renamed
 * or relocated anywhere on your server. If you do, use an absolute
 * (full) server path.
 * For more info please see the user guide:
 * https://codeigniter.com/user_guide/basics/file_structure.html
 *
 * NO TRAILING SLASH!
 */
$view_folder = '';

/*
 * --------------------------------------------------------------------
 * DEFAULT CONTROLLER
 * --------------------------------------------------------------------
 *
 * Normally you will set your default controller in the routing config file.
 * You can, however, force a different controller or function if you want.
 * For more info, please read the user guide:
 * https://codeigniter.com/user_guide/general/routing.html
 */
// $routing['default_controller'] = 'home';

/*
 * -------------------------------------------------------------------
 *  RESOLVE THE SYSTEM PATH
 * -------------------------------------------------------------------
 */
if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp . DIRECTORY_SEPARATOR;
} else {
    // Ensure there is a slash on the end of the path
    $system_path = strtr(
        rtrim($system_path, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;
}

// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct it: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  RESOLVE THE APPLICATION FOLDER
 * -------------------------------------------------------------------
 */
if (($_temp = realpath($application_folder)) !== FALSE) {
    $application_folder = $_temp . DIRECTORY_SEPARATOR;
} else {
    if (!is_dir($application_folder)) {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct it: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
        exit(3); // EXIT_CONFIG
    }

    $application_folder = strtr(
        rtrim($application_folder, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR
    ) . DIRECTORY_SEPARATOR;
}

define('APPPATH', $application_folder);
define('BASEPATH', $system_path);

// Resolve the view path
if (empty($view_folder)) {
    $view_folder = APPPATH . 'views';
} elseif (($_temp = realpath($view_folder)) !== FALSE) {
    $view_folder = $_temp . DIRECTORY_SEPARATOR;
} else {
    if (!is_dir($view_folder)) {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct it: ' . pathinfo(__FILE__, PATHINFO_BASENAME);
        exit(3); // EXIT_CONFIG
    }
}

define('VIEWPATH', $view_folder);

/*
 * -------------------------------------------------------------------
 *  LOAD THE BOOTSTRAP FILE
 * -------------------------------------------------------------------
 *
 * And away we go...
 */
require_once BASEPATH . 'core/CodeIgniter.php';

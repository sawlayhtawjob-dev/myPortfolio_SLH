<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Site
|--------------------------------------------------------------------------
*/

define('SITE_NAME', 'Saw Lay Htaw Portfolio');
define('SITE_OWNER', 'SAWLAYHTAW');

define('BASE_URL', '/myPortfolio_SLH/');


/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'myportfolio_slh');
define('DB_USER', 'root');
define('DB_PASS', '');


/*
|--------------------------------------------------------------------------
| Paths
|--------------------------------------------------------------------------
*/

define('ROOT_PATH', dirname(__DIR__));

define('ASSET_URL', BASE_URL . 'assets/');
define('UPLOAD_URL', BASE_URL . 'uploads/');

define(
    'PROJECT_UPLOAD_DIR',
    ROOT_PATH . '/uploads/projects/'
);

define(
    'PROFILE_UPLOAD_DIR',
    ROOT_PATH . '/assets/images/'
);


/*
|--------------------------------------------------------------------------
| Timezone
|--------------------------------------------------------------------------
*/

date_default_timezone_set('Asia/Bangkok');


/*
|--------------------------------------------------------------------------
| Session
|--------------------------------------------------------------------------
|
| Start session only when no session is active.
|
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
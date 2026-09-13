<?php
declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Environment
|--------------------------------------------------------------------------
|
| Change this to 'production' when deploying to your live server.
|
*/

define('APP_ENV', 'local');


$isProduction = (APP_ENV === 'production');


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
|
| Local development:
|   DB_USER = root
|   DB_PASS = ''
|
| Production:
|   Replace these with your hosting database credentials.
|
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
| Error Handling
|--------------------------------------------------------------------------
|
| Never display PHP errors publicly in production.
| Errors should be logged instead.
|
*/

if ($isProduction) {

    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors', '1');

} else {

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ini_set('log_errors', '1');
}


/*
|--------------------------------------------------------------------------
| Session Security
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {

    /*
    | HTTPS detection
    |
    | On production, the site should always use HTTPS.
    |
    */

    $isHttps = (
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        ||
        (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
    );


    /*
    | Session cookie configuration
    */

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => BASE_URL,
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);


    session_start();
}


/*
|--------------------------------------------------------------------------
| Security Headers
|--------------------------------------------------------------------------
|
| These headers improve browser-side security.
|
*/

if (!headers_sent()) {

    header('X-Content-Type-Options: nosniff');

    header('X-Frame-Options: SAMEORIGIN');

    header('Referrer-Policy: strict-origin-when-cross-origin');

    header(
        'Permissions-Policy: camera=(), microphone=(), geolocation=()'
    );
}


/*
|--------------------------------------------------------------------------
| Application Constants
|--------------------------------------------------------------------------
*/

define('IS_PRODUCTION', $isProduction);
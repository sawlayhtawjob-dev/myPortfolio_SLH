<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';


/*
|--------------------------------------------------------------------------
| Escape Output
|--------------------------------------------------------------------------
*/

function e(?string $value): string
{
    return htmlspecialchars(
        $value ?? '',
        ENT_QUOTES | ENT_SUBSTITUTE,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| URL
|--------------------------------------------------------------------------
*/

function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}


/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

function redirect(string $path): never
{
    $location = url($path);

    header('Location: ' . $location, true, 302);
    exit;
}


/*
|--------------------------------------------------------------------------
| Request Helpers
|--------------------------------------------------------------------------
*/

function request_method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function is_post(): bool
{
    return request_method() === 'POST';
}

function post(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
}


/*
|--------------------------------------------------------------------------
| Require POST
|--------------------------------------------------------------------------
*/

function require_post(): void
{
    if (!is_post()) {
        http_response_code(405);
        header('Allow: POST');

        exit('Method Not Allowed.');
    }
}


/*
|--------------------------------------------------------------------------
| Database Helpers
|--------------------------------------------------------------------------
*/

function db_all(
    string $sql,
    array $params = []
): array {
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}


function db_one(
    string $sql,
    array $params = []
): ?array {
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    $result = $stmt->fetch();

    return $result ?: null;
}


function db_execute(
    string $sql,
    array $params = []
): bool {
    $stmt = db()->prepare($sql);

    return $stmt->execute($params);
}


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

function is_admin(): bool
{
    return isset($_SESSION['admin_id'])
        && is_scalar($_SESSION['admin_id'])
        && (int) $_SESSION['admin_id'] > 0;
}


function require_admin(): void
{
    if (!is_admin()) {
        redirect('admin/login.php');
    }
}


/*
|--------------------------------------------------------------------------
| Session Authentication
|--------------------------------------------------------------------------
*/

function login_admin(int $adminId): void
{
    session_regenerate_id(true);

    $_SESSION['admin_id'] = $adminId;
    $_SESSION['admin_login_at'] = time();

    /*
    | Regenerate CSRF token after authentication.
    */

    unset($_SESSION['csrf_token']);
}


function logout_admin(): void
{
    /*
    | Remove all session data.
    */

    $_SESSION = [];


    /*
    | Remove session cookie.
    */

    if (ini_get('session.use_cookies')) {

        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            [
                'expires'  => time() - 42000,
                'path'     => $params['path'] ?? '/',
                'domain'   => $params['domain'] ?? '',
                'secure'   => (bool) ($params['secure'] ?? false),
                'httponly' => (bool) ($params['httponly'] ?? true),
                'samesite' => $params['samesite'] ?? 'Lax',
            ]
        );
    }


    /*
    | Destroy server-side session.
    */

    session_destroy();
}


/*
|--------------------------------------------------------------------------
| CSRF Protection
|--------------------------------------------------------------------------
*/

function csrf_token(): string
{
    if (
        empty($_SESSION['csrf_token'])
        || !is_string($_SESSION['csrf_token'])
    ) {
        $_SESSION['csrf_token'] = bin2hex(
            random_bytes(32)
        );
    }

    return $_SESSION['csrf_token'];
}


function csrf_field(): string
{
    return sprintf(
        '<input type="hidden" name="csrf_token" value="%s">',
        e(csrf_token())
    );
}


function verify_csrf(): void
{
    if (!is_post()) {
        http_response_code(405);
        header('Allow: POST');

        exit('Method Not Allowed.');
    }

    $sessionToken = $_SESSION['csrf_token'] ?? '';
    $requestToken = $_POST['csrf_token'] ?? '';

    if (
        !is_string($sessionToken)
        || !is_string($requestToken)
        || $sessionToken === ''
        || $requestToken === ''
        || !hash_equals($sessionToken, $requestToken)
    ) {
        http_response_code(419);

        exit('Invalid or expired CSRF token.');
    }
}


/*
|--------------------------------------------------------------------------
| Flash Messages
|--------------------------------------------------------------------------
*/

function flash(
    string $key,
    ?string $message = null
): ?string {

    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;

        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;

    unset($_SESSION['flash'][$key]);

    return is_string($value) ? $value : null;
}


/*
|--------------------------------------------------------------------------
| Date Helpers
|--------------------------------------------------------------------------
*/

function format_date(?string $date): string
{
    if (!$date) {
        return '';
    }

    $timestamp = strtotime($date);

    if ($timestamp === false) {
        return '';
    }

    return date('M Y', $timestamp);
}


/*
|--------------------------------------------------------------------------
| Active Navigation
|--------------------------------------------------------------------------
*/

function active_page(string $page): string
{
    $currentPage = basename(
        $_SERVER['PHP_SELF'] ?? ''
    );

    return $currentPage === $page
        ? 'active'
        : '';
}


/*
|--------------------------------------------------------------------------
| Input Helpers
|--------------------------------------------------------------------------
*/

function clean_string(
    mixed $value,
    int $maxLength = 255
): string {
    if (!is_string($value)) {
        return '';
    }

    $value = trim($value);

    if ($value === '') {
        return '';
    }

    if (mb_strlen($value) > $maxLength) {
        $value = mb_substr(
            $value,
            0,
            $maxLength
        );
    }

    return $value;
}


function positive_int(mixed $value): int
{
    $number = filter_var(
        $value,
        FILTER_VALIDATE_INT,
        [
            'options' => [
                'min_range' => 1,
            ],
        ]
    );

    return $number !== false
        ? (int) $number
        : 0;
}


/*
|--------------------------------------------------------------------------
| URL Validation
|--------------------------------------------------------------------------
*/

function valid_url(?string $value): bool
{
    if (!$value) {
        return false;
    }

    return filter_var(
        $value,
        FILTER_VALIDATE_URL
    ) !== false;
}
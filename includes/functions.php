<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

/*
|--------------------------------------------------------------------------
| Escape
|--------------------------------------------------------------------------
*/
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
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
    header('Location: ' . url($path));
    exit;
}

/*
|--------------------------------------------------------------------------
| Request
|--------------------------------------------------------------------------
*/
function is_post(): bool
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function post(string $key, mixed $default = ''): mixed
{
    return $_POST[$key] ?? $default;
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
    return !empty($_SESSION['admin_id']);
}

function require_admin(): void
{
    if (!is_admin()) {
        redirect('admin/login.php');
    }
}

/*
|--------------------------------------------------------------------------
| CSRF
|--------------------------------------------------------------------------
*/
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' .
        e(csrf_token()) .
        '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (
        empty($_SESSION['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $token)
    ) {
        http_response_code(419);
        exit('Invalid CSRF token.');
    }
}

/*
|--------------------------------------------------------------------------
| Flash Messages
|--------------------------------------------------------------------------
*/
function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    $value = $_SESSION['flash'][$key] ?? null;

    unset($_SESSION['flash'][$key]);

    return $value;
}

/*
|--------------------------------------------------------------------------
| Date
|--------------------------------------------------------------------------
*/
function format_date(?string $date): string
{
    if (!$date) {
        return '';
    }

    return date('M Y', strtotime($date));
}

/*
|--------------------------------------------------------------------------
| Active Navigation
|--------------------------------------------------------------------------
*/
function active_page(string $page): string
{
    return basename($_SERVER['PHP_SELF']) === $page ? 'active' : '';
}
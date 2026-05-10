<?php

declare(strict_types=1);

ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('session.use_only_cookies', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Strict');

const APP_CSP_POLICY = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:; font-src 'self'; connect-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'none'; object-src 'none'";

if (!headers_sent()) {
    header('Content-Security-Policy: ' . APP_CSP_POLICY);
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('Referrer-Policy: same-origin');
}

function app_secure_session_start(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['SERVER_PORT'] ?? null) === '443');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Strict',
    ]);

    session_start();
}

function app_csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        app_secure_session_start();
    }

    if (empty($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function app_csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . app_escape(app_csrf_token()) . '">';
}

function app_csrf_meta(): string
{
    return '<meta name="csrf-token" content="' . app_escape(app_csrf_token()) . '">';
}

function app_validate_csrf_token(): void
{
    $submittedToken = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

    if (!is_string($submittedToken) || !hash_equals(app_csrf_token(), $submittedToken)) {
        app_json_response([
            'success' => false,
            'message' => 'Invalid security token. Please refresh the page and try again.',
        ], 403);
        exit;
    }
}

function app_json_response(array $payload, int $statusCode = 200): void
{
    if (!headers_sent()) {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
    }

    echo json_encode($payload);
}

function app_require_post(bool $validateCsrf = true): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        app_json_response([
            'success' => false,
            'message' => 'Invalid request method.',
        ], 405);
        exit;
    }

    if ($validateCsrf) {
        app_validate_csrf_token();
    }
}

function app_require_role(string $role): void
{
    if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== $role) {
        app_json_response([
            'success' => false,
            'message' => 'Unauthorized request.',
        ], 403);
        exit;
    }
}

function app_escape(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

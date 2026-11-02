<?php

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}

/**
 * Escape string for safe HTML output (XSS protection)
 */
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Determine dynamic base URL for subfolder or virtual host installations
 */
function base_url(string $path = ''): string {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $base = rtrim($scriptDir, '/');
    $cleanPath = '/' . ltrim($path, '/');
    return $base . $cleanPath;
}

/**
 * Redirect to specific path within the application
 */
function redirect(string $path): void {
    header('Location: ' . base_url($path));
    exit;
}

/**
 * Set flash message in session
 */
function set_flash(string $type, string $message): void {
    $_SESSION['flash'][$type] = $message;
}

/**
 * Get and clear flash message
 */
function get_flash(string $type): ?string {
    if (isset($_SESSION['flash'][$type])) {
        $msg = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $msg;
    }
    return null;
}

/**
 * Check if a flash message exists
 */
function has_flash(string $type): bool {
    return !empty($_SESSION['flash'][$type]);
}

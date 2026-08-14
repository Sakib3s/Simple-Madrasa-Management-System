<?php

declare(strict_types=1);

function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $location): never
{
    header("Location: {$location}");
    exit;
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function selected(string|int|null $value, string|int|null $expected): string
{
    return (string) $value === (string) $expected ? 'selected' : '';
}

function checked(string|int|null $value, string|int|null $expected): string
{
    return (string) $value === (string) $expected ? 'checked' : '';
}

function page_title(string $title): string
{
    return $title . ' | Madrasa Management';
}

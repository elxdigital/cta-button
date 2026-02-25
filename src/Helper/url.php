<?php

function getFullUrl(string $path = null): string
{
    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_TEST;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

function seeFullUrl(string $url, ?bool $translate_url = false): string
{
    if (str_contains($url, 'http://') || str_contains($url, 'https://')) {
        return $url;
    }

    if (str_starts_with($url, '#')) {
        return $url;
    }

    if (str_starts_with($url, '/')) {
        return !$translate_url ? getFullUrl($url) : urlComTraducao($url);
    }

    return $url;
}

function urlComTraducao(?string $path = null): string
{
    $_SESSION['lang'] = $_SESSION['lang'] ?? "pt";

    if (strpos($_SERVER['HTTP_HOST'], "localhost")) {
        if ($path) {
            return CONF_URL_TEST . "/" . $_SESSION['lang'] . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }

        return CONF_URL_TEST . "/" . $_SESSION['lang'];
    }

    if ($path) {
        return CONF_URL_BASE . "/" . $_SESSION['lang'] . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE . "/" . $_SESSION['lang'];
}

function openOnNewWindow(string $url): bool
{
    return (str_contains($url, 'http://') || str_contains($url, 'https://'));
}

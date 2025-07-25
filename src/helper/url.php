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

function seeFullUrl(string $url): string
{
    if (str_contains($url, 'http://') || str_contains($url, 'https://')) {
        return $url;
    }

    if (str_starts_with($url, '#')) {
        return $url;
    }

    if (str_starts_with($url, '/')) {
        return getFullUrl($url);
    }

    return $url;
}

function openOnNewWindow(string $url): bool
{
    return (str_contains($url, 'http://') || str_contains($url, 'https://'));
}

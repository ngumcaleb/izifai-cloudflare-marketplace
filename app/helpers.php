<?php

if (!function_exists('r2_url')) {
    function r2_url($path): ?string
    {
        if (!$path) return null;
        return url('/r2/' . ltrim($path, '/'));
    }
}

<?php

if (!function_exists('r2_url')) {
    function r2_url($path): ?string
    {
        if (!$path) return null;
        return url('/r2/' . ltrim($path, '/'));
    }
}

if (!function_exists('wa_url')) {
    function wa_url($number): string
    {
        if (!$number) return '';
        $cleaned = preg_replace('/[^0-9]/', '', $number);
        if (!str_starts_with($cleaned, '237')) {
            $cleaned = '237' . $cleaned;
        }
        return $cleaned;
    }
}

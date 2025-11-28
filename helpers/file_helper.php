<?php
function normalize_public_path(string $path): string
{
    $clean = str_replace(['..\\', '../', '.\\'], '', $path);
    $clean = ltrim($clean, '/');
    return $clean;
}

function view_file_href(string $path, string $prefix = '../../'): string
{
    return $prefix . normalize_public_path($path);
}

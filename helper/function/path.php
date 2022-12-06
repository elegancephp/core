<?php

if (!function_exists('path')) {

    /** Formata um caminho de diretório */
    function path(): string
    {
        $path = array_filter(func_get_args(), fn ($i) => !is_blank($i));
        $path = str_replace('\\', '/', implode('/', $path));
        $path = str_trim($path, '/', '/ ');
        $path = str_replace_all('//', '/', $path);
        return $path;
    }
}
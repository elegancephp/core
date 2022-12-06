<?php

use Elegance\File;
use Elegance\Import;

if (!function_exists('jsonFile')) {

    /** Manipula arquivos JSON */
    function jsonFile(string $file, array $value = [], bool $merge = false): array
    {
        File::ensure_extension($file, 'json');

        $content = [];

        if (File::check($file)) {
            $content = Import::content($file);
            $content = is_json($content) ? json_decode($content, true) : [];
        }

        if (func_num_args() > 1) {
            $content = $merge ? [...$content, ...$value] : $value;
            $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            File::create($file, $json, true);
        }

        return $content;
    }
}

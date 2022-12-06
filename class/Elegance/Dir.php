<?php

namespace Elegance;

abstract class Dir
{
    /** Cria um diretório */
    static function create(string $path): ?bool
    {
        $path = self::getOnly($path);

        if (!is_dir($path)) {
            $createList = explode('/', $path);
            $createPath = '';
            foreach ($createList as $creating) {
                $createPath = ($createPath == '') ? $creating : self::getOnly("$createPath/$creating");
                if ($createPath != '.' && $createPath != '..' && !empty($createPath) && !self::check($createPath)) {
                    mkdir($createPath);
                }
            }
            return is_dir($path);
        }
        return null;
    }

    /** Remove um diretório */
    static function remove(string $path, bool $recursive = false): ?bool
    {
        $path = self::getOnly($path);

        if (is_dir($path)) {
            if ($recursive || empty(self::seek_for_all($path))) {
                $drop = function ($path, $function) {
                    foreach (scandir($path) as $iten) {
                        if ($iten != '.' && $iten != '..') {
                            if (is_dir("$path/$iten")) {
                                $function("$path/$iten", $function);
                            } else {
                                unlink("$path/$iten");
                            }
                        }
                    }
                    rmdir($path);
                };
                $drop($path, $drop);
            }
            return !is_dir($path);
        }
        return null;
    }

    /** Cria uma copia de um diretório */
    static function copy(string $path_from, string $path_for, bool $replace = false): ?bool
    {
        if (self::check($path_from)) {
            self::create($path_for);
            $copy = function ($from, $for, $replace, $function) {
                foreach (self::seek_for_dir($from) as $dir) {
                    $function("$from/$dir", "$for/$dir", $replace, $function);
                }
                foreach (self::seek_for_file($from) as $file) {
                    File::copy("$from/$file", "$for/$file", $replace);
                }
            };
            $copy($path_from, $path_for, $replace, $copy);
            return true;
        }
        return null;
    }

    /** Altera o local de um diretório */
    static function move(string $path_from, string $path_for): ?bool
    {
        if (!self::check($path_for) && self::check($path_from)) {
            $path_from = path($path_from);
            $path_for = path($path_for);
            return boolval(rename($path_from, $path_for));
        }
        return null;
    }

    /** Vasculha um diretório em busca de arquivos */
    static function seek_for_file(string $path, bool $recursive = false): array
    {
        $return = [];
        foreach (self::seek_for_all($path, $recursive) as $item) {
            if (File::check("$path/$item")) {
                $return[] = $item;
            }
        }
        return $return;
    }

    /** Vasculha um diretório em busca de diretórios */
    static function seek_for_dir(string $path, bool $recursive = false): array
    {
        $return = [];
        foreach (self::seek_for_all($path, $recursive) as $item) {
            if (self::check("$path/$item")) {
                $return[] = $item;
            }
        }
        return $return;
    }

    /** Vasculha um diretório em busca de arquivos e diretórios */
    static function seek_for_all(string $path, bool $recursive = false): array
    {
        $path = self::getOnly($path);
        $return = [];
        if (is_dir($path)) {
            foreach (scandir($path) as $item) {
                if ($item != '.' && $item != '..') {
                    $return[] = $item;
                    if ($recursive && self::check("$path/$item")) {
                        foreach (self::seek_for_all("$path/$item", true) as $subItem) {
                            $return[] = "$item/$subItem";
                        }
                    }
                }
            }
        }
        return $return;
    }

    /** Retorna um caminho sem referenciar arquivos */
    static function getOnly(string $path): string
    {
        $path = path($path);
        if (!is_dir($path) && $path != '.') {
            $path = explode('/', $path);
            if (strpos(end($path), '.') !== false) {
                array_pop($path);
            }
            $path = implode('/', $path);
        }
        return $path;
    }

    /** Verifica se um diretório existe */
    static function check(string $path): bool
    {
        return is_dir(path($path));
    }
}

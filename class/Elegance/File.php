<?php

namespace Elegance;

abstract class File
{
    /** Cria um arquivo de texto */
    static function create(string $path, string $content, bool $recreate = false): ?bool
    {
        if ($recreate || !self::check($path)) {
            $path = path($path);
            Dir::create($path);
            $fp = fopen($path, 'w');
            fwrite($fp, $content);
            fclose($fp);
            return true;
        }
        return null;
    }

    /** Remove um arquivo */
    static function remove(string $path): ?bool
    {
        if (self::check($path)) {
            $path = path($path);
            unlink($path);
            return !is_file($path);
        }
        return null;
    }

    /** Cria uma copia de um arquivo */
    static function copy(string $path_from, string $path_for, bool $recreate = false): ?bool
    {
        if ($recreate || !self::check($path_for)) {
            if (self::check($path_from)) {
                Dir::create($path_for);
                return boolval(copy(path($path_from), path($path_for)));
            }
        }
        return null;
    }

    /** Altera o local de um arquivo */
    static function move(string $path_from, string $path_for, bool $replace = false): ?bool
    {
        if ($replace || !self::check($path_for)) {
            if (self::check($path_from)) {
                Dir::create($path_for);
                return boolval(rename(path($path_from), path($path_for)));
            }
        }
        return null;
    }

    /** Retorna apenas o nome do arquivo */
    static function getOnly(string $path): string
    {
        $path = path($path);
        $path = explode('/', $path);
        return array_pop($path);
    }

    /** Retorna a extensão do arquivo */
    static function getEx(string $path): string
    {
        $parts = explode('.', self::getOnly($path));
        return strtolower(end($parts));
    }

    /** Verifica se um arquivo existe */
    static function check(string $path): bool
    {
        return is_file(path($path));
    }

    /** Garante que a referencia aponta para um arquivo com uma das extensões forneceidas */
    static function ensure_extension(string &$path, array|string $extensions = 'php'): void
    {
        $extensions = is_array($extensions) ? $extensions : [$extensions];

        $extensions = array_map(fn ($i) => str_replace('.', '', $i), $extensions);

        $path_ex = explode('.', $path);
        $path_ex = array_pop($path_ex);

        if (!in_array($path_ex, $extensions))
            $path .= '.' . $extensions[0];
    }
}

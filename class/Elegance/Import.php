<?php

namespace Elegance;

abstract class Import
{
    /** Retorna o conteúdo de um aquivo */
    static function content(string $filePath, string|array $prepare = []): string
    {
        $filePath = path($filePath);

        $content = File::check($filePath) ? file_get_contents($filePath) : '';

        return Prepare::prepare($content, $prepare);
    }

    /** Retorna o resultado (return) em um arquivo php  */
    static function return(string $filePath, array $params = []): mixed
    {
        $filePath = path($filePath);

        File::ensure_extension($filePath, 'php');

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, &$__PARAMS__) {

                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];

                ob_start();
                $__RETURN__ = require $__FILEPATH__;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);
        }

        return $return ?? null;
    }

    /** Retorna o valor de uma variavel dentro de em um arquivo php  */
    static function var(string $filePath, string $varName, array $params = []): mixed
    {
        $filePath = path($filePath);
        File::ensure_extension($filePath, 'php');

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, $__VARNAME__, &$__PARAMS__) {

                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];

                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = $$__VARNAME__ ?? null;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $varName, $params);
        }

        return $return ?? null;
    }

    /** Retorna a saída de texto gerada por um arquivo */
    static function output(string $filePath, array $params = []): string
    {
        $filePath = path($filePath);

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, &$__PARAMS__) {

                foreach (array_keys($__PARAMS__) as $__KEY__)
                    if (!is_numeric($__KEY__))
                        $$__KEY__ = &$__PARAMS__[$__KEY__];

                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = ob_get_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);
        }

        return $return ?? '';
    }
}

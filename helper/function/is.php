<?php

if (!function_exists('is_class')) {

    /** Verifica se um objeto é ou extende uma classe */
    function is_class(mixed $object, object|string $class): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;
            $class = is_string($class) ? $class : $class::class;

            if (class_exists($object) && class_exists($class))
                return $object == $class || isset(class_parents($object)[$class]);
        }

        return false;
    }
}

if (!function_exists('is_extend')) {

    /** Verifica se um objeto extende uma classe */
    function is_extend(mixed $object, object|string $class): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;
            $class = is_string($class) ? $class : $class::class;

            if (class_exists($object) && class_exists($class))
                return isset(class_parents($object)[$class]);
        }

        return false;
    }
}

if (!function_exists('is_implement')) {

    /** Verifica se um objeto implementa uma interface */
    function is_implement(mixed $object, object|string $interface): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;

            if (class_exists($object) && interface_exists($interface))
                return isset(class_implements($object)[$interface]);
        }

        return false;
    }
}

if (!function_exists('is_trait')) {

    /** Verifica se um objeto utiliza uma trait */
    function is_trait(mixed $object, object|string|null $trait): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;

            if (class_exists($object) && trait_exists($trait)) {
                if (isset(class_uses($object)[$trait]))
                    return true;

                foreach (class_parents($object) as $parrent)
                    if (isset(class_uses($parrent)[$trait]))
                        return true;
            }
        }

        return false;
    }
}

if (!function_exists('is_blank')) {

    /** Verifica se uma variavel é nula, vazia ou composta de espaços em branco */
    function is_blank(mixed $var): bool
    {
        if (is_string($var))
            $var = trim($var);

        return (empty($var) && !is_numeric($var) && !is_bool($var));
    }
}

if (!function_exists('is_md5')) {

    /** Verifica se uma variavel é hash MD5 */
    function is_md5(mixed $var): bool
    {
        return is_string($var) ? boolval(preg_match('/^[a-fA-F0-9]{32}$/', $var)) : false;
    }
}

if (!function_exists('is_json')) {

    /** Verifica se uma variavel é uma string JSON */
    function is_json(mixed $var): bool
    {
        if (is_string($var))
            try {
                json_decode($var);
                return json_last_error() === JSON_ERROR_NONE;
            } catch (Error | Exception) {
            }

        return false;
    }
}

if (!function_exists('is_closure')) {

    /** Verifica se uma variavel é uma função anonima ou objeto callable */
    function is_closure(mixed $var): bool
    {
        return ($var instanceof Closure) || (is_object($var) && is_callable($var));
    }
}

if (!function_exists('is_stringable')) {

    /** Verifica se uma variavel é uma string ou um objeto Stringable */
    function is_stringable(mixed $var): bool
    {
        return is_string($var) || ($var instanceof Stringable);
    }
}

if (!function_exists('is_base64')) {

    /** Verifica se uma variavel é uma string base64 */
    function is_base64(mixed $var): bool
    {
        if (is_string($var))
            if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $var)) {
                $decoded = base64_decode($var, true);
                if ($decoded !== false)
                    return base64_encode($decoded) == $var;
            }

        return true;
    }
}
<?php

namespace Elegance;

abstract class Prepare
{
    /** Prepara um texto para ser exibido subistituindo ocorrencias do template */
    static function prepare(?string $string, array|string $prepare = []): ?string
    {
        if ($string && !is_blank($prepare)) {
            $commands = self::getPrepareCommands($string);
            if (!empty($commands)) {
                $prepare = self::combinePrepare($prepare);
                $string = self::resolve($string, $commands, $prepare);
            }
        }
        return $string;
    }

    /** Escapa as tags prepare de um texto */
    static function scape($string, ?array $prepare = null): string
    {
        if ($prepare) {
            $prepare = self::combinePrepare($prepare);
            $prepare = array_keys($prepare);

            $replace = array_map(fn ($value) => "[&#35$value]", $prepare);
            $prepare = array_map(fn ($value) => "[#$value]", $prepare);

            return str_replace($prepare, $replace, $string);
        } else {
            return str_replace('[#', "[&#35", $string);
        }
    }

    /** Resolve uma string aplicando os comandos de prepare */
    protected static function resolve(string $string, array $commands, array $prepare): string
    {
        list($sequence, $reference) = self::separePrepareTypes($prepare);

        $getPrepareReplace = function ($ref, $bruteCommand) use (&$sequence, &$reference) {
            if (str_starts_with($ref, '#')) {
                if ($ref == '#') {
                    $ref = array_shift($sequence) ?? '[#]';
                } else {
                    $ref = $reference[substr($ref, 1)] ?? "[$bruteCommand]";
                }
            }

            if (is_numeric($ref)) $ref = intval($ref);

            return  match ($ref) {
                'TRUE' => true,
                'FALSE' => false,
                'NULL' => null,
                default => $ref
            };
        };

        foreach ($commands as $search) {
            if (strpos($string, $search) !== false) {

                $bruteCommand = substr($search, 1, -1);
                $command = $bruteCommand;
                $params = [];

                if (strpos($command, ':') !== false) {
                    $params = explode(':', $command);
                    $command = array_shift($params);
                    $params = implode(':', $params);
                    $params = explode(',', $params);
                    $params = array_map(
                        fn ($value) => $getPrepareReplace($value, $bruteCommand),
                        $params
                    );
                }

                if (strpos($command, '?') !== false) {
                    $command = explode('?', $command);
                    $command = array_filter($command, fn ($value) => !is_blank($value));
                    $command = array_map(
                        fn ($value) => $getPrepareReplace($value, $bruteCommand),
                        $command
                    );

                    $result = array_shift($command);

                    $op1 = array_shift($command) ?? '';
                    $op2 = array_shift($command) ?? array_shift($params) ?? '';

                    $command = $result ? $op1 : $op2;
                }

                $replace = $getPrepareReplace($command, $bruteCommand);

                if (is_closure($replace))
                    $replace = $replace(...$params);

                if (!is_null($replace))
                    if ($command == '#') {
                        $string = str_replace_first($search, $replace, $string);
                    } else {
                        $string = str_replace($search, $replace, $string);
                    }
            }
        }

        return $string;
    }

    /** Separa um array prepare em parametros sequenciais dos referenciados */
    protected static function separePrepareTypes(array $prepare): array
    {
        $sequence = [];
        $reference = [];
        foreach ($prepare as $key => $value) {
            if (is_numeric($key)) {
                $sequence[] = $value;
            } else {
                $reference[$key] = $value;
            }
        }
        return [$sequence, $reference];
    }

    /** Combina subarray de prepare em um prepare de array unico */
    protected static function combinePrepare(array|string $prepare): array
    {
        $prepare = is_array($prepare) ? $prepare : [$prepare];
        foreach ($prepare as $key => $value) {
            if (is_array($value)) {
                unset($prepare[$key]);
                foreach (self::combinePrepare($value) as $subKey => $subValue) {
                    $newKey = $subKey == '.' ? $key : "$key.$subKey";
                    $prepare[$newKey] = $subValue;
                }
            }
        }
        return $prepare;
    }

    /** Retorna os comandos prepare existentes dentro da string */
    protected static function getPrepareCommands(string $string): array
    {
        preg_match_all("#\[[\#\>][^\]]*+\]#i", $string, $commands);
        return array_shift($commands);
    }
}
<?php

namespace App;

class URL
{

    /**
     * Force l'utilisateur à mettre seulement des entiers dans l'url
     *
     * @param string $name
     * @param int|null $default
     * @return int|null
     * @throws \Exception
     */
    public static function getInt(string $name, ?int $default = null): ?int
    {
        if (!isset($_GET[$name])) return $default;
        if ($_GET[$name] === '0') return 0;

        if (!filter_var($_GET[$name], FILTER_VALIDATE_INT)) {
            throw new \Exception('Numéro de page invalide');
        }
        return (int)$_GET[$name];
    }

    /**
     * Bloque l'utilisateur à rentrer un chiffre négatif dans l'url
     *
     * @param string $name
     * @param int|null $default
     * @return int|null
     * @throws \Exception
     */
    public static function getPositiveInt(string $name, ?int $default = null): ?int
    {
        $param = self::getInt($name, $default);
        if ($param !== null && $param <= 0) {
            throw new \Exception('Numéro de page invalide');
        }
        return $param;
    }
}
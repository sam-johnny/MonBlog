<?php

namespace App;

class ObjectHandler
{


    /**
     * Méthode pour hydrater les objets
     *
     * @param $object
     * @param array $data $_POST
     * @param array $fields les champs
     */
    public static function hydrate($object, array $data, array $fields): void
    {
        foreach ($fields as $field) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
            $object->$method($data[$field]);
        }
    }
}
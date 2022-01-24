<?php
namespace App\Table\Exception;


class NotFoundException extends \Exception
{

    /**
     * Exception si aucun enregistrement ne correspond à la table
     *
     * @param string $table
     * @param $id
     */
    public function __construct(string $table, $id)
    {
        $this->message = "Aucun enregistrement ne correspond à l'id #$id dans la table '$table'";
    }
}
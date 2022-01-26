<?php

namespace App\Model\Manager;

use App\Model\Entity\User;
use App\Table\Exception\NotFoundException;

/**
 * Class UserManager
 * requêtes SQL par table
 */
class UserManager extends AbstractManager
{
    protected $table = "user";
    protected $class = User::class;

    /**
     * Récupère les données lié à l'username dans la base de données
     *
     * @param string $username
     * @return mixed
     * @throws NotFoundException
     */
    public function findByUsername(string $username)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE username = :username;');
        $query->execute(['username' => $username]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $username);
        }
        return $result;
    }

    /**
     * Crée les données lié au tableau dans la base de données
     * La partie execute de la méthode create de class AbstractManager
     *
     * @param User $user
     * @throws \Exception
     */
    public function createUser(User $user): void
    {
        $create = $this->create([
            'username' => $user->getUsername(),
            'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
            'email' => $user->getEmail(),
            'role' => 'membre'
        ]);
        $user->setID($create);

    }
}

<?php

namespace App\Table;

use App\Model\User;
use App\Table\Exception\NotFoundException;

class UserTable extends AbstractTable
{
    protected $table = "user";
    protected $class = User::class;

    public function findByUsername(string $username)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $query->execute(['username' => $username]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $username);
        }
        return $result;
    }

    public function createUser(User $user): void
    {
        $id = $this->create([
            'username' => $user->getUsername(),
            'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
            'email' => $user->getEmail(),
            'role' => 'Non attribué'
        ]);
        $user->setID($id);

    }
}

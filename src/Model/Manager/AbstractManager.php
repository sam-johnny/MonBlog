<?php
namespace App\Model\Manager;

use App\Exception\NotFoundException;
use \PDO;

/**
 * Class AbstractManager
 * requêtes SQL générales
 */
class AbstractManager
{
    protected $pdo;
    protected $table = null;
    protected $class = null;


    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère des données
     *
     * @param int $id
     * @return mixed
     * @throws NotFoundException
     */
    public function find (int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id;');
        $query->execute(['id' => $id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    /**
     * Vérifie si une valeur existe en base de données
     *
     * @param string $field Champs à rechercher
     * @param mixed $value Valeur associée au champs
     * @param int|null $except
     * @return bool
     */
    public function exists (string $field, $value, ?int $except = null): bool
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?;";
        $params = [$value];
        if ($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    /**
     * Récupère toutes les données lié à la table dans la base de données
     *
     * @return array
     */
    public function all (): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    /**
     * Supprime les éléments lié à l'id dans la base de données
     *
     * @param int $id
     * @throws \Exception
     */
    public function delete (int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?;");
        $queryExecute = $query->execute([$id]);
        if ($queryExecute === false) {
            throw new \Exception("Impossible de supprimer l'enregistrement $id dans la table {$this->table}");
        }
    }

    /**
     * Crée les données lié au tableau dans la base de données
     *
     * @param array $data
     * @return int
     * @throws \Exception
     */
    public function create (array $data)
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET " . implode(', ', $sqlFields));
        $queryExecute = $query->execute($data);
        if ($queryExecute === false) {
            throw new \Exception("Impossible de créer l'enregistrement dans la table {$this->table}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Modifie les données dans la base de données
     *
     * @param array $data
     * @param int $id
     * @throws \Exception
     */
    public function update (array $data, int $id)
    {
        $sqlFields = [];
        foreach ($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE id = :id");
        $queryExecute = $query->execute(array_merge($data, ['id' => $id]));
        if ($queryExecute === false) {
            throw new \Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }

    /**
     * Récupère les données lié à la requête sql dans la base de données
     *
     * @param string $sql
     * @return array
     */
    public function queryAndFetchAll (string $sql): array
    {
       return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }
}


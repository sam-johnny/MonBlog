<?php

namespace App\Model\Manager;

use App\Model\Entity\Comment;

/**
 * Class CommentManager
 * requêtes SQL par table
 */
class CommentManager extends AbstractManager
{
    protected $table = "comment";
    protected $class = Comment::class;


    /**
     * Récupère les commentaires à afficher sur les articles
     *
     * @param int $id
     * @return array
     */
    public function findComments(int $id): array
    {
        $comments = $this->pdo
            ->query("SELECT *
                            FROM {$this->table}
                            WHERE post_id = {$id} AND status = 1
                            ORDER BY id DESC;")
            ->fetchAll(\PDO::FETCH_CLASS, $this->class);
        return $comments;
    }


    /**
     * Récupère les commentaires non validés
     * Pour la partie admin
     *
     * @return array
     */
    public function findCommentsNotValide(): array
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} 
                                            WHERE status = 0
                                            ORDER BY id DESC;");
    }

}



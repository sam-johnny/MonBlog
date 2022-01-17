<?php

namespace App\Table;

use App\Model\Comment;
use App\PaginatedQuery;

class CommentTable extends AbstractTable
{
    protected $table = "comment";
    protected $class = Comment::class;


    public function findComments(int $id): array
    {
        $comments = $this->pdo
            ->query("SELECT *
                            FROM {$this->table}
                            WHERE post_id = {$id} AND status = 1
                            ORDER BY id DESC")
            ->fetchAll(\PDO::FETCH_CLASS, $this->class);
        return $comments;
    }


    public function findCommentsNotValide(): array
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} 
                                            WHERE status = 0
                                            ORDER BY id DESC");
    }

}



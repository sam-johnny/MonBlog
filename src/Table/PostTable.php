<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;

class PostTable extends AbstractTable
{
    protected $table = "post";
    protected $class = Post::class;

    public function updatePost(Post $post): void
    {
        $this->update([
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ], $post->getID());
    }

    public function createPost(Post $post): void
    {
        $id = $this->create([
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $post->setID($id);

    }

    public function attachCategories(int $id, array $categories): void
    {
        $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ?');
        foreach ($categories as $category) {
            $query->execute([$id, $category]);
        }
    }


    public function findPaginated(int $limitPage): array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM {$this->table}",
            $limitPage,
            $this->pdo,
        );
        $posts = $paginatedQuery->getItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        $totalPages = $paginatedQuery->getTotalPages();
        return [$posts, $paginatedQuery, $totalPages];
    }

    public function findPaginatedForCategory(int $categoryID, int $limitPage): array
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.*
            FROM {$this->table} p
            JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = {$categoryID}
            ORDER BY created_at DESC",
            "SELECT COUNT(category_id) FROM post_category WHERE category_id = {$categoryID}",
            $limitPage
        );
        $posts = $paginatedQuery->getItems($this->class);
        (new CategoryTable($this->pdo))->hydratePosts($posts);
        $totalPages = $paginatedQuery->getTotalPages();
        return [$posts, $paginatedQuery, $totalPages];
    }

}

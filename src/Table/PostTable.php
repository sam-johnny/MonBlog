<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;

/**
 * Class PostTable
 * requêtes SQL par table
 */
class PostTable extends AbstractTable
{
    protected $table = "post";
    protected $class = Post::class;

    /**
     * Modifie les données lié au tableau dans la base de données
     * La partie execute de la méthode update de class AbstractTable
     *
     * @param Post $post
     * @throws \Exception
     */
    public function updatePost(Post $post): void
    {
        $this->update([
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'chapo' => $post->getChapo(),
            'update_at' => date('Y-m-d H:i:s')
        ], $post->getID());
    }

    /**
     * Crée les données lié au tableau dans la base de données
     * La partie execute de la méthode create de class AbstractTable
     *
     * @param Post $post
     * @throws \Exception
     */
    public function createPost(Post $post): void
    {
        $create = $this->create([
            'title' => $post->getTitle(),
            'slug' => $post->getSlug(),
            'chapo' => $post->getChapo(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
            'user_id' => $_SESSION['auth']['id'],
            'update_at' => '2010-01-01'
        ]);
        $post->setID($create);

    }

    /**
     * Supprime la catégorie attachée à l'article
     *
     * @param int $id
     * @param array $categories
     */
    public function attachCategories(int $id, array $categories): void
    {
        $this->pdo->exec('DELETE FROM post_category WHERE post_id = ' . $id);
        $query = $this->pdo->prepare('INSERT INTO post_category SET post_id = ?, category_id = ?');
        foreach ($categories as $category) {
            $query->execute([$id, $category]);
        }
    }


    /**
     * Récupère les articles pour notre listing avec le nombre d'article à afficher par page
     *
     * @param int $limitPage
     * @return array
     * @throws \Exception
     */
    public function findPaginated(int $limitPage)
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

    /**
     * Récupère les articles pour notre listing avec le nombre d'article à afficher par page
     * Pour la liste des articles par catégorie
     *
     * @param int $categoryID
     * @param int $limitPage
     * @return array
     * @throws \Exception
     */
    public function findPaginatedForCategory(int $categoryID, int $limitPage)
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

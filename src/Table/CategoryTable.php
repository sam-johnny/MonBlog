<?php

namespace App\Table;

use App\Model\Category;
use App\Table\Exception\NotFoundException;
use \PDO;

class CategoryTable extends Table
{
    protected $table = 'category';
    protected $class = Category::class;

    public function find(int $id): ?Category
    {
        $query = $this->pdo->prepare('SELECT * FROM category WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, \App\Model\Category::class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException('category', $id);
        }
        return $result;
    }

    /**
     * @param App\Model\Post[] $posts
     */
    public function categoriesInPosts(array $posts): void
    {
        $postById = [];
        foreach ($posts as $post) {
            $postById[$post->getID()] = $post;
        }
        $categories = $this->pdo->query('SELECT c.*, pc.post_id
                            FROM post_category pc
                            JOIN category c ON c.id = pc.category_id
                            WHERE pc.post_id IN (' . implode(',', array_keys($postById)) . ')'
        )->fetchAll(PDO::FETCH_CLASS, \App\Model\Category::class);

        foreach ($categories as $category) {
            $postById[$category->getPostID()]->addCategory($category);
        }
    }
}
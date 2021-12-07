<?php

namespace App\Model;

use App\Helpers\Text;

class Post
{
    private $id;
    private $name;
    private $content;
    private $created_at;
    private $slug;
    private $categories = [];

    public function getName(): ?string
    {
        return htmlentities($this->name);
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 110)));
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    /**
     * @return Category[]
     */
    public function getCategories () : array
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }
}
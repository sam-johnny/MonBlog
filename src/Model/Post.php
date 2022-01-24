<?php

namespace App\Model;

use App\Helper\TextHelper;

class Post
{
    private $id;
    private $title;
    private $chapo;
    private $content;
    private $created_at;
    private $slug;
    private $categories = [];
    private $user_id;
    private $update_at;

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title ;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

    /**
     * @return string|null
     */
    public function getExcerpt(): ?string
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(TextHelper::excerpt($this->content, 110)));
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getID(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return Category[]
     */
    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    /**
     * @return array
     */
    public function getCategoriesIds(): array
    {
        $ids = [];
        foreach ($this->categories as $category) {
            $ids[] = $category->getID();
        }
        return $ids;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * @return int|null
     */
    public function getUserID(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     */
    public function setUserID(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string|null
     */
    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    /**
     * @param string $chapo
     * @return $this
     */
    public function setChapo(string $chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getUpdateAt(): \DateTime
    {
        return new \DateTime($this->update_at);
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setUpdateAt(string $date): self
    {
        $this->update_at = $date;
        return $this;
    }
}
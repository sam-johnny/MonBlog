<?php

namespace App\Model;

class Category
{
    private $id;
    private $slug;
    private $name;
    private $post_id;
    private $post;


    public function getID (): ?int
    {
        return $this->id;
    }

    public function setID($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSlug (): ?string
    {
        return $this->slug;
    }

    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getName (): ?string
    {
        return $this->name;
    }

    public function getFormattedName(): ?string
    {
        return htmlentities($this->name);
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPost (): ?string
    {
        return $this->post;
    }

    public function setPost (Post $post)
    {
        $this->post = $post;
        return$this;
    }

    /**
     * @return int|null
     */
    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    /**
     * @param int|null $post_id
     */
    public function setPostId(?int $post_id): void
    {
        $this->post_id = $post_id;
    }



}
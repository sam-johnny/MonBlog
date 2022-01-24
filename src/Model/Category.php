<?php

namespace App\Model;

class Category
{
    private $id;
    private $slug;
    private $name;
    private $post_id;
    private $post;


    /**
     * @return int|null
     */
    public function getID (): ?int
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setID($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug (): ?string
    {
        return $this->slug;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function setSlug($slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName (): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getFormattedName(): ?string
    {
        return htmlentities($this->name);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPost (): ?string
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return $this
     */
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
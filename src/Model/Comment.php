<?php

namespace App\Model;

class Comment extends \App\Model\Post
{
    private $id;
    private $username;
    private $content;
    private $created_at;
    private $email;
    private $post_id;


    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

    public function setcontent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getID(): ?int
    {
        return $this->id;
    }

    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->created_at);
    }

    public function setCreatedAt(string $date): self
    {
        $this->created_at = $date;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPostID()
    {
        return $this->post_id;
    }

    public function setPostId($post_id): self
    {
        $this->post_id = $post_id;
        return $this;
    }

}


<?php

namespace App\Model;

class Comment
{
    private $id;
    private $username;
    private $content;
    private $created_at;
    private $email;
    private $post_id;
    private $user_id;


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

    public function getPostID(): ?int
    {
        return $this->post_id;
    }

    public function setPostID(int $post_id): self
    {
        $this->post_id = $post_id;
        return $this;
    }

    public function getUserID(): ?int
    {
        return $this->user_id;
    }

    public function setUserID($user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }



}


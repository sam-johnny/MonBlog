<?php

namespace App\Model\Entity;

class Comment
{
    private $id;
    private $username;
    private $content;
    private $created_at;
    private $email;
    private $post_id;
    private $user_id;


    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
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
     * @return string|null
     */
    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setcontent(string $content): self
    {
        $this->content = $content;
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
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPostID(): ?int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     * @return $this
     */
    public function setPostID(int $post_id): self
    {
        $this->post_id = $post_id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getUserID(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param $user_id
     * @return $this
     */
    public function setUserID($user_id): self
    {
        $this->user_id = $user_id;
        return $this;
    }



}


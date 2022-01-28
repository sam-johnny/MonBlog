<?php

namespace App;

use \PDO;

class PaginatedQuery
{
    private $query;
    private $queryCount;
    private $pdo;
    private $limitPage;
    private $count;
    private $items;

    public function __construct(string $query, string $queryCount, int $limitPage, \PDO $pdo = null)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->limitPage = $limitPage;
        $this->pdo = $pdo ?: Database::getPDO();
    }

    /**
     * Récupère les articles pour notre listing
     *
     * @param string $classMapping
     * @return array
     * @throws \Exception
     */
    public function getItems(string $classMapping): array
    {
        if ($this->items === null) {
            $currentPage = $this->getCurrentPage();
            $totalPages = $this->getTotalPages();
            if ($currentPage > $totalPages) {
                throw new \Exception("Cette page n'existe pas");
            }
            $offset = $this->limitPage * ($currentPage - 1);
            $this->items = $this->pdo->query($this->query .
                " LIMIT {$this->limitPage} OFFSET $offset")
                ->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }
        return $this->items;
    }

    /**
     * Affiche les numéros des pages
     *
     * @param string $link
     * @param int $i
     * @param string|null $active
     * @return string|null
     * @throws \Exception
     */
    public function numPage(string $link, int $i, ?string $active = null): ?string
    {

        $link .= "?page=";
        $currentPage = $this->getCurrentPage();
        $active = $currentPage === $i ? 'active' : '';
        return <<<HTML
<li class="page-item {$active}"><a class="page-link" href="{$link}{$i}">{$i}</a></li><br>
HTML;
    }

    /**
     * Soustrait -1 sur la page
     *
     * @param string $link
     * @return string|null
     * @throws \Exception
     */
    public function previousPage(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if ($currentPage <= 1) return null;
        if ($currentPage > 2) $link .= "?page=" . ($currentPage - 1);
        return <<<HTML
<li class="page-item"><a class="page-link " href="{$link}">&laquo; Page précédente</a></li> 
HTML;
    }

    /**
     * Rajoute +1 sur la page
     *
     * @param string $link
     * @return string|null
     * @throws \Exception
     */
    public function nextPage(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $totalPages = $this->getTotalPages();
        if ($currentPage >= $totalPages) return null;
        $link .= "?page=" . ($currentPage + 1);
        return <<<HTML
<li class="page-item"><a class="page-link float-end" href="{$link}">Page suivante &raquo;</a></li>
HTML;
    }

    /**
     * La page courante est toujours un nombre positif
     * Cette méthode sert à ne pas répéter 'URL::getPositiveInt('page', 1)'
     *
     * @return int
     * @throws \Exception
     */
    private function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    /**
     * Calcul le nombre total des pages
     *
     * @return int
     */
    public function getTotalPages(): int
    {
        if ($this->count === null) {
            $this->count = (int)$this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0];
        }
        return ceil($this->count / $this->limitPage);
    }

}
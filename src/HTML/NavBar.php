<?php

namespace App\HTML;

/**
 * Class NavBar
 * Permet des liens pour la navbar rapidement et simplement
 */
class NavBar
{

    /**
     * Génère le code html pour les liens de la navbar
     *
     * @param string $href
     * @param string $name
     * @return string
     */
    public function link(string $href, string $name): string
    {
        $active = $_SERVER['REQUEST_URI'] === $href ? 'active' : '';
        return <<<HTML
<li class="nav-item">
    <a class="nav-link {$active}" href="{$href}">{$name}</a>
</li>
HTML;
    }

    /**
     * Génère le code html pour les boutons regroupés de la navbar
     *
     * @param string $href
     * @param string $name
     * @return string
     */
    public function dropdown(string $href, string $name): string
    {
        $active = $_SERVER['REQUEST_URI'] === $href ? 'active' : '';
        return <<<HTML
<li class="nav-item">
    <a class="dropdown-item {$active}" href="{$href}">{$name}</a>
</li>
HTML;
    }
}
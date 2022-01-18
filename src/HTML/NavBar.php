<?php

namespace App\HTML;

class NavBar
{
    public function link(string $href, string $name): string
    {
        $active = $_SERVER['REQUEST_URI'] === $href ? 'active' : '';
        return <<<HTML
<li class="nav-item">
    <a class="nav-link {$active}" href="{$href}">{$name}</a>
</li>
HTML;

    }

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
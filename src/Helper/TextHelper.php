<?php

namespace App\Helper;

class TextHelper
{

    /**
     * Coupe le contenu avec une limite de charactère
     *
     * @param $content
     * @param int $limit
     * @return string
     */
    public static function excerpt($content, $limit = 110): string
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . '...';
    }

}
<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Méthode du trait StringEscaper permettant de protéger les caractères sensibles au code HTML.
     *
     * @param string|null $string $string texte à protéger
     * @return string|null le texte résultant
     */
    public function escapeString(?string $string): ?string
    {
        if ($string === null) {
            return null;
        } else {
            return htmlspecialchars($string, flags: ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
        }
    }


    /**
     * Méthode du trait StringEscaper permettant de suprrimer les tags et les balises dans une chaîne de caractère.
     *
     * @param string|null $text texte à traiter
     * @return string le texte traité ou une chaîne vide si $text vaut null.
     */
    public function stripTagsAndTrim(?string $text): string
    {
        if ($text === null) {
            return "";
        } else {
            return strip_tags(trim($text));
        }
    }
}
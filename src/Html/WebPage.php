<?php

declare(strict_types=1);

namespace Html;

class WebPage
{
    /**
     * Classe WebPage. La classe est décrite par 3 attributs d'instances qui décrivent le code à insérer dans le <head>,
     * le code à insérer dans le <title> et le code à insérer dans le <body>.
     *
     * @var string $head code à insérer dans le <head>.
     * @var string $title code à insérer dans le <title>.
     * @var string $body code à insérer dans le <body>.
     */
    private string $head = "";
    private string $title = "";
    private string $body = "";


    /**
     * Constructeur de la classe WebPage. Il permet de définir le titre d'une nouvelle instance.
     *
     * @param string $title titre du nouvel objet.
     */
    public function __construct(string $title = "")
    {
        $this->title=$title;
    }


    /**
     * Accesseur de la classe WebPage permettant d'accéder à l'attribut head.
     *
     * @return string contenu de l'attribut head
     */
    public function getHead(): string
    {
        return $this->head;
    }


    /**
     * Accesseur de la classe WebPage permettant d'accéder à l'attribut title.
     *
     * @return string contenu de l'attribut title
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /**
     * Modificateur de la classe WebPage permettant de changer la valeur de l'attribut title.
     *
     * @param string $title nouveau titre à assigner
     * @return void rien
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


    /**
     * Accesseur de la classe WebPage permettant d'accéder à l'attribut body.
     *
     * @return string contenu de l'attribut body
     */
    public function getBody(): string
    {
        return $this->body;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter du code de contenu à l'attribut head.
     *
     * @param string $content code à ajouter
     * @return void rien
     */
    public function appendToHead(string $content): void
    {
        $this->head.= $content;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter du code css à l'attribut head.
     *
     * @param string $css code à ajouter
     * @return void rien
     */
    public function appendCss(string $css): void
    {
        $this->head.= <<<HTML
        <style>
        {$css}
        </style>

HTML;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter un lien css à l'attribut head.
     *
     * @param string $url lien à ajouter
     * @return void rien
     */
    public function appendCssUrl(string $url): void
    {
        $this->head.= <<<HTML
    <link rel="stylesheet" href="{$url}">

HTML;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter du code js à l'attribut head.
     *
     * @param string $js code à ajouter
     * @return void rien
     */
    public function appendJs(string $js): void
    {
        $this->head.= <<<HTML
        <script>
        {$js}
        </script>

HTML;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter un lien js à l'attribut head.
     *
     * @param string $url lien à ajouter
     * @return void rien
     */
    public function appendJsUrl(string $url): void
    {
        $this->head.= <<<HTML
        <script src="{$url}"></script>

HTML;
    }


    /**
     * Méthode de la classe WebPage permettant d'ajouter du code de contenu à l'attribut body.
     *
     * @param string $content code à ajouter
     * @return void rien
     */
    public function appendContent(string $content): void
    {
        $this->body.= $content;
    }


    /**
     * Méthode de la classe WebPage permettant de construire le code html entier à partir des attributs d'instance.
     *
     * @return string code html complet
     */
    public function toHTML(): string
    {
        $html = <<<HTML
<!doctype html>
<html lang="fr">
    <head>
    {$this->head}
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{$this->title}</title>
    </head>
    <body>
    {$this->body}
    </body>
</html>

HTML;

        return $html;
    }


    /**
     * Méthode de la classe WebPage permettant de protéger les caractères sensibles au code HTML.
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


    public static function getLastModification(): string
    {
        return date("d/m/Y-H:i:s", getlastmod());
    }
}

<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Entity\Exception\ParameterException;
use Html\StringEscaper;

class MovieForm
{
    use StringEscaper;

    /**
     * Classe MovieForm. Elle permet de générer le code html permettant de créer un formulaire pour créer un nouvel
     * objet Movie.
     *
     * @var Movie|null
     */
    private ?Movie $movie;


    /**
     * Constructeur de la classe MovieForm. Il permet de créer une nouvelle instance et de définir la valeur du
     * paramètre movie.
     *
     * @param Movie|null $movie paramètre movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }


    /**
     * Accesseur d'instance MovieForm permettant d'obtenir la valeur du paramètre movie.
     *
     * @return Movie|null la valeur du paramètre movie
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }


    /**
     * Méthode d'instance MovieForm permettant de créer un formulaire pour créer un film Movie.
     *
     * @param string $action
     * @return string
     */
    public function getHtmlForm(string $action): string
    {
        $id = $this?->movie?->getId();
        $posterId = $this->escapeString($this?->movie?->getPosterId());
        $originalLanguage = $this->escapeString($this?->movie?->getOriginalLanguage());
        $originalTitle = $this->escapeString($this?->movie?->getOriginalTitle());
        $overview = $this->escapeString($this?->movie?->getOverview());
        $releaseDate = $this->escapeString($this?->movie?->getReleaseDate());
        $runtime = $this->escapeString(strval($this?->movie?->getRuntime()));
        $tagline = $this->escapeString($this?->movie?->getTagline());
        $title = $this->escapeString($this?->movie?->getTitle());

        $html = <<<HTML
    <form name="" method="post" action="{$action}">
        <input type="hidden" name="id" value="{$id}">
        <input type="hidden" name="posterId" value="{$posterId}">
        <label>
            Langue original
            <input type="text" name="originalLanguage" value="{$originalLanguage}" required>
        </label>
        <label>
            Titre original
            <input type="text" name="originalTitle" value="{$originalTitle}" required>
        </label>
        <label>
            Description
            <input type="text" name="overview" value="{$overview}" required>
        </label>
        <label>
            Date de sortie
            <input type="date" name="releaseDate" value="{$releaseDate}" required>
        </label>
        <label>
            Durée
            <input type="number" name="runtime" value="{$runtime}" required>
        </label>
        <label>
            slogan
            <input type="text" name="tagline" value="{$tagline}" required>
        </label>
        <label>
            Titre
            <input type="text" name="title" value="{$title}" required>
        </label>
        <button type="submit">
            Enregistrer
        </button>
    </form>

HTML;

        return $html;
    }


    /**
     * Méthode d'instance MovieForm permettant de créer le film à partir de la query string du formulaire
     *
     * @return void
     * @throws ParameterException si un paramètre est manquant (sauf posterId qui est facultatif)
     */
    public function setEntityFromQueryString(): void
    {
        if (!(isset($_POST['id']) and ctype_digit($_POST['id']))) {
            $id = null;
        } else {
            $id = intval($_POST['id']);
        }

        if (!(ctype_digit($_GET['posterId']))) {
            throw new ParameterException();
        } else {
            $posterId = intval($this->stripTagsAndTrim($_POST['posterId']));
        }

        if (!(isset($_POST['originalLanguage']) and ctype_alpha($_POST['originalLanguage']))) {
            throw new ParameterException();
        } else {
            $orginalLanguage = $this->stripTagsAndTrim($_POST['originalLanguage']);
        }

        if (!(isset($_POST['originalTitle']) and $_POST['originalTitle'] === '')) {
            throw new ParameterException();
        } else {
            $orginalTitle = $this->stripTagsAndTrim($_POST['originalTitle']);
        }

        if (!(isset($_POST['overview']) and $_POST['overview'] === '')) {
            throw new ParameterException();
        } else {
            $overview = $this->stripTagsAndTrim($_POST['overview']);
        }

        if (!(isset($_POST['releaseDate']))) {
            throw new ParameterException();
        } else {
            $date = explode('-', $_POST['releaseDate']);
            for ($i = 0; $i = count($date); $i++) {
                $date[$i] = intval($date[$i]);
            }
            if (count($date) == 3 and checkdate((int)$date[1], (int)$date[2], (int)$date[0])) {
                $releaseDate = $this->stripTagsAndTrim($_POST['releaseDate']);
            } else {
                throw new ParameterException();
            }
        }

        if (!(isset($_POST['runtime']) and ctype_digit($_POST['runtime']))) {
            throw new ParameterException();
        } else {
            $runtime = intval($this->stripTagsAndTrim($_POST['runtime']));
        }

        if (!(isset($_POST['tagline']) and $_POST['tagline'] === '')) {
            throw new ParameterException();
        } else {
            $tagline = $this->stripTagsAndTrim($_POST['tagline']);
        }

        if (!(isset($_POST['title']) and $_POST['title'] === '')) {
            throw new ParameterException();
        } else {
            $title = $this->stripTagsAndTrim($_POST['title']);
        }

        $this->movie = Movie::create(
            $id,
            $posterId,
            $orginalLanguage,
            $orginalTitle,
            $overview,
            $releaseDate,
            $runtime,
            $tagline,
            $title
        );
    }
}

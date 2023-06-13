<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

/**
 * La classe movie est composée de 9 attributs (id, posterId, originalLanguage, originalTitle, overview, releaseDate, runetime, tagline et title)
 * Elle possède une méthode findById qui permet de retrouver un film à parti de son id.
 */
class Movie
{
    private int|null $id;
    private int|null $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /** Accesseur à l'id d'un film
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** Accesseur à l'id du poster d'un film
     * @return int|null
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    /** Accesseur au langage original d'un film
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /** Accesseur au titre original d'un film
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /** Accesseur à l'aperçu d'un film
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /** Accesseur à la date de sortie d'un film
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /** Accesseur à la durée d'un film
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /** Accesseur au slogan d'un film
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /** Accesseur au titre du film
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param int|null $posterId
     */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * @param string $originalLanguage
     */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * @param string $originalTitle
     */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @param string $tagline
     */
    public function setTagline(string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }


    /** Affiche un film à partir de son id.
     * @param int $id
     * @return Movie
     */
    public static function findById(int $id): Movie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie
    WHERE id=:id
SQL
        );
        $stmt->execute(["id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException("Le film demandé est introuvable");
        }

    }

    /** Méthode de la classe Movie qui permet de construire une instance de Movie
     * @param int $id id de la nouvelle instance
     * @param int|null $posterId posterId de la nouvelle instance
     * @param string $originalLanguage originalLanguage de la nouvelle instance
     * @param string $originalTitle originalTitle de la nouvelle instance
     * @param string $overview overview de la nouvelle instance
     * @param int $releaseDate releaseDate de la nouvelle instance
     * @param int $runtime runtime de la nouvelle instance
     * @param string $tagline tagline de la nouvelle instance
     * @param string $title title de la nouvelle instance
     * @return Movie nouvelle instance
     */

    public static function create(int $id, ?int $posterId = null, string $originalLanguage, string $originalTitle, string $overview, int $releaseDate, int $runtime, string $tagline, string $title): Movie
    {
        $new_Movie = new Movie();
        $new_Movie->setId($id)->setPosterId($posterId)->setOriginalLanguage($originalLanguage)->setOriginalTitle($originalTitle)->setOverview($overview)->setReleaseDate($releaseDate)->setRuntime($runtime)->setTagline($tagline)->setTitle($title);
        return $new_Movie;
    }

    /**
     * Constructeur privé de la classe Movie
     */
    private function __construct()
    {

    }


}

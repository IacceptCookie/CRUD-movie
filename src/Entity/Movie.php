<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    /**
     * La classe movie est composée de 9 attributs (id, posterId, originalLanguage, originalTitle, overview, releaseDate, runetime, tagline et title)
     * Elle possède une méthode findById qui permet de retrouver un film à parti de son id.
     */
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
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut id.
     *
     * @param int|null $id nouvelle valeur de id
     * @return Movie l'instance modifiée
     */
    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut posterId.
     *
     * @param int|null $posterId nouvelle valeur de posterId
     * @return Movie l'instance modifiée
     */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut originalLanguage.
     *
     * @param string $originalLanguage nouvelle valeur d'originalLanguage
     * @return Movie l'instance modifiée
     */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut originalTitle.
     *
     * @param string $originalTitle nouvelle valeur d'originalTitle
     * @return Movie l'instance modifiée
     */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut overview.
     *
     * @param string $overview nouvelle valeur d'overview
     * @return Movie l'instance modifiée
     */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut releaseDate.
     *
     * @param string $releaseDate nouvelle valeur de releaseDate
     * @return Movie l'instance modifiée
     */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut runtime.
     *
     * @param int $runtime nouvelle valeur de runtime
     * @return Movie l'instance modifiée
     */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut tagline.
     *
     * @param string $tagline nouvelle valeur de l'attribut tagline
     * @return Movie l'instance modifiée
     */
    public function setTagline(string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * Modificateur d'instance Movie permettant de modifier la valeur de l'attribut title.
     *
     * @param string $title nouvelle valeur de l'attribut title
     * @return Movie l'instance modifiée
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


        /** Méthode permettant de supprimer un enregistrement dans la base de données et de mettre son id à null
        * @return $this
         */
        public function delete(): Movie
        {
            $stmt = MyPdo::getInstance()->prepare(
                <<<SQL
    DELETE 
    FROM movie
    WHERE id = :id
SQL
            );
            $stmt->execute(["id" =>$this->id]);
            $this->setId(null);
            return $this;
        }


    /**
     * Méthode Movie permettant de mettre à jour un enregistrement dans la base de donnée.
     *
     * @return $this
     */
    protected function update(): Movie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    UPDATE movie
    SET posterId = :posterId,
        originalLanguage = :originalLanguage,
        originalTitle = :originalTitle,
        overview = :overview,
        releaseDate = :releaseDate,
        runTime = :runTime,
        tagline = :tagline,
        title = :title
    WHERE id = :id
SQL
        );

        $stmt->execute(["id" =>$this->id,
            "posterId" =>$this->posterId,
            "originalLanguage" =>$this->originalLanguage,
            "originalTitle" =>$this->originalTitle,
            "overview" =>$this->overview,
            "releaseDate" =>$this->releaseDate,
            "runTime" =>$this->runtime,
            "tagline" =>$this->tagline,
            "title" =>$this->title]);

        return $this;
    }


    /**
     * Méthode Movie permettant d'insérer un nouvel film dans la base de donnée.
     *
     * @return $this Le film inséré
     */
    protected function insert(): Movie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    INSERT INTO movie (posterId,originalLanguage,originalTitle,overview,releaseDate,runTime,tagline,title) 
    VALUES (:posterId,:originalLanguage,:originalTitle,:overview,:releaseDate,:runTime,:tagline,:title)
SQL
        );

        $stmt->execute(["posterId" =>$this->posterId,
            "originalLanguage" =>$this->originalLanguage,
            "originalTitle" =>$this->originalTitle,
            "overview" =>$this->overview,
            "releaseDate" =>$this->releaseDate,
            "runTime" =>$this->runtime,
            "tagline" =>$this->tagline,
            "title" =>$this->title]);
        $this->setId(intval(MyPDO::getInstance()->lastInsertId()));


        return $this;
    }


    /**
     * Méthode Movie permettant de mettre à jour une modification ou un ajout d'une entrée dans la base de donnée.
     *
     * @return $this
     */
    public function save(): Movie
    {
        if (is_null($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;
    }


    /** Méthode de la classe Movie qui permet de construire une instance de Movie
     * @param int|null $id id de la nouvelle instance
     * @param int|null $posterId posterId de la nouvelle instance
     * @param string $originalLanguage originalLanguage de la nouvelle instance
     * @param string $originalTitle originalTitle de la nouvelle instance
     * @param string $overview overview de la nouvelle instance
     * @param string $releaseDate releaseDate de la nouvelle instance
     * @param int $runtime runtime de la nouvelle instance
     * @param string $tagline tagline de la nouvelle instance
     * @param string $title title de la nouvelle instance
     * @return Movie nouvelle instance
     */

    public static function create(?int $id, ?int $posterId = null, string $originalLanguage, string $originalTitle, string $overview, string $releaseDate, int $runtime, string $tagline, string $title): Movie
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

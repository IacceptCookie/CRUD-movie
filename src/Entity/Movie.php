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
            $stmt->execute(["id"=>$id]);
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
}

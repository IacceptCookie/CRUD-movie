<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private int $posterId;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private string $title;

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }
/**
 * @return string
 */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }
/**
 * @return string
 */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }
 /**
 * @return string
 */
    public function getOverview(): string
    {
        return $this->overview;
    }
/**
 * @return string
 */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }
 /**
 * @return int
 */
    public function getRuntime(): int
    {
        return $this->runtime;
    }
 /**
 * @return string
 */
    public function getTagline(): string
    {
        return $this->tagline;
    }
 /**
 * @return string
 */
    public function getTitle(): string
    {
        return $this->title;
    }
    public static function findById(int $id): Movie
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT *
    FROM movie
    WHERE id=:id
SQL
        );
        $stmt->execute(["id"=>$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, movie::class);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException("Le film demandé est introuvable");
        }

    }
}

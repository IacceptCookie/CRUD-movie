<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use Entity\People;
use PDO;

class MovieCollection
{
    public static function findAll(): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie
    ORDER BY title ASC, releaseDate DESC
SQL
        );
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT DISTINCT m.id AS "id", posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie m
        JOIN cast c ON m.id=c.movieId
    WHERE id = :peopleId
    ORDER BY title ASC, releaseDate DESC
SQL
        );

        $stmt->execute(["peopleId" =>$peopleId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);


    }

}

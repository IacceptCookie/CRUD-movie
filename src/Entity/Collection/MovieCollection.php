<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use Entity\People;
use PDO;

class MovieCollection
{
    /** Classe MovieCollection. Elle n'a aucun attribut et possède deux méthodes de classes qui sont findAll et
     * findByPeopleId.
     *
     */


    /** Méthode de classe MovieCollection. Elle permet de récupérer un tableau qui contient tous les films.
     * @return Movie[]
     */
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

    /** Méthode de classe MovieCollection. Elle permet de récupérer un tableau qui contient tous les films d'une
     * personne grâce à son peopleId.
     * @return Movie[]
     */
    public static function findByPeopleId(int $peopleId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT DISTINCT m.id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie m
        JOIN cast c ON m.id=c.movieId
    WHERE c.peopleId = :peopleId
    ORDER BY title ASC, releaseDate DESC
SQL
        );

        $stmt->execute(["peopleId" => $peopleId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);


    }

    /** Méthode de classe MovieCollection qui permet de retourner un tableau qui contient tous les films d'un genre.
     * @param int $genreId genre des films à collecter
     * @return Movie[]
     */
    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
    SELECT DISTINCT m.id, posterId, originalLanguage, originalTitle, overview, releaseDate, runtime, tagline, title
    FROM movie m 
        JOIN movie_genre o ON m.id = o.movieId
    WHERE genreId = :genreId
    ORDER BY title ASC, releaseDate DESC
SQL
        );
        $stmt->execute(["genreId" => $genreId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Movie::class);
    }

}

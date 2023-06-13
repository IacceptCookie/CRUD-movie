<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;
use PDO;

class PeopleCollection
{
    /**
     * Classe PeopleCollection. Elle n'est décrite par aucun attribut et n'execute qu'un seul savoir-faire
     * findByMovieId.
     */


    /**
     * Méthode de classe PeopleCollection. Elle permet de récupérer un tableau contenant tous les acteurs d'un film
     * grace à son movieId.
     * @return People[] un tableau contenant tous les acteurs triés par nom
     */
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT DISTINCT p.id, avatarId, birthday, deathday, name, biography, placeOfBirth
    FROM people p
        JOIN cast c ON p.id=c.peopleId
    WHERE c.movieId = :movieId
    ORDER BY name ASC
SQL
        );

        $stmt->execute(["movieId" =>$movieId]);

        return $stmt->fetchAll(PDO::FETCH_CLASS, People::class);
    }
}

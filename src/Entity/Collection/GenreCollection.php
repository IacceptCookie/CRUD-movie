<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;
use PDO;

class GenreCollection
{
    /** La classe GenreCollection ne contient aucun attributs. Elle contient une méthode, findAll qui renvoie tous les genres.
     *
     */


    /** Méthode de la classe GenreCollection qui renvoie un tableau contenant tous les genres.
     * @return array
     */
    public static function findAll(): array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
    SELECT id, name 
    FROM genre
    ORDER BY name ASC
SQL
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, Genre::class);
    }

}

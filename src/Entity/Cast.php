<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Cast
{
    private int $id;
    private int $movieId;
    private int $peopleId;
    private string $role;
    private int $orderIndex;


    /**
     * Méthode de la classe Cast permettant d'obtenir la valeur du role à partir de l'id d'un film et d'un acteur
     *
     * @param int $movieId id du film
     * @param int $peopleId id de l'acteur
     * @return string role de l'acteur
     */
    public static function getRoleById(int $movieId, int $peopleId): string
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT DISTINCT role
    FROM cast
    WHERE peopleId = :peopleId AND
          movieId = :movieId
SQL
        );

        $stmt->execute(["movieId" =>$movieId, "peopleId" =>$movieId]);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException("Le casting demandé est introuvable");
        }
    }
}

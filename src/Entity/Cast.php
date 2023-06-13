<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

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

        $stmt->execute(["movieId" =>$movieId, "peopleId" =>$peopleId]);
        if (($result = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
            return $result["role"];
        } else {
            throw new EntityNotFoundException("Le casting demandé est introuvable");
        }
    }
}

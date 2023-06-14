<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Genre
{
    /** La classe genre est composée de 2 attributs : id et name avec leur getter respectif.
     * @var int
     */
    private int $id;
    private string $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /** Méthode de la classe genre. Elle permet de trouver un genre à partir de son id.
     * @param int $id
     * @return mixed
     */
    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, name
        FROM genre
        WHERE id= :id
SQL
        );
        $stmt->execute(["id" => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, Genre::class);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException("Le genre demandé est introuvable");
        }
    }

}

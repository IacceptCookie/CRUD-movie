<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Image
{
    /**
     * Classe Image, décrite par deux paramètres d'instances.
     *
     * @var int $id valeur de l'id
     * @var string $jpeg valeur de l'image
     */
    private int $id;
    private string $jpeg;


    /**
     * Accesseur de la classe Image permettant de lire la valeur de l'attribut d'instance id.
     * @return int valeur d'id
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * Accesseur de la classe Image permettant de lire la valeur de l'attribut d'instance jpeg.
     * @return string valeur de jpeg
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }


    /**
     * Méthode de classe Cover permettant de retourner un objet Cover contenant les informations d'une pochette
     * à partir de son id.
     *
     * @param int $id Id de la pochette à chercher
     * @return Image objet Cover correspondant à l'id donnée
     * @throws EntityNotFoundException si la pochette n'est pas trouvé.
     */
    public static function findById(int $id): Image
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT id, jpeg
    FROM image
    WHERE id = :id
SQL
        );

        $stmt->execute(["id" =>$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, Image::class);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException();
        }
    }
}

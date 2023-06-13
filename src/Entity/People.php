<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class People
{
    private int|null $id;
    private int|null $avatarId;
    private string|null $birthday;
    private string|null $deathday;
    private string $name;
    private string|null $biography;
    private string|null $placeOfBirth;


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ id.
     *
     * @return int|null valeur du champ id
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ avatarId.
     *
     * @return int|null valeur du champ avatarId
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ birthday.
     *
     * @return string|null valeur du champ birthday
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ deathday.
     *
     * @return string|null valeur du champ deathday
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ name.
     *
     * @return string valeur du champ name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ biography.
     *
     * @return string|null valeur du champ biography
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }


    /**
     * Accesseur d'instance People permettant d'obtenir la valeur du champ placeOfBirth.
     *
     * @return string|null valeur du champ placeOfBirth
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }


    /**
     * Méthode de classe People permettant de retourner un objet People contenant les informations d'une personne
     * à partir de son id.
     *
     * @param int $id Id de la personne à chercher
     * @return People objet People correspondant à l'id donnée
     * @throws EntityNotFoundException si la personne n'est pas trouvée.
     */
    public static function findById(int $id): People
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT id, avatarId, birthday, deathday, name, biography, placeOfBirth
    FROM people
    WHERE id = :id
SQL
        );

        $stmt->execute(["id" =>$id]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, People::class);
        if (($result = $stmt->fetch()) !== false) {
            return $result;
        } else {
            throw new EntityNotFoundException();
        }
    }
}

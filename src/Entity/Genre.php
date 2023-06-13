<?php

declare(strict_types=1);

namespace Entity;

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


}

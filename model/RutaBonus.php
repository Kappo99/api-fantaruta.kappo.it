<?php

class RutaBonus
{
    private $Id;
    private $Title;
    private $Description;
    private $Image;
    private $IsActive;

    public function __construct(string $Title, string $Description, string $Image, bool $IsActive, ?int $Id = null)
    {
        $this->Id = $Id;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Image = $Image;
        $this->IsActive = $IsActive;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    public function setId(int $Id)
    {
        if ($this->Id === null)
            $this->Id = $Id;
    }

    public function getId(): int
    {
        return $this->Id;
    }
    public function getTitle(): string
    {
        return $this->Title;
    }
    public function getDescription(): string
    {
        return $this->Description;
    }
    public function getImage(): string
    {
        return $this->Image;
    }
    public function getIsActive(): bool
    {
        return $this->IsActive;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->Id,
            'Title' => $this->Title,
            'Description' => $this->Description,
            'Image' => $this->Image,
            'IsActive' => $this->IsActive,
        ];
    }

    // ===========================================================================================

    /**
     * Get the RutaBonus List
     * @return RutaBonus[] Rutabonus List or null
     */
    public static function getRutaBonus(): mixed
    {
        $queryText = 'SELECT * FROM `RutaBonus`';
        $query = new Query($queryText);
        $result = DataBase::executeQuery($query);

        $rutabonus = array();
        foreach ($result as $r) {
            $rutabonus[] = new RutaBonus(
                $r['Title_RutaBonus'],
                $r['Description_RutaBonus'],
                $r['Image_RutaBonus'],
                $r['IsActive_RutaBonus'],
                $r['Id_RutaBonus'],
            );
        }

        return $rutabonus;
    }
}
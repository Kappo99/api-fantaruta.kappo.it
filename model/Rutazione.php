<?php

class Rutazione
{
    private $Id;
    private $Num;
    private $Giornata;
    private $Title;
    private $Description;
    private $Rutas;
    private $MonteRuta;
    private $Malus;
    private $MalusText;
    private $Bonus;
    private $BonusText;
    private $IsRutata;

    public function __construct(int $Num, int $Giornata, string $Title, string $Description, int $Rutas, int $MonteRuta, ?int $Malus, ?string $MalusText, ?int $Bonus, ?string $BonusText, bool $IsRutata, ?int $Id = null)
    {
        $this->Id = $Id;
        $this->Num = $Num;
        $this->Giornata = $Giornata;
        $this->Title = $Title;
        $this->Description = $Description;
        $this->Rutas = $Rutas;
        $this->MonteRuta = $MonteRuta;
        $this->Malus = $Malus;
        $this->MalusText = $MalusText;
        $this->Bonus = $Bonus;
        $this->BonusText = $BonusText;
        $this->IsRutata = $IsRutata;
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
    public function setNum(int $Num)
    {
        $this->Num = $Num;
    }

    public function getId(): int
    {
        return $this->Id;
    }
    public function getNum(): int
    {
        return $this->Num;
    }
    public function getGiornata(): int
    {
        return $this->Giornata;
    }
    public function getTitle(): string
    {
        return $this->Title;
    }
    public function getDescription(): string
    {
        return $this->Description;
    }
    public function getRutas(): int
    {
        return $this->Rutas;
    }
    public function getMonteRuta(): int
    {
        return $this->MonteRuta;
    }
    public function getMalus(): int
    {
        return $this->Malus;
    }
    public function getMalusText(): string
    {
        return $this->MalusText;
    }
    public function getBonus(): int
    {
        return $this->Bonus;
    }
    public function getBonusText(): string
    {
        return $this->BonusText;
    }
    public function getIsRutata(): bool
    {
        return $this->IsRutata;
    }

    public function toArray(): array
    {
        return [
            'Id_Rutazione' => $this->Id,
            'Num_Rutazione' => $this->Num,
            'Giornata_Rutazione' => $this->Giornata,
            'Title_Rutazione' => $this->Title,
            'Description_Rutazione' => $this->Description,
            'Rutas_Rutazione' => $this->Rutas,
            'MonteRuta_Rutazione' => $this->MonteRuta,
            'Malus_Rutazione' => $this->Malus,
            'MalusText_Rutazione' => $this->MalusText,
            'Bonus_Rutazione' => $this->Bonus,
            'BonusText_Rutazione' => $this->BonusText,
            'IsRutata_Rutazione' => $this->IsRutata,
        ];
    }

    // ===========================================================================================

    /**
     * Get the Rutazione with specified Giornata
     * @param int $Giornata Rutazione's Giornata
     * @return Rutazione[] Rutazione or null
     */
    public static function getRutazioniByGiornata(int $Giornata): mixed
    {
        $queryText = 'SELECT * FROM `Rutazione` WHERE `Giornata_Rutazione` = ?';
        $query = new Query($queryText, 'i', $Giornata);
        $result = DataBase::executeQuery($query);

        $rutazioni = array();
        foreach ($result as $r) {
            $rutazioni[] = new Rutazione(
                $r['Num_Rutazione'],
                $r['Giornata_Rutazione'],
                $r['Title_Rutazione'],
                $r['Description_Rutazione'],
                $r['Rutas_Rutazione'],
                $r['MonteRuta_Rutazione'],
                $r['Malus_Rutazione'],
                $r['MalusText_Rutazione'],
                $r['Bonus_Rutazione'],
                $r['BonusText_Rutazione'],
                $r['IsRutata_Rutazione'],
                $r['Id_Rutazione'],
            );
        }

        return $rutazioni;
    }
}
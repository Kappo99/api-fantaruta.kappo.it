<?php

class Rutasslifica
{
    private $Id;
    private $Giornata;
    private $IdRutatore;
    private $MonteRuta;
    private $Rutatore;

    public function __construct(int $Giornata, int $IdRutatore, int $MonteRuta, ?int $Id = null, ?Rutatore $Rutatore = null)
    {
        $this->Id = $Id;
        $this->Giornata = $Giornata;
        $this->IdRutatore = $IdRutatore;
        $this->MonteRuta = $MonteRuta;
        $this->Rutatore = $Rutatore;
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
    public function getGiornata(): int
    {
        return $this->Giornata;
    }
    public function getIdRutatore(): int
    {
        return $this->IdRutatore;
    }
    public function getMonteRuta(): int
    {
        return $this->MonteRuta;
    }
    public function getRutatore(): Rutatore
    {
        return $this->Rutatore;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->Id,
            'Giornata' => $this->Giornata,
            'IdRutatore' => $this->IdRutatore,
            'MonteRuta' => $this->MonteRuta,
            'Rutatore' => $this->Rutatore->toArray(),
        ];
    }

    // ===========================================================================================

    /**
     * Get the Rutasslifica List
     * @return Rutasslifica[] Rutasslifica List or null
     */
    public static function getRutasslifica(): mixed
    {
        $queryText = 'SELECT *
                        FROM `Rutasslifica` ';
        $query = new Query($queryText);
        $result = DataBase::executeQuery($query);

        $Rutasslifica = array();
        foreach ($result as $r) {
            $Rutasslifica[] = new Rutasslifica(
                $r['Giornata_Rutasslifica'],
                $r['IdRutatore_Rutasslifica'],
                $r['MonteRuta_Rutasslifica'],
                $r['Id_Rutasslifica'],
                new Rutatore(
                    $r['Num_Rutatore'],
                    $r['Name_Rutatore'],
                    $r['Password_Rutatore'],
                    $r['Id_Rutatore'],
                )
            );
        }

        return $Rutasslifica;
    }
}
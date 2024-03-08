<?php

class Formazione
{
    private $Id;
    private $Giornata;
    private $IdRutatore;
    private $IdRutazione;
    private $Rutatore;
    private $Rutazione;

    public function __construct(int $Giornata, int $IdRutatore, int $IdRutazione, ?int $Id = null, ?Rutatore $Rutatore = null, ?Rutazione $Rutazione = null)
    {
        $this->Id = $Id;
        $this->Giornata = $Giornata;
        $this->IdRutatore = $IdRutatore;
        $this->IdRutazione = $IdRutazione;
        $this->Rutatore = $Rutatore;
        $this->Rutazione = $Rutazione;
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
    public function getIdRutazione(): int
    {
        return $this->IdRutazione;
    }
    public function getRutatore(): Rutatore
    {
        return $this->Rutatore;
    }
    public function getRutazione(): Rutazione
    {
        return $this->Rutazione;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->Id,
            'Giornata' => $this->Giornata,
            'IdRutatore' => $this->IdRutatore,
            'IdRutazione' => $this->IdRutazione,
            'Rutatore' => $this->Rutatore->toArray(),
            'Rutazione' => $this->Rutazione->toArray(),
        ];
    }

    // ===========================================================================================

    /**
     * Get the Formazione with specified Giornata
     * @param int $Giornata Formazione's Giornata
     * @return mixed Formazione[] or null
     */
    public static function getFormazioniByGiornata(int $Giornata): mixed
    {
        $queryText = 
            'SELECT * 
            FROM `Formazione` 
                INNER JOIN `Rutatore` ON `Id_Rutatore_Formazione` = `Id_Rutatore`
                INNER JOIN `Rutazione` ON `Id_Rutazione_Formazione` = `Id_Rutazione`
            WHERE `Giornata_Formazione` = ?';
        $query = new Query($queryText, 'i', $Giornata);
        $result = DataBase::executeQuery($query);

        $formazioni = array();
        foreach ($result as $r) {
            $formazioni[] = new Formazione(
                $r['Giornata_Formazione'],
                $r['Id_Rutatore_Formazione'],
                $r['Id_Rutazione_Formazione'],
                $r['Id_Formazione'],
                // new Rutatore(
                //     $r['Num_Rutatore'],
                //     $r['Name_Rutatore'],
                //     $r['Password_Rutatore'],
                //     $r['Id_Rutatore'],
                // ),
                // new Rutazione(
                //     $r['Num_Rutazione'],
                //     $r['Giornata_Rutazione'],
                //     $r['Title_Rutazione'],
                //     $r['Description_Rutazione'],
                //     $r['Rutas_Rutazione'],
                //     $r['MonteRuta_Rutazione'],
                //     $r['Malus_Rutazione'],
                //     $r['MalusText_Rutazione'],
                //     $r['Bonus_Rutazione'],
                //     $r['BonusText_Rutazione'],
                //     $r['IsRutata_Rutazione'],
                //     $r['Id_Rutazione'],
                // ),
            );
        }

        return $formazioni;
    }
}
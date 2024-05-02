<?php

class Formazione
{
    private $Id;
    private $Giornata;
    private $IdRutatore;
    private $IdRutazione;
    private $Bonus_x2;
    private $Bonus_x5;
    private $Rutatore;
    private $Rutazione;

    public function __construct(int $Giornata, int $IdRutatore, int $IdRutazione, bool $Bonus_x2, bool $Bonus_x5, ?int $Id = null, ?Rutatore $Rutatore = null, ?Rutazione $Rutazione = null)
    {
        $this->Id = $Id;
        $this->Giornata = $Giornata;
        $this->IdRutatore = $IdRutatore;
        $this->IdRutazione = $IdRutazione;
        $this->Bonus_x2 = $Bonus_x2;
        $this->Bonus_x5 = $Bonus_x5;
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
    public function getBonus_x2(): bool
    {
        return $this->Bonus_x2;
    }
    public function getBonus_x5(): bool
    {
        return $this->Bonus_x5;
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
            'Bonus_x2' => $this->Bonus_x2,
            'Bonus_x5' => $this->Bonus_x5,
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
            WHERE `Giornata_Formazione` = ?
            ORDER BY `Id_Rutatore`, `Id_Rutazione`';
        $query = new Query($queryText, 'i', $Giornata);
        $result = DataBase::executeQuery($query);

        $formazioni = array();
        foreach ($result as $r) {
            // $rutazione = new Rutazione(
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
            // );
            // $rutazione->setBonus_x5($r['Bonus_x5_Formazione']);
            $formazioni[] = new Formazione(
                $r['Giornata_Formazione'],
                $r['Id_Rutatore_Formazione'],
                $r['Id_Rutazione_Formazione'],
                $r['Bonus_x2_Formazione'],
                $r['Bonus_x5_Formazione'],
                $r['Id_Formazione'],
                new Rutatore(
                    $r['Num_Rutatore'],
                    $r['Name_Rutatore'],
                    $r['Password_Rutatore'],
                    $r['Role_Rutatore'],
                    $r['Id_Rutatore'],
                ),
                new Rutazione(
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
                ),
            );
        }

        return $formazioni;
    }

    /**
     * Insert the Formazione List
     * @param mixed $formazioni Formazione's List
     * @return int id of the last Formazione added
     */
    public static function insertFormazioniByList(mixed $formazioni): int
    {
        $giornata = $formazioni[0]->getGiornata();
        $idRutatore = $formazioni[0]->getIdRutatore();

        $queryText = 'DELETE FROM `Formazione` WHERE `Giornata_Formazione` = ? AND `Id_Rutatore_Formazione` = ?';
        $query = new Query($queryText, 'ii', $giornata, $idRutatore);
        $result = DataBase::executeQuery($query);

        $values = array();
        foreach ($formazioni as $formazione)
            $values[] = '(' . $formazione->getGiornata() . ',' . $formazione->getIdRutatore() . ',' . $formazione->getIdRutazione() . ',' . $formazione->getBonus_x5() . ')';
        // $values = substr($values, 0, strlen($values) - 2);
        $queryText = 'INSERT INTO `Formazione`(`Giornata_Formazione`,`Id_Rutatore_Formazione`,`Id_Rutazione_Formazione`,,`Bonus_x5_Formazione`)
                        VALUES ' . implode(',', $values);
        $query = new Query($queryText);
        $result = DataBase::executeQuery($query);

        return $result;
    }
}
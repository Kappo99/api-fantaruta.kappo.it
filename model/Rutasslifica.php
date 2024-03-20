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
        $queryText = 'SELECT `Id_Rutasslifica`, `Giornata_Rutasslifica`, `Id_Rutatore_Rutasslifica`, 
                        SUM(`MonteRuta_Rutasslifica`) AS `MonteRuta_Rutasslifica`,
                        `Id_Rutatore`, `Num_Rutatore`, `Name_Rutatore`, `Role_Rutatore`, `Password_Rutatore`
                        FROM `Rutasslifica` 
                            INNER JOIN `Rutatore` ON `Id_Rutatore_Rutasslifica` = `Id_Rutatore`
                        GROUP BY `Id_Rutatore`
                        ORDER BY `MonteRuta_Rutasslifica` DESC';
        $query = new Query($queryText);
        $result = DataBase::executeQuery($query);

        $rutasslifica = array();
        foreach ($result as $r) {
            $rutasslifica[] = new Rutasslifica(
                $r['Giornata_Rutasslifica'],
                $r['Id_Rutatore_Rutasslifica'],
                $r['MonteRuta_Rutasslifica'],
                $r['Id_Rutasslifica'],
                new Rutatore(
                    $r['Num_Rutatore'],
                    $r['Name_Rutatore'],
                    $r['Password_Rutatore'],
                    $r['Role_Rutatore'],
                    $r['Id_Rutatore'],
                )
            );
        }

        return $rutasslifica;
    }

    /**
     * Get the Rutasslifica List until specified Giornata
     * @return mixed 2x Rutasslifica[] List or null (specified Giornata and prec)
     */
    public static function getRutasslificaByGiornata($giornata): mixed
    {
        $queryText = 'SELECT `Id_Rutasslifica`, `Giornata_Rutasslifica`, `Id_Rutatore_Rutasslifica`, 
                        SUM(`MonteRuta_Rutasslifica`) AS `MonteRuta_Rutasslifica`,
                        `Id_Rutatore`, `Num_Rutatore`, `Name_Rutatore`, `Role_Rutatore`, `Password_Rutatore`
                        FROM `Rutasslifica` 
                            INNER JOIN `Rutatore` ON `Id_Rutatore_Rutasslifica` = `Id_Rutatore`
                        WHERE `Giornata_Rutasslifica` <= ?
                        GROUP BY `Id_Rutatore`
                        ORDER BY `MonteRuta_Rutasslifica` DESC, `Id_Rutatore`';
        $query = new Query($queryText, 'i', $giornata);
        $result = DataBase::executeQuery($query);

        $rutasslifica = array();
        foreach ($result as $r) {
            $rutasslifica[] = new Rutasslifica(
                $r['Giornata_Rutasslifica'],
                $r['Id_Rutatore_Rutasslifica'],
                $r['MonteRuta_Rutasslifica'],
                $r['Id_Rutasslifica'],
                new Rutatore(
                    $r['Num_Rutatore'],
                    $r['Name_Rutatore'],
                    $r['Password_Rutatore'],
                    $r['Role_Rutatore'],
                    $r['Id_Rutatore'],
                )
            );
        }

        $queryText = 'SELECT `Id_Rutasslifica`, `Giornata_Rutasslifica`, `Id_Rutatore_Rutasslifica`, 
                        SUM(`MonteRuta_Rutasslifica`) AS `MonteRuta_Rutasslifica`,
                        `Id_Rutatore`, `Num_Rutatore`, `Name_Rutatore`, `Role_Rutatore`, `Password_Rutatore`
                        FROM `Rutasslifica` 
                            INNER JOIN `Rutatore` ON `Id_Rutatore_Rutasslifica` = `Id_Rutatore`
                        WHERE `Giornata_Rutasslifica` <= ?
                        GROUP BY `Id_Rutatore`
                        ORDER BY `MonteRuta_Rutasslifica` DESC, `Id_Rutatore`';
        $query = new Query($queryText, 'i', $giornata - 1);
        $result = DataBase::executeQuery($query);

        $rutasslificaPrev = array();
        foreach ($result as $r) {
            $rutasslificaPrev[] = new Rutasslifica(
                $r['Giornata_Rutasslifica'],
                $r['Id_Rutatore_Rutasslifica'],
                $r['MonteRuta_Rutasslifica'],
                $r['Id_Rutasslifica'],
                new Rutatore(
                    $r['Num_Rutatore'],
                    $r['Name_Rutatore'],
                    $r['Password_Rutatore'],
                    $r['Role_Rutatore'],
                    $r['Id_Rutatore'],
                )
            );
        }

        return [$rutasslifica, $rutasslificaPrev];
    }
}
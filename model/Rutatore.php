<?php

class Rutatore
{
    private $Id;
    private $Num;
    private $Name;
    private $Password;
    private $Role;

    public function __construct(int $Num, string $Name, string $Password, string $Role = 'User', ?int $Id = null)
    {
        $this->Id = $Id;
        $this->Num = $Num;
        $this->Name = $Name;
        $this->Password = $Password;
        $this->Role = $Role;
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
    public function setName(string $Name)
    {
        $this->Name = $Name;
    }
    public function setPassword(string $Password)
    {
        $this->Password = $Password;
    }
    public function setRole(string $Role)
    {
        $this->Role = $Role;
    }

    public function getId(): int
    {
        return $this->Id;
    }
    public function getNum(): int
    {
        return $this->Num;
    }
    public function getName(): string
    {
        return $this->Name;
    }
    public function getPassword(): string
    {
        return $this->Password;
    }
    public function getRole(): string
    {
        return $this->Role;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->Id,
            'Num' => $this->Num,
            'Name' => $this->Name,
            'Password' => $this->Password,
            'Role' => $this->Role,
        ];
    }

    // ===========================================================================================

    /**
     * Get the Rutatore with specified Num and Password
     * @param int $Num Rutatore's Num
     * @param string $Password Rutatore's Password
     * @return Rutatore Rutatore or null
     */
    public static function authenticateUser(int $Num, string $Password): Rutatore | null
    {
        $queryText = 'SELECT * FROM `Rutatore` WHERE `Num_Rutatore` = ?';
        $query = new Query($queryText, 'i', $Num);
        $result = DataBase::executeQuery($query, false);

        $Rutatore = $result ? new Rutatore(
            $result['Num_Rutatore'],
            $result['Name_Rutatore'],
            $result['Password_Rutatore'],
            $result['Role_Rutatore'],
            $result['Id_Rutatore'],
        ) : null;
        $passwordOk = $Password == $Rutatore->getPassword();

        return $passwordOk ? $Rutatore : null;
    }

    /**
     * Get the Rutatore with specified Id
     * @param int $Id Rutatore's Id
     * @return Rutatore Rutatore or null
     */
    public static function getRutatoreById(int $Id): Rutatore | null
    {
        $queryText = 'SELECT * FROM `Rutatore` WHERE `Id_Rutatore` = ?';
        $query = new Query($queryText, 'i', $Id);
        $result = DataBase::executeQuery($query, false);

        return $result ? new Rutatore(
            $result['Num_Rutatore'],
            $result['Name_Rutatore'],
            $result['Password_Rutatore'],
            $result['Role_Rutatore'],
            $result['Id_Rutatore'],
        ) : null;
    }
}
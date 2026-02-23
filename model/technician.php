<?php
// model/technician.php
// Purpose: Technician class (OOP requirement)

class Technician
{
    private int $techID;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $phone;
    private string $password;

    public function __construct(
        int $techID,
        string $firstName,
        string $lastName,
        string $email,
        string $phone,
        string $password
    ) {
        $this->techID = $techID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }

    // Getters (used by views)
    public function getTechID(): int { return $this->techID; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): string { return $this->email; }
    public function getPhone(): string { return $this->phone; }
    public function getPassword(): string { return $this->password; }

    // Requirement: show Name as "First Last"
    public function getName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }
}
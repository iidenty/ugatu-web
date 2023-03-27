<?php

namespace lab3s34;

class User
{
    /** @var string */
    private $login;

    /** @var string */
    private $firstName;

    /** @var string */
    private $lastName;

    /** @var string */
    private $middleName;

    /**
     * @param string $login
     * @param string $firstName
     * @param string $lastName
     * @param string $middleName
     */
    public function __construct(
        string $login,
        string $firstName,
        string $lastName,
        string $middleName
    ) {
        $this->login = $login;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getFIO(): string
    {
        return $this->lastName . ' ' . $this->firstName . ' ' . $this->middleName;
    }
}
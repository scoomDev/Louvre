<?php

namespace TL\CoreBundle\Entity;

/**
 * Captures information from the first form
 */
class Start
{
    private $day;
    private $completeName;
    private $email;
    private $nbrPerson;
    private $type;

    public function getDay()
    {
        return $this->day;
    }

    public function setDay(\Datetime $day)
    {
        $this->day = $day;
        return $this;
    }

    public function getcompleteName()
    {
        return $this->completeName;
    }

    public function setcompleteName(string $completeName)
    {
        $this->completeName = $completeName;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getNbrPerson()
    {
        return $this->nbrPerson;
    }

    public function setNbrPerson(int $nbrPerson)
    {
        $this->nbrPerson = $nbrPerson;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }
}

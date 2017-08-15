<?php

namespace TL\CoreBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use TL\CoreBundle\Validator\Hours;
use TL\CoreBundle\Validator\Closed;
use TL\CoreBundle\Validator\Day;

/**
 * Captures informations from the first form
 */
class Start
{
    /**
     * Day of the visit
     *
     * @var \Datetime
     * 
     * @Assert\NotBlank(message="Veuillez choisir une date de visite.")
     * @Assert\DateTime()
     * @Closed()
     * @Day()
     */
    private $day;

    /**
     * Full Name for billing
     *
     * @var string
     * 
     * @Assert\Type("string")
     * @Assert\Length(min=2, minMessage="Veuillez entrer votre nom complet.")
     * @Assert\NotBlank(message="Veuillez remplir ce champs.")
     */
    private $completeName;

    /**
     * Address email for billing
     *
     * @var string
     * 
     * @Assert\Type("string")
     * @Assert\Email(message="L'email {{ value }}, n'est pas un email valide.", checkMX=true)
     * @Assert\NotBlank(message="Veuillez remplir ce champs.")
     */
    private $email;

    /**
     * Determines the number of tickets
     *
     * @var integer
     * 
     * @Assert\Type(type="integer", message="Veuillez rentrer le nombre de ticket voulu en chiffre, {{ value }} n'est pas un chiffre")
     * @Assert\NotBlank(message="Veuillez rentrer le nombre de tickets voulus.")
     */
    private $nbrPerson;

    /**
     * Determines the type of ticket
     * Day or half day
     *
     * @var string
     * 
     * @Assert\Type("string")
     * @Assert\NotBlank(message="Veuillez choisir un type de billet.")
     * @Hours()
     */
    private $type;

    public function __construct() {
        $this->day = new \Datetime();
        $this->nbrPerson = 1;
    }

    /*---------------------
        GETTERS & SETTERS 
    ----------------------*/
    public function getDay()
    {
        return $this->day;
    }

    public function setDay($day)
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

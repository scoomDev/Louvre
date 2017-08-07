<?php

namespace TL\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Command
 *
 * @ORM\Table(name="tl_command")
 * @ORM\Entity(repositoryClass="TL\CoreBundle\Repository\CommandRepository")
 */
class Command
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="day", type="datetime")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="complete_name", type="string", length=255)
     * @Assert\Type("String")
     * @Assert\Length(min=2, minMessage="Veuillez entrer votre nom complet.")
     * @Assert\NotBlank(message="Veuillez remplir ce champs.")
     */
    private $completeName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message="L'email {{ value }}, n'est pas un email valide.", checkMX=true)
     * @Assert\NotBlank(message="Veuillez remplir ce champs.")
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_person", type="integer")
     */
    private $nbrPerson;

    /**
     * @var string
     *
     * @ORM\Column(name="total_price", type="decimal", precision=5, scale=2)
     */
    private $totalPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="TL\CoreBundle\Entity\Ticket", cascade="persist", mappedBy="command")
     * $Assert\NotNull()
     */
    private $tickets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set day
     *
     * @param \DateTime $day
     *
     * @return Command
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Command
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nbrPerson
     *
     * @param string $nbrPerson
     *
     * @return Command
     */
    public function setNbrPerson($nbrPerson)
    {
        $this->nbrPerson = $nbrPerson;

        return $this;
    }

    /**
     * Get nbrPerson
     *
     * @return string
     */
    public function getNbrPerson()
    {
        return $this->nbrPerson;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return Command
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Command
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set completeName
     *
     * @param string $completeName
     *
     * @return Command
     */
    public function setCompleteName($completeName)
    {
        $this->completeName = $completeName;

        return $this;
    }

    /**
     * Get completeName
     *
     * @return string
     */
    public function getCompleteName()
    {
        return $this->completeName;
    }

    /**
     * Add ticket
     *
     * @param \TL\CoreBundle\Entity\Ticket $ticket
     *
     * @return Command
     */
    public function addTicket(\TL\CoreBundle\Entity\Ticket $ticket)
    {
        $ticket->setCommand($this);
        $this->tickets[] = $ticket;

        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \TL\CoreBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\TL\CoreBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }
}

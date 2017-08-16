<?php

namespace TL\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Day
 *
 * @ORM\Table(name="tl_day")
 * @ORM\Entity(repositoryClass="TL\CoreBundle\Repository\DayRepository")
 */
class Day
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
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(name="nbr_tickets", type="string", length=255)
     */
    private $nbrTickets = 0;


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
     * @return Day
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
     * Set nbrTickets
     *
     * @param string $nbrTickets
     *
     * @return Day
     */
    public function setNbrTickets($nbrTickets)
    {
        $this->nbrTickets = $nbrTickets;

        return $this;
    }

    /**
     * Get nbrTickets
     *
     * @return string
     */
    public function getNbrTickets()
    {
        return $this->nbrTickets;
    }
}


<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @AcmeAssert\TicketLimit()
 * @AcmeAssert\NotAfter14H()
 *
 */
class Booking
{
    const MAX_TICKET_PER_DAY = 1000;
    const TYPE_FULL_DAY = true;
    const TYPE_HALF_DAY = false;


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThanOrEqual("today", message="Impossible de sélectionner un jour passé")
     * @Assert\Date(message="Test")
     * @AcmeAssert\Not01May
     * @AcmeAssert\Not01Nov
     * @AcmeAssert\Not25Dec
     * @AcmeAssert\NotTuesday
     * @AcmeAssert\NotSunday
     * @AcmeAssert\NotHoliday
     */
    private $visitDay;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Email invalide")
     * @Assert\NotBlank(message="Veuillez renseigner ce champ")
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $orderType = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $ticketNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $orderNumber;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="booking", cascade={"persist", "remove"})
     */
    private $tickets;

    public function __construct()
    {
        $this->orderDate = new \DateTime();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getVisitDay()
    {
        return $this->visitDay;
    }

    public function setVisitDay($visitDay): self
    {
        $this->visitDay = $visitDay;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getOrderType(): ?bool
    {
        return $this->orderType;
    }

    public function setOrderType(bool $orderType): self
    {
        $this->orderType = $orderType;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->orderPrice;
    }

    public function setOrderPrice(?int $price): self
    {
        $this->orderPrice = $price;

        return $this;
    }

    public function incrementOrderPrice(?int $ticketPrice): self
    {
        $this->orderPrice += $ticketPrice;

        return $this;
    }

    public function getTicketNumber(): ?int
    {
        return $this->ticketNumber;
    }

    public function setTicketNumber(int $ticketNumber): self
    {
        $this->ticketNumber = $ticketNumber;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setBooking($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getBooking() === $this) {
                $ticket->setBooking(null);
            }
        }

        return $this;
    }

}

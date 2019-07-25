<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("apiMessage")
     */
    private $sendAt;

    /**
     * @ORM\Column(type="string", length=10000)
     * @Groups("apiMessage")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\History", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("apiMessage")
     */
    private $histories;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("apiMessage")
     */
    private $agency;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("apiMessage")
     */
    private $client;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups("apiMessage")
     */
    private $admin=false;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups("apiMessage")
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=15)
     * @Groups("apiMessage")
     */
    private $receiver;

    public function __construct()
    {
        $this->agency = new ArrayCollection();
        $this->client = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getHistories(): ?History
    {
        return $this->histories;
    }

    public function setHistories(?History $histories): self
    {
        $this->histories = $histories;

        return $this;
    }

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?string
    {
        return $this->receiver;
    }

    public function setReceiver(string $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function __toString()
    {
        return ($this->content.' - envoyé par: '.$this->sender);
    }
}

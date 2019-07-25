<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoryRepository")
 */
class History
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("apiMessage")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateBegin;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateEnd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="histories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="histories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agency;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="histories")
     */
    private $messages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Stage", mappedBy="histories")
     */
    private $stages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StateHistory", inversedBy="histories", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->dateBegin;
    }

    public function setDateBegin(\DateTimeInterface $dateBegin): self
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

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

    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): self
    {
        $this->agency = $agency;

        return $this;
    }
    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessages(Message $messages): self
    {
        if (!$this->messages->contains($messages)) {
            $this->messages[] = $messages;
            $messages->setHistories($this);
        }

        return $this;
    }

    public function removeMessages(Message $messages): self
    {
        if ($this->messages->contains($messages)) {
            $this->messages->removeElement($messages);
            // set the owning side to null (unless already changed)
            if ($messages->getHistories() === $this) {
                $messages->setHistories(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->addHistories($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->contains($stage)) {
            $this->stages->removeElement($stage);
            $stage->removeHistories($this);
        }

        return $this;
    }

    public function __toString()
    {
        return strval($this->id);
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getState(): ?StateHistory
    {
        return $this->state;
    }

    public function setState(?StateHistory $state): self
    {
        $this->state = $state;

        return $this;
    }
}

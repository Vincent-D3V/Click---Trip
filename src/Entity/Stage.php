<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validate=false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"apiStage", "listing"})
     */
    private $destination;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("apiStage")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("apiStage")
     */
    private $nameStage;

    /**
     * @Gedmo\Slug(fields={"nameStage"})
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups("apiStage")
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     * @Groups("apiStage")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agency", inversedBy="stages")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("apiStage")
     */
    private $agency;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\History", inversedBy="stages")
     */
    private $histories;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Theme", mappedBy="stages")
     * @Groups("apiStage")
     */
    private $themes;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Style", mappedBy="stages")
     * @Groups("apiStage")
     */
    private $styles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Price", mappedBy="stages", cascade={"persist"})
     * @Groups("apiStage")
     */
    private $prices;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Size", mappedBy="stages")
     * @Groups("apiStage")
     */
    private $sizes;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted=false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Documents", mappedBy="stage", orphanRemoval=true, cascade={"persist"})
     */
    private $documents;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bestMonth;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $details;

    public function __construct()
    {
        $this->histories = new ArrayCollection();
        $this->themes = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->prices = new ArrayCollection();
        $this->sizes = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(bool $validate): self
    {
        $this->validate = $validate;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNameStage(): ?string
    {
        return $this->nameStage;
    }

    public function setNameStage(string $nameStage): self
    {
        $this->nameStage = $nameStage;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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
     * @return Collection|History[]
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistories(History $histories): self
    {
        if (!$this->histories->contains($histories)) {
            $this->histories[] = $histories;
        }

        return $this;
    }

    public function removeHistories(History $histories): self
    {
        if ($this->histories->contains($histories)) {
            $this->histories->removeElement($histories);
        }

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->addStage($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
            $theme->removeStage($this);
        }

        return $this;
    }

    /**
     * @return Collection|Style[]
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->styles->contains($style)) {
            $this->styles[] = $style;
            $style->addStage($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        if ($this->styles->contains($style)) {
            $this->styles->removeElement($style);
            $style->removeStage($this);
        }

        return $this;
    }

    /**
     * @return Collection|Price[]
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setStage($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->contains($price)) {
            $this->prices->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getStage() === $this) {
                $price->setStage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Size[]
     */
    public function getSizes(): Collection
    {
        return $this->sizes;
    }

    public function addSize(Size $size): self
    {
        if (!$this->sizes->contains($size)) {
            $this->sizes[] = $size;
            $size->addStage($this);
        }

        return $this;
    }

    public function removeSize(Size $size): self
    {
        if ($this->sizes->contains($size)) {
            $this->sizes->removeElement($size);
            $size->removeStage($this);
        }

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;
        return $this;
    }

    public function __toString()
    {
        return strval($this->id);
        // return $this->name.' '.$this->surname;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection|Documents[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Documents $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setStage($this);
        }

        return $this;
    }

    public function removeDocument(Documents $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getStage() === $this) {
                $document->setStage(null);
            }
        }

        return $this;
    }

    public function getBestMonth(): ?int
    {
        return $this->bestMonth;
    }

    public function setBestMonth(int $bestMonth): self
    {
        $this->bestMonth = $bestMonth;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }
}

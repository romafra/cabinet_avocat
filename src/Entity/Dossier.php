<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierRepository")
 */
class Dossier
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dosref;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dosstatut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dosdescription;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dosdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $dosavoid;

    /**
     * @ORM\Column(type="integer")
     */
    private $doscliid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDosref(): ?string
    {
        return $this->dosref;
    }

    public function setDosref(?string $dosref): self
    {
        $this->dosref = $dosref;

        return $this;
    }

    public function getDosstatut(): ?int
    {
        return $this->dosstatut;
    }

    public function setDosstatut(?int $dosstatut): self
    {
        $this->dosstatut = $dosstatut;

        return $this;
    }

    public function getDosdescription(): ?string
    {
        return $this->dosdescription;
    }

    public function setDosdescription(?string $dosdescription): self
    {
        $this->dosdescription = $dosdescription;

        return $this;
    }

    public function getDosdate(): ?\DateTimeInterface
    {
        return $this->dosdate;
    }

    public function setDosdate(?\DateTimeInterface $dosdate): self
    {
        $this->dosdate = $dosdate;

        return $this;
    }

    public function getDosavoid(): ?int
    {
        return $this->dosavoid;
    }

    public function setDosavoid(int $dosavoid): self
    {
        $this->dosavoid = $dosavoid;

        return $this;
    }

    public function getDoscliid(): ?int
    {
        return $this->doscliid;
    }

    public function setDoscliid(int $doscliid): self
    {
        $this->doscliid = $doscliid;

        return $this;
    }
}

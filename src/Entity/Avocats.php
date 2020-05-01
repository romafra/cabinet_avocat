<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvocatsRepository")
 */
class Avocats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rdv", mappedBy="avocat")
     */
    private $rdvss;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $init;

    public function __construct()
    {
        $this->rdvss = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection|Rdv[]
     */
    public function getRdvss(): Collection
    {
        return $this->rdvss;
    }

    public function addRdvss(Rdv $rdvss): self
    {
        if (!$this->rdvss->contains($rdvss)) {
            $this->rdvss[] = $rdvss;
            $rdvss->setAvocat($this);
        }

        return $this;
    }

    public function removeRdvss(Rdv $rdvss): self
    {
        if ($this->rdvss->contains($rdvss)) {
            $this->rdvss->removeElement($rdvss);
            // set the owning side to null (unless already changed)
            if ($rdvss->getAvocat() === $this) {
                $rdvss->setAvocat(null);
            }
        }

        return $this;
    }

    public function getInit(): ?string
    {
        return $this->init;
    }

    public function setInit(string $init): self
    {
        $this->init = $init;

        return $this;
    }

}

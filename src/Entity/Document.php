<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $doctype;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $docsujet;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $docdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $docdosid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $docstatut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctype(): ?int
    {
        return $this->doctype;
    }

    public function setDoctype(?int $doctype): self
    {
        $this->doctype = $doctype;

        return $this;
    }

    public function getDocsujet(): ?string
    {
        return $this->docsujet;
    }  

    public function setDocsujet(?string $docsujet): self
    {
        $this->docsujet = $docsujet;

        return $this;
    }

    public function getDocdate(): ?\DateTimeInterface
    {
        return $this->docdate;
    }

    public function setDocdate(?\DateTimeInterface $docdate): self
    {
        $this->docdate = $docdate;

        return $this;
    }

    public function getDocdosid(): ?int
    {
        return $this->docdosid;
    }

    public function setDocdosid(int $docdosid): self
    {
        $this->docdosid = $docdosid;

        return $this;
    }

    public function getDocstatut(): ?int
    {
        return $this->docstatut;
    }

    public function setDocstatut(?int $docstatut): self
    {
        $this->docstatut = $docstatut;

        return $this;
    }
}

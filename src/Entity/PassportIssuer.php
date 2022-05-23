<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PassportIssuerRepository")
 */
class PassportIssuer
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $issuedBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $issuerCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cbduigCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passportCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $regionId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getIssuedBy(): ?string
    {
        return $this->issuedBy;
    }

    public function setIssuedBy(string $issuedBy): self
    {
        $this->issuedBy = $issuedBy;

        return $this;
    }

    public function getCbduigCode(): ?string
    {
        return $this->cbduigCode;
    }

    public function setCbduigCode(string $cbduigCode): self
    {
        $this->cbduigCode = $cbduigCode;

        return $this;
    }

    public function getPassportCode(): ?int
    {
        return $this->passportCode;
    }

    public function setPassportCode(int $passportCode): self
    {
        $this->passportCode = $passportCode;

        return $this;
    }

    public function getRegionId(): ?int
    {
        return $this->regionId;
    }

    public function setRegionId(int $regionId): self
    {
        $this->regionId = $regionId;

        return $this;
    }

    public function getIssuerCode(): ?string
    {
        return $this->issuerCode;
    }

    public function setIssuerCode(string $issuerCode): self
    {
        $this->issuerCode = $issuerCode;

        return $this;
    }
}

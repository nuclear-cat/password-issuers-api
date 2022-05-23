<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PassportIssuerRepository;

/**
 * @ORM\Entity(repositoryClass=PassportIssuerRepository::class)
 */
class PassportIssuer
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private string $issuedBy;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $issuerCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $cbduigCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $passportCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $regionId;

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

    public function getPassportCode(): ?string
    {
        return $this->passportCode;
    }

    public function setPassportCode(string $passportCode): self
    {
        $this->passportCode = $passportCode;

        return $this;
    }

    public function getRegionId(): ?string
    {
        return $this->regionId;
    }

    public function setRegionId(string $regionId): self
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

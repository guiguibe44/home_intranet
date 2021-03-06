<?php

namespace App\Entity;

use App\Repository\WebsiteRepository;
use App\Security\Crypt;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=WebsiteRepository::class)
 */
class Website
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ftpHost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ftpUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ftpPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sqlAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sqlDataBaseName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sqlUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sqlPassword;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="websites")
     */
    private $customer;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, mappedBy="website")
     */
    private $services;

    public function __construct()
    {
        $this->customer = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function getFtpHost(): ?string
    {
        return $this->ftpHost;
    }

    public function setFtpHost(?string $ftpHost): self
    {
        $this->ftpHost = $ftpHost;

        return $this;
    }

    public function getFtpUser(): ?string
    {
        return $this->ftpUser;
    }

    public function setFtpUser(?string $ftpUser): self
    {
        $this->ftpUser = $ftpUser;

        return $this;
    }

    public function setCryptedFtpUser(?string $ftpUser): self
    {
        $crypt = new Crypt();
        $cryptFtpUser = $crypt->encrypt($ftpUser);
        $this->ftpUser = $cryptFtpUser;

        return $this;
    }
    public function getCryptedFtpUser(): ?string
    {
        $crypt = new Crypt();
        $uncryptedFtpUser = $crypt->decrypt($this->ftpUser);
        return $uncryptedFtpUser;
    }


    public function getFtpPassword(): ?string
    {
        return $this->ftpPassword;
    }

    public function setFtpPassword(?string $ftpPassword): self
    {
        $this->ftpPassword = $ftpPassword;

        return $this;
    }

    public function setCryptedFtpPassword(?string $ftpPassword): self
    {
        $crypt = new Crypt();
        $cryptFtpPassword = $crypt->encrypt($ftpPassword);
        $this->ftpPassword = $cryptFtpPassword;

        return $this;
    }
    public function getCryptedFtpPassword(): ?string
    {
        $crypt = new Crypt();
        $uncryptedFtpPassword = $crypt->decrypt($this->ftpPassword);
        return $uncryptedFtpPassword;
    }

    public function getSqlAddress(): ?string
    {
        return $this->sqlAddress;
    }

    public function setSqlAddress(?string $sqlAddress): self
    {
        $this->sqlAddress = $sqlAddress;

        return $this;
    }

    public function getSqlDataBaseName(): ?string
    {
        return $this->sqlDataBaseName;
    }

    public function setSqlDataBaseName(?string $sqlDataBaseName): self
    {
        $this->sqlDataBaseName = $sqlDataBaseName;

        return $this;
    }

    public function getSqlUser(): ?string
    {
        return $this->sqlUser;
    }

    public function setSqlUser(?string $sqlUser): self
    {
        $this->sqlUser = $sqlUser;

        return $this;
    }

    public function setCryptedSqlUser(?string $sqlUser): self
    {
        $crypt = new Crypt();
        $cryptSqlUser = $crypt->encrypt($sqlUser);
        $this->sqlUser = $cryptSqlUser;

        return $this;
    }
    public function getCryptedSqlUser(): ?string
    {
        $crypt = new Crypt();
        $uncryptedSqlUser = $crypt->decrypt($this->sqlUser);
        return $uncryptedSqlUser;
    }


    public function getSqlPassword(): ?string
    {
        return $this->sqlPassword;
    }

    public function setSqlPassword(?string $sqlPassword): self
    {
        $this->sqlPassword = $sqlPassword;

        return $this;
    }

    public function setCryptedSqlPassword(?string $password): self
    {
        $crypt = new Crypt();
        $cryptPwd = $crypt->encrypt($password);
        $this->sqlPassword = $cryptPwd;

        return $this;
    }
    public function getCryptedSqlPassword(): ?string
    {
        $crypt = new Crypt();
        $uncryptedPassword = $crypt->decrypt($this->sqlPassword);
        return $uncryptedPassword;
    }

    /**
     * @return Collection|User[]
     */
    public function getCustomer(): Collection
    {
        return $this->customer;
    }

    public function addCustomer(User $customer): self
    {
        if (!$this->customer->contains($customer)) {
            $this->customer[] = $customer;
        }

        return $this;
    }

    public function removeCustomer(User $customer): self
    {
        $this->customer->removeElement($customer);

        return $this;
    }

    public function __toString()
    {
        return $this->getDomain();
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->addWebsite($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            $service->removeWebsite($this);
        }

        return $this;
    }
}

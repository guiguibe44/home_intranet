<?php

namespace App\Entity;

use App\Repository\AccessRepository;
use App\Security\Crypt;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=AccessRepository::class)
 */
class Access
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="accesses")
     */
    private $service;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function setCryptedLogin(?string $login): self
    {
        $crypt = new Crypt();
        $cryptLogin = $crypt->encrypt($login);
        $this->login = $cryptLogin;

        return $this;
    }
    public function getCryptedLogin(): ?string
    {
        $crypt = new Crypt();
        $uncryptedLogin = $crypt->decrypt($this->login);
        return $uncryptedLogin;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function setCryptedPassword(?string $password): self
    {
        $crypt = new Crypt();
        $cryptPwd = $crypt->encrypt($password);
        $this->password = $cryptPwd;

        return $this;
    }
    public function getCryptedPassword(): ?string
    {
        $crypt = new Crypt();
        $uncryptedPassword = $crypt->decrypt($this->password);
        return $uncryptedPassword;
    }


    public function __toString()
    {
        return $this->getName();
    }
}

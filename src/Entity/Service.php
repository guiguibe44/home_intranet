<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
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
     * @ORM\ManyToMany(targetEntity=Website::class, inversedBy="services")
     */
    private $website;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="services")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Access::class, mappedBy="service")
     */
    private $accesses;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    public function __construct()
    {
        $this->website = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->accesses = new ArrayCollection();
    }

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

    /**
     * @return Collection|Website[]
     */
    public function getWebsite(): Collection
    {
        return $this->website;
    }

    public function addWebsite(Website $website): self
    {
        if (!$this->website->contains($website)) {
            $this->website[] = $website;
        }

        return $this;
    }

    public function removeWebsite(Website $website): self
    {
        $this->website->removeElement($website);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->user->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Access[]
     */
    public function getAccesses(): Collection
    {
        return $this->accesses;
    }

    public function addAccess(Access $access): self
    {
        if (!$this->accesses->contains($access)) {
            $this->accesses[] = $access;
            $access->setService($this);
        }

        return $this;
    }

    public function removeAccess(Access $access): self
    {
        if ($this->accesses->removeElement($access)) {
            // set the owning side to null (unless already changed)
            if ($access->getService() === $this) {
                $access->setService(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }


}

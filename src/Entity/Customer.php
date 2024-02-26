<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource]
class Customer extends User
{

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_creation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $civility = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $society = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\ManyToOne(inversedBy: 'customers')]
    private ?City $city = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Order::class)]
    private Collection $orders_customer;

    public function __construct()
    {
        $this->orders_customer = new ArrayCollection();
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeImmutable $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function isCivility(): ?bool
    {
        return $this->civility;
    }

    public function setCivility(?bool $civility): static
    {
        $this->civility = $civility;

        return $this;
    }

    public function getSociety(): ?string
    {
        return $this->society;
    }

    public function setSociety(?string $society): static
    {
        $this->society = $society;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersCustomer(): Collection
    {
        return $this->orders_customer;
    }

    public function addOrdersCustomer(Order $ordersCustomer): static
    {
        if (!$this->orders_customer->contains($ordersCustomer)) {
            $this->orders_customer->add($ordersCustomer);
            $ordersCustomer->setCustomer($this);
        }

        return $this;
    }

    public function removeOrdersCustomer(Order $ordersCustomer): static
    {
        if ($this->orders_customer->removeElement($ordersCustomer)) {
            // set the owning side to null (unless already changed)
            if ($ordersCustomer->getCustomer() === $this) {
                $ordersCustomer->setCustomer(null);
            }
        }

        return $this;
    }

}

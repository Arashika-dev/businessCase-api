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
use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CityRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['city:item' ]],
    operations:[
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(),
        new Patch(),
    ]
)]
class City
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['city:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['city:item', 'user:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 10)]
    #[Groups(['city:item', 'user:read'])]
    private ?string $zipCode = null;

    #[ORM\ManyToOne(inversedBy: 'cities')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['city:item', 'user:read'])]
    private ?Country $country = null;

    #[ORM\OneToMany(mappedBy: 'city', targetEntity: Customer::class)]
    private Collection $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCountry(): ?country
    {
        return $this->country;
    }

    public function setCountry(?country $country): static
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setCity($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getCity() === $this) {
                $customer->setCity(null);
            }
        }

        return $this;
    }
}

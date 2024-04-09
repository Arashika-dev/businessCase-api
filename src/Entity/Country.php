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
use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['country:item']],
    operations:[
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(),
        new Patch(),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'ipartial'])]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:item','city:item'])]
    private ?int $id = null;

    #[ORM\Column(length:3, unique:true)]
    #[Groups(['country:item','city:item', 'user:read'])]
    private ?string $code = null;


    #[ORM\Column(length: 255, unique:true)]
    #[Groups(['country:item','city:item', 'user:read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: City::class, orphanRemoval: true)]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }


    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
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

    /**
     * @return Collection<int, City>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setCountry($this);
        }

        return $this;
    }

    public function removeCity(City $city): static
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getCountry() === $this) {
                $city->setCountry(null);
            }
        }

        return $this;
    }

    public function getId(): ?int { return $this->id; }

}

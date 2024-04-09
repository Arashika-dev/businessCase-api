<?php

namespace App\Entity;


use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['articles:read']]
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('articles:read', 'category:read', 'order:read')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('articles:read', 'category:read', 'order:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups('articles:read')]
    private ?string $url_img = null;

    #[ORM\Column]
    #[Groups('articles:read', 'category:read')]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('articles:read')]
    private ?Category $category = null;

    #[ORM\ManyToMany(targetEntity: Services::class)]
    #[Groups('articles:read','order:read')]
    private Collection $service;

    public function __construct()
    {
        $this->service = new ArrayCollection();
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

    public function getUrlImg(): ?string
    {
        return $this->url_img;
    }

    public function setUrlImg(string $url_img): static
    {
        $this->url_img = $url_img;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Services $service): static
    {
        if (!$this->service->contains($service)) {
            $this->service->add($service);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        $this->service->removeElement($service);

        return $this;
    }
}

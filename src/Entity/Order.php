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
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    normalizationContext:['groups' => ['order:read']]
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['order:read', 'user:read'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['order:read', 'user:read'])]
    private ?\DateTimeImmutable $deposit_hour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['order:read', 'user:read'])]
    private ?\DateTimeInterface $recuperation_hour = null;

    #[ORM\ManyToOne(inversedBy: 'orders_customer')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read'])]
    private ?Customer $customer = null;

    #[ORM\ManyToMany(targetEntity: article::class)]
    #[Groups(['order:read'])]
    private Collection $article;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['order:read', 'user:read'])]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['order:read'])]
    private ?Staff $affectedStaff = null;

    #[ORM\Column]
    #[Groups(['order:read', 'user:read'])]
    private ?float $totalPrice = null;

    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->deposit_hour = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepositHour(): ?\DateTimeImmutable
    {
        return $this->deposit_hour;
    }

    public function setDepositHour(?\DateTimeImmutable $deposit_hour): static
    {
        $this->deposit_hour = $deposit_hour;

        return $this;
    }

    public function getRecuperationHour(): ?\DateTimeInterface
    {
        return $this->recuperation_hour;
    }

    public function setRecuperationHour(?\DateTimeInterface $recuperation_hour): static
    {
        $this->recuperation_hour = $recuperation_hour;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Collection<int, article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(article $article): static
    {
        if (!$this->article->contains($article)) {
            $this->article->add($article);
        }

        return $this;
    }

    public function removeArticle(article $article): static
    {
        $this->article->removeElement($article);

        return $this;
    }


    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAffectedStaff(): ?Staff
    {
        return $this->affectedStaff;
    }

    public function setAffectedStaff(?Staff $affectedStaff): static
    {
        $this->affectedStaff = $affectedStaff;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }
}

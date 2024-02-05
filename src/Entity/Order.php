<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deposit_hour = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $recuperation_hour = null;

    #[ORM\ManyToOne(inversedBy: 'orders_staff')]
    private ?User $staff = null;

    #[ORM\ManyToOne(inversedBy: 'orders_customer')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer = null;

    #[ORM\ManyToMany(targetEntity: article::class)]
    private Collection $article;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?State $state = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    public function __construct()
    {
        $this->article = new ArrayCollection();
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

    public function getStaff(): ?User
    {
        return $this->staff;
    }

    public function setStaff(?User $staff): static
    {
        $this->staff = $staff;

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

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): static
    {
        $this->state = $state;

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
}

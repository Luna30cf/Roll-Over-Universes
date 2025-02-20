<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Transaction_date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Amount = null;

    #[ORM\Column(length: 255)]
    private ?string $Billing_city = null;

    #[ORM\Column]
    private ?int $Billing_pc = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $Cart = null;

    #[ORM\ManyToOne(inversedBy: 'Invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->Transaction_date;
    }

    public function setTransactionDate(\DateTimeInterface $Transaction_date): static
    {
        $this->Transaction_date = $Transaction_date;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->Amount;
    }

    public function setAmount(string $Amount): static
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->Billing_city;
    }

    public function setBillingCity(string $Billing_city): static
    {
        $this->Billing_city = $Billing_city;

        return $this;
    }

    public function getBillingPc(): ?int
    {
        return $this->Billing_pc;
    }

    public function setBillingPc(int $Billing_pc): static
    {
        $this->Billing_pc = $Billing_pc;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->Cart;
    }

    public function setCart(Cart $Cart): static
    {
        $this->Cart = $Cart;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}

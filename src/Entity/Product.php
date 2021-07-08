<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Traits\EntityLifecicleTrait;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="`products`")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields={"title"}, message="Product with this title exists")
 */
class Product
{
    use EntityLifecicleTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private $qty;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=3, nullable=false)
     * @Assert\NotBlank
     * @Assert\PositiveOrZero
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=ProductOption::class, mappedBy="product_id", orphanRemoval=true)
     */
    private $productOptions;

    public function __construct()
    {
        $this->productOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|ProductOption[]
     */
    public function getProductOptions(): Collection
    {
        return $this->productOptions;
    }

    public function addProductOption(ProductOption $productOption): self
    {
        if (!$this->productOptions->contains($productOption)) {
            $this->productOptions[] = $productOption;
            $productOption->setProductId($this);
        }

        return $this;
    }

    public function removeProductOption(ProductOption $productOption): self
    {
        if ($this->productOptions->removeElement($productOption)) {
            // set the owning side to null (unless already changed)
            if ($productOption->getProductId() === $this) {
                $productOption->setProductId(null);
            }
        }

        return $this;
    }

}

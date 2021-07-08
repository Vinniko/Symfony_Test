<?php

namespace App\Entity;

use App\Repository\ProductOptionRepository;
use App\Traits\EntityLifecicleTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductOptionRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class ProductOption
{
    use EntityLifecicleTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productOptions")
     * @ORM\JoinColumn(name="product_id", nullable=false)
     */
    private $product_id;

    /**
     * @ORM\ManyToOne(targetEntity=Option::class, inversedBy="productOptions")
     * @ORM\JoinColumn(name="option_id", nullable=false)
     */
    private $option_id;

    /**
     * @ORM\Column(type="float", nullable=false)
     * @Assert\PositiveOrZero
     */
    private $value;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }

    public function getOptionId(): ?Option
    {
        return $this->option_id;
    }

    public function setOptionId(?Option $option_id): self
    {
        $this->option_id = $option_id;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }
}

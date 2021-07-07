<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use App\Traits\EntityLifecicleTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OptionRepository::class)
 * @ORM\Table(name="`options`")
 * @ORM\HasLifecycleCallbacks
 */
class Option
{
    use EntityLifecicleTrait;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,  unique=true, nullable=false)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=ProductOption::class, mappedBy="option_id", orphanRemoval=true)
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
            $productOption->setOptionId($this);
        }

        return $this;
    }

    public function removeProductOption(ProductOption $productOption): self
    {
        if ($this->productOptions->removeElement($productOption)) {
            // set the owning side to null (unless already changed)
            if ($productOption->getOptionId() === $this) {
                $productOption->setOptionId(null);
            }
        }

        return $this;
    }
}

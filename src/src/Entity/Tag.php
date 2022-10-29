<?php

namespace App\Entity;

use App\Factory\TagFactory;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Advert::class, inversedBy: 'tags')]
    private Collection $adverts;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'tag')]
    private Collection $tag;

    public function __construct()
    {
        $this->adverts = new ArrayCollection();
        $this->tag = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Advert>
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts->add($advert);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        $this->adverts->removeElement($advert);

        return $this;
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
    
    public function __toString()
    {
        return $this->title;
    }
    
    
    // #[ORM\ManyToOne(tagEntity: TagFactory::class:'tag')]
    // private $tag;
    
    public function getCatag(): ?tag
    {
        return $this->tag;
    }
    
    public function setCatag(?tag $tag): self
    {
        $this->tag = $tag;
        
        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(User $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag->add($tag);
            $tag->addTag($this);
        }

        return $this;
    }

    public function removeTag(User $tag): self
    {
        if ($this->tag->removeElement($tag)) {
            $tag->removeTag($this);
        }

        return $this;
    }
}

<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter; // ordonner nos résultats  ("amount" & "sentAt")
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 * @ApiResource(
 *     collectionOperations={"GET", "POST"},
 *     itemOperations={"GET", "PUT", "DELETE", "PATCH"},
 *     subresourceOperations={
 *          "api_categories_articles_get_subresource"={
 *              "normalization_context"={"groups"={"articles_subresources"}},
 *          },
 *           "events_get_subresource"={"path"="/articles/{id}/events"},
 *     },
 *     attributes={
 *          "pagination_enabled"=true,
 *          "pagination_items_per_page"=25,
 *          "order"={"createdAt": "desc"}
 *     },
 *     normalizationContext={
 *          "groups"={"articles_read"}
 *     },
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 * @ApiFilter(SearchFilter::class, properties={"title": "partial", "description": "partial"})
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"articles_read", "categories_read", "articles_subresources"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"articles_read", "categories_read", "articles_subresources"})
     * @Assert\NotBlank(message="Le titre est obligatoire")
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins 2 caractères")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups({"articles_read", "categories_read", "articles_subresources"})
     * @Assert\NotBlank(message="La description est obligatoire")
     * @Assert\Length(min=5, minMessage="La description doit faire au moins 5 caractères")
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     * @Assert\NotBlank(message="Le contenu est obligatoire")
     * @Assert\Length(min=50, minMessage="Le contenu doit faire au moins 50 caractères")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     */
    private $image;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     */
    private $updatedAt;


    /**
     * @ORM\Column(type="boolean")
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     * @Assert\NotBlank(message="Le statut est obligatoire")
     * @Assert\Type(type="bool", message="La valeur doit être un booléen")
     */
    private $isPublished;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="article")
     * @Groups({"articles_read", "articles_subresources" })
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @Groups({"articles_read", "categories_read", "articles_subresources"})
     * @Assert\NotBlank(message="L'auteur est obligatoire")
     */
    private $usercreator;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="article")
     * @Groups({"articles_read", "categories_read", "articles_subresources" })
     * @ApiSubresource
     */
    private $events;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    /**
     * Permet de récupérer le nombre d'evenements dans l'article
     * @Groups({"articles_read"})
     * @return int|null
     */
    public function getNbEvents(): ?int {
        $events = $this->events->toArray();
        return  count($events);
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }



    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }



    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }


    public function setCreatedAt(?\DateTime $createdAt) : self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setUpdatedAt(?\DateTime $updatedAt) : self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addArticle($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeArticle($this);
        }

        return $this;
    }

    public function getUsercreator(): ?User
    {
        return $this->usercreator;
    }

    public function setUsercreator(?User $usercreator): self
    {
        $this->usercreator = $usercreator;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setArticle($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getArticle() === $this) {
                $event->setArticle(null);
            }
        }

        return $this;
    }
}

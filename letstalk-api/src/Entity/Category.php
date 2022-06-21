<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter; // ordonner nos résultats  ("amount" & "sentAt")
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ApiResource(
 *     collectionOperations={"GET", "POST"},
 *     itemOperations={"GET", "PUT", "DELETE", "PATCH"},
 *     subresourceOperations={
 *          "articles_get_subresource"={"path"="/categories/{id}/articles"}
 *     },
 *     normalizationContext={
 *          "groups"={"categories_read"}
 *     }
 * )
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"categories_read", "articles_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"categories_read", "articles_read"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, inversedBy="categories")
     * @Groups({"categories_read"})
     * @ApiSubresource
     */
    private $article;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories_read", "articles_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"categories_read" ,"articles_read"})
     */
    private $updatedAt;

    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    /**
     * Permet de récupérer le nombre d'articles dans la catégorie
     * @Groups({"categories_read"})
     * @return int|null
     */
    public function getNbArticles(): ?int {
        $articles = $this->article->toArray();
        return  count($articles);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticle(): Collection
    {
        return $this->article;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        $this->article->removeElement($article);

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

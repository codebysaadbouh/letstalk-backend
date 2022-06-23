<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ApiResource(
 *     collectionOperations={"GET", "POST"},
 *     itemOperations={"GET", "PUT", "DELETE", "PATCH"},
 *     subresourceOperations={
 *          "api_articles_events_get_subresource"={
 *              "normalization_context"={"groups"={"events_subresources"}},
 *          },
 *     },
 *     normalizationContext={
 *          "groups"={"event_read"}
 *      },
 * )
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"event_read", "events_subresources"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_read", "events_subresources"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_read", "events_subresources"})
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_read", "events_subresources"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event_read", "events_subresources"})
     */
    private $city;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"event_read", "events_subresources"})
     */
    private $postalCode;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event_read", "events_subresources"})
     */
    private $eventAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"event_read", "events_subresources"})
     */
    private $poster;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="events")
     * @Groups({"event_read"})
     */
    private $article;

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

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getEventAt(): ?\DateTimeInterface
    {
        return $this->eventAt;
    }

    public function setEventAt(\DateTimeInterface $eventAt): self
    {
        $this->eventAt = $eventAt;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(?string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}

<?php

namespace App\Entities;

use App\EntityRepositories\ArticleRepository;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: ArticleRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class Article
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $title;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: true)]
    private ?string $subtitle = null;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: true)]
    private ?string $summary = null;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: true)]
    private string $content;

    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: ArticleCategory::class, mappedBy: 'articles', cascade: ['persist'])]
    private ArticleCategory $category;

    #[\Doctrine\ORM\Mapping\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    public function __construct(string $title, string $content, ArticleCategory $category)
    {
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): static
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCategory(): ArticleCategory
    {
        return $this->category;
    }

    public function setCategory(ArticleCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeImmutable
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeImmutable $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}

<?php

namespace App\Entities;

use App\EntityRepositories\ArticleRepository;
use Webmozart\Assert\Assert;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: ArticleRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class Article
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\ManyToOne(targetEntity: Blogger::class, inversedBy: 'articles')]
    #[\Doctrine\ORM\Mapping\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Blogger $blogger;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $title;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: true)]
    private ?string $subtitle = null;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: true)]
    private ?string $summary = null;

    #[\Doctrine\ORM\Mapping\Column(type: 'text', nullable: true)]
    private string $content;

    #[\Doctrine\ORM\Mapping\ManyToOne(targetEntity: ArticleCategory::class, cascade: ['persist'], inversedBy: 'articles')]
    #[\Doctrine\ORM\Mapping\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ArticleCategory $category;

    #[\Doctrine\ORM\Mapping\Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $publishedAt = null;

    public function __construct(Blogger $blogger, string $title, string $content, ArticleCategory $category)
    {
        Assert::maxLength($title, 255);

        $this->blogger = $blogger;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;

        $blogger->addArticle($this);
        $category->addArticle($this);
    }

    public function getBlogger(): Blogger
    {
        return $this->blogger;
    }

    public function setBlogger(Blogger $blogger): static
    {
        $this->blogger = $blogger;

        return $this;
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
        Assert::maxLength($subtitle, 255);
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

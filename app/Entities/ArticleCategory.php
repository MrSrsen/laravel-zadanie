<?php

namespace App\Entities;

use App\EntityRepositories\ArticleCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: ArticleCategoryRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class ArticleCategory
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $title;

    /** @var Collection<Article> */
    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: Article::class, inversedBy: 'category', orphanRemoval: true)]
    #[\Doctrine\ORM\Mapping\JoinTable(name: 'article_article_category')]
    #[\Doctrine\ORM\Mapping\JoinColumn(name: 'article_id', nullable: false, onDelete: 'CASCADE')]
    #[\Doctrine\ORM\Mapping\InverseJoinColumn(name: 'category_id', nullable: false, onDelete: 'CASCADE')]
    private Collection $articles;

    /** @var Collection<Blogger> */
    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: Blogger::class, inversedBy: 'category')]
    #[\Doctrine\ORM\Mapping\JoinTable(name: 'blogger_article_category')]
    #[\Doctrine\ORM\Mapping\JoinColumn(name: 'blogger_id', nullable: false, onDelete: 'CASCADE')]
    #[\Doctrine\ORM\Mapping\InverseJoinColumn(name: 'article_category_id', nullable: false, onDelete: 'CASCADE')]
    private Collection $bloggers;

    public function __construct(string $title)
    {
        $this->title = $title;

        $this->articles = new ArrayCollection();
        $this->bloggers = new ArrayCollection();
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

    /** @return Collection<Article> */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
        }

        return $this;
    }

    public function getBloggers(): Collection
    {
        return $this->bloggers;
    }

    public function addBlogger(Blogger $blogger): static
    {
        if (!$this->bloggers->contains($blogger)) {
            $this->bloggers->add($blogger);
        }

        return $this;
    }

    public function removeBlogger(Blogger $blogger): static
    {
        if ($this->bloggers->contains($blogger)) {
            $this->bloggers->removeElement($blogger);
        }

        return $this;
    }
}

<?php

namespace App\Entities;

use App\EntityRepositories\BloggerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Webmozart\Assert\Assert;

#[\Doctrine\ORM\Mapping\Entity(repositoryClass: BloggerRepository::class)]
#[\Doctrine\ORM\Mapping\HasLifecycleCallbacks]
class Blogger implements JWTSubject, Authenticatable
{
    use EntityTrait;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $title;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[\Doctrine\ORM\Mapping\Column(type: 'string', nullable: false)]
    private string $password;

    /** @var Collection<array-key, Article> */
    #[\Doctrine\ORM\Mapping\OneToMany(mappedBy: 'blogger', targetEntity: Article::class)]
    private Collection $articles;

    /** @var Collection<array-key, ArticleCategory> */
    #[\Doctrine\ORM\Mapping\ManyToMany(targetEntity: ArticleCategory::class, mappedBy: 'bloggers')]
    private Collection $articleCategories;

    public function __construct(string $title, string $email, #[\SensitiveParameter] string $password)
    {
        Assert::maxLength($title, 255);
        Assert::maxLength($email, 255);
        Assert::maxLength($password, 255);

        $this->title = $title;
        $this->email = $email;
        $this->password = $password;

        $this->articles = new ArrayCollection();
        $this->articleCategories = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        Assert::maxLength($title, 255);
        $this->title = $title;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        Assert::maxLength($email, 255);
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(#[\SensitiveParameter] string $password): static
    {
        Assert::maxLength($password, 255);
        $this->password = $password;

        return $this;
    }

    /** @return Collection<array-key, Article> */
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

    /** @return Collection<array-key, ArticleCategory> */
    public function getArticleCategories(): Collection
    {
        return $this->articleCategories;
    }

    public function addArticleCategory(ArticleCategory $articleCategory): static
    {
        if (!$this->articleCategories->contains($articleCategory)) {
            $this->articleCategories->add($articleCategory);
            $articleCategory->addBlogger($this);
        }

        return $this;
    }

    public function removeArticleCategory(ArticleCategory $articleCategory): static
    {
        if ($this->articleCategories->contains($articleCategory)) {
            $this->articleCategories->removeElement($articleCategory);
            $articleCategory->removeBlogger($this);
        }

        return $this;
    }

    public function getJWTIdentifier()
    {
        return $this->getId();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getAuthIdentifierName(): string
    {
        return 'email';
    }

    public function getAuthIdentifier(): ?string
    {
        return $this->getEmail();
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): string
    {
        return $this->getPassword();
    }

    public function getRememberToken()
    {
        throw new \RuntimeException('Not implemented.');
    }

    public function setRememberToken($value)
    {
        throw new \RuntimeException('Not implemented.');
    }

    public function getRememberTokenName()
    {
        throw new \RuntimeException('Not implemented.');
    }
}

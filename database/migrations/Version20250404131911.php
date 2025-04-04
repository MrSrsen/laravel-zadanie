<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250404131911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE article_categories (id UUID NOT NULL, title VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62A97E92B36786B ON article_categories (title)');
        $this->addSql('COMMENT ON COLUMN article_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article_categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN article_categories.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE article_article_category (article_id UUID NOT NULL, category_id UUID NOT NULL, PRIMARY KEY(article_id, category_id))');
        $this->addSql('CREATE INDEX IDX_44F096D97294869C ON article_article_category (article_id)');
        $this->addSql('CREATE INDEX IDX_44F096D912469DE2 ON article_article_category (category_id)');
        $this->addSql('CREATE TABLE blogger_article_category (blogger_id UUID NOT NULL, article_category_id UUID NOT NULL, PRIMARY KEY(blogger_id, article_category_id))');
        $this->addSql('CREATE INDEX IDX_55CF65A8D700BD1D ON blogger_article_category (blogger_id)');
        $this->addSql('CREATE INDEX IDX_55CF65A888C5F785 ON blogger_article_category (article_category_id)');
        $this->addSql('CREATE TABLE articles (id UUID NOT NULL, blogger_id UUID NOT NULL, category_id UUID NOT NULL, title VARCHAR(255) NOT NULL, subtitle VARCHAR(255) DEFAULT NULL, summary TEXT DEFAULT NULL, content TEXT DEFAULT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BFDD3168D700BD1D ON articles (blogger_id)');
        $this->addSql('CREATE INDEX IDX_BFDD316812469DE2 ON articles (category_id)');
        $this->addSql('COMMENT ON COLUMN articles.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN articles.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN articles.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN articles.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE bloggers (id UUID NOT NULL, title VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55A2B56FE7927C74 ON bloggers (email)');
        $this->addSql('COMMENT ON COLUMN bloggers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN bloggers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN bloggers.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE article_article_category ADD CONSTRAINT FK_44F096D97294869C FOREIGN KEY (article_id) REFERENCES article_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_article_category ADD CONSTRAINT FK_44F096D912469DE2 FOREIGN KEY (category_id) REFERENCES articles (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blogger_article_category ADD CONSTRAINT FK_55CF65A8D700BD1D FOREIGN KEY (blogger_id) REFERENCES article_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE blogger_article_category ADD CONSTRAINT FK_55CF65A888C5F785 FOREIGN KEY (article_category_id) REFERENCES bloggers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168D700BD1D FOREIGN KEY (blogger_id) REFERENCES bloggers (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD316812469DE2 FOREIGN KEY (category_id) REFERENCES article_categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article_article_category DROP CONSTRAINT FK_44F096D97294869C');
        $this->addSql('ALTER TABLE article_article_category DROP CONSTRAINT FK_44F096D912469DE2');
        $this->addSql('ALTER TABLE blogger_article_category DROP CONSTRAINT FK_55CF65A8D700BD1D');
        $this->addSql('ALTER TABLE blogger_article_category DROP CONSTRAINT FK_55CF65A888C5F785');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD3168D700BD1D');
        $this->addSql('ALTER TABLE articles DROP CONSTRAINT FK_BFDD316812469DE2');
        $this->addSql('DROP TABLE article_categories');
        $this->addSql('DROP TABLE article_article_category');
        $this->addSql('DROP TABLE blogger_article_category');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE bloggers');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240811162038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add first_name, last_name, created_at, and updated_at fields to user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD last_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD updated_at DATETIME DEFAULT NULL');

        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_23A0E6612469DE2 ON article (category_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user DROP COLUMN first_name');
        $this->addSql('ALTER TABLE user DROP COLUMN last_name');
        $this->addSql('ALTER TABLE user DROP COLUMN created_at');
        $this->addSql('ALTER TABLE user DROP COLUMN updated_at');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('DROP INDEX IDX_23A0E6612469DE2 ON article');
        $this->addSql('ALTER TABLE article CHANGE category_id category_id INT DEFAULT NULL');
    }
}

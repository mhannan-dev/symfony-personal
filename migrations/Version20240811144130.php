<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20240811144130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add category_id to the article table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article ADD category_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP category_id');
    }
}

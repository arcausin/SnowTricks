<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230728071200 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick ADD id_category_id INT NOT NULL');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EA545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D8F0A91EA545015 ON trick (id_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EA545015');
        $this->addSql('DROP INDEX IDX_D8F0A91EA545015 ON trick');
        $this->addSql('ALTER TABLE trick DROP id_category_id');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917172619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes_menus DROP FOREIGN KEY FK_E9C075423E2ED6D6');
        $this->addSql('ALTER TABLE recettes_menus DROP FOREIGN KEY FK_E9C0754214041B84');
        $this->addSql('DROP TABLE recettes_menus');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes_menus (recettes_id INT NOT NULL, menus_id INT NOT NULL, INDEX IDX_E9C075423E2ED6D6 (recettes_id), INDEX IDX_E9C0754214041B84 (menus_id), PRIMARY KEY(recettes_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE recettes_menus ADD CONSTRAINT FK_E9C075423E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_menus ADD CONSTRAINT FK_E9C0754214041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
    }
}

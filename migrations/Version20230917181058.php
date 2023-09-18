<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917181058 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredients_by_recette (id INT AUTO_INCREMENT NOT NULL, ingredient_id INT NOT NULL, recette_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_F44A3CA9933FE08C (ingredient_id), INDEX IDX_F44A3CA989312FE9 (recette_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredients_by_recette ADD CONSTRAINT FK_F44A3CA9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE ingredients_by_recette ADD CONSTRAINT FK_F44A3CA989312FE9 FOREIGN KEY (recette_id) REFERENCES recettes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients_by_recette DROP FOREIGN KEY FK_F44A3CA9933FE08C');
        $this->addSql('ALTER TABLE ingredients_by_recette DROP FOREIGN KEY FK_F44A3CA989312FE9');
        $this->addSql('DROP TABLE ingredients_by_recette');
    }
}

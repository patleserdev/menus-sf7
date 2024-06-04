<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231015152738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredients_categorie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recettes_categorie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredients ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES ingredients_categorie (id)');
        $this->addSql('CREATE INDEX IDX_4B60114FBCF5E72D ON ingredients (categorie_id)');
        $this->addSql('ALTER TABLE recettes ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72CBCF5E72D FOREIGN KEY (categorie_id) REFERENCES recettes_categorie (id)');
        $this->addSql('CREATE INDEX IDX_EB48E72CBCF5E72D ON recettes (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114FBCF5E72D');
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72CBCF5E72D');
        $this->addSql('DROP TABLE ingredients_categorie');
        $this->addSql('DROP TABLE recettes_categorie');
        $this->addSql('DROP INDEX IDX_4B60114FBCF5E72D ON ingredients');
        $this->addSql('ALTER TABLE ingredients DROP categorie_id');
        $this->addSql('DROP INDEX IDX_EB48E72CBCF5E72D ON recettes');
        $this->addSql('ALTER TABLE recettes DROP categorie_id');
    }
}

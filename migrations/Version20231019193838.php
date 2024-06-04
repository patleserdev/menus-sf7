<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019193838 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mesures (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredients_by_recette ADD mesure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredients_by_recette ADD CONSTRAINT FK_F44A3CA943AB22FA FOREIGN KEY (mesure_id) REFERENCES mesures (id)');
        $this->addSql('CREATE INDEX IDX_F44A3CA943AB22FA ON ingredients_by_recette (mesure_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients_by_recette DROP FOREIGN KEY FK_F44A3CA943AB22FA');
        $this->addSql('DROP TABLE mesures');
        $this->addSql('DROP INDEX IDX_F44A3CA943AB22FA ON ingredients_by_recette');
        $this->addSql('ALTER TABLE ingredients_by_recette DROP mesure_id');
    }
}

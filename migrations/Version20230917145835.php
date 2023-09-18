<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917145835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes_menus (recettes_id INT NOT NULL, menus_id INT NOT NULL, INDEX IDX_E9C075423E2ED6D6 (recettes_id), INDEX IDX_E9C0754214041B84 (menus_id), PRIMARY KEY(recettes_id, menus_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recettes_ingredients (recettes_id INT NOT NULL, ingredients_id INT NOT NULL, INDEX IDX_33E6DB8E3E2ED6D6 (recettes_id), INDEX IDX_33E6DB8E3EC4DCE (ingredients_id), PRIMARY KEY(recettes_id, ingredients_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes_menus ADD CONSTRAINT FK_E9C075423E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_menus ADD CONSTRAINT FK_E9C0754214041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_ingredients ADD CONSTRAINT FK_33E6DB8E3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes_ingredients ADD CONSTRAINT FK_33E6DB8E3EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recettes CHANGE title titre VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes_menus DROP FOREIGN KEY FK_E9C075423E2ED6D6');
        $this->addSql('ALTER TABLE recettes_menus DROP FOREIGN KEY FK_E9C0754214041B84');
        $this->addSql('ALTER TABLE recettes_ingredients DROP FOREIGN KEY FK_33E6DB8E3E2ED6D6');
        $this->addSql('ALTER TABLE recettes_ingredients DROP FOREIGN KEY FK_33E6DB8E3EC4DCE');
        $this->addSql('DROP TABLE recettes_menus');
        $this->addSql('DROP TABLE recettes_ingredients');
        $this->addSql('ALTER TABLE recettes CHANGE titre title VARCHAR(255) NOT NULL');
    }
}

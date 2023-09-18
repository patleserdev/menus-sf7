<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230917165938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menus_recettes (menus_id INT NOT NULL, recettes_id INT NOT NULL, INDEX IDX_89A9262614041B84 (menus_id), INDEX IDX_89A926263E2ED6D6 (recettes_id), PRIMARY KEY(menus_id, recettes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menus_recettes ADD CONSTRAINT FK_89A9262614041B84 FOREIGN KEY (menus_id) REFERENCES menus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menus_recettes ADD CONSTRAINT FK_89A926263E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menus_recettes DROP FOREIGN KEY FK_89A9262614041B84');
        $this->addSql('ALTER TABLE menus_recettes DROP FOREIGN KEY FK_89A926263E2ED6D6');
        $this->addSql('DROP TABLE menus_recettes');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819080028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE boissons (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, nom LONGTEXT NOT NULL, prix NUMERIC(4, 2) NOT NULL, photo LONGTEXT DEFAULT NULL, INDEX IDX_13E865EEBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boissons_categorie (id INT AUTO_INCREMENT NOT NULL, nom LONGTEXT NOT NULL, photo LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte (id INT AUTO_INCREMENT NOT NULL, categorie LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plats (id INT AUTO_INCREMENT NOT NULL, nom LONGTEXT NOT NULL, description LONGTEXT NOT NULL, prix NUMERIC(4, 2) NOT NULL, photo LONGTEXT DEFAULT NULL, categorie LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE boissons ADD CONSTRAINT FK_13E865EEBCF5E72D FOREIGN KEY (categorie_id) REFERENCES boissons_categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boissons DROP FOREIGN KEY FK_13E865EEBCF5E72D');
        $this->addSql('DROP TABLE boissons');
        $this->addSql('DROP TABLE boissons_categorie');
        $this->addSql('DROP TABLE carte');
        $this->addSql('DROP TABLE plats');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122144337 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experiences (id INT AUTO_INCREMENT NOT NULL, job_title VARCHAR(255) NOT NULL, companies VARCHAR(255) NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, activities LONGTEXT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE graduations (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, schools VARCHAR(255) NOT NULL, studies VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hobbies (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE languages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nivel VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, tech VARCHAR(510) NOT NULL, content VARCHAR(1000) NOT NULL, link VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, img VARCHAR(1000) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites_skills (sites_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_797F64217838E496 (sites_id), INDEX IDX_797F64217FF61858 (skills_id), PRIMARY KEY(sites_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, soft_skills VARCHAR(255) NOT NULL, hard_skills VARCHAR(255) NOT NULL, expertises VARCHAR(255) NOT NULL, icons VARCHAR(500) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sites_skills ADD CONSTRAINT FK_797F64217838E496 FOREIGN KEY (sites_id) REFERENCES sites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sites_skills ADD CONSTRAINT FK_797F64217FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sites_skills DROP FOREIGN KEY FK_797F64217838E496');
        $this->addSql('ALTER TABLE sites_skills DROP FOREIGN KEY FK_797F64217FF61858');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE experiences');
        $this->addSql('DROP TABLE graduations');
        $this->addSql('DROP TABLE hobbies');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE sites_skills');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE messenger_messages');
    }
}

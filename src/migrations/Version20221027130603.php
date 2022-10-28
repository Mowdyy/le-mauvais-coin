<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027130603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advert (id INT AUTO_INCREMENT NOT NULL, user_register_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, upvotes INT DEFAULT NULL, downvotes INT DEFAULT NULL, image_file_name VARCHAR(255) DEFAULT NULL, INDEX IDX_54F1F40BE06D02EB (user_register_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, user_register_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, answer VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B6F7494ED07ECCB6 (advert_id), INDEX IDX_B6F7494EE06D02EB (user_register_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_advert (tag_id INT NOT NULL, advert_id INT NOT NULL, INDEX IDX_BDB0BD27BAD26311 (tag_id), INDEX IDX_BDB0BD27D07ECCB6 (advert_id), PRIMARY KEY(tag_id, advert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_register (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', city VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, zip_code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_BF74A414E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BE06D02EB FOREIGN KEY (user_register_id) REFERENCES user_register (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EE06D02EB FOREIGN KEY (user_register_id) REFERENCES user_register (id)');
        $this->addSql('ALTER TABLE tag_advert ADD CONSTRAINT FK_BDB0BD27BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_advert ADD CONSTRAINT FK_BDB0BD27D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BE06D02EB');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED07ECCB6');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EE06D02EB');
        $this->addSql('ALTER TABLE tag_advert DROP FOREIGN KEY FK_BDB0BD27BAD26311');
        $this->addSql('ALTER TABLE tag_advert DROP FOREIGN KEY FK_BDB0BD27D07ECCB6');
        $this->addSql('DROP TABLE advert');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_advert');
        $this->addSql('DROP TABLE user_register');
    }
}

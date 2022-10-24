<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024081900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, advert_id INT NOT NULL, title VARCHAR(255) NOT NULL, answer VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B6F7494ED07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_advert (tag_id INT NOT NULL, advert_id INT NOT NULL, INDEX IDX_BDB0BD27BAD26311 (tag_id), INDEX IDX_BDB0BD27D07ECCB6 (advert_id), PRIMARY KEY(tag_id, advert_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE tag_advert ADD CONSTRAINT FK_BDB0BD27BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_advert ADD CONSTRAINT FK_BDB0BD27D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5D07ECCB6');
        $this->addSql('ALTER TABLE advert_tags DROP FOREIGN KEY FK_269CD56BD07ECCB6');
        $this->addSql('ALTER TABLE advert_tags DROP FOREIGN KEY FK_269CD56B8D7B4FB4');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE advert_tags');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BA76ED395');
        $this->addSql('DROP INDEX IDX_54F1F40BA76ED395 ON advert');
        $this->addSql('ALTER TABLE advert CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40B9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54F1F40B9D86650F ON advert (user_id_id)');
        $this->addSql('ALTER TABLE user CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE username user_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, advert_id INT DEFAULT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_8ADC54D5D07ECCB6 (advert_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE advert_tags (advert_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_269CD56B8D7B4FB4 (tags_id), INDEX IDX_269CD56BD07ECCB6 (advert_id), PRIMARY KEY(advert_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
        $this->addSql('ALTER TABLE advert_tags ADD CONSTRAINT FK_269CD56BD07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE advert_tags ADD CONSTRAINT FK_269CD56B8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED07ECCB6');
        $this->addSql('ALTER TABLE tag_advert DROP FOREIGN KEY FK_BDB0BD27BAD26311');
        $this->addSql('ALTER TABLE tag_advert DROP FOREIGN KEY FK_BDB0BD27D07ECCB6');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_advert');
        $this->addSql('ALTER TABLE user CHANGE creation_date creation_date DATE NOT NULL, CHANGE user_name username VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40B9D86650F');
        $this->addSql('DROP INDEX IDX_54F1F40B9D86650F ON advert');
        $this->addSql('ALTER TABLE advert CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_54F1F40BA76ED395 ON advert (user_id)');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200407135913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, stage_from_id INT NOT NULL, stage_to_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, distance INT NOT NULL, UNIQUE INDEX UNIQ_66AB212EF2379946 (stage_from_id), UNIQUE INDEX UNIQ_66AB212EB092F8A1 (stage_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_trip (user_id INT NOT NULL, trip_id INT NOT NULL, INDEX IDX_CD7B9F2A76ED395 (user_id), INDEX IDX_CD7B9F2A5BC2E0E (trip_id), PRIMARY KEY(user_id, trip_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, trip_id INT NOT NULL, city VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, mark INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, arrival DATE NOT NULL, departure DATE NOT NULL, INDEX IDX_C27C9369A5BC2E0E (trip_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, date DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, trip_id INT DEFAULT NULL, stage_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, path VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_14B78418A5BC2E0E (trip_id), INDEX IDX_14B784182298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, vegan TINYINT(1) NOT NULL, ecological TINYINT(1) NOT NULL, INDEX IDX_7656F53BF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212EF2379946 FOREIGN KEY (stage_from_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE transport ADD CONSTRAINT FK_66AB212EB092F8A1 FOREIGN KEY (stage_to_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_trip ADD CONSTRAINT FK_CD7B9F2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_trip ADD CONSTRAINT FK_CD7B9F2A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784182298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('ALTER TABLE user_trip DROP FOREIGN KEY FK_CD7B9F2A76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BF675F31B');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212EF2379946');
        $this->addSql('ALTER TABLE transport DROP FOREIGN KEY FK_66AB212EB092F8A1');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784182298D193');
        $this->addSql('ALTER TABLE user_trip DROP FOREIGN KEY FK_CD7B9F2A5BC2E0E');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A5BC2E0E');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A5BC2E0E');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE user_trip');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE trip');
    }
}

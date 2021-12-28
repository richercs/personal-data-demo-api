<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228112041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE App_PhoneNumber (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, phone_number VARCHAR(255) NOT NULL, INDEX IDX_BFE21411A76ED395 (user_id), UNIQUE INDEX phone_idx (user_id, phone_number), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE App_PhoneNumber ADD CONSTRAINT FK_BFE21411A76ED395 FOREIGN KEY (user_id) REFERENCES App_User (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE App_PhoneNumber');
    }
}

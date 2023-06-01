<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230531033940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE functions_admin (functions_id INT NOT NULL, admin_id INT NOT NULL, INDEX IDX_39C45F009011893B (functions_id), INDEX IDX_39C45F00642B8210 (admin_id), PRIMARY KEY(functions_id, admin_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE functions_admin ADD CONSTRAINT FK_39C45F009011893B FOREIGN KEY (functions_id) REFERENCES functions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE functions_admin ADD CONSTRAINT FK_39C45F00642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE functions_admin DROP FOREIGN KEY FK_39C45F009011893B');
        $this->addSql('ALTER TABLE functions_admin DROP FOREIGN KEY FK_39C45F00642B8210');
        $this->addSql('DROP TABLE functions_admin');
    }
}

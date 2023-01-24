<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230121170534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv ADD visiteurs_id INT DEFAULT NULL, ADD type_rdv VARCHAR(255) DEFAULT NULL, ADD date_creation DATE DEFAULT NULL, ADD id_crer_par VARCHAR(255) DEFAULT NULL, ADD id_fermer_par VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv ADD CONSTRAINT FK_10C31F86BF668307 FOREIGN KEY (visiteurs_id) REFERENCES visiteur (id)');
        $this->addSql('CREATE INDEX IDX_10C31F86BF668307 ON rdv (visiteurs_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rdv DROP FOREIGN KEY FK_10C31F86BF668307');
        $this->addSql('DROP INDEX IDX_10C31F86BF668307 ON rdv');
        $this->addSql('ALTER TABLE rdv DROP visiteurs_id, DROP type_rdv, DROP date_creation, DROP id_crer_par, DROP id_fermer_par');
    }
}

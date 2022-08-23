<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125110455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, nom_agent VARCHAR(255) NOT NULL, prenom_agent VARCHAR(255) NOT NULL, tel_agent VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, services_id INT DEFAULT NULL, nom_utilisateur VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, second_password VARCHAR(255) DEFAULT NULL, nom_user VARCHAR(255) NOT NULL, prenom_user VARCHAR(255) NOT NULL, tel_user INT NOT NULL, etat TINYINT(1) NOT NULL, adresse_user VARCHAR(255) NOT NULL, activation_token VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649D37CC8AC (nom_utilisateur), INDEX IDX_8D93D649AEF5A6C1 (services_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite (id INT AUTO_INCREMENT NOT NULL, visiteurs_id INT DEFAULT NULL, services_id INT DEFAULT NULL, users_id INT DEFAULT NULL, motif VARCHAR(255) DEFAULT NULL, type_visite VARCHAR(255) DEFAULT NULL, entrer DATETIME DEFAULT NULL, sortie DATETIME DEFAULT NULL, crer_par VARCHAR(255) DEFAULT NULL, fermer_par VARCHAR(255) DEFAULT NULL, statue TINYINT(1) DEFAULT NULL, id_crer_par VARCHAR(255) DEFAULT NULL, id_fermer_par VARCHAR(255) DEFAULT NULL, date_operation DATE DEFAULT NULL, INDEX IDX_B09C8CBBBF668307 (visiteurs_id), INDEX IDX_B09C8CBBAEF5A6C1 (services_id), INDEX IDX_B09C8CBB67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiteur (id INT AUTO_INCREMENT NOT NULL, nom_visiteur VARCHAR(255) NOT NULL, prenom_visiteur VARCHAR(255) NOT NULL, adreese_visiteur VARCHAR(255) NOT NULL, tel_visiteur INT NOT NULL, matricule VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4EA587B830AD7416 (tel_visiteur), UNIQUE INDEX UNIQ_4EA587B812B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBBF668307 FOREIGN KEY (visiteurs_id) REFERENCES visiteur (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBBAEF5A6C1 FOREIGN KEY (services_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE visite ADD CONSTRAINT FK_B09C8CBB67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AEF5A6C1');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBBAEF5A6C1');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBB67B3B43D');
        $this->addSql('ALTER TABLE visite DROP FOREIGN KEY FK_B09C8CBBBF668307');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE visite');
        $this->addSql('DROP TABLE visiteur');
    }
}

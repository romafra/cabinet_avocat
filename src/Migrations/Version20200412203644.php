<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200412203644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actu CHANGE imageurl imageurl VARCHAR(255) DEFAULT NULL, CHANGE link link VARCHAR(255) DEFAULT NULL, CHANGE textalt textalt VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE avocats CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client CHANGE adress adress VARCHAR(255) DEFAULT NULL, CHANGE zipcode zipcode VARCHAR(30) DEFAULT NULL, CHANGE city city VARCHAR(100) DEFAULT NULL, CHANGE phone phone VARCHAR(50) DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE email email VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE doctype doctype INT DEFAULT NULL, CHANGE docsujet docsujet VARCHAR(255) DEFAULT NULL, CHANGE docdate docdate DATE DEFAULT NULL, CHANGE docstatut docstatut INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier CHANGE dosref dosref VARCHAR(100) DEFAULT NULL, CHANGE dosstatut dosstatut INT DEFAULT NULL, CHANGE dosdescription dosdescription VARCHAR(255) DEFAULT NULL, CHANGE dosdate dosdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE rdv CHANGE avocat_id avocat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actu CHANGE imageurl imageurl VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE link link VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE textalt textalt VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE avocats CHANGE firstname firstname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE lastname lastname VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE client CHANGE adress adress VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE zipcode zipcode VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE user_id user_id INT DEFAULT NULL, CHANGE email email VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE document CHANGE doctype doctype INT DEFAULT NULL, CHANGE docsujet docsujet VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE docdate docdate DATE DEFAULT \'NULL\', CHANGE docstatut docstatut INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dossier CHANGE dosref dosref VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE dosstatut dosstatut INT DEFAULT NULL, CHANGE dosdescription dosdescription VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE dosdate dosdate DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE rdv CHANGE avocat_id avocat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}

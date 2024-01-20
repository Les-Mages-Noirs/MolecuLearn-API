<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240120172147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE atom_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE connection_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE molecule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE atom (id INT NOT NULL, atomic_number INT NOT NULL, symbol VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE connection (id INT NOT NULL, atom1_id INT DEFAULT NULL, atom2_id INT DEFAULT NULL, value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29F7736628D306E1 ON connection (atom1_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29F773663A66A90F ON connection (atom2_id)');
        $this->addSql('CREATE TABLE molecule (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('ALTER TABLE connection ADD CONSTRAINT FK_29F7736628D306E1 FOREIGN KEY (atom1_id) REFERENCES atom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE connection ADD CONSTRAINT FK_29F773663A66A90F FOREIGN KEY (atom2_id) REFERENCES atom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE atom_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE connection_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE molecule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE connection DROP CONSTRAINT FK_29F7736628D306E1');
        $this->addSql('ALTER TABLE connection DROP CONSTRAINT FK_29F773663A66A90F');
        $this->addSql('DROP TABLE atom');
        $this->addSql('DROP TABLE connection');
        $this->addSql('DROP TABLE molecule');
        $this->addSql('DROP TABLE "user"');
    }
}

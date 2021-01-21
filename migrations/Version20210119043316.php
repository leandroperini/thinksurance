<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119043316 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_permission (role_id INTEGER NOT NULL, permission_id INTEGER NOT NULL, PRIMARY KEY(role_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_6F7DF886D60322AC ON role_permission (role_id)');
        $this->addSql('CREATE INDEX IDX_6F7DF886FED90CCA ON role_permission (permission_id)');
        $this->addSql('DROP INDEX IDX_2DE8C6A3D60322AC');
        $this->addSql('DROP INDEX IDX_2DE8C6A3A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_role AS SELECT user_id, role_id FROM user_role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('CREATE TABLE user_role (user_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(user_id, role_id), CONSTRAINT FK_2DE8C6A3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2DE8C6A3D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_role (user_id, role_id) SELECT user_id, role_id FROM __temp__user_role');
        $this->addSql('DROP TABLE __temp__user_role');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('DROP INDEX IDX_472E5446FED90CCA');
        $this->addSql('DROP INDEX IDX_472E5446A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_permission AS SELECT user_id, permission_id FROM user_permission');
        $this->addSql('DROP TABLE user_permission');
        $this->addSql('CREATE TABLE user_permission (user_id INTEGER NOT NULL, permission_id INTEGER NOT NULL, PRIMARY KEY(user_id, permission_id), CONSTRAINT FK_472E5446A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_472E5446FED90CCA FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user_permission (user_id, permission_id) SELECT user_id, permission_id FROM __temp__user_permission');
        $this->addSql('DROP TABLE __temp__user_permission');
        $this->addSql('CREATE INDEX IDX_472E5446FED90CCA ON user_permission (permission_id)');
        $this->addSql('CREATE INDEX IDX_472E5446A76ED395 ON user_permission (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP INDEX IDX_472E5446A76ED395');
        $this->addSql('DROP INDEX IDX_472E5446FED90CCA');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_permission AS SELECT user_id, permission_id FROM user_permission');
        $this->addSql('DROP TABLE user_permission');
        $this->addSql('CREATE TABLE user_permission (user_id INTEGER NOT NULL, permission_id INTEGER NOT NULL, PRIMARY KEY(user_id, permission_id))');
        $this->addSql('INSERT INTO user_permission (user_id, permission_id) SELECT user_id, permission_id FROM __temp__user_permission');
        $this->addSql('DROP TABLE __temp__user_permission');
        $this->addSql('CREATE INDEX IDX_472E5446A76ED395 ON user_permission (user_id)');
        $this->addSql('CREATE INDEX IDX_472E5446FED90CCA ON user_permission (permission_id)');
        $this->addSql('DROP INDEX IDX_2DE8C6A3A76ED395');
        $this->addSql('DROP INDEX IDX_2DE8C6A3D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user_role AS SELECT user_id, role_id FROM user_role');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('CREATE TABLE user_role (user_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(user_id, role_id))');
        $this->addSql('INSERT INTO user_role (user_id, role_id) SELECT user_id, role_id FROM __temp__user_role');
        $this->addSql('DROP TABLE __temp__user_role');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
    }
}

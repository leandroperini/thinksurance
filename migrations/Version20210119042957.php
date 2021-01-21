<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210119042957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_role (user_id INTEGER NOT NULL, role_id INTEGER NOT NULL, PRIMARY KEY(user_id, role_id))');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3A76ED395 ON user_role (user_id)');
        $this->addSql('CREATE INDEX IDX_2DE8C6A3D60322AC ON user_role (role_id)');
        $this->addSql('CREATE TABLE user_permission (user_id INTEGER NOT NULL, permission_id INTEGER NOT NULL, PRIMARY KEY(user_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_472E5446A76ED395 ON user_permission (user_id)');
        $this->addSql('CREATE INDEX IDX_472E5446FED90CCA ON user_permission (permission_id)');
        $this->addSql('DROP TABLE role_permission');
        $this->addSql('DROP TABLE role_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role_permission (role_id INTEGER NOT NULL, permission_id INTEGER NOT NULL, PRIMARY KEY(role_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_6F7DF886FED90CCA ON role_permission (permission_id)');
        $this->addSql('CREATE INDEX IDX_6F7DF886D60322AC ON role_permission (role_id)');
        $this->addSql('CREATE TABLE role_user (role_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(role_id, user_id))');
        $this->addSql('CREATE INDEX IDX_332CA4DDA76ED395 ON role_user (user_id)');
        $this->addSql('CREATE INDEX IDX_332CA4DDD60322AC ON role_user (role_id)');
        $this->addSql('DROP TABLE user_role');
        $this->addSql('DROP TABLE user_permission');
    }
}

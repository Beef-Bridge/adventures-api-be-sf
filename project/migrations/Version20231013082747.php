<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231013082747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095A24AA27A8');
        $this->addSql('DROP INDEX IDX_AC74095A24AA27A8 ON activity');
        $this->addSql('ALTER TABLE activity ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE activity_type_id_id activity_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095AC51EFA73 FOREIGN KEY (activity_type_id) REFERENCES activity_type (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AC74095AC51EFA73 ON activity (activity_type_id)');
        $this->addSql('ALTER TABLE activity_type ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity_type DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE activity DROP FOREIGN KEY FK_AC74095AC51EFA73');
        $this->addSql('DROP INDEX IDX_AC74095AC51EFA73 ON activity');
        $this->addSql('ALTER TABLE activity DROP created_at, DROP updated_at, CHANGE activity_type_id activity_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE activity ADD CONSTRAINT FK_AC74095A24AA27A8 FOREIGN KEY (activity_type_id_id) REFERENCES activity_type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AC74095A24AA27A8 ON activity (activity_type_id_id)');
    }
}

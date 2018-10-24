<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180915224252 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dialog_contact DROP FOREIGN KEY FK_6173E6675E46C4E2');
        $this->addSql('DROP TABLE dialog');
        $this->addSql('DROP TABLE dialog_contact');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dialog (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, dated DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialog_contact (dialog_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_6173E6675E46C4E2 (dialog_id), INDEX IDX_6173E667E7A1254A (contact_id), PRIMARY KEY(dialog_id, contact_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dialog_contact ADD CONSTRAINT FK_6173E6675E46C4E2 FOREIGN KEY (dialog_id) REFERENCES dialog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dialog_contact ADD CONSTRAINT FK_6173E667E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
    }
}

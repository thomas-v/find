<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181018223613 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contract_contact DROP FOREIGN KEY FK_44339BF0E7A1254A');
        $this->addSql('ALTER TABLE contract_contact DROP FOREIGN KEY FK_44339BF02576E0FD');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE contract_contact');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, firstname VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, gender VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, address VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, zip VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, city VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, mail VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, phone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_4C62E638979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_contact (contract_id INT NOT NULL, contact_id INT NOT NULL, INDEX IDX_44339BF02576E0FD (contract_id), INDEX IDX_44339BF0E7A1254A (contact_id), PRIMARY KEY(contract_id, contact_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE contract_contact ADD CONSTRAINT FK_44339BF02576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contract_contact ADD CONSTRAINT FK_44339BF0E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE');
    }
}

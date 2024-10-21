<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018125254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_streamer (user_id INT NOT NULL, streamer_id INT NOT NULL, INDEX IDX_CD7B4A32A76ED395 (user_id), INDEX IDX_CD7B4A3225F432AD (streamer_id), PRIMARY KEY(user_id, streamer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_succes (user_id INT NOT NULL, succes_id INT NOT NULL, INDEX IDX_DA9038BEA76ED395 (user_id), INDEX IDX_DA9038BE4EF1B4AB (succes_id), PRIMARY KEY(user_id, succes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_streamer ADD CONSTRAINT FK_CD7B4A32A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_streamer ADD CONSTRAINT FK_CD7B4A3225F432AD FOREIGN KEY (streamer_id) REFERENCES streamer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_succes ADD CONSTRAINT FK_DA9038BEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_succes ADD CONSTRAINT FK_DA9038BE4EF1B4AB FOREIGN KEY (succes_id) REFERENCES succes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chambre ADD streamer_id INT DEFAULT NULL, ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF25F432AD FOREIGN KEY (streamer_id) REFERENCES streamer (id)');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FFD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE INDEX IDX_C509E4FF25F432AD ON chambre (streamer_id)');
        $this->addSql('CREATE INDEX IDX_C509E4FFD725330D ON chambre (agence_id)');
        $this->addSql('ALTER TABLE user ADD agence_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D725330D ON user (agence_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_streamer DROP FOREIGN KEY FK_CD7B4A32A76ED395');
        $this->addSql('ALTER TABLE user_streamer DROP FOREIGN KEY FK_CD7B4A3225F432AD');
        $this->addSql('ALTER TABLE user_succes DROP FOREIGN KEY FK_DA9038BEA76ED395');
        $this->addSql('ALTER TABLE user_succes DROP FOREIGN KEY FK_DA9038BE4EF1B4AB');
        $this->addSql('DROP TABLE user_streamer');
        $this->addSql('DROP TABLE user_succes');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF25F432AD');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FFD725330D');
        $this->addSql('DROP INDEX IDX_C509E4FF25F432AD ON chambre');
        $this->addSql('DROP INDEX IDX_C509E4FFD725330D ON chambre');
        $this->addSql('ALTER TABLE chambre DROP streamer_id, DROP agence_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D725330D');
        $this->addSql('DROP INDEX UNIQ_8D93D649D725330D ON user');
        $this->addSql('ALTER TABLE user DROP agence_id');
    }
}

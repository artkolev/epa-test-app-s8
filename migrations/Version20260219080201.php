<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260219080201 extends AbstractMigration
{

    const string TABLENAME = 'service';

    public function getDescription(): string
    {
        return 'Add service table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
CREATE TABLE  `' . self::TABLENAME . '` (
    id INT AUTO_INCREMENT NOT NULL,
    title VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY UK_title (title),
    INDEX IDX_active (active)
) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `' . self::TABLENAME . '`');
    }
}

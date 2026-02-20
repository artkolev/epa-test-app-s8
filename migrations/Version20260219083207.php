<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260219083207 extends AbstractMigration
{

    const string TABLENAME = 'order';

    public function getDescription(): string
    {
        return 'Add order table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
CREATE TABLE  `' . self::TABLENAME . '` (
    id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    email VARCHAR(180) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
    FOREIGN KEY (`service_id`) REFERENCES `service` (`id`)
) DEFAULT CHARACTER SET utf8mb4
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE `' . self::TABLENAME . '`');
    }
}

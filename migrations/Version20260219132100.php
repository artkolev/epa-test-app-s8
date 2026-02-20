<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260219132100 extends AbstractMigration
{
    const string TABLENAME = 'service';

    public function getDescription(): string
    {
        return 'Add service exaptions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
INSERT INTO `' . self::TABLENAME . '`
    (`title`, `price`, `active`)
VALUES
    (\'Оценка стоимости автомобиля\', 500, 1),
    (\'Оценка стоимости квартиры\', 5000, 1),
    (\'Оценка стоимости бизнеса\', 50000, 1)
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM `' . self::TABLENAME . '` WHERE `title` IN
            (\'Оценка стоимости автомобиля\', \'Оценка стоимости квартиры\', \'Оценка стоимости бизнеса\')');
    }
}

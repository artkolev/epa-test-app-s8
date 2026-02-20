<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260219065451 extends AbstractMigration
{
    const string TABLENAME = 'user';

    public function getDescription(): string
    {
        return 'Add default user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
INSERT INTO `' . self::TABLENAME . '`
    (`id`, `email`, `roles`, `password`)
VALUES (
    1,
    \'admin@example.com\',
    \'["ROLE_USER"]\',
    \'$argon2id$v=19$m=65536,t=4,p=1$yEr9V85v4Fh5mCdUHG82tQ$z3eJH6/rSXaBMw+W/QxlXeYPHN+ljQFM42D4PF72dLA\'
)
    ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM `' . self::TABLENAME . '` WHERE `id` = 1');
    }
}

<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200827022002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create products table';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql(/** @lang PostgreSQL */ <<<'SQL'
CREATE TABLE public.products (
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    CONSTRAINT products_pkey PRIMARY KEY (id)
)
SQL
);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(/** @lang PostgreSQL */'DROP TABLE public.products');
    }
}

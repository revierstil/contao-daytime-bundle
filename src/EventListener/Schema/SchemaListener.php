<?php

declare(strict_types=1);

namespace Revierstil\DaytimeBundle\EventListener\Schema;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaTableEventArgs;
use Revierstil\DaytimeBundle\Entity\Text;

final class SchemaListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    private $removePidForeignKeyEntities = [
        Text::class,
    ];

    private $removePidForeignKeyTables;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postGenerateSchemaTable(GenerateSchemaTableEventArgs $args)
    {
        $table = $args->getClassTable();
        if (in_array($table->getName(), $this->getRemovePidForeignKeyTables())) {
            $this->removePidForeignKeyConstraints($table);
        }
    }

    private function removePidForeignKeyConstraints(Table $table)
    {
        /** @var ForeignKeyConstraint $constraint */
        foreach ($table->getForeignKeys() as $constraint) {
            if (in_array('pid', $constraint->getLocalColumns())) {
                $table->removeForeignKey($constraint->getName());
            }
        }
    }

    private function getRemovePidForeignKeyTables()
    {
        if (is_null($this->removePidForeignKeyTables)) {
            $this->removePidForeignKeyTables = array_map(function ($entityName) {
                return $this->entityManager->getClassMetadata($entityName)->getTableName();
            }, $this->removePidForeignKeyEntities);
        }

        return $this->removePidForeignKeyTables;
    }
}

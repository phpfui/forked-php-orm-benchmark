<?php

declare(strict_types=1);

namespace app\Mapper;

use Sirius\Orm\Action\Delete as DeleteAction;
use Sirius\Orm\Action\Insert as InsertAction;
use Sirius\Orm\Action\Update as UpdateAction;
use Sirius\Orm\Connection;
use Sirius\Orm\Entity\ClassMethodsHydrator;
use Sirius\Orm\Entity\StateEnum;
use Sirius\Orm\Exception\FailedActionException;
use Sirius\Orm\Mapper;
use Sirius\Orm\MapperConfig;
use Sirius\Sql\Bindings;
use app\Entity\Category;

/**
 * @method CategoryQuery where($column, $value, $condition)
 * @method CategoryQuery orderBy(string $expr, string ...$exprs)
 */
abstract class CategoryMapperBase extends Mapper
{
    protected function init()
    {
        $this->mapperConfig = MapperConfig::fromArray([
            'entityClass' => 'app\Entity\Category',
            'primaryKey' => 'id',
            'table' => 'categories',
            'tableAlias' => null,
            'guards' => [],
            'columns' => ['id', 'name'],
            'columnAttributeMap' => [],
            'casts' => ['id' => 'int', 'name' => 'string'],
        ]);
        $this->hydrator     = new ClassMethodsHydrator($this->orm->getCastingManager());
        $this->hydrator->setMapper($this);

        $this->initRelations();
    }

    protected function initRelations()
    {
    }

    public function find($pk, array $load = []): ?Category
    {
        return $this->newQuery()->find($pk, $load);
    }

    public function newQuery(): CategoryQuery
    {
        $query = new CategoryQuery($this->getReadConnection(), $this);
        return $this->behaviours->apply($this, __FUNCTION__, $query);
    }

    public function newSubselectQuery(Connection $connection, Bindings $bindings, string $indent): CategoryQuery
    {
        $query = new CategoryQuery($this->getReadConnection(), $this, $bindings, $indent);
        return $this->behaviours->apply($this, __FUNCTION__, $query);
    }

    public function save(Category $entity, $withRelations = false): bool
    {
        $entity = $this->behaviours->apply($this, 'saving', $entity);
        $action = $this->newSaveAction($entity, ['relations' => $withRelations]);
        $result = $this->runActionInTransaction($action);
        $entity = $this->behaviours->apply($this, 'saved', $entity);

        return $result;
    }

    public function newSaveAction(Category $entity, $options): UpdateAction
    {
        if ( ! $this->getHydrator()->getPk($entity) || $entity->getState() == StateEnum::NEW) {
            $action = new InsertAction($this, $entity, $options);
        } else {
            $action = new UpdateAction($this, $entity, $options);
        }

        return $this->behaviours->apply($this, __FUNCTION__, $action);
    }

    public function delete(Category $entity, $withRelations = false): bool
    {
        $entity = $this->behaviours->apply($this, 'deleting', $entity);
        $action = $this->newDeleteAction($entity, ['relations' => $withRelations]);
        $result = $this->runActionInTransaction($action);
        $entity = $this->behaviours->apply($this, 'deleted', $entity);

        return $result;
    }

    public function newDeleteAction(Category $entity, $options): DeleteAction
    {
        $action = new DeleteAction($this, $entity, $options);

        return $this->behaviours->apply($this, __FUNCTION__, $action);
    }
}

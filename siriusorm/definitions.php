<?php

use Sirius\Orm\Blueprint\Column;
use Sirius\Orm\Blueprint\ComputedProperty;
use Sirius\Orm\Blueprint\Mapper;
use Sirius\Orm\Blueprint\Orm;
use Sirius\Orm\Blueprint\Relation\ManyToMany;
use Sirius\Orm\Blueprint\Relation\ManyToOne;
use Sirius\Orm\Blueprint\Relation\OneToMany;
use Sirius\Orm\CodeGenerator\ClassGenerator;

$orm = Orm::make()
          ->setMapperNamespace('app\\Mapper')
          ->setMapperDestination(__DIR__ . '/src/Mapper/')
          ->setEntityNamespace('app\\Entity')
          ->setEntityDestination(__DIR__ . '/src/Entity/');

$orm->addMapper(
    Mapper::make('products')
          ->setEntityStyle(Mapper::ENTITY_STYLE_METHODS)
          ->setTable('products')
        // columns
          ->addAutoIncrementColumn()
          ->addColumn(Column::integer('category_id', true))
          ->addColumn(Column::varchar('name'))
          ->addColumn(Column::varchar('sku'))
          ->addColumn(Column::decimal('price', 14, 2))
        // relations
          ->addRelation('images', OneToMany::make('images')
                                           ->setForeignKey('imageable_id')
                                           ->setForeignGuards(['imageable_type' => 'products']))
          ->addRelation('tags', ManyToMany::make('tags'))
          ->addRelation('category', ManyToOne::make('categories'))
);


$orm->addMapper(
    Mapper::make('images')
          ->setEntityStyle(Mapper::ENTITY_STYLE_METHODS)
          ->setTable('images')
        // columns
          ->addAutoIncrementColumn()
          ->addColumn(Column::varchar('imageable_type', 100)->setIndex(true))
          ->addColumn(Column::bigInteger('imageable_id', true)->setIndex(true))
          ->addColumn(Column::string('path'))
);

$orm->addMapper(
    Mapper::make('tags')
          ->setEntityStyle(Mapper::ENTITY_STYLE_METHODS)
          ->addAutoIncrementColumn()
          ->addColumn(Column::varchar('name'))
          ->addComputedProperty(ComputedProperty::make('product_id')
                                                ->setGetterBody('return $this->get("product_id");')
                                                ->setSetterBody('return $this->set("product_id", $value);')
          )
);

$orm->addMapper(
    Mapper::make('categories')
          ->setEntityStyle(Mapper::ENTITY_STYLE_METHODS)
        // columns
          ->addAutoIncrementColumn()
          ->addColumn(Column::string('name')->setUnique(true))
);

$generator = new ClassGenerator($orm);
$generator->writeFiles();

return $orm;


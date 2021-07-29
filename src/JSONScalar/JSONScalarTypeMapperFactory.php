<?php

namespace TheCodingMachine\GraphQLite\Types\JSONScalar;

use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperFactoryContext;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperFactoryInterface;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class JSONScalarTypeMapperFactory implements RootTypeMapperFactoryInterface
{
    public function create(
        RootTypeMapperInterface $next,
        RootTypeMapperFactoryContext $context
    ): RootTypeMapperInterface {
        return new JSONScalarTypeMapper($next);
    }
}

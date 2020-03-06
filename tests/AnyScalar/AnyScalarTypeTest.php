<?php

namespace TheCodingMachine\GraphQLite\Types\AnyScalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\SelectionSetNode;
use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\OutputType;
use GraphQL\Type\Definition\Type as GraphQLType;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use RuntimeException;
use TheCodingMachine\GraphQLite\Mappers\RecursiveTypeMapperInterface;
use TheCodingMachine\GraphQLite\Mappers\Root\FinalRootTypeMapper;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class AnyScalarTypeTest extends TestCase
{
    public function testMapNameToType()
    {
        $typeMapper = new class implements RootTypeMapperInterface {
            public function toGraphQLOutputType(Type $type, ?OutputType $subType, ReflectionMethod $refMethod, DocBlock $docBlockObj): OutputType
            {
                throw new RuntimeException('Not implemented');
            }

            /**
             * @inheritDoc
             */
            public function toGraphQLInputType(Type $type, ?InputType $subType, string $argumentName, ReflectionMethod $refMethod, DocBlock $docBlockObj): InputType
            {
                throw new RuntimeException('Not implemented');
            }

            /**
             * @inheritDoc
             */
            public function mapNameToType(string $typeName): NamedType
            {
                throw new RuntimeException('Not found');
            }
        };

        $mapper = new AnyScalarTypeMapper($typeMapper);

        $this->expectExceptionMessage('Not found');
        $mapper->mapNameToType('foo');
    }
}

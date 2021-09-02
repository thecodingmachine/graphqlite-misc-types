<?php

namespace TheCodingMachine\GraphQLite\Types\JSONScalar;

use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\OutputType;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use RuntimeException;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class JSONScalarTypeTest extends TestCase
{
    public function testMapNameToType()
    {
        $typeMapper = new class implements RootTypeMapperInterface {
            public function toGraphQLOutputType(Type $type, ?OutputType $subType, $reflector, DocBlock $docBlockObj): OutputType
            {
                throw new RuntimeException('Not implemented');
            }

            /**
             * @inheritDoc
             */
            public function toGraphQLInputType(Type $type, ?InputType $subType, string $argumentName, $reflector, DocBlock $docBlockObj): InputType
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

        $mapper = new JSONScalarTypeMapper($typeMapper);

        $this->expectExceptionMessage('Not found');
        $mapper->mapNameToType('foo');
    }
}

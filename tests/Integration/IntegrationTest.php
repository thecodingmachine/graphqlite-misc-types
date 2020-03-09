<?php

namespace TheCodingMachine\GraphQLite\Types;


use GraphQL\Error\Debug;
use GraphQL\GraphQL;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;
use TheCodingMachine\GraphQLite\Containers\BasicAutoWiringContainer;
use TheCodingMachine\GraphQLite\Containers\EmptyContainer;
use TheCodingMachine\GraphQLite\Mappers\StaticTypeMapper;
use TheCodingMachine\GraphQLite\Schema;
use TheCodingMachine\GraphQLite\SchemaFactory;
use TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarType;
use TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarTypeMapper;
use TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarTypeMapperFactory;

class IntegrationTest extends TestCase
{
    /**
     * @var Schema
     */
    private $schema;

    public function setUp(): void
    {
        $schemaFactory = new SchemaFactory(new ArrayCache(), new BasicAutoWiringContainer(new EmptyContainer()));
        $schemaFactory->addControllerNamespace('TheCodingMachine\GraphQLite\Types\Fixtures');
        $schemaFactory->addTypeNamespace('TheCodingMachine\GraphQLite\Types\Fixtures');


        $schemaFactory->addRootTypeMapperFactory(new AnyScalarTypeMapperFactory());


        $this->schema = $schemaFactory->createSchema();
    }

    public function testEndToEnd(): void
    {
        $this->schema->assertValid();

        // Test string
        $queryString = '
        query {
            echoScalar(scalar:"foo")
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        $this->assertSame([
            'echoScalar' => 'foo'
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);

        // Test int
        $queryString = '
        query {
            echoScalar(scalar:42)
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        $this->assertSame([
            'echoScalar' => 42
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);

        // Test float
        $queryString = '
        query {
            echoScalar(scalar:42.42)
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        $this->assertSame([
            'echoScalar' => 42.42
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);

        // Test bool
        $queryString = '
        query {
            echoScalar(scalar:true)
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        $this->assertSame([
            'echoScalar' => true
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);

    }
}

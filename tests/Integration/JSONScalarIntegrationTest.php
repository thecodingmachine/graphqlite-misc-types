<?php

namespace TheCodingMachine\GraphQLite\Types;


use GraphQL\Error\Debug;
use GraphQL\GraphQL;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Simple\ArrayCache;
use TheCodingMachine\GraphQLite\Containers\BasicAutoWiringContainer;
use TheCodingMachine\GraphQLite\Containers\EmptyContainer;
use TheCodingMachine\GraphQLite\Schema;
use TheCodingMachine\GraphQLite\SchemaFactory;
use TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarTypeMapperFactory;
use TheCodingMachine\GraphQLite\Types\JSONScalar\JSONScalarTypeMapperFactory;

class JSONScalarIntegrationTest extends TestCase
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
        $schemaFactory->addRootTypeMapperFactory(new JSONScalarTypeMapperFactory());


        $this->schema = $schemaFactory->createSchema();
    }

    public function testEndToEnd(): void
    {
        $this->schema->assertValid();

        // Test JSON
        $queryString = '
        query {
            echoJSON(JSON:"{\"foo\": \"bar\"}")
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        $this->assertSame([
            'echoJSON' => ['foo' => 'bar']
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);
    }
}

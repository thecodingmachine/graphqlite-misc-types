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

class IntegrationTest extends TestCase
{
    /**
     * @var Schema
     */
    private $schema;

    public function setUp()
    {
        $schemaFactory = new SchemaFactory(new ArrayCache(), new BasicAutoWiringContainer(new EmptyContainer()));
        $schemaFactory->addControllerNamespace('TheCodingMachine\GraphQLite\Types\Fixtures');
        $schemaFactory->addTypeNamespace('TheCodingMachine\GraphQLite\Types\Fixtures');

        $this->schema = $schemaFactory->createSchema();
    }

    public function testEndToEnd()
    {
        $this->schema->assertValid();

        $queryString = '
        query {
            echoScalar(scalar:"foo")
        }
        ';

        $result = GraphQL::executeQuery(
            $this->schema,
            $queryString
        );

        var_dump($result);

        $this->assertSame([
            'echoScalar' => 'foo'
        ], $result->toArray(Debug::RETHROW_INTERNAL_EXCEPTIONS)['data']);

    }
}
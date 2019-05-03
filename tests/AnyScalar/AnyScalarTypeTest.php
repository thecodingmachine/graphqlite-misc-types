<?php

namespace TheCodingMachine\GraphQLite\Types\AnyScalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\SelectionSetNode;
use PHPUnit\Framework\TestCase;

class AnyScalarTypeTest extends TestCase
{
    public function testMapNameToType()
    {
        $mapper = new AnyScalarTypeMapper();

        $this->assertNull($mapper->mapNameToType('foo'));
    }
}

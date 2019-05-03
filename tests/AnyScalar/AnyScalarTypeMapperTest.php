<?php

namespace TheCodingMachine\GraphQLite\Types\AnyScalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\SelectionSetNode;
use PHPUnit\Framework\TestCase;

class AnyScalarTypeMapperTest extends TestCase
{
    public function testErrorsParseValue()
    {
        $anyScalarType = new AnyScalarType();

        $this->expectException(Error::class);
        $anyScalarType->parseValue([]);
    }

    public function testErrorsParseLiterral()
    {
        $anyScalarType = new AnyScalarType();

        $this->expectException(Error::class);
        $anyScalarType->parseLiteral(new SelectionSetNode([]));
    }
}

<?php

namespace TheCodingMachine\GraphQLite\Types\JSONScalar;

use GraphQL\Error\Error;
use GraphQL\Language\AST\SelectionSetNode;
use PHPUnit\Framework\TestCase;

class JSONScalarTypeMapperTest extends TestCase
{
    public function testErrorsParseValue()
    {
        $jsonScalarType = new JSONScalarType();

        $this->expectException(Error::class);
        $jsonScalarType->parseValue('');
    }

    public function testErrorsParseLiterral()
    {
        $jsonScalarType = new JSONScalarType();

        $this->expectException(Error::class);
        $jsonScalarType->parseLiteral(new SelectionSetNode([]));
    }
}

<?php


namespace TheCodingMachine\GraphQLite\Types\AnyScalar;


use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\OutputType;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types\Scalar;
use ReflectionMethod;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class AnyScalarTypeMapper implements RootTypeMapperInterface
{

    public function toGraphQLOutputType(Type $type, ?OutputType $subType, ReflectionMethod $refMethod, DocBlock $docBlockObj): ?OutputType
    {
        if ($type instanceof Scalar) {
            // AnyScalarType is a class implementing the Webonyx ScalarType type.
            return AnyScalarType::getInstance();
        }
        return null;
    }

    public function toGraphQLInputType(Type $type, ?InputType $subType, string $argumentName, ReflectionMethod $refMethod, DocBlock $docBlockObj): ?InputType
    {
        if ($type instanceof Scalar) {
            // AnyScalarType is a class implementing the Webonyx ScalarType type.
            return AnyScalarType::getInstance();
        }
        return null;
    }

    /**
     * Returns a GraphQL type by name.
     * If this root type mapper can return this type in "toGraphQLOutputType" or "toGraphQLInputType", it should
     * also map these types by name in the "mapNameToType" method.
     *
     * @param string $typeName The name of the GraphQL type
     * @return NamedType|null
     */
    public function mapNameToType(string $typeName): ?NamedType
    {
        if ($typeName === AnyScalarType::NAME) {
            return AnyScalarType::getInstance();
        }
        return null;
    }
}

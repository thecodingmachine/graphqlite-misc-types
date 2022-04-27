<?php

namespace TheCodingMachine\GraphQLite\Types\JSONScalar;

use GraphQL\Type\Definition\InputType;
use GraphQL\Type\Definition\NamedType;
use GraphQL\Type\Definition\OutputType;
use phpDocumentor\Reflection\DocBlock;
use phpDocumentor\Reflection\Type;
use ReflectionMethod;
use ReflectionProperty;
use TheCodingMachine\GraphQLite\Mappers\Root\RootTypeMapperInterface;

class JSONScalarTypeMapper implements RootTypeMapperInterface
{
    /** @var RootTypeMapperInterface */
    private $next;

    public function __construct(RootTypeMapperInterface $next)
    {
        $this->next = $next;
    }

    public function toGraphQLOutputType(
        Type $type,
        ?OutputType $subType,
        $reflector,
        DocBlock $docBlockObj
    ): OutputType {
        if ($this->matchReturnType($docBlockObj)) {
            return JSONScalarType::getInstance();
        }
        return  $this->next->toGraphQLOutputType($type, $subType, $reflector, $docBlockObj);
    }

    public function toGraphQLInputType(
        Type $type,
        ?InputType $subType,
        string $argumentName,
        $reflector,
        DocBlock $docBlockObj
    ): InputType {
        if ($this->matchInputType($argumentName, $reflector, $docBlockObj)) {
            return JSONScalarType::getInstance();
        }
        return $this->next->toGraphQLInputType($type, $subType, $argumentName, $reflector, $docBlockObj);
    }

    /**
     * @param string $typeName The name of the GraphQL type
     * @return NamedType
     */
    public function mapNameToType(string $typeName): NamedType
    {
        if ($typeName === JSONScalarType::NAME) {
            return JSONScalarType::getInstance();
        }
        return $this->next->mapNameToType($typeName);
    }

    /**
     * @param DocBlock $docBlockObj
     * @return bool
     */
    private function matchReturnType(DocBlock $docBlockObj): bool
    {
        $paramText = $docBlockObj->hasTag('return') ?
            $docBlockObj->getTagsByName('return')[0]->__toString() :
            null;
        return strpos($paramText, JSONScalarType::NAME) > 0;
    }

    /**
     * @param string $argumentName
     * @param ReflectionMethod|ReflectionProperty $reflector
     * @param DocBlock $docBlockObj
     * @return bool
     */
    private function matchInputType(string $argumentName, $reflector, DocBlock $docBlockObj): bool
    {
        $params = $docBlockObj->getTagsByName('param');
        for ($i = 0; $i < count($params); $i++) {
            $paramText = $params[$i]->__toString();
            if ($reflector instanceof ReflectionMethod) {
                $refParams = $reflector->getParameters();
                if (strpos($paramText, JSONScalarType::NAME) > 0 && $refParams[$i]->getName() === $argumentName) {
                    return true;
                }
            }
        }
        return false;
    }
}

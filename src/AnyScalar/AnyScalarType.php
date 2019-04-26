<?php


namespace TheCodingMachine\GraphQLite\Types\AnyScalar;


use Exception;
use GraphQL\Error\Error;
use GraphQL\Language\AST\BooleanValueNode;
use GraphQL\Language\AST\FloatValueNode;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

final class AnyScalarType extends ScalarType
{
    const NAME = 'AnyScalar';

    const SCALAR_NODES = [
        StringValueNode::class,
        BooleanValueNode::class,
        IntValueNode::class,
        FloatValueNode::class
    ];

    /**
     * @var self
     */
    private static $instance;

    public function __construct()
    {
        parent::__construct([
            'name' => 'AnyScalar',
            'description' => 'A GraphQL type that can contain any scalar value (int, string, bool or float)'
        ]);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Serializes an internal value to include in a response.
     *
     * @param string $value
     * @return string
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     */
    public function parseValue($value)
    {
        if (!is_scalar($value)) {
            throw new Error('Cannot represent following value as scalar: ' . Utils::printSafeJson($value));
        }

        return $value;
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
     *
     * In the case of an invalid node or value this method must throw an Exception
     *
     * @param Node         $valueNode
     * @param mixed[]|null $variables
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        $isScalar = false;
        foreach (self::SCALAR_NODES as $nodeClass) {
            if ($valueNode instanceof $nodeClass) {
                $isScalar = true;
                break;
            }
        }

        if (!$isScalar) {
            throw new Error('Not a valid scalar', $valueNode);
        }
        return $valueNode->value;
    }
}

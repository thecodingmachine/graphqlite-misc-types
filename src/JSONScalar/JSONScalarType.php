<?php

namespace TheCodingMachine\GraphQLite\Types\JSONScalar;

use Exception;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils as GraphQLUtils;

final class JSONScalarType extends ScalarType
{
    public const NAME = 'JSON';

    /**
     * @var self
     */
    private static $instance;

    public function __construct()
    {
        parent::__construct([
            'name' => 'JSON',
            'description' => 'A GraphQL type that can contain json'
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
     * @param mixed $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws Error
     */
    public function parseValue($value)
    {
        return $this->decodeJSON($value);
    }

    /**
     * @param mixed $valueNode
     * @param mixed[]|null $variables
     * @return mixed
     * @throws Exception
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!property_exists($valueNode, 'value')) {
            throw new Error(
                'Can only parse literals that contain a value, got '.GraphQLUtils::printSafeJson($valueNode)
            );
        }

        return $this->decodeJSON($valueNode->value);
    }

    /**
     *
     * @param mixed $value
     * @throws Error
     * @return mixed
     */
    private function decodeJSON($value)
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;
        if ($decoded === null) {
            throw new Error(
                'Error decoding JSON '. GraphQLUtils::printSafeJson($value)
            );
        }

        return $decoded;
    }
}

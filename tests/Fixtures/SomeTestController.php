<?php


namespace TheCodingMachine\GraphQLite\Types\Fixtures;


use TheCodingMachine\GraphQLite\Annotations\Query;

class SomeTestController
{
    /**
     * @Query()
     * @param scalar $scalar
     * @return scalar
     */
    public function echoScalar($scalar)
    {
        return $scalar;
    }

    /**
     * @Query()
     */
    public function testIgnore(string $foo): string
    {
        return $foo;
    }
}

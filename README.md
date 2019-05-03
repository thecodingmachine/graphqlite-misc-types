[![Latest Stable Version](https://poser.pugx.org/thecodingmachine/graphqlite-misc-types/v/stable)](https://packagist.org/packages/thecodingmachine/graphqlite-misc-types)
[![Total Downloads](https://poser.pugx.org/thecodingmachine/graphqlite-misc-types/downloads)](https://packagist.org/packages/thecodingmachine/graphqlite-misc-types)
[![Latest Unstable Version](https://poser.pugx.org/thecodingmachine/graphqlite-misc-types/v/unstable)](https://packagist.org/packages/thecodingmachine/graphqlite-misc-types)
[![License](https://poser.pugx.org/thecodingmachine/graphqlite-misc-types/license)](https://packagist.org/packages/thecodingmachine/graphqlite-misc-types)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thecodingmachine/graphqlite-misc-types/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thecodingmachine/graphqlite-misc-types/?branch=master)
[![Build Status](https://travis-ci.org/thecodingmachine/graphqlite-misc-types.svg?branch=master)](https://travis-ci.org/thecodingmachine/graphqlite-misc-types)
[![Coverage Status](https://coveralls.io/repos/thecodingmachine/graphqlite-misc-types/badge.svg?branch=master&service=github)](https://coveralls.io/github/thecodingmachine/graphqlite-misc-types?branch=master)

# GraphQLite miscellaneous types

This package is an add-on to the [GraphQLite](http://graphqlite.thecodingmachine.io/) PHP library.
It contains a set of GraphQL scalar types that can be added to GraphQLite.

## Install

```console
$ composer require thecodingmachine/graphqlite-misc-types
```

## "Any" scalar type

This types adds support for a "AnyScalar" type that can be any of "string", "int", "float" or "bool".

### Usage

```php
/**
 * @Query()
 * @param scalar $scalar
 * @return scalar
 */
public function echoScalar($scalar)
{
    return $scalar;
}
```

Use the "scalar" type-hint in the DocBlock to cast a value to "AnyScalar".

### Registering AnyScalar

#### Using the SchemaFactory

If you are using the `SchemaFactory` to initialize GraphQLite, use this code to add support for `AnyScalar`:

```php
$schemaFactory->addRootTypeMapper(new \TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarTypeMapper());
```

#### Using the Symfony bundle

If you are using the Symfony bundle to initialize GraphQLite, register the `AnyScalarTypeMapper` as a service:

```yaml
# config/services.yaml
services:
    TheCodingMachine\GraphQLite\Types\AnyScalar\AnyScalarTypeMapper:
        tags: ['graphql.root_type_mapper']
```

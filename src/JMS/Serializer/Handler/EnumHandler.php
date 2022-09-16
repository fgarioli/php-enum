<?php

namespace FGarioli\Enum\JMS\Serializer\Handler;

use FGarioli\Enum\Enum;
use InvalidArgumentException;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;

class EnumHandler implements SubscribingHandlerInterface
{
    public const TYPE_ENUM = 'enum';

    /**
     * {@inheritdoc}
     */
    public static function getSubscribingMethods()
    {
        $methods = [];

        $methods[] = [
            'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
            'format' => 'json',
            'type' => self::TYPE_ENUM,
            'method' => 'serializeToJson',
        ];
        $methods[] = [
            'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
            'format' => 'json',
            'type' => self::TYPE_ENUM,
            'method' => 'deserializeFromJSON',
        ];

        return $methods;
    }

    public function serializeToJson(JsonSerializationVisitor $visitor, Enum $enum, array $type, Context $context)
    {
        return $enum->getValue();
    }

    public function deserializeFromJSON(JsonDeserializationVisitor $visitor, $enumAsString, array $type, Context $context)
    {
        if (!is_subclass_of($type['params'][0]['name'], Enum::class)) {
            throw new InvalidArgumentException('The first parameter of the Enum type must be a subclass of Enum');
        }

        return $type['params'][0]['name']::from($enumAsString);
    }
}

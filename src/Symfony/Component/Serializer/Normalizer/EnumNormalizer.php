<?php

namespace FGarioli\Enum\Symfony\Component\Serializer\Normalizer;

use FGarioli\Enum\Enum;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EnumNormalizer extends ObjectNormalizer
{
    public function normalize($object, ?string $format = null, array $context = [])
    {
        return (string) $object;
    }

    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {
        return $type::from($data);
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        if (!is_subclass_of($type, Enum::class)) {
            return false;
        }
        return true;
    }

    public function supportsNormalization($data, ?string $format = null)
    {
        if (!is_null($data) && is_object($data)) {
            $class = get_class($data);
            return is_subclass_of($class, Enum::class);
        }

        return false;
    }
}

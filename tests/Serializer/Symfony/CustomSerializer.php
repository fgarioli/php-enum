<?php

declare(strict_types=1);

namespace FGarioli\Enum\Tests\Serializer\Symfony;

use Doctrine\Common\Annotations\AnnotationReader;
use FGarioli\Enum\Symfony\Component\Serializer\Normalizer\EnumNormalizer;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;

final class CustomSerializer
{
    /**
     *
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetadataFactory(
            new AnnotationLoader(
                new AnnotationReader()
            )
        );

        $this->serializer = new Serializer(
            [
                new ArrayDenormalizer(),
                new JsonSerializableNormalizer(),
                new BackedEnumNormalizer(),
                new DateTimeNormalizer(),
                new DataUriNormalizer(),
                new EnumNormalizer(),
                new ObjectNormalizer(
                    $classMetadataFactory,
                    new CamelCaseToSnakeCaseNameConverter(),
                    null,
                    new PhpDocExtractor()
                ),
                new PropertyNormalizer()
            ],
            [
                new JsonEncoder(),
            ]
        );
    }

    public function serialize($data): string
    {
        return $this->serializer->serialize($data, JsonEncoder::FORMAT, [
            ObjectNormalizer::SKIP_NULL_VALUES => true,
            ObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
            'json_encode_options' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        ]);
    }

    public function deserialize(string $data, string $type, bool $is_array = false)
    {
        return $this->serializer->deserialize($data, $type . ($is_array ? '[]' : ''), JsonEncoder::FORMAT);
    }
}

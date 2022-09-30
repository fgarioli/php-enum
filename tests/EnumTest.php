<?php

namespace FGarioli\Enum\Tests;

use PHPUnit\Framework\TestCase;
use FGarioli\Enum\Tests\Enum\TipoObjeto;
use FGarioli\Enum\Tests\Serializer\JMS\Model\TestModel as JMSModel;
use FGarioli\Enum\Tests\Serializer\Symfony\Model\TestModel as SymfonyModel;
use FGarioli\Enum\Tests\Serializer\JMS\CustomSerializer as JMSSerializer;
use FGarioli\Enum\Tests\Serializer\Symfony\CustomSerializer as SymfonySerializer;

class EnumTest extends TestCase
{
    public function testFrom(): void
    {
        $tipoObjeto = TipoObjeto::from('1');
        $this->assertTrue($tipoObjeto == TipoObjeto::ENVELOPE());

        try {
            $tipoObjeto = TipoObjeto::from('5');
        } catch (\InvalidArgumentException $ex) {
            $this->assertTrue(true);
        }
    }

    public function testTryFrom(): void
    {
        $tipoObjeto = TipoObjeto::tryFrom('1');
        $this->assertTrue($tipoObjeto == TipoObjeto::ENVELOPE());
        $this->assertTrue(null === TipoObjeto::tryFrom('5'));
    }

    public function testCases(): void
    {
        foreach (TipoObjeto::cases() as $tipoObjeto) {
            $this->assertTrue($tipoObjeto instanceof TipoObjeto);
        }
    }

    public function testSymfonySerialize(): void
    {
        $serializer = new SymfonySerializer();

        $testObject = new SymfonyModel();
        $testObject->setId(10);
        $testObject->setTipoObjeto(TipoObjeto::ENVELOPE());

        $serialized = $serializer->serialize($testObject);

        $this->assertEquals('{"tipo_objeto":"1","id":10}', $serialized);

        /** @var SymfonyModel $unserialized */
        $unserialized = $serializer->deserialize($serialized, SymfonyModel::class);
        $this->assertTrue($unserialized->getTipoObjeto() == TipoObjeto::ENVELOPE());
    }

    public function testJMSSerializer()
    {
        $serializer = JMSSerializer::getInstance();

        $testObject = new JMSModel();
        $testObject->setId(10);
        $testObject->setTipoObjeto(TipoObjeto::ENVELOPE());

        $serialized = $serializer->serialize($testObject);

        $this->assertEquals('{"id":10,"tipo_objeto":"1"}', $serialized);

        /** @var JMSModel $unserialized */
        $unserialized = $serializer->deserialize($serialized, JMSModel::class);
        $this->assertTrue($unserialized->getTipoObjeto() == TipoObjeto::ENVELOPE());
    }
}

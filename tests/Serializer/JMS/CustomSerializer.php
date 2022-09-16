<?php

namespace FGarioli\Enum\Tests\Serializer\JMS;

use FGarioli\Enum\JMS\Serializer\Handler\EnumHandler;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class CustomSerializer
{
    /**
     *
     * @var Serializer
     */
    private $serializer;

    /**
     * Construtor do tipo privado previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    private function __construct()
    {
        $builder = SerializerBuilder::create();
        // $builder->setPropertyNamingStrategy(new IdenticalPropertyNamingStrategy());
        $builder->configureHandlers(function (HandlerRegistry $registry) {
            $registry->registerSubscribingHandler(new EnumHandler());
        });
        $this->serializer = $builder->build();
    }

    /**
     * Retorna uma instância única de uma classe.
     *
     * @static var Singleton $instance A instância única dessa classe.
     *
     * @return CustomSerializer A Instância única.
     */
    public static function getInstance(): CustomSerializer
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function serialize($data): ?string
    {
        if (is_null($data)) {
            return null;
        }

        return $this->serializer->serialize($data, 'json');
    }

    public function deserialize(string $data, string $type)
    {
        return $this->serializer->deserialize($data, $type, 'json');
    }

    public function toArray($data, string $type)
    {
        return $this->serializer->toArray($data, null, $type);
    }

    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone()
    {
    }
}

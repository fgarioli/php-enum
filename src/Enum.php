<?php

namespace FGarioli\Enum;

use JsonSerializable;

abstract class Enum implements JsonSerializable
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        foreach ($reflection->getConstants() as $value) {
            return new $class($value);
        }

        throw new \Exception("Invalid method {$name} called in class {$class}");
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }

    public static function from(string $value): self
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        $constants = $reflection->getConstants();

        if (!in_array($value, $constants)) {
            throw new \InvalidArgumentException("Invalid value for TipoObjeto");
        }

        return new $class($value);
    }

    /**
     *
     * @param string $value
     * @return self|null
     */
    public static function tryFrom(string $value): ?self
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        $constants = $reflection->getConstants();

        if (!in_array($value, $constants)) {
            return null;
        }

        return new $class($value);
    }

    /**
     *
     * @return static[]
     */
    public static function cases(): array
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        $cases = [];

        foreach ($reflection->getConstants() as $key => $value) {
            $cases[] = self::from($value);
        }

        return $cases;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->getValue();
    }
}

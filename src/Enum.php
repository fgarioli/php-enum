<?php

namespace FGarioli\Enum;

use JsonSerializable;

abstract class Enum implements JsonSerializable
{
    private string $label;
    private $value;

    private function __construct(string $label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);
        foreach ($reflection->getConstants() as $key => $value) {
            if ($key === $name) {
                return new $class($key, $value);
            }
        }

        throw new \Exception("Invalid method {$name} called in class {$class}");
    }

    public function jsonSerialize(): mixed
    {
        return $this->getValue();
    }

    public static function from($value): self
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);

        foreach ($reflection->getConstants() as $key => $cValue) {
            if ($cValue === $value) {
                return new $class($key, $cValue);
            }
        }

        throw new \InvalidArgumentException("Invalid value for {$class}");
    }

    public static function tryFrom($value): ?self
    {
        $class = get_called_class();
        $reflection = new \ReflectionClass($class);

        foreach ($reflection->getConstants() as $key => $cValue) {
            if ($cValue === $value) {
                return new $class($key, $cValue);
            }
        }

        return null;
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

    public function getLabel(): string
    {
        return $this->label;
    }
}

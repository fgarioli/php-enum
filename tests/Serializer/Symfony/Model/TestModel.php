<?php

namespace FGarioli\Enum\Tests\Serializer\Symfony\Model;

use FGarioli\Enum\Tests\Enum\TipoObjeto;

class TestModel
{
    private ?int $id = null;

    private ?TipoObjeto $tipoObjeto = null;

    /**
     * Get the value of tipoObjeto
     *
     * @return TipoObjeto|null
     */
    public function getTipoObjeto(): ?TipoObjeto
    {
        return $this->tipoObjeto;
    }

    /**
     * Set the value of tipoObjeto
     *
     * @param TipoObjeto|null $tipoObjeto
     *
     * @return self
     */
    public function setTipoObjeto(?TipoObjeto $tipoObjeto): self
    {
        $this->tipoObjeto = $tipoObjeto;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int|null $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}

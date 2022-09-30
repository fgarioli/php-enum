<?php

namespace FGarioli\Enum\Tests\Enum;

use FGarioli\Enum\Enum;

/**
 * @method static TipoObjeto ENVELOPE()
 * @method static TipoObjeto PACOTE()
 * @method static TipoObjeto ROLO()
 */
final class TipoObjeto extends Enum
{
    private const ENVELOPE = "1";
    private const PACOTE = "2";
    private const ROLO = "3";
}

<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Constants;

class Content
{
    const TYPE = 'type';
    const MODULE = 'module';


    public static function setModule(mixed $object): array
    {
        return [self::MODULE => $object->id];
    }
}
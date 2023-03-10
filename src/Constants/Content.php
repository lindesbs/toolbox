<?php

declare(strict_types=1);

namespace lindesbs\toolbox\Constants;

class Content
{
    const TYPE = 'type';
    const MODULE = 'module';


    public static function setModule(mixed $object): array
    {
        return [self::MODULE => $object->id];
    }
}
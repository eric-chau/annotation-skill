<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Annotation\Exception;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class UnsupportedAnnotationException extends \InvalidArgumentException
{
    public function __construct(string $handlerClass, $anno)
    {
        parent::__construct(get_class($anno) . " is not supported by $handlerClass.");
    }
}

<?php

declare(strict_types=1);

namespace Jarvis\Skill\Annotation\Exception;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class UnsupportedAnnotationException extends \InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $handlerClass The handler classname
     * @param object $annotation   The unsupported annotation
     */
    public function __construct(string $handlerClass, $annotation)
    {
        parent::__construct(sprintf(
            '%s is not supported by %s.',
            get_class($annotation)
            $handlerClass
        ));
    }
}

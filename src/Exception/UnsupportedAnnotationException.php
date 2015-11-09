<?php

namespace Jarvis\Skill\Annotation\Exception;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class UnsupportedAnnotationException extends \InvalidArgumentException
{
    public function __construct($handlerClass, $annotation)
    {
        parent::__construct("'$handlerClass' annotation is not supported by ".get_class($annotation));
    }
}

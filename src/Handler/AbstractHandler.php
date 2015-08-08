<?php

namespace Jarvis\Skill\Annotation\Handler;

use Jarvis\Skill\Annotation\AnnotationHandlerInterface;
use Jarvis\Skill\Annotation\Exception\UnsupportedAnnotationException;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
abstract class AbstractHandler implements AnnotationHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle($annotation)
    {
        if (!$this->supports($annotation)) {
            throw new UnsupportedAnnotationException(static::class, $annotation);
        }
    }
}

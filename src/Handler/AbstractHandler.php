<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Annotation\Handler;

use Jarvis\Skill\Annotation\Handler\AnnotationHandlerInterface;
use Jarvis\Skill\Annotation\Exception\UnsupportedAnnotationException;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
abstract class AbstractHandler implements AnnotationHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handle($anno)
    {
        if (!$this->supports($anno)) {
            throw new UnsupportedAnnotationException(static::class, $anno);
        }
    }
}

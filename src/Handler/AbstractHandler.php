<?php

declare(strict_types=1);

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
    public function handle($annotation): void
    {
        if (!$this->supports($annotation)) {
            throw new UnsupportedAnnotationException(static::class, $annotation);
        }
    }
}

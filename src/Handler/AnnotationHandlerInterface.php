<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Annotation\Handler;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
interface AnnotationHandlerInterface
{
    public function handle($annotation);
    public function supports($annotation) : bool;
}

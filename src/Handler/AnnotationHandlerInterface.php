<?php

declare(strict_types=1);

namespace Jarvis\Skill\Annotation\Handler;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
interface AnnotationHandlerInterface
{
    /**
     * Handles the provided annotation.
     *
     * @param  object $annotation The annotation to handle
     */
    public function handle($annotation): void;

    /**
     * Returns true if the annotation is supported, false otherwise.
     *
     * @param  object $annotation The annotation to check
     *
     * @return bool true if the annotation is supporte,d false otherwise
     */
    public function supports($annotation): bool;
}

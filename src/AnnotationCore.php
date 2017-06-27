<?php

declare(strict_types=1);

namespace Jarvis\Skill\Annotation;

use Jarvis\Jarvis;
use Jarvis\Skill\Annotation\Handler\AnnotationHandlerInterface;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;
use Jarvis\Skill\EventBroadcaster\BroadcasterInterface;
use Jarvis\Skill\EventBroadcaster\ControllerEvent;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Reader;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class AnnotationCore implements ContainerProviderInterface
{
    const ANNOTATION_HANDLER_BASE_ID = 'annotation.handler.';

    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $app)
    {
        $app['annotationReader'] = function ($app): Reader {
            return new Reader(new Parser(), new ArrayCache());
        };
        $app->lock('annotationReader');

        $app->on(BroadcasterInterface::CONTROLLER_EVENT, function (ControllerEvent $event) use ($app): void {
            if (!is_array($event->callback())) {
                return;
            }

            $app['request']->attributes->add($event->arguments());
            [$controller, $action] = $event->callback();
            $annotations = array_merge(
                $app->annotationReader->getClassAnnotations($controller)->toArray(),
                $app->annotationReader->getMethodAnnotations($controller, $action)->toArray()
            );

            $annotations = array_filter($annotations, 'is_object');
            if (false == $annotations) {
                return;
            }

            $handlers = $app->find(self::ANNOTATION_HANDLER_BASE_ID . '*');
            foreach ($annotations as $annotation) {
                foreach ($handlers as $handler) {
                    if ($handler instanceof AnnotationHandlerInterface && $handler->supports($annotation)) {
                        $handler->handle($annotation);
                    }
                }
            }

            $event->setArguments(array_merge(
                $event->arguments(),
                $app['request']->attributes->all()
            ));
        });
    }
}

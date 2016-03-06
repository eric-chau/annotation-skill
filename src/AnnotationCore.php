<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Annotation;

use Jarvis\Jarvis;
use Jarvis\Skill\Annotation\Cache\DoctrineCache;
use Jarvis\Skill\Annotation\Handler\AnnotationHandlerInterface;
use Jarvis\Skill\DependencyInjection\{ContainerProviderInterface, Reference};
use Jarvis\Skill\EventBroadcaster\{ControllerEvent, JarvisEvents};
use Minime\Annotations\{Cache\ArrayCache, Reader};

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class AnnotationCore implements ContainerProviderInterface
{
    const ANNO_SERVICE_HANDLER_BASE_ID = 'annotation.handler.';

    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $app)
    {
        $app['annoReader'] = function ($app) {
            $cache = null;
            if (isset($app['doctrine.cache'])) {
                $cache = new DoctrineCache($app['doctrine.cache']);
            }

            return new Reader(new Parser(), $cache ?: new ArrayCache());
        };

        $app->lock('annoReader');

        $app->addReceiver(JarvisEvents::CONTROLLER_EVENT, function (ControllerEvent $event) use ($app) {
            $app->request->attributes->add((array) $event->arguments());

            if (!is_array($event->callback())) {
                return;
            }

            list($controller, $action) = $event->callback();

            $annotations = array_merge(
                $app->annoReader->getClassAnnotations($controller)->toArray(),
                $app->annoReader->getMethodAnnotations($controller, $action)->toArray()
            );

            $handlers = $app->find(self::ANNO_SERVICE_HANDLER_BASE_ID . '*');
            foreach ($annotations as $annotation) {
                foreach ($handlers as $handler) {
                    if ($handler instanceof AnnotationHandlerInterface && $handler->supports($annotation)) {
                        $handler->handle($annotation);
                    }
                }
            }

            $arguments = [];
            $reflectionMethod = new \ReflectionMethod($controller, $action);
            foreach ($reflectionMethod->getParameters() as $reflectionParam) {
                if ($app->request->attributes->has($name = $reflectionParam->getName())) {
                    $arguments[$name] = $app->request->attributes->get($name);
                }
            }

            $event->setArguments($arguments);
        });
    }
}

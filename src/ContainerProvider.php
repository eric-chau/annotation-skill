<?php

namespace Jarvis\Skill\Annotation;

use Jarvis\Jarvis;
use Jarvis\Skill\Annotation\Cache\DoctrineCache;
use Jarvis\Skill\DependencyInjection\ContainerProviderInterface;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Reader;

/**
 * @author Eric Chau <eric.chau@gmail.com>
 */
class ContainerProvider implements ContainerProviderInterface
{
    const CACHE_DIR_NAME = 'annotation_cache';

    /**
     * {@inheritdoc}
     */
    public function hydrate(Jarvis $jarvis)
    {
        $jarvis['annotation_reader'] = function ($jarvis) {
            $cache = null;
            if (isset($jarvis['doctrine.cache'])) {
                $cache = new DoctrineCache($jarvis['doctrine.cache']);
            }

            return new Reader(new Parser(), $cache ?: new ArrayCache());
        };
    }
}

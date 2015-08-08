<?php

namespace Jarvis\Skill\Annotation;

use Jarvis\DependencyInjection\ContainerProviderInterface;
use Jarvis\Jarvis;
use Minime\Annotations\Cache\ArrayCache;
use Minime\Annotations\Cache\FileCache;
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
    public static function hydrate(Jarvis $jarvis)
    {
        $jarvis['annotation_reader'] = function ($jarvis) {
            $cache = null;
            $cacheDir = isset($jarvis['settings']['cache_dir']) ? $jarvis['settings']['cache_dir'] : null;
            if (null !== $cacheDir && is_writable($cacheDir)) {
                $cacheDir = $cacheDir.DIRECTORY_SEPARATOR.self::CACHE_DIR_NAME;
                if (is_dir($cacheDir)) {
                    mkdir($cacheDir, 0755);
                }

                $cache = new FileCache($cacheDir.DIRECTORY_SEPARATOR);
            }

            return new Reader(new Parser(), $cache ?: new ArrayCache());
        };
    }
}

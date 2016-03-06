<?php

declare(strict_types = 1);

namespace Jarvis\Skill\Annotation\Cache;

use Doctrine\Common\Cache\CacheProvider;
use Minime\Annotations\Interfaces\CacheInterface;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class DoctrineCache implements CacheInterface
{
    private $doctrineCache;

    public function __construct(CacheProvider $doctrineCache)
    {
        $this->doctrineCache = $doctrineCache;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey($docblock)
    {
        return is_string($docblock) ? md5($docblock) : '';
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, array $annotations)
    {
        $this->doctrineCache->save($key, $annotations);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->doctrineCache->fetch($key);
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->doctrineCache->deleteAll();
    }
}

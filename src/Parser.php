<?php

declare(strict_types=1);

namespace Jarvis\Skill\Annotation;

use Minime\Annotations\Parser as MinimeParser;

/**
 * @author Eric Chau <eriic.chau@gmail.com>
 */
class Parser extends MinimeParser
{
    /**
     * List of Php docblock annotation to ignore
     */
    protected $annotationsToIgnore = [
        'api'            => true,
        'author'         => true,
        'category'       => true,
        'copyright'      => true,
        'deprecated'     => true,
        'example'        => true,
        'filesource'     => true,
        'global'         => true,
        'ignore'         => true,
        'internal'       => true,
        'license'        => true,
        'link'           => true,
        'method'         => true,
        'package'        => true,
        'param'          => true,
        'property'       => true,
        'property-read'  => true,
        'property-write' => true,
        'return'         => true,
        'see'            => true,
        'since'          => true,
        'source'         => true,
        'subpackage'     => true,
        'throws'         => true,
        'todo'           => true,
        'uses'           => true,
        'var'            => true,
        'version'        => true,
    ];

    /**
     * @var bool
     */
    protected $filterPhpDoc = true;

    /**
     * Enables filtering annotation that belongs to PhpDoc.
     */
    public function enableFilterPhpDoc(): void
    {
        $this->filterPhpDoc = true;
    }

    /**
     * Disables filtering annotation that belongs to PhpDoc.
     */
    public function disableFilterPhpDoc(): void
    {
        $this->filterPhpDoc = false;
    }

    /**
     * Overrides MinimeParser::parse() to filter Php docblock annotations
     * if filtering PhpDoc is enabled.
     *
     * {@inheritdoc}
     */
    public function parse($docblock)
    {
        $annotations = parent::parse($docblock);

        return !$this->filterPhpDoc
            ? $annotations
            : array_filter($annotations, function (string $name) {
                return !isset($this->annotationsToIgnore[$name]);
            }, ARRAY_FILTER_USE_KEY)
        ;

    }
}

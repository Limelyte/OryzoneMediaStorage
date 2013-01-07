<?php

/*
 * This file is part of the Oryzone/MediaStorage package.
 *
 * (c) Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Oryzone\MediaStorage\NamingStrategy;

use Pimple;

use Oryzone\MediaStorage\Exception\InvalidConfigurationException,
    Oryzone\MediaStorage\Exception\InvalidArgumentException;

class PimpleNamingStrategyFactory implements NamingStrategyFactoryInterface
{
    /**
     * @var \Pimple $container
     */
    protected $container;

    /**
     * Constructor
     *
     * @param \Pimple $container
     */
    public function __construct(Pimple $container)
    {
        $this->container = $container;
    }

    /**
     * Adds a definition to the container
     * @param string $name
     * @param callable $definition
     */
    public function addDefinition($name, \Closure $definition)
    {
        $this->container[$name] = $definition;
    }

    /**
     * {@inheritDoc}
     */
    public function get($namingStrategyName)
    {
        try
        {
            $namingStrategy = $this->container[$namingStrategyName];
        }
        catch(\InvalidArgumentException $e)
        {
            throw new InvalidArgumentException(sprintf('The namingStrategy "%s" has not been defined', $namingStrategyName), $e->getCode(), $e);
        }

        if( ! $namingStrategy instanceof NamingStrategyInterface)
            throw new InvalidConfigurationException(sprintf('The service "%s" in the container is not an instance of "Oryzone\MediaStorage\NamingStrategy\NamingStrategyInterface"', $namingStrategyName));

        return $namingStrategy;
    }
}

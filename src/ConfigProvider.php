<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-authentication-service
 * @author: n3vrax
 * Date: 5/19/2016
 * Time: 12:37 AM
 */

namespace Dot\Authentication;

use Dot\Authentication\Adapter\AdapterPluginManager;
use Dot\Authentication\Factory\AdapterPluginManagerFactory;
use Dot\Authentication\Factory\AuthenticationOptionsFactory;
use Dot\Authentication\Factory\AuthenticationServiceFactory;
use Dot\Authentication\Factory\ResolverPluginManagerFactory;
use Dot\Authentication\Factory\StoragePluginManagerFactory;
use Dot\Authentication\Http\ResolverPluginManager;
use Dot\Authentication\Options\AuthenticationOptions;
use Dot\Authentication\Storage\StoragePluginManager;

class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),

            'dot_authentication' => [

                'adapter' => [],

                'storage' => [],

                'adapter_manager' => [],

                'storage_manager' => [],

                'resolver_manager' => []
            ]
        ];
    }

    public function getDependencyConfig()
    {
        return [
            //default services
            'factories' => [
                AuthenticationInterface::class => AuthenticationServiceFactory::class,

                AdapterPluginManager::class => AdapterPluginManagerFactory::class,

                ResolverPluginManager::class => ResolverPluginManagerFactory::class,

                StoragePluginManager::class => StoragePluginManagerFactory::class,

                AuthenticationOptions::class => AuthenticationOptionsFactory::class,
            ]
        ];
    }
}
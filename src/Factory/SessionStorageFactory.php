<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-authentication-service
 * @author: n3vrax
 * Date: 5/19/2016
 * Time: 12:37 AM
 */

namespace Dot\Authentication\Factory;

use Dot\Authentication\Exception\RuntimeException;
use Dot\Authentication\Storage\SessionStorage;
use Interop\Container\ContainerInterface;
use Zend\Session\SessionManager;

/**
 * Class SessionStorageFactory
 * @package Dot\Authentication\Factory
 */
class SessionStorageFactory
{
    /**
     * @param ContainerInterface $container
     * @param $resolvedName
     * @param array $options
     * @return SessionStorage
     */
    public function __invoke(ContainerInterface $container, $resolvedName, array $options = [])
    {
        $namespace = isset($options['namespace']) ? $options['namespace'] : null;
        $member = isset($options['member']) ? $options['member'] : null;

        $sessionManager = isset($options['session_manager']) ? $options['session_manager'] : null;

        $sessionManager = $container->has($sessionManager)
            ? $container->get($sessionManager)
            : $sessionManager;

        if(is_string($sessionManager) && class_exists($sessionManager))
        {
            $sessionManager = new $sessionManager;
        }

        if($sessionManager && !$sessionManager instanceof SessionManager) {
            throw new RuntimeException('Session storage session manager invalid');
        }

        return new SessionStorage($namespace, $member, $sessionManager);
    }
}
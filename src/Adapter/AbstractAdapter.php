<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-authentication-service
 * @author: n3vrax
 * Date: 5/19/2016
 * Time: 12:37 AM
 */

namespace Dot\Authentication\Adapter;

use Dot\Authentication\Exception\InvalidArgumentException;
use Dot\Authentication\Identity\IdentityInterface;
use Dot\Authentication\Options\AuthenticationOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Hydrator\ClassMethods;
use Zend\Hydrator\HydratorInterface;

/**
 * Class AbstractAdapter
 * @package Dot\Authentication\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
    /** @var  ServerRequestInterface */
    protected $request;

    /** @var  ResponseInterface */
    protected $response;

    /** @var  IdentityInterface */
    protected $identityPrototype;

    /** @var  HydratorInterface */
    protected $identityHydrator;

    /** @var  AuthenticationOptions */
    protected $authenticationOptions;

    /**
     * AbstractAdapter constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['identity_prototype']) && $options['identity_prototype'] instanceof IdentityInterface) {
            $this->setIdentityPrototype($options['identity_prototype']);
        }

        if (isset($options['identity_hydrator']) && $options['identity_hydrator'] instanceof HydratorInterface) {
            $this->setIdentityHydrator($options['identity_hydrator']);
        }

        if (isset($options['authentication_options'])
            && $options['authentication_options'] instanceof AuthenticationOptions) {
            $this->setAuthenticationOptions($options['authentication_options']);
        }

        if (! $this->identityPrototype instanceof IdentityInterface) {
            throw new InvalidArgumentException('Identity prototype is required and must be an instance of ' .
                IdentityInterface::class);
        }
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest() : ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * @param ServerRequestInterface $request
     * @return AbstractAdapter
     */
    public function setRequest(ServerRequestInterface $request) : AbstractAdapter
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse() : ResponseInterface
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     * @return AbstractAdapter
     */
    public function setResponse(ResponseInterface $response) : AbstractAdapter
    {
        $this->response = $response;
        return $this;
    }

    /**
     * @return IdentityInterface
     */
    public function getIdentityPrototype() : IdentityInterface
    {
        return $this->identityPrototype;
    }

    /**
     * @param IdentityInterface $identityPrototype
     * @return AbstractAdapter
     */
    public function setIdentityPrototype(IdentityInterface $identityPrototype) : AbstractAdapter
    {
        $this->identityPrototype = $identityPrototype;
        return $this;
    }

    /**
     * @return HydratorInterface
     */
    public function getIdentityHydrator() : HydratorInterface
    {
        if (! $this->identityHydrator instanceof HydratorInterface) {
            $this->identityHydrator = new ClassMethods(false);
        }
        return $this->identityHydrator;
    }

    /**
     * @param HydratorInterface $identityHydrator
     * @return AbstractAdapter
     */
    public function setIdentityHydrator(HydratorInterface $identityHydrator) : AbstractAdapter
    {
        $this->identityHydrator = $identityHydrator;
        return $this;
    }

    /**
     * @return AuthenticationOptions
     */
    public function getAuthenticationOptions(): AuthenticationOptions
    {
        if (! $this->authenticationOptions) {
            $this->authenticationOptions = new AuthenticationOptions([]);
        }
        return $this->authenticationOptions;
    }

    /**
     * @param AuthenticationOptions $authenticationOptions
     * @return AbstractAdapter
     */
    public function setAuthenticationOptions(AuthenticationOptions $authenticationOptions): AbstractAdapter
    {
        $this->authenticationOptions = $authenticationOptions;
        return $this;
    }
}

<?php

namespace Jacoz\Symfony\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route(service="jsab.controller.abstract_api_controller")
 */
abstract class AbstractApiController
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @return TokenStorageInterface
     */
    public function getTokenStorage()
    {
        return $this->tokenStorage;
    }

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return UserInterface|null
     */
    protected function getCurrentUser()
    {
        if (   !$this->tokenStorage
            || !$this->tokenStorage->getToken()
            || !$this->tokenStorage->getToken()->getUser() instanceof UserInterface
        ) {
            return;
        }

        return $this->tokenStorage->getToken()->getUser();
    }
}

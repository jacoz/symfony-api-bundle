<?php

namespace Jacoz\Symfony\ApiBundle\Controller;

use Jacoz\Symfony\ApiBundle\Provider\TranslationsProvider;
use Jacoz\Symfony\ApiBundle\Response\ApiResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/api/translations", service="jsab.controller.translations_controller")
 */
class TranslationsController
{
    /**
     * @var TranslationsProvider
     */
    private $translationsProvider;

    /**
     * @param TranslationsProvider $translationsProvider
     */
    public function __construct(TranslationsProvider $translationsProvider)
    {
        $this->translationsProvider = $translationsProvider;
    }

    /**
     * @Route(
     *     "/{locale}.{_format}",
     *     defaults={"_format": "json"},
     *     requirements={"locale": "[a-z]{2}", "_format": "json"},
     *     name="list_translations"
     * )
     * @Method({"GET"})
     * @Cache(expires="+365 days")
     */
    public function getAction($locale)
    {
        $catalogue = $this->translationsProvider->getAppCatalogue($locale);

        return new ApiResponse($catalogue);
    }
}

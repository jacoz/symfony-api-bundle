<?php

namespace Jacoz\Symfony\ApiBundle\Provider;

use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProvider
{
    /**
     * @var TranslatorBagInterface
     */
    private $translator;

    /**
     * @param TranslatorBagInterface $translator
     */
    public function __construct(TranslatorBagInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @todo cache result
     * @param string $locale
     * @return array
     */
    public function getAppCatalogue($locale = null)
    {
        $catalogue = $this->translator->getCatalogue($locale);

        $all = $catalogue->all();

        return isset($all['messages']) ? $all['messages'] : [];
    }
}

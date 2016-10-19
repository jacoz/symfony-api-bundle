<?php

namespace Jacoz\Symfony\ApiBundle\Tests\Mapper;

use Jacoz\Symfony\ApiBundle\Provider\TranslationsProvider;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\TranslatorBagInterface;

class TranslationsProviderTest extends TestCase
{
    public function testNoMessagesDomain()
    {
        $translationsProvider = new TranslationsProvider($this->getTranslatorBag());

        $this->assertEmpty($translationsProvider->getAppCatalogue());
    }

    public function testPopulatedMessagesDomain()
    {
        $messages = [
            'messages' => [
                'foo' => 'bar',
                'baz' => 'boom',
            ],
        ];

        $translationsProvider = new TranslationsProvider($this->getTranslatorBag($messages));
        $catalogue = $translationsProvider->getAppCatalogue();

        $this->assertNotEmpty($catalogue);
        $this->assertCount(2, $catalogue);
    }

    /**
     * @param array $messages
     * @return TranslatorBagInterface
     */
    private function getTranslatorBag($messages = [])
    {
        $validator = $this
            ->getMockBuilder(TranslatorBagInterface::class)
            ->setMethods(['getCatalogue'])
            ->disableOriginalConstructor()
            ->getMock();

        $validator->expects($this->any())
            ->method('getCatalogue')
            ->will($this->returnValue($this->getMessageCatalogue($messages)));

        return $validator;
    }

    /**
     * @param array $messages
     * @return MessageCatalogue
     */
    private function getMessageCatalogue($messages = [])
    {
        return new MessageCatalogue('en', $messages);
    }
}

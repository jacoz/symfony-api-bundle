<?php

namespace Jacoz\Symfony\ApiBundle\Request\ParamConverter;

use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiConverter implements ParamConverterInterface
{
    const CONTENT_TYPE_JSON = 'json';

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param string $objectNamespace
     * @return object
     */
    public function getDocument(Request $request, $objectNamespace)
    {
        $content = $this->getContent($request);

        return $this->serializer->deserialize(
            $content,
            $objectNamespace,
            self::CONTENT_TYPE_JSON
        );
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isJsonRequest(Request $request)
    {
        return $request->getContentType() === static::CONTENT_TYPE_JSON;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getContent(Request $request)
    {
        if (!$this->isJsonRequest($request)) {
            return json_encode($request->request->all());
        }

        return $request->getContent();
    }
}

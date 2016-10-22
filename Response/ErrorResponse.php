<?php

namespace Jacoz\Symfony\ApiBundle\Response;

use Jacoz\Symfony\ApiBundle\Exception\ApiException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ErrorResponse extends AbstractResponse
{
    const DEFAULT_ERROR_CODE = 500;

    /**
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            $this->setHeaders($exception->getHeaders());
        }

        $code = $this->getExceptionStatusCode($exception);
        $exceptionClass = $this->getExceptionClass($exception);

        $data = [
            'error' => [
                'message' => $exception->getMessage(),
                'exception_class' => $exceptionClass,
            ],
        ];

        if ($exception instanceof ApiException && !empty($exception->getErrors())) {
            $data['error']['errors'] = $exception->getErrors();
        }

        parent::__construct($data, $code);
    }

    /**
     * @param \Exception $exception
     * @return int
     */
    private function getExceptionStatusCode(\Exception $exception)
    {
        if ($exception instanceof HttpExceptionInterface) {
            $code = $exception->getStatusCode();
        } else {
            if (!$exception->getCode()) {
                $code = self::DEFAULT_ERROR_CODE;
            } else {
                $code = $exception->getCode();
            }
        }

        return $code;
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    private function getExceptionClass(\Exception $exception)
    {
        return (new \ReflectionClass($exception))->getShortName();
    }
}

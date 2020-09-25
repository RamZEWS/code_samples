<?php

declare(strict_types=1);

namespace Core\Controller;

use JsonException;

class BaseAjaxController implements ControllerInterface
{
    /** @var array */
    protected $responseBody;

    /**
     * @return string
     *
     * @throws JsonException
     */
    public function sendResponse(): string
    {
        return json_encode($this->responseBody, JSON_THROW_ON_ERROR);
    }

    public function prepareHeaders(): void
    {
        header('Content-type: application/json');
    }
}
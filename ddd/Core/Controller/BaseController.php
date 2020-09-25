<?php

declare(strict_types=1);

namespace Core\Controller;

class BaseController implements ControllerInterface
{
    /** @var Template */
    private $template;

    /**
     * @return string
     */
    public function sendResponse(): string
    {
        return $this->template->render();
    }
}
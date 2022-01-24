<?php

declare(strict_types=1);

namespace App\Factory;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Handler\TestHandler;

class TestHandlerFactory
{
    public function __invoke(ContainerInterface $container) : TestHandler
    {
        return new TestHandler($container->get(TemplateRendererInterface::class), $container->get('config')['credentials']);
    }
}

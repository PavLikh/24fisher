<?php

declare(strict_types=1);

namespace App\Factory;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Handler\HookPageHandler;

class HookPageHandlerFactory
{
    public function __invoke(ContainerInterface $container) : HookPageHandler
    {
        return new HookPageHandler($container->get(TemplateRendererInterface::class), $container->get('config')['credentials']);
    }
}

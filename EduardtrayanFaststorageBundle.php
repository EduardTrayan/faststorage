<?php

namespace Eduardtrayan\FaststorageBundle;

use Eduardtrayan\FaststorageBundle\DependencyInjection\ContainerBuilder\FastStorageCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EduardtrayanFaststorageBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new FastStorageCompilerPass());
    }
}

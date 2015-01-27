<?php

namespace Eduardtrayan\FaststorageBundle\DependencyInjection\ContainerBuilder;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class FastStorageCompilerPass implements CompilerPassInterface
{
    const EXCEPTION_UNDEFINED_DEFAULT_STORAGE = 'There is no storage with tag "fast_storage.storage" and alias "%s"';
    const EXCEPTION_NO_STORAGE_DEFINED = 'There are no storage defined for "eduardtrayan_faststorage"';
    const EXCEPTION_NO_STORAGE_PARAMETERS = 'There are no parameters for storage "%s"';

    /** {@inheritdoc} */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('fast_storage')) {
            return;
        }

        $configs = $container->getExtensionConfig('eduardtrayan_faststorage');
        $config = array_shift($configs);

        if (!isset($config['default_storage']) || empty($config['default_storage'])) {
            return;
        }

        $defaultStorage = $config['default_storage'];

        $drivers = $container->findTaggedServiceIds('fast_storage.driver');

        foreach ($drivers as $id => $tags) {
            foreach ($tags as $attributes) {
                if (!isset($attributes['alias'])) {
                    continue;
                }

                if ($attributes['alias'] === $defaultStorage) {
                    $container->setAlias('fast_storage.driver', $id);

                    $this->configureStorage($container->getDefinition($id), $config, $defaultStorage);

                    return;
                }
            }

            $container->removeDefinition($id);
        }

        throw new InvalidConfigurationException(
            sprintf(self::EXCEPTION_UNDEFINED_DEFAULT_STORAGE, $defaultStorage)
        );
    }

    /**
     * @param Definition $definition
     * @param array      $config
     * @param string     $storageName
     * @throws InvalidConfigurationException
     */
    private function configureStorage(Definition $definition, array $config, $storageName)
    {
        if (!isset($config['storage']) || empty($config['storage'])) {
            throw new InvalidConfigurationException(
                sprintf(self::EXCEPTION_NO_STORAGE_DEFINED)
            );
        }

        if (!isset($config['storage'][$storageName]) || empty($config['storage'][$storageName])) {
            throw new InvalidConfigurationException(
                sprintf(self::EXCEPTION_NO_STORAGE_PARAMETERS, $storageName)
            );
        }

        $storageParameters = $config['storage'][$storageName];

        $definition->replaceArgument(0, $storageParameters['host']);
        $definition->replaceArgument(1, $storageParameters['port']);
    }
}

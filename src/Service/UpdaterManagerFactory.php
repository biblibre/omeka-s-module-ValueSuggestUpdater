<?php
namespace ValueSuggestUpdater\Service;

use ValueSuggestUpdater\Updater\Manager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class UpdaterManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $config = $serviceLocator->get('Config');
        if (!isset($config['valuesuggestupdater_updaters'])) {
            throw new Exception\ConfigException('Missing ValueSuggestUpdater updaters configuration');
        }

        return new Manager($serviceLocator, $config['valuesuggestupdater_updaters']);
    }
}

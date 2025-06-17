<?php
namespace ValueSuggestUpdater\Service;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ValueSuggestUpdater\Updater\IdRefUpdater;

class IdRefUpdaterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $httpClient = $services->get('Omeka\HttpClient');
        $logger = $services->get('Omeka\Logger');

        $updater = new IdRefUpdater($httpClient, $logger);

        return $updater;
    }
}

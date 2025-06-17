<?php
namespace ValueSuggestUpdater\Service\Form;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use ValueSuggestUpdater\Form\UpdateForm;

class UpdateFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $updaterManager = $services->get('ValueSuggestUpdater\UpdaterManager');
        $dataTypeManager = $services->get('Omeka\DataTypeManager');

        $form = new UpdateForm(null, $options ?? []);
        $form->setUpdaterManager($updaterManager);
        $form->setDataTypeManager($dataTypeManager);

        return $form;
    }
}

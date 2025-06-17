<?php

namespace ValueSuggestUpdater\Form;

use Laminas\Form\Element\MultiCheckbox;
use Laminas\Form\Form;
use Omeka\DataType\Manager as DataTypeManager;
use ValueSuggestUpdater\Updater\Manager as UpdaterManager;

class UpdateForm extends Form
{
    protected DataTypeManager $dataTypeManager;
    protected UpdaterManager $updaterManager;

    public function init()
    {
        $this->add([
            'name' => 'data_types',
            'type' => MultiCheckbox::class,
            'options' => [
                'label' => 'Data types to update', // @translate
                'info' => 'Only values of selected data types will be updated. Selecting none have the same effect as selecting all.', // @translate
                'value_options' => $this->getDataTypesValueOptions(),
            ],
        ]);

        $inputFilter = $this->getInputFilter();

        $inputFilter->add([
            'name' => 'data_types',
            'required' => false,
        ]);
    }

    protected function getDataTypesValueOptions()
    {
        $dataTypeManager = $this->getDataTypeManager();
        $updaterManager = $this->getUpdaterManager();

        $valueOptions = [];

        $names = $updaterManager->getRegisteredNames(true);
        foreach ($names as $name) {
            if ($dataTypeManager->has($name)) {
                $dataType = $dataTypeManager->get($name);
                $valueOptions[$name] = $dataType->getLabel();
            }
        }

        return $valueOptions;
    }

    public function setDataTypeManager(DataTypeManager $dataTypeManager)
    {
        $this->dataTypeManager = $dataTypeManager;
    }

    public function getDataTypeManager(): DataTypeManager
    {
        return $this->dataTypeManager;
    }

    public function setUpdaterManager(UpdaterManager $updaterManager)
    {
        $this->updaterManager = $updaterManager;
    }

    public function getUpdaterManager(): UpdaterManager
    {
        return $this->updaterManager;
    }
}

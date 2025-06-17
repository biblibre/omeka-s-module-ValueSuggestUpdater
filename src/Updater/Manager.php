<?php
namespace ValueSuggestUpdater\Updater;

use Omeka\ServiceManager\AbstractPluginManager;

class Manager extends AbstractPluginManager
{
    protected $autoAddInvokableClass = false;

    protected $instanceOf = UpdaterInterface::class;
}

<?php
namespace ValueSuggestUpdater\Updater;

use Omeka\Entity\Value;

interface UpdaterInterface
{
    /**
     * Updates a value (if needed)
     *
     * @return bool true if $value was modified, false otherwise
     */
    public function update(Value $value): bool;
}

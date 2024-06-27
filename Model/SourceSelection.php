<?php
/**
 * Copyright © Smartex Canada All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Smartex\InventoryInStorePickupSalesFix\Model;

class SourceSelection
{
    /**
     * @var boolean
     */
    private $state = false;

    /**
     * Start source selection process
     *
     * @param callable $callback
     * @return mixed
     */
    public function startSourceSelection(callable $callback)
    {
        $this->state = true;

        $result = $callback();

        $this->state = false;

        return $result;
    }

    /**
     * Determine if the system is processing source selection
     *
     * @return bool
     */
    public function isProcessingSourceSelection(): bool
    {
        return $this->state;
    }
}

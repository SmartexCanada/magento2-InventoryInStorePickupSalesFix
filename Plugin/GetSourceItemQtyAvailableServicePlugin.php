<?php
/**
 * Copyright © Smartex Canada All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Smartex\InventoryInStorePickupSalesFix\Plugin;

use Magento\InventoryApi\Api\Data\SourceItemInterface;
use Magento\InventoryInStorePickupSales\Model\SourceSelection\GetSourceItemQtyAvailableService;
use Smartex\InventoryInStorePickupSalesFix\Model\SourceSelection;

class GetSourceItemQtyAvailableServicePlugin
{
    /**
     * @var SourceSelection
     */
    private $sourceSelection;

    /**
     * @param SourceSelection
     */
    public function __construct(
        SourceSelection $sourceSelection
    ) {
        $this->sourceSelection = $sourceSelection;
    }

    /**
     * @param GetSourceItemQtyAvailableService $subject
     * @param callable $proceed
     * @param SourceItemInterface $sourceItem
     * @return float
     */
    public function aroundExecute(
        GetSourceItemQtyAvailableService $subject,
        callable $proceed,
        SourceItemInterface $sourceItem
    ): float
    {
        return $this->sourceSelection->startSourceSelection(
            function () use ($proceed, $sourceItem) {
                return $proceed($sourceItem);
            }
        );
    }
}

<?php
/**
 * Copyright © Smartex Canada All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Smartex\InventoryInStorePickupSalesFix\Plugin;

use Magento\InventoryInStorePickupSales\Model\SourceSelection\GetActiveStorePickupOrdersBySource;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Smartex\InventoryInStorePickupSalesFix\Model\SourceSelection;

class GetActiveStorePickupOrdersBySourcePlugin
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
     * @param GetActiveStorePickupOrdersBySource $subject
     * @param callable $proceed
     * @param string $pickupLocationCode
     * @return OrderSearchResultInterface
     */
    public function aroundExecute(
        GetActiveStorePickupOrdersBySource $subject,
        callable $proceed,
        string $pickupLocationCode
    ): OrderSearchResultInterface
    {
        return $this->sourceSelection->startSourceSelection(
            function () use ($proceed, $pickupLocationCode) {
                return $proceed($pickupLocationCode);
            }
        );
    }
}

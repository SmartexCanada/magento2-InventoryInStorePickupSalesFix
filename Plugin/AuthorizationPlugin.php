<?php
/**
 * Copyright © Smartex Canada All rights reserved.
 * See LICENSE for license details.
 */
declare(strict_types=1);

namespace Smartex\InventoryInStorePickupSalesFix\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Sales\Model\ResourceModel\Order as Resource;
use Magento\Sales\Model\ResourceModel\Order\Plugin\Authorization;
use Smartex\InventoryInStorePickupSalesFix\Model\SourceSelection;

class AuthorizationPlugin
{
    /**
     * @var SourceSelection
     */
    private $sourceSelection;

    /**
     * @param SourceSelection $sourceSelection
     */
    public function __construct(
        SourceSelection $sourceSelection
    ) {
        $this->sourceSelection = $sourceSelection;
    }

    /**
     * @param Authorization $subject
     * @param callable $proceed
     * @param Resource $orderResource
     * @param Resource $result
     * @param AbstractModel $order
     * @return Resource
     */
    public function aroundAfterLoad(
        Authorization $subject,
        callable $proceed,
        Resource $orderResource,
        Resource $result,
        AbstractModel $order
    ): Resource
    {
        try {
            $proceed($orderResource, $result, $order);
        } catch (NoSuchEntityException $e) {
            if (!$this->sourceSelection->isProcessingSourceSelection()) {
                throw $e;
            }
        }

        return $result;
    }
}

<?php
/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Unit4\ProductSave\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class LogProductSave
 * @package Unit4\ProductSave\Observer
 */
class LogProductSave implements ObserverInterface
{
    /**
     * @var null|\Psr\Log\LoggerInterface
     */
    protected $logger = null;

    /**
     * LogProductSave constructor.
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();

        if ($product->getId() && ($product->isDataChanged() || $product->isObjectNew())) {
            $logMessage  = PHP_EOL . 'Product Saving Log...' . PHP_EOL;

            foreach ($product->getData() as $key => $dataItem) {
                if ((is_string($dataItem) || is_int($dataItem)) && $dataItem != $product->getOrigData($key)) {
                    $logMessage .= $key . ' = ' . $dataItem . PHP_EOL;
                }
            }
            $this->logger->info($logMessage);
        }
    }
}

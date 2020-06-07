<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Unit4\CustomPriority\Setup\Patch\Data;

use Magento\Customer\Setup\CustomerSetup;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\Patch\PatchInterface;


/**
 * @package Unit4\CustomPriority\Setup\Patch\Data
 */
class CustomerAttr implements \Magento\Framework\Setup\Patch\DataPatchInterface
{
    /**
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var \Magento\Framework\Setup\ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * CustomerAttr constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param ModuleDataSetupInterface $moduleDataSetup
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        ModuleDataSetupInterface $moduleDataSetup
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->moduleDataSetup = $moduleDataSetup;
    }

    /**
     * @return \Magento\Framework\Setup\Patch\DataPatchInterface|void
     */
    public function apply()
    {
        $this->moduleDataSetup->startSetup();

        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        // $customerSetup->updateAttribute();

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'custom_priority',
            [
                'label' => 'Priority',
                'type' => 'int',
                'input' => 'select',
                'source' => '\Unit4\CustomPriority\Model\Entity\Attribute\Frontend\Source\CustomerPriority',
                'required' => 0,
                'system' => 0,
                'position' => 100,
            ]
        );
        try {
            $customerSetup->getEavConfig()
                ->getAttribute('customer', 'custom_priority')
                ->setData('used_in_forms', ['adminhtml_customer'])
                ->save();
        } catch (LocalizedException $e) {
        }

        $this->moduleDataSetup->endSetup();
    }

    /**
     * @return array|string[]
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return array|string[]
     */
    public function getAliases()
    {
        return [];
    }

}

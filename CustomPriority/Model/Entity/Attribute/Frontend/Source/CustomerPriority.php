<?php

/**
 * Copyright © Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Unit4\CustomPriority\Model\Entity\Attribute\Frontend\Source;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

/**
 * @package Training\Orm\Entity\Attribute\Source
 */
class CustomerPriority extends AbstractSource
{
    /**
     * Retrieve All options
     *
     * @return array[]
     */
    public function getAllOptions()
    {
        $options = array_map(function($priority) {
            return [
                'label' => sprintf('Priority %d', $priority),
                'value' => $priority
            ];
        }, range(1, 10));
        if ($this->getAttribute()->getFrontendInput() === 'select') {
            array_unshift($options, ['label' => '', 'value' => 0]);
        }
        return $options;
    }
}

<?php

namespace Gsx\Globalshopex\Model\Source;

class Servers implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'value' => 1,
                'label' => __('Review')
            ],
            [
                'value' => 0,
                'label' => __('Enable')
            ]
        ];
    }
}

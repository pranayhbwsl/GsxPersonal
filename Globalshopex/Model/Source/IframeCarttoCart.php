<?php

namespace Gsx\Globalshopex\Model\Source;

class IframeCarttoCart implements \Magento\Framework\Option\ArrayInterface
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
                'label' => __('Iframe Integration')
            ],
            [
                'value' => 0,
                'label' => __('Cart To Cart Integration')
            ]
        ];
    }
}

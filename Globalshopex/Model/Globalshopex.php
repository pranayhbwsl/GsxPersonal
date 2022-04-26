<?php

namespace Gsx\Globalshopex\Model;

use Gsx\Globalshopex\Model\ResourceModel\Globalshopex as ResourceGlobalshopex;

class Globalshopex extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceGlobalshopex::Class);
    }
}

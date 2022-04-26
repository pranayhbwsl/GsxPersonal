<?php
/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace Gsx\Globalshopex\Model\ResourceModel\Globalshopex;

use Gsx\Globalshopex\Model\Globalshopex;
use Gsx\Globalshopex\Model\ResourceModel\Globalshopex as ResourceGlobalshopex;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Globalshopex::Class, ResourceGlobalshopex::Class);
    }
}

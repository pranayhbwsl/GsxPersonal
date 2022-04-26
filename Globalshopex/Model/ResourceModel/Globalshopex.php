<?php
/**
 * Copyright © 2015 Amasty. All rights reserved.
 */

namespace Gsx\Globalshopex\Model\ResourceModel;

class Globalshopex extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('gsx_globalshopex', 'id');
    }
}

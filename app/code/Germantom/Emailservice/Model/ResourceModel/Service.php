<?php

namespace Germantom\Emailservice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Service extends AbstractDb 
{
	protected function _construct()
    {
        $this->_init('germantom_customer_service', 'customer_service_id');
    }
}
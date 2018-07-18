<?php
/**
 * Created by PhpStorm.
 * User: mct
 * Date: 14.06.18
 * Time: 11:14
 */

namespace Germantom\Emailservice\Model\ResourceModel\Service;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Germantom\Emailservice\Model\Service;
use Germantom\Emailservice\Model\ResourceModel\Service as ServiceResource;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'customer_service_id';

    protected function _construct()
    {
        $this->_init(Service::class, ServiceResource::class);
    }

}
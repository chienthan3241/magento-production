<?php
/**
 * Created by PhpStorm.
 * User: mct
 * Date: 14.06.18
 * Time: 11:08
 */

namespace Germantom\Emailservice\Model;

use Magento\Framework\Model\AbstractModel;

class Service extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Germantom\Emailservice\Model\ResourceModel\Service');
    }

}
<?php

namespace Germantom\Emailservice\Block\Adminhtml\Emailservice\Reply;

use Magento\Backend\Block\Widget\Context;

/**
* this class is the parent class, which all button class will be inherit from
*/
class AbstractButton
{
	protected $context;
	protected $registry;

	public function __construct(Context $context, \Magento\Framework\Registry $registry) 
    {
        $this->context = $context;
        $this->registry = $registry;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }

    public function getId()
    {
        $emailservice = $this->registry->registry('service');
        return $emailservice ? $emailservice->getId() : null;
    }

}
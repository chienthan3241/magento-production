<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action 
{
	protected $_resultPageFactory;

   
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

	public function execute() 
	{
		$resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Germantom_Emailservice::emailservice');
        $resultPage->addBreadcrumb(__('Germantom Customerservice'), __('Germantom Customerservice'));
        $resultPage->addBreadcrumb(__('Manage Email Service'), __('Manage Email Service'));
        $resultPage->getConfig()->getTitle()->prepend(__('Manage Email Service'));

        return $resultPage;
	}

	protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Germantom_Emailservice::emailservice');
    }
}
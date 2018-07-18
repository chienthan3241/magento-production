<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Germantom\Emailservice\Model\ResourceModel\Service\CollectionFactory;

/**
 * Class MassStatus: Change confirm status of one or more selected email
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(\Magento\Backend\App\Action\Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Germantom_Emailservice::eamilservice');
    }
    
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $status = $this->getRequest()->getParam('status');
        
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus($status);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been changed.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

/**
* delete one selected row
*/
class Delete extends \Magento\Backend\App\Action
{
    protected $_resources;
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Germantom_Emailservice::emailservice');
    }

    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('customer_service_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();
                $customerServiceTable = $this->_resources->getTableName('germantom_customer_service');
                $sql = "DELETE FROM germantom_customer_service WHERE customer_service_id = $id";
                $connection->query($sql);
                // display success message
                $this->messageManager->addSuccess(__('The Submission has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong'));
                return $resultRedirect->setPath('*/*/');
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Submissions to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

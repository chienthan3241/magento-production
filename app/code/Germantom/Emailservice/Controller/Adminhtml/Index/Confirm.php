<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;
/**
* Send confirm email to customer
*/
class Confirm extends AbstractMailer
{
    /**
     * Confirm action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be confirm
        $id = $this->getRequest()->getParam('customer_service_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();
                //get all info about this email_service
                $sql = "SELECT first_name, last_name, email FROM germantom_customer_service WHERE customer_service_id = $id";
                $result = $connection->fetchAll($sql);
				//send confirm email to customer
				$from = 'support@germantom.com';
			    $to = $result[0]['email'];
			    $subject = 'Germantom Kundenservice';
			    $body = $this->getEmailConfirmTemplate($result[0]['first_name'], $result[0]['last_name']);
			    if ($this->sendMail($from, $to, $subject, $body)) {
			    	//update confirm status
                    $sql = "UPDATE germantom_customer_service SET  status = 1 WHERE customer_service_id = $id";
                	$connection->query($sql);
                    $this->messageManager->addSuccess(__('The Confirm Email has been sent.'));
                } else {
                    $this->messageManager->addError(__('Something went wrong'));
                }
				return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Something went wrong'));
                return $resultRedirect->setPath('*/*/');
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Submissions to confirm.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }

    
}
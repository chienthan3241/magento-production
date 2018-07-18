<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

/**
* this router will send reply email to customer and update status / insert new row in th database
*/
class Save extends AbstractMailer 
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
     * send Reply action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        //send reply email to customer
        $from = 'support@germantom.com';
        $to = $data['email'];
        $subject = 'Germantom Kundenservice reply';
        $body = $this->getEmailReplyTemplate($data['first_name'], $data['last_name'], $data['reply_message'], $data['created_time']);

        if ($this->sendMail($from, $to, $subject, $body)) {
            $this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
            $connection = $this->_resources->getConnection();
            //insert new reply into db
            $sql = "INSERT INTO germantom_customer_service (first_name, last_name, street, street_number, postcode, city, country, email, order_number, customer_number, message, status, is_reply, reply_status, related_id) VALUES (:first_name, :last_name, :street, :street_number, :postcode, :city, :country, :email, :order_number, :customer_number, :message, :status, :is_reply, :reply_status, :related_id)";
            $binds = array(
                'first_name' => isset($data['first_name']) ? $data['first_name'] : NULL,
                'last_name' => isset($data['last_name']) ? $data['last_name'] : NULL,
                'street' => isset($data['street']) ? $data['street'] : NULL,
                'street_number' => isset($data['street_number']) ? $data['street_number'] : NULL,
                'postcode' => isset($data['postcode']) ? $data['postcode'] : NULL,
                'city' => isset($data['city']) ? $data['city'] : NULL,
                'country' => isset($data['country']) ? $data['country']: NULL,
                'email' => isset($data['email']) ? $data['email'] : NULL,
                'order_number' => isset($data['order_number']) ? $data['order_number'] : NULL,
                'customer_number' => isset($data['customer_number']) ? $data['customer_number'] : NULL,
                'message' => isset($data['reply_message']) ? $data['reply_message'] : NULL,
                'status' => null,
                'is_reply' => 1,
                'reply_status' => null, 
                'related_id' => $data['customer_service_id']
            );
            $connection->query($sql, $binds);
            //update reply status
            $sql = "UPDATE germantom_customer_service SET  reply_status = 1 WHERE customer_service_id = :id";
            $binds = array('id' => $data['customer_service_id']);
            $connection->query($sql, $binds);   

            $this->messageManager->addSuccess(__('The Reply Email has been sent.'));
        } else {
            $this->messageManager->addError(__('Something went wrong'));
        }
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
<?php

namespace Germantom\Emailservice\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

/**
* Class reply: show ui-component form to reply to customer
*/
class Reply extends \Magento\Backend\App\Action
{
	protected $_resources;
	protected $_coreRegistry = null;
	protected $resultPageFactory;

	/**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

	/**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Germantom_Emailservice::emailservice');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Germantom_Emailservice::emailservice')
            ->addBreadcrumb(__('Submissions'), __('Submissions'))
            ->addBreadcrumb(__('Reply Submissions'), __('Reply Submissions'));
        return $resultPage;
    }

    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('customer_service_id');
        $model = $this->_objectManager->create('Germantom\Emailservice\Model\Service');
		
		// 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        // 3. Set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

		// 4. Register model to use later in blocks
        $this->_coreRegistry->register('service', $model);
        
        // 5. Build reply form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Reply Submission') : __('Reply'),
            $id ? __('Reply Submission') : __('Reply')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Emailservice'));
        
        return $resultPage;
    }

}
<?php

namespace Germantom\Emailservice\Block\Adminhtml\Emailservice\Reply;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
* Back button to the grid view
*/
class BackButton extends AbstractButton implements ButtonProviderInterface 
{
	/**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}
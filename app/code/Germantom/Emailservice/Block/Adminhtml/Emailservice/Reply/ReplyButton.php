<?php

namespace Germantom\Emailservice\Block\Adminhtml\Emailservice\Reply;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
* Reply Button will submit form to router /save and send reply email to customer
*/
class ReplyButton extends AbstractButton implements ButtonProviderInterface 
{
	/**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reply'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => [
                    'Magento_Ui/js/form/button-adapter' => [
                        'actions' => [
                            [
                                'targetName' => 'emailservice_index_form.emailservice_index_form',
                                'actionName' => 'save',
                                'params' => [
                                    true
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'on_click' => '',
            'sort_order' => 90,
        ];
    }
}
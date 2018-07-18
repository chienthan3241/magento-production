<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Germantom\Emailservice\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Cms\Block\Adminhtml\Page\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;

/**
 * Class PageActions
 */
class Actions extends Column
{
    /** Url path */
    const URL_PATH_REPLY = 'emailservice/index/reply';
    const URL_PATH_DELETE = 'emailservice/index/delete';
    const URL_PATH_CONFIRM = 'emailservice/index/confirm';

    /** @var UrlBuilder */
    protected $actionUrlBuilder;

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $replyUrl;
    /**
     * @var string
     */
    private $confirmUrl;


    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $replyUrl
     * @param string $confirmUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlBuilder $actionUrlBuilder,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $replyUrl = self::URL_PATH_REPLY,
        $confirmUrl = self::URL_PATH_CONFIRM

    ) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->replyUrl = $replyUrl;
        $this->confirmUrl = $confirmUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['customer_service_id'])) {
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['customer_service_id' => $item['customer_service_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.title }'),
                            'message' => __('Are you sure you wan\'t to delete a ${ $.$data.title } record?')
                        ]
                    ];
                    if (isset($item['is_reply']) && $item['is_reply'] == 0) {
                        $item[$name]['reply'] = [
                            'href' => $this->urlBuilder->getUrl($this->replyUrl, ['customer_service_id' => $item['customer_service_id']]),
                            'label' => __('Reply')
                        ];
                        if (isset($item['status']) && $item['status'] == 0) {
                            $item[$name]['confirm'] = [
                                'href' => $this->urlBuilder->getUrl($this->confirmUrl, ['customer_service_id' => $item['customer_service_id']]),
                                'label' => __('Confirm')
                            ];
                        }
                    }
                }
            }
        }
        
        return $dataSource;
    }
}

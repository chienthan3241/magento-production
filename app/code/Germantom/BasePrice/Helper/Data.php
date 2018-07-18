<?php

namespace Germantom\Baseprice\Helper;

class Data extends \Magenerds\BasePrice\Helper\Data {
	/**
     * Returns the base price text according to the configured template
     *
     * @param \Magento\Catalog\Model\Product $product
     * @return mixed
     */
    public function getBasePriceText(\Magento\Catalog\Model\Product $product)
    {
        $template = $this->scopeConfig->getValue(
            'baseprice/general/template',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $basePrice = $this->getBasePrice($product);

        if (!$basePrice) return '';

        $basePriceStr = str_replace(
            '{REF_UNIT}', $this->getReferenceUnit($product), str_replace(
            '{REF_AMOUNT}', $this->getReferenceAmount($product), str_replace(
            '{BASE_PRICE}', $this->_priceHelper->currency($basePrice), $template)
        ));

        return __("Content") . ': ' . round($product->getData('baseprice_product_amount'), 2) . ' ' . $this->getReferenceUnit($product) . " ($basePriceStr)";
    }
}
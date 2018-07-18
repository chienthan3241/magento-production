<?php 

namespace Germantom\Catalog\Block\Product\ProductList;

/**
 * 
 */
class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
	/**
     * Load Available Orders
     *
     * @return $this
     */
    private function loadAvailableOrders()
    {
        if ($this->_availableOrder === null) {
            $this->_availableOrder = $this->_catalogConfig->getAttributeUsedForSortByArray();
        }
        return $this;
    }
    
	/**
     * Set default Order field
     *
     * @param string $field
     * @return $this
     */
    public function setDefaultOrder($field)
    {
        $this->loadAvailableOrders();
        if (isset($this->_availableOrder[$field])) {
            //add exception for laimer brand page
        	if (strtolower(parse_url($this->getPagerUrl())['path']) == '/laimer') {
        		$this->_orderField = 'position';
        	} else {
	            $this->_orderField = $field;
	        }
        }
        return $this;
    }
}
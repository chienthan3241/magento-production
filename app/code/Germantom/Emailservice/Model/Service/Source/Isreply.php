<?php

namespace Germantom\Emailservice\Model\Service\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Isreply implements OptionSourceInterface 
{
	/**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        
        $availableOptions = ['1' => 'true', '0' => 'false'];
        
        $options = [];
        foreach ($availableOptions as $key => $label) {
            $options[] = [
                'label' => $label,
                'value' => $key,
            ];
        }
        return $options;
    }
}
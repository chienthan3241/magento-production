<?php

namespace Germantom\Emailservice\Model\Service\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Replystatus implements OptionSourceInterface 
{
	/**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        
        $availableOptions = ['0' => 'Not Replied', '1' => 'Replied'];
        
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
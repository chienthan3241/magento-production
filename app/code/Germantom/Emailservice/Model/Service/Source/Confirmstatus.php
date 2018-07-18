<?php

namespace Germantom\Emailservice\Model\Service\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Confirmstatus implements OptionSourceInterface 
{
	/**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        
        $availableOptions = ['0' => 'Not Confirmed', '1' => 'Confirmed'];
        
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
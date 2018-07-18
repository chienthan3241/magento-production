<?php

//TODO think about separate helper for FE and BE

namespace TemplateMonster\Megamenu\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const CONFIG_PATH_ACTIVE = 'megamenu/config/megamenu_general_active';
    const CONFIG_PATH_SHOW_LEFT = 'megamenu/config/megamenu_general_show_left';

    const ATTRIBUTE_GROUP = 'Megamenu';

    protected $_scopeConfig;

    protected $attributesToExclude = [
        'mm_turn_on',
        'mm_turn_column_on',
        'mm_column_number',
        'mm_turn_images_on',
        'mm_turn_products_on',
        'mm_products',
        'mm_turn_blocks_on',
        'mm_blocks',
        'mm_turn_label_on',
        'mm_template',
        'mm_css_class',
        'mm_configurator'
    ];

    protected $attributesToExcludeLevelTwo = [
        'mm_image',
        'mm_turn_column_on',
        'mm_column_number',
        'mm_turn_images_on',
        'mm_turn_products_on',
        'mm_products',
        'mm_turn_blocks_on',
        'mm_blocks',
        'mm_turn_label_on',
        'mm_template',
        //'mm_configurator'
    ];

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->_scopeConfig = $scopeConfig;
    }

    public function getConfig($path, $scope)
    {
        return $this->_scopeConfig->getValue($path, $scope);
    }

    public function isModuleEnabled()
    {
        return $this->getConfig(
            self::CONFIG_PATH_ACTIVE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isVertical()
    {
        return $this->getConfig(
            self::CONFIG_PATH_SHOW_LEFT,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function unserialize($string)
    {
        if ($string) {
            return explode(',', str_replace(' ', '', $string));
        }
        return [];
    }

    public function serialize($array)
    {
        return implode(',', $array);
    }

    public function excludeAttributes($attributes, $categoryLevel)
    {
        if ($categoryLevel == 2) {
            return array_diff_key($attributes, array_flip($this->attributesToExcludeLevelTwo));
        } elseif ($categoryLevel) {
            return array_diff_key($attributes, array_flip($this->attributesToExclude));
        }
        return null;
    }

    public function getAttributeGroup()
    {
        return self::ATTRIBUTE_GROUP;
    }

    //TODO check if possible to do in css
    public function hackGrid($html)
    {
        $pos = strpos($html, 'class="admin__control-support-text"');
        $html = substr_replace($html, 'style="margin-left: 0px;" ', $pos, 0);
        $pos = strpos($html, 'class="admin__data-grid-pager-wrap"');
        $html = substr_replace($html, 'style="margin-left: 0px;" ', $pos, 0);
        return $html;
    }

    public function unparse_url( $parsed_url , $ommit = array( ) )
    {
        $url           = '';
        $p             = array();
        $p['scheme']   = isset( $parsed_url['scheme'] ) ? $parsed_url['scheme'] . '://' : '';
        $p['host']     = isset( $parsed_url['host'] ) ? $parsed_url['host'] : '';
        $p['port']     = isset( $parsed_url['port'] ) ? ':' . $parsed_url['port'] : '';
        $p['user']     = isset( $parsed_url['user'] ) ? $parsed_url['user'] : '';
        $p['pass']     = isset( $parsed_url['pass'] ) ? ':' . $parsed_url['pass']  : '';
        $p['pass']     = ( $p['user'] || $p['pass'] ) ? $p['pass']."@" : '';
        $p['path']     = isset( $parsed_url['path'] ) ? $parsed_url['path'] : '';
        $p['query']    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';
        $p['fragment'] = isset( $parsed_url['fragment'] ) ? '#' . $parsed_url['fragment'] : '';
        if ( $ommit )
        {
            foreach ( $ommit as $key )
            {
                if ( isset( $p[ $key ] ) )
                {
                    $p[ $key ] = ''; 
                }
            }
        }
          
        return $p['scheme'].$p['user'].$p['pass'].$p['host'].$p['port'].$p['path'].$p['query'].$p['fragment']; 
    }
}
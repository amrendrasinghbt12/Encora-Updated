<?php
/**
 * Custom Product Module
 *
 * @category  
 * @package   
 */
namespace Customproduct\Script\Model\Object\Source;


/**
 * Class ProductConfig
 * @package Customproduct\Script\Model\Object\Source
 */
class ProductConfig extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * @return array|array[]
     */
    public function getAllOptions()
    {
        return[
            ['value'=>'','label'=>__()],
            ['value'=>'new','label'=>__('New')],
            ['value'=>'used','label'=>__('Used')],
            ['value'=>'refurbished','label'=>__('Refurbished')]
        ];
    }

}
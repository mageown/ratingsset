<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Model_Attribute_Source_RatingSets extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{

    public function getAllOptions()
    {
        $collection = Mage::getModel('mageown_ratingsset/set')->getCollection();
        /** @var Mageown_RatingsSet_Model_Set $item */
        foreach ($collection as $item){
            $this->_options[] = array(
                    'label' => $item->getName(),
                    'value' =>  $item->getEntityId()
                );
        }
        return $this->_options;
    }

    public function toOptionArray()
    {
        return $this->getAllOptions();
    }


    public function getFlatColums()
    {
        $columns = array(
            $this->getAttribute()->getAttributeCode() => array(
                'type'      => 'int',
                'unsigned'  => false,
                'is_null'   => true,
                'default'   => null,
                'extra'     => null
            )
        );
        return $columns;
    }


    public function getFlatUpdateSelect($store)
    {
        return Mage::getResourceModel('eav/entity_attribute')
            ->getFlatUpdateSelect($this->getAttribute(), $store);
    }
}
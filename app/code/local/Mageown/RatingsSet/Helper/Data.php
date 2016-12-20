<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Helper_Data extends Mage_Core_Helper_Abstract
{
    const RATINGSSET_GLOBAL_DEFAULT = 'ratingsset/general/default';

    /**
     * @return Mage_Core_Model_Config
     */
    public function getDefaultSet()
    {
        $ratingsSet = Mage::getConfig(self::RATINGSSET_GLOBAL_DEFAULT);
        return $ratingsSet;
    }

    /**
     * @param $product Mage_Catalog_Model_Product
     * @return Mageown_RatingsSet_Model_Set
     */
    public function getRatingsSet(Mage_Catalog_Model_Product $product){

        $ratingsSet = $product->getRatingsSet();
        if(!$ratingsSet){
            $ratingsSet = $this->getDefaultSet();
        }
        /** @var Mageown_RatingsSet_Model_Set $collection */
        $collection =  Mage::getModel('mageown_ratingsset/set')->load($ratingsSet);
        return $collection;
    }
}
<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Block_Review_Form extends Mage_Review_Block_Form
{

    public function getRatings()
    {
        $productId = Mage::app()->getRequest()->getParam('id', false);
        /** @var Mage_Catalog_Model_Product $product */
        $product = Mage::getModel('catalog/product')->load($productId);
        /** @var Mageown_RatingsSet_Helper_Data $helper */
        $helper = Mage::helper('mageown_ratingsset');
        $ratingSetCollection = $helper->getRatingsSet($product);

        $ratingCollection = Mage::getModel('rating/rating')
            ->getResourceCollection()
            ->addEntityFilter('product');
        if ($ratingSetCollection->getRatings()) {
            $ratingCollection->addFieldToFilter('main_table.rating_id', array(
                'in' => explode(',', $ratingSetCollection->getRatings())
            ));
        }
        $ratingCollection->setPositionOrder()
            ->addRatingPerStoreName(Mage::app()->getStore()->getId())
            ->setStoreFilter(Mage::app()->getStore()->getId())
            ->load()
            ->addOptionToItems();
        return $ratingCollection;
    }
}

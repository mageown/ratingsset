<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Block_Adminhtml_Review_Rating_Detailed extends Mage_Adminhtml_Block_Review_Rating_Detailed
{
    protected $_voteCollection = false;
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('rating/detailed.phtml');
        if( Mage::registry('review_data') ) {
            $this->setReviewId(Mage::registry('review_data')->getReviewId());
        }
    }
    public function getRating()
    {
        if( !$this->getRatingCollection() ) {
            if( Mage::registry('review_data') ) {
                $stores = Mage::registry('review_data')->getStores();
                $stores = array_diff($stores, array(0));

                $productId = Mage::registry('review_data')->getEntityPkValue();
                /** @var Mage_Catalog_Model_Product $product */
                $product = Mage::getModel('catalog/product')->load($productId);
                /** @var Mageown_RatingsSet_Helper_Data $helper */
                $helper = Mage::helper('mageown_ratingsset');
                $ratingSetCollection = $helper->getRatingsSet($product);

                $ratingCollection = Mage::getModel('rating/rating')
                    ->getResourceCollection()
                    ->addEntityFilter('product')
                    ->setStoreFilter($stores);
                if ($ratingSetCollection->getRatings()) {
                    $ratingCollection->addFieldToFilter('main_table.rating_id', array(
                        'in' => explode(',', $ratingSetCollection->getRatings())
                    ));
                }
                $ratingCollection->setPositionOrder()
                    ->load()
                    ->addOptionToItems();

                $this->_voteCollection = Mage::getModel('rating/rating_option_vote')
                    ->getResourceCollection()
                    ->setReviewFilter($this->getReviewId())
                    ->addOptionInfo()
                    ->load()
                    ->addRatingOptions();

            } elseif (!$this->getIsIndependentMode()) {
                $ratingCollection = Mage::getModel('rating/rating')
                    ->getResourceCollection()
                    ->addEntityFilter('product')
                    ->setStoreFilter(Mage::app()->getDefaultStoreView()->getId())
                    ->setPositionOrder()
                    ->load()
                    ->addOptionToItems();
            } else {
                $ratingCollection = Mage::getModel('rating/rating')
                    ->getResourceCollection()
                    ->addEntityFilter('product')
                    ->setStoreFilter(
                        $this->getRequest()->getParam('select_stores')
                            ? $this->getRequest()->getParam('select_stores')
                            : $this->getRequest()->getParam('stores')
                    )
                    ->setPositionOrder()
                    ->load()
                    ->addOptionToItems();
                if(intval($this->getRequest()->getParam('id'))){
                    $this->_voteCollection = Mage::getModel('rating/rating_option_vote')
                        ->getResourceCollection()
                        ->setReviewFilter(intval($this->getRequest()->getParam('id')))
                        ->addOptionInfo()
                        ->load()
                        ->addRatingOptions();
                }
            }
            $this->setRatingCollection( ( $ratingCollection->getSize() ) ? $ratingCollection : false );
        }
        return $this->getRatingCollection();
    }
}

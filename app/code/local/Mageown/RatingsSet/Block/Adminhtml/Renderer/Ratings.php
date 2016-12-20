<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Block_Adminhtml_Renderer_Ratings extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());

        $array = array();
        $ratings = Mage::getModel('rating/rating')
            ->getResourceCollection()
            ->addEntityFilter('product')
            ->addFieldToFilter('rating_id',  array('in'=> explode(',', $value)));

        foreach ($ratings as $rating) {
            $array[] =  $rating->getRatingCode();
        }
        return implode(', ', $array);
    }

}
?>
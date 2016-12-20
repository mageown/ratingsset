<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Block_Adminhtml_RatingsSet extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    protected function _construct()
    {
        parent::_construct();

        $this->_controller = 'ratingsSet';
        $this->_blockGroup = 'mageown_ratingsset_adminhtml';
        $this->_headerText = Mage::helper('mageown_ratingsset')->__('Set Manager');
        $this->_addButtonLabel = Mage::helper('mageown_ratingsset')->__('Add Set');
    }

    public function getCreateUrl()
    {
        return $this->getUrl('*/*/edit');
    }
}
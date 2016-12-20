<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Model_Resource_Set_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected  function _construct()
    {
        parent::_construct();

        $this->_init(
            'mageown_ratingsset/set',
            'mageown_ratingsset/set'
        );
    }
}
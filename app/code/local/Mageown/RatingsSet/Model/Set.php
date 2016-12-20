<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */
/**
 * @method getRatings()
 * @method getName()
 * @method getEntityId()
 */
class Mageown_RatingsSet_Model_Set extends Mage_Core_Model_Abstract
{

    protected function _construct()
    {
        $this->_init('mageown_ratingsset/set');
    }
    
}
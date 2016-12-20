<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

$installer = Mage::getResourceModel('catalog/setup', 'catalog_setup');
$installer->startSetup();
$installer->removeAttribute('catalog_product','ratings_set');

$installer->addAttribute('catalog_product', 'ratings_set', array(
    'label'             => 'Ratings Set',
    'type'              => 'int',	//backend_type
    'input'             => 'select',	//frontend_input
    'frontend_class'	=> '',
    'source'			=> 'mageown_ratingsset/attribute_source_ratingSets',
    'backend'           => 'mageown_ratingsset/attribute_backend_list',
    'frontend'          => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE,
    'required'          => false,
    'used_in_product_listing'	=> false,
    'sort_order' => 1000,
    'visible'       => 1,
    'input_renderer'=> 'mageown_ratingsset_adminhtml/renderer_helper_default',
));

$installer->endSetup();
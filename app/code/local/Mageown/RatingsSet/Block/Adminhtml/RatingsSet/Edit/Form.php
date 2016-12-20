<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Block_Adminhtml_RatingsSet_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl(
                '*/*/edit',
                array(
                    '_current' => true,
                    'continue' => 0,
                )
            ),
            'method' => 'post',
        ));
        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'general',
            array(
                'legend' => $this->__('Set Details')
            )
        );

        $this->_addFieldsToFieldset($fieldset, array(
            'name' => array(
                'label' => $this->__('Name'),
                'input' => 'text',
                'required' => true,
            ),
            'ratings' => array(
                'label' => $this->__('Ratings'),
                'input' => 'multiselect',
                'required' => true,
                'values'     => $this->getRatings(),
            ),
        ));

        return $this;
    }

    protected function _addFieldsToFieldset(Varien_Data_Form_Element_Fieldset $fieldset, $fields)
    {
        $requestData = new Varien_Object($this->getRequest()
            ->getPost('setData'));

        foreach ($fields as $name => $_data) {
            if ($requestValue = $requestData->getData($name)) {
                $_data['value'] = $requestValue;
            }
            $_data['name'] = "setData[$name]";

            $_data['title'] = $_data['label'];

            if (!array_key_exists('value', $_data)) {
                $_data['value'] = $this->_getSet()->getData($name);
            }

            $fieldset->addField($name, $_data['input'], $_data);
        }

        return $this;
    }

    protected function _getSet()
    {
        if (!$this->hasData('set')) {
            $ratingsSet = Mage::registry('current_set');
            if (!$ratingsSet instanceof Mageown_RatingsSet_Model_Set) {
                /** @var Mageown_RatingsSet_Model_Set $ratingsSet */
                $ratingsSet =  Mage::getModel('mageown_ratingsset/set');
            }

            $this->setData('set', $ratingsSet);
        }
        return $this->getData('set');
    }

    public function getRatings()
    {
        $array = array();
        $ratings = Mage::getModel('rating/rating')
            ->getResourceCollection()
            ->addEntityFilter('product');

        foreach ($ratings as $rating) {
            $array[] = array(
                'value' => $rating->getRatingId(),
                'label' => $rating->getRatingCode()
            );
        }
        return $array;
    }
}
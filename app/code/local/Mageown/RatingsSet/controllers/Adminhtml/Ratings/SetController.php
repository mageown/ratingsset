<?php
/**
 * @package    Mageown_RatingsSet
 * @author     Mageown
 * @contacts   https://mageown.com/
 */

class Mageown_RatingsSet_Adminhtml_Ratings_SetController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $ratingsSetBlock = $this->getLayout()
            ->createBlock('mageown_ratingsset_adminhtml/ratingsSet');

        $this->loadLayout()
            ->_addContent($ratingsSetBlock)
            ->renderLayout();
    }

    public function editAction()
    {
        $ratingsSet =  Mage::getModel('mageown_ratingsset/set');
        if ($ratingsSetId = $this->getRequest()->getParam('id', false)) {
            $ratingsSet->load($ratingsSetId);

            if(!$ratingsSet) {
                return $this->_redirect('*/*/index');
            }
        }

        if ($postData = $this->getRequest()->getPost('setData')) {
            try {
                $ratingsSet->addData($postData);
                $ratingsSet->setData('ratings', implode(',', $postData['ratings']));
                $ratingsSet->save();

                $this->_getSession()->addSuccess(
                    $this->__('Rating set has been saved.')
                );
                return $this->_redirect('*/*/index');
            } catch
            (Exception $e) {
                Mage::logException($e);
                $this->_getSession()->addError($e->getMessage());
            }
        }
        Mage::register('current_set', $ratingsSet);

        $ratingsSetEditBlock = $this->getLayout()->createBlock(
            'mageown_ratingsset_adminhtml/ratingsSet_edit'
        );

        $this->loadLayout()
            ->_addContent($ratingsSetEditBlock)
            ->renderLayout();
    }

    public function deleteAction()
    {
        $ratingsSet = Mage::getModel('mageown_ratingsset/set');

        if ($ratingsSetId = $this->getRequest()->getParam('id', false)) {
            $ratingsSet->load($ratingsSetId);
            if(!$ratingsSet){
                return $this->_redirect('*/*/index');
            }
        }

        try {
            $ratingsSet->delete();
            $this->_getSession()->addSuccess($this->__('Rating set has been deleted.'));
        } catch
        (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($e->getMessage());
        }
        return $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        $actionName = $this->getRequest()->getActionName();
        switch ($actionName) {
            case 'index':
            case 'edit':
            case 'delete':
            default:
                $adminSession = Mage::getSingleton('admin/session');
                $isAllowed = $adminSession
                    ->isAllowed('mageown_ratingsset/set');
                break;
        }

        return $isAllowed;
    }
}
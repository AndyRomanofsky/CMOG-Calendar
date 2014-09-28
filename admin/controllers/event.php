<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * Event Controller
 */
class CmogCalControllerEvent extends JControllerForm
{ 
    /**
     * Implement to allowAdd or not
     *
     * Not used at this time (but you can look at how other components use it....)
     * Overwrites: JControllerForm::allowAdd
     *
     * @param array $data
     * @return bool
     */
    protected function allowAdd($data = array())
    {
        return parent::allowAdd($data);
    }
 
    /**
     * Implement to allow edit or not
     * Overwrites: JControllerForm::allowEdit
     *
     * @param array $data
     * @param string $key
     * @return bool
     */
    protected function allowEdit($data = array(), $key = 'ID')
    {
        $id = isset( $data[ $key ] ) ? $data[ $key ] : 0;
        if( !empty( $id ) ){
            $user = JFactory::getUser();
            return $user->authorise( "core.edit", "com_cmogcal.event." . $id );
        }
    }
	
		/**
		 * Method to run batch operations.
		 *
		 * @param   object  $model  The model.
		 *
		 * @return  boolean	 True if successful, false otherwise and internal error is set.
		 *
		 * @since   2.5
		 */
		public function batch($model = null)
		{
			JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
	
			// Set the model
			$model = $this->getModel('event', '', array());
	
			// Preset the redirect
			$this->setRedirect(JRoute::_('index.php?option=com_cmogcal&view=events' . $this->getRedirectToListAppend(), false));
	
			return parent::batch($model);
		}
}
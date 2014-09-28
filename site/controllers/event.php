<?php
/**
* @package CMOGCAL
* @subpackage Event
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 24, 2013 
* @filename event.php
* @folder \cmogcal\site\controllers
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * Event Controller
 */
class CmogCalControllerEvent extends JControllerForm
{
	 protected $view_item = 'event';
	 protected $view_list = 'dailyevents';
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
        $id = (int) isset( $data[ $key ] ) ? $data[ $key ] : 0;
        if( !empty( $id ) ){
            $user = JFactory::getUser();
            return $user->authorise( "core.edit", "com_cmogcal.event." . $id );
        }
	}	
	/**
	 * Method to cancel an edit.
	 *
	 * @param	string	$key	The name of the primary key of the URL variable.
	 *
	 * @return	Boolean	True if access level checks pass, false otherwise.
	 * @since	1.6
	 */
	public function cancel($key = 'ID')
	{
	    parent::cancel($key);

		// Redirect to the return page.
		$this->setRedirect("/church-calendar/daily-evets.html");
	}	
	
	 	/**
	 * Method to edit an existing record.
	 *
	 * @param	string	$key	The name of the primary key of the URL variable.
	 * @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return	Boolean	True if access level check and checkout passes, false otherwise.
	 * @since	1.6
	 */
	public function edit($key = 'ID' , $urlVar = null)
	{
		$result = parent::edit($key, null);

		return $result;
	}
 
	

	/**
	 * Method to save a record.
	 *
	 * @param	string	$key	The name of the primary key of the URL variable.
	 * @param	string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return	Boolean	True if successful, false otherwise.
	 * @since	1.6
	 */
	public function save($key = "ID", $urlVar = 'a_id')
	{
		// Load the backend helper for filtering.
		require_once JPATH_ADMINISTRATOR.'/components/com_cmogcal/helpers/cmogcal.php';

		$result = parent::save($key, $urlVar);


		return $result;
	}


 
}
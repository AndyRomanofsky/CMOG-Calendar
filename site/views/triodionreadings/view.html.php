<?php
/**
* @package CMOGCAL
* @subpackage Tridion Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Tuesday, May 14, 2013 - 3:29:50 PM
* @filename view.html.php
* @folder \cmogcal\site\views\triodionreadings
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * TridionReadings View
 */
class CmogCalViewTriodionReadings extends JViewLegacy
{
        protected $items;
        protected $DisplayWeeks;
        protected $pagination;
        protected $canDo;
        /**
         * TriodionReadings view display method
         * @return void
         */
        function display($tpl = null) 
        {
                // Get data from the model
                $this->items = $this->get('Items');
                $this->DisplayWeeks = $this->get('DisplayWeeks');
                $this->pagination = $this->get('Pagination');
                           $state = $this->get('State');
                // What Access Permissions does this user have? What can (s)he do?
                $this->canDo = CmogCalHelper::getActions();
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
 
             
 
                // Display the template
                parent::display($tpl);
 
                // Set the document
                $this->setDocument();
        }
 
	
        /**
         * Method to set up the document properties
         *
         * @return void
         */
        protected function setDocument() 
        {
                $document = JFactory::getDocument();
                $document->setTitle(JText::_('Triodion Readings'));
        }
}
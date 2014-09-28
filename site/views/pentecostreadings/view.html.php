<?php
/**
* @package CMOGCAL
* @subpackage 
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 17, 2013 - 9:06:37 AM
* @filename view.html.php
* @folder \cmogcal\site\views\pentecostreadings
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * PentecostReadings View
 */
class CmogCalViewPentecostReadings extends JViewLegacy
{
        protected $items;
        protected $DisplayWeeks;
        protected $pagination;
        protected $canDo;
        /**
         * TridionReadings view display method
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
                $document->setTitle(JText::_('Pentecost Readings'));
        }
}
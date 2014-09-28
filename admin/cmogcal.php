<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_cmogcal')) 
{
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
 
// Set some global property
//$document = JFactory::getDocument();
//$document->addStyleDeclaration('.icon-48-cmogcal {background-image: url(../media/com_cmogcal/images/tux-48x48.png);}');
 
// require helper file
JLoader::register('CmogCalHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'cmogcal.php'); 
require_once( dirname(__FILE__) . DS . 'helpers' . DS . 'mogdate.php' );

		
//$document =& JFactory::getDocument();
//$document->addStyleSheet("calendar.css");
 
// import joomla controller library
jimport('joomla.application.component.controller');
 
// Get an instance of the controller prefixed by CmogCal
$controller = JController::getInstance('CmogCal');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();

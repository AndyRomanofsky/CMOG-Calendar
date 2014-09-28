<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
// require helper file
//JLoader::register('CmogCalHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'cmogcal.php'); 
require_once( dirname(__FILE__) . DS . 'helpers' . DS . 'cmogcal.php'); 
require_once( dirname(__FILE__) . DS . 'helpers' . DS . 'mogdate.php' );
/**
 * Cmog Cal Component Controller
 */
class CmogCalController extends JController
{
}
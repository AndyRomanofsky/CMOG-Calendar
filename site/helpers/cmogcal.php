<?php
// No direct access to this file
defined('_JEXEC') or die;
 
/**
 * CmogCal component helper.
 */
abstract class CmogCalHelper
{
        /**
         * Configure the Linkbar. (not needed for site side)
         */
        public static function addSubmenu($submenu) 
        {
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_CALENDARS'),
                                         'index.php?option=com_cmogcal&view=calendars', $submenu == 'calendars');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_EVENTS'),
                                         'index.php?option=com_cmogcal&view=events', $submenu == 'events');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_MOVEABLEEVENTS'),
                                         'index.php?option=com_cmogcal&view=moveableevents', $submenu == 'moveableevents');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_TRIODIONS'),
                                         'index.php?option=com_cmogcal&view=triodionweeks', $submenu == 'triodionweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_PENTECOSTS'),
                                         'index.php?option=com_cmogcal&view=pentecostweeks', $submenu == 'pentecostweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_PASCHAS'),
                                         'index.php?option=com_cmogcal&view=paschaweeks', $submenu == 'paschaweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_LUKES'),
                                         'index.php?option=com_cmogcal&view=lukeweeks', $submenu == 'lukeweeks');
                JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_CATEGORIES'),
                                         'index.php?option=com_categories&view=categories&extension=com_cmogcal',
                                         $submenu == 'categories');
				JSubMenuHelper::addEntry(JText::_('COM_CMOGCAL_SUBMENU_MANAGER'),
                                         'index.php?option=com_cmogcal', $submenu == 'CmogCals');
                
                // set some global property
                $document = JFactory::getDocument();
                $document->addStyleDeclaration('.icon-48-cmogcal ' .
                                               '{background-image: url(../media/com_cmogcal/images/tux-48x48.png);}');
                if ($submenu == 'categories') 
                {
                        $document->setTitle(JText::_('COM_CMOGCAL_ADMINISTRATION_CATEGORIES'));
                }
        }
			
        /**
		* Get the actions
		*/        
		public static function getActions($rowId = 0,$table = "")
        {
		jimport('joomla.access.access');
		$user   = JFactory::getUser();
		$result = new JObject;

		if (empty($rowId)) {
		$assetName = 'com_cmogcal';
		}
		else {
		$assetName = 'com_cmogcal.'. $table . '.' . (int) $rowId;
		}
		
		$actions = JAccess::getActions('com_cmogcal', 'event');

		foreach ($actions as $action) { 
		$result->set($action->name, $user->authorise($action->name, $assetName));
		}
		return $result;
        }
		
		
			/**
	 * Creates a list of years used in filter select list
	 * used in  view
	 *
	 * @return  array
	 *
	 * @since   2.5
	 */
	public static function getyears()
	{
	// Create  query object.           
               // $dby = JFactory::getDBO();
                //$query = $dby->getQuery();
                // Select some fields
		//		   $query->select('DISTINCT `Year`');
                // From the TriodionWeeks table
              //  $query->from('#__CMOG_Events');
		//$query->where(`Year` > 0);
		//$years = $dby->loadObjectList();
		// Check for a database error.
		//if ($dby->getErrorNum())
		//{
		//	JError::raiseNotice(500, $dby->getErrorMsg());
		//	return null;
		//}
		$years[]=1956;
		$years[]=1957;
		$years[]=2008;
		$years[]=2009;
		$years[]=2010;
		$years[]=2011;
		$years[]=2012;
		$years[]=2013;
		$years[]=2014;
		$years[]=2015;
		$years[]=2016;
		$years[]=2017;
		return $years;
	}
		
}
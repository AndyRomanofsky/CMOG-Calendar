<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');
 
/**
 * LukeWeeks class
 */
class CmogCalTableLukeWeek extends JTable
{
        /**
         * Constructor
         *
         * @param object Database connector object
         */
        function __construct(&$db) 
        {
                parent::__construct('#__cmog_templates', 'ID', $db);
        }
 
        /**
         * Overloaded load function
         *
         * @param       int $pk primary key
         * @param       boolean $reset reset data
         * @return      boolean
         * @see JTable:load
         */
        public function load($pk = null, $reset = true) 
        {
                if (parent::load($pk, $reset)) 
                {
                        // Convert the params field to a registry.
                        $params = new JRegistry;                 
                       // loadJSON is @deprecated    12.1  Use loadString passing JSON as the format instead.
                       // $params->loadString($this->item->params, 'JSON');
                       // "item" should not be present.
                       $params->loadJSON($this->params);
 
                        $this->params = $params;
                        return true;
                }
                else
                {
                        return false;
                }
        }
		 
        /**
		* Method to compute the default name of the asset.
		* The default name is in the form `table_name.id`
		* where id is the value of the primary key of the table.
		*
		* @return      string
		* @since       2.5
		*/
        protected function _getAssetName()
        {
		$k = $this->_tbl_key;
		return 'com_cmogcal.lukeweek.'.(int) $this->$k;
        }
		/**
		* Method to return the title to use for the asset table.
		*
		* @return      string
		* @since       2.5
		*/
        protected function _getAssetTitle()
        {
		return $this->event;
        }
		/**
		* Method to get the asset-parent-id of the item
		*
		* @return      int
		*/
        protected function _getAssetParentId()
        {
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = JTable::getInstance('Asset');
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();
		// Find the parent-asset
		if (($this->catid)&& !empty($this->catid))
		{
		// The item has a category as asset-parent
		$assetParent->loadByName('com_cmogcal.category.' . (int) $this->catid);
		}
		else
		{
		// The item has the component as asset-parent
		$assetParent->loadByName('com_cmogcal');
		}
		// Return the found asset-parent-id
		if ($assetParent->id)
		{
		$assetParentId=$assetParent->id;
		}                
		return $assetParentId;        
		}
}
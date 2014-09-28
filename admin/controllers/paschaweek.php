<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
 
/**
 * PaschaWeek Controller
 */
class CmogCalControllerPaschaWeek extends JControllerForm
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
            return $user->authorise( "core.edit", "com_cmogcal.paschaweek." . $id );
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
			$model = $this->getModel('paschaweek', '', array());
	
			// Preset the redirect
			$this->setRedirect(JRoute::_('index.php?option=com_cmogcal&view=paschaweeks' . $this->getRedirectToListAppend(), false));
	
			return parent::batch($model);
		}
			
			/**
			 *
			 *  load template
			 */
			 
			  public function loadlist()
			 {	
			 
		$filter_year = JRequest::getVar(filter_year);
		
		if (($filter_year) and ($filter_year <> -1)){
				
		// Pascha date for filter year
		$p_date= MOGDate::getDate_of_Pascha($filter_year);
		
					 }	else {
					 JFactory::getApplication()->enqueueMessage( "No year given!" , 'Warning');
					 		 }
		// Get items to load from the request.
				$cid = JRequest::getVar('cid', array(), '', 'array');
		
				if (!is_array($cid) || count($cid) < 1)
				{
					JError::raiseWarning(500, JText::_($this->text_prefix . '_NO_ITEM_SELECTED'));
				}
				else
				{
					// Make sure the item ids are integers
					jimport('joomla.utilities.arrayhelper');
					JArrayHelper::toInteger($cid);
					
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
					
				while (count($cid) > 0){	
				$tmplt_id = array_pop($cid);
			
		// Read a template
		// 
		$result = mysql_query('SELECT * from jo25_cmog_templates where ID = '. $tmplt_id );
		 $row = mysql_fetch_array($result);
		//
		//calulate 	date
		$load_date = getDate(mktime(0, 0, 0, $p_date[mon], ($p_date[mday] + $row[wday] +(($row[week] -1)*7)), $p_date[year]));
		
		$LMonth = $load_date[mon];  
		$LDay = $load_date[mday];
		$LYear = $load_date[year];
		
		//check that any are not already loaded
		$result = mysql_query('SELECT ID from jo25_CMOG_Events where gmd = ' . $row["gmd"] . ' and Year = ' . $LYear . ' and Month = ' . $LMonth . ' and Day = ' . $LDay . ' and tmplt_id = '. $tmplt_id );
		 $row2 = mysql_fetch_array($result);
		
			// if already loaded -update
			if ($row2[ID]) {
			
			$this->updateone($row2[ID],  $row);	
			
			
			} else {
		// not loaded - laod	        
		
		$this->loadone($tmplt_id,$LYear,$LMonth,$LDay);	
			}
					}
				}
			
		
				// Preset the redirect
				$this->setRedirect(JRoute::_('index.php?option=com_cmogcal&view=paschaweeks' . $this->getRedirectToListAppend(), false));
			 }
			 
			/**
			 *
			 *  load template
			 */
			 
			  public function load()
			 {
			 
		$LDay = JRequest::getCmd('Day');
		$LMonth = JRequest::getCmd('Month');
		$LYear = JRequest::getCmd('Year');
		$tmplt_id = JRequest::getCmd('tmplt_id');
		
				$this->loadone($tmplt_id,$LYear,$LMonth,$LDay);
		
				// Preset the redirect
				$this->setRedirect(JRoute::_('index.php?option=com_cmogcal&view=paschaweeks' . $this->getRedirectToListAppend(), false));
			 }
			 
			/**
			 *
			 *  load one template
			 */
			 
			 protected function loadone($tmplt_id = null,$LYear = null,$LMonth = null, $LDay = null)
			 {
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		 
		// Read the template
		// 
		
		$result = mysql_query('SELECT * from jo25_cmog_templates where ID = '. $tmplt_id );
		 $row = mysql_fetch_array($result);
		//
		// write the event
		$SQLinsert = "insert into jo25_CMOG_Events ";
		$SQLcolumn = "(EventText, Link, Class, gmd,  AddDate, icon, hymn, listorder, ordering, popup, catid, created_by, published, access, language, tmplt_id,Year, Month, Day) ";
		
		$SQLvalues = " Values('"; 
		$SQLvalues .= $row["EventText"] . "', '" . $row["Link"] . "', '" . $row["Class"] . "', '" . $row["gmd"] . "',  '"; 
		$SQLvalues .= $row["AddDate"] . "', '"  . $row["icon"] . "', '"  . $row["hymn"] . "', '" . $row["listorder"] . "', '" . $row["ordering"] . "', '";
		$SQLvalues .= $row["popup"] . "', '" . $row["catid"] . "', '"  . $row["created_by"] . "', '" . $row["published"] . "', '" . $row["access"] . "', '" . $row["language"] . "', '";
		
		$SQLvalues .= $tmplt_id . "', '" . $LYear . "', '" . $LMonth . "', '" . $LDay . "') ";
		
		$SQL = $SQLinsert . $SQLcolumn . $SQLvalues ;
		$result = mysql_query($SQL);
						if (!$result) {
					 JFactory::getApplication()->enqueueMessage( "Error writing entry: " .  mysql_error() , 'Warning');	
						} else {
					JFactory::getApplication()->enqueueMessage(JText::_('Event - '  . $LMonth . "/" . $LDay . "/"  .$LYear . " - " .$row["EventText"] .' loaded from template.'), 'Message');
						 }
			 }
			 
			/**
			 *
			 *  update one template
			 */
			 
			 protected function updateone($ID = null,$trow = array())
			 {
		// Get a db connection.
		$db = JFactory::getDbo();
		 
		// Create a new query object.
		$query = $db->getQuery(true);
		 
		
		//
		// update the event
		$SQLupdate = "update jo25_CMOG_Events ";
		
		$SQLcolumn = "SET EventText = '". $trow["EventText"] . "', ";
		$SQLcolumn .= "Link = '". $trow["Link"] . "', ";
		$SQLcolumn .= "Class = '". $trow["Class"] . "', ";
		$SQLcolumn .= "icon = '". $trow["icon"] . "', ";
		$SQLcolumn .= "hymn = '". $trow["hymn"] . "', ";
		$SQLcolumn .= "popup = '". $trow["popup"] . "', ";
		$SQLcolumn .= "catid = '". $trow["catid"] . "', ";
		$SQLcolumn .= "published = '". $trow["published"] . "', ";
		$SQLcolumn .= "access = '". $trow["access"] . "', ";
		$SQLcolumn .= "language = '". $trow["language"] . "' ";
		
		$SQLwhere = " WHERE ID =  ". (int) $ID . "  ";
		
		$SQL = $SQLupdate . $SQLcolumn . $SQLwhere ;
		$result = mysql_query($SQL);
						if (!mysql_error()) {
					
					JFactory::getApplication()->enqueueMessage(JText::_('Event - '  . $ID . " - " .$trow["EventText"] .' updated from template.'), 'Message');
						 }else { 
						 JFactory::getApplication()->enqueueMessage( "Error updatind entry: " . $ID ." - " . mysql_error() , 'Warning');	
						} 
			 } 
}
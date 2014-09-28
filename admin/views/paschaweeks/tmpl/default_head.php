<?php
/**
* @package CMOGCAL
* @subpackage Pascha Weeks
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Thursday, May 09, 2013 - 8:53:42 AM
* @filename default_head.php
* @folder \cmogcal\admin\views\paschaweeks\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
$state= $this->get('state');
?>
<tr class="sortable">
        <th width="5%" align="left">
		<?php echo JText::_( 'Num' ); ?>
     	    </th>
        <th width="1%">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                   
        <th>
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_PASCHA_HEADING_EVENTTEXT', 'EventText', $this->sortDirection, $this->sortColumn); ?>
        </th>     
			 <?php if ($state->get('filter.showlinks') == "Yes"){?>
				 <th>Links</th>
			 <?php } ?>
				  <?php if ($state->get('filter.findentries') == "Yes"){?>
					  <th width="10%">Loaded dates</th>
				  <?php } ?>       
        <th width="5%">  
     <?php echo JHTML::_( 'grid.sort', 'JPUBLISHED', 'published', $this->sortDirection, $this->sortColumn); ?>
        </th>               
        <th width="5%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_PASCHA_HEADING_WEEK', 'week', $this->sortDirection, $this->sortColumn); ?>
        </th>                 
        <th width="5%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_PASCHA_HEADING_WDAY', 'wday', $this->sortDirection, $this->sortColumn); ?>
        </th>               
        <th width="10%">
     <?php echo JHTML::_( 'grid.sort', 'JCATEGORY', 'category_title', $this->sortDirection, $this->sortColumn); ?>
        </th>
		
				<th width="10%">
				<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'access_level', $this->sortDirection, $this->sortColumn); ?>
				</th>
		
        <th width="5%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_PASCHA_HEADING_ID', 'ID', $this->sortDirection, $this->sortColumn); ?>
     </th>
<?php
/**
* @package CMOGCAL
* @subpackage Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Wednesday, May 08, 2013 - 12:53:41 PM
* @filename default_head.php
* @folder \cmogcal\admin\views\events\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

$state = $this->get('state');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->sortColumn;
$listDirn	= $this->sortDirection;
$saveOrder	= $listOrder == 'ordering';
?>
<tr class="sortable">
        <th width="5%" align="left">
		<?php echo JText::_( 'Num' ); ?>
     	    </th>
        <th width="1%">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>                   
        <th>
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_EVENT', 'EventText', $this->sortDirection, $this->sortColumn); ?>
        </th>  
			 <?php if ($state->get('filter.showlinks') == "Yes"){?>
				 <th>Links</th>
			 <?php } ?>        
        <th width="5%">  
     <?php echo JHTML::_( 'grid.sort', 'JPUBLISHED', 'published', $this->sortDirection, $this->sortColumn); ?>
        </th>                 
        <th width="5%"> 
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_MONTH', 'Month', $this->sortDirection, $this->sortColumn); ?>
        </th>                 
        <th width="5%"> 
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_DAY', 'Day', $this->sortDirection, $this->sortColumn); ?>
        </th>               
        <th width="5%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_YEAR', 'Year', $this->sortDirection, $this->sortColumn); ?>
        </th>             
        <th width="10%">
     <?php echo JHTML::_( 'grid.sort', 'JCATEGORY', 'category_title', $this->sortDirection, $this->sortColumn); ?>
        </th>  
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
					<?php if ($saveOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'events.saveorder'); ?>
					<?php endif; ?>
				</th>           
        <th width="10%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_GMD', 'gmd', $this->sortDirection, $this->sortColumn); ?>
        </th>
		
				<th width="10%">
				<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ACCESS', 'access_level', $this->sortDirection, $this->sortColumn); ?>
				</th>
        <th width="5%">
     <?php echo JHTML::_( 'grid.sort', 'COM_CMOGCAL_CMOGCAL_HEADING_ID', 'ID', $this->sortDirection, $this->sortColumn); ?>
     </th>
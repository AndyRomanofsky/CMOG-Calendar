<?php
/**
* @package CMOGCAL
* @subpackage Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Wednesday, May 08, 2013 - 12:54:42 PM
* @filename default_body.php
* @folder \cmogcal\admin\views\events\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

$state = $this->get('state');

        $evtclass[gf]="Great Feast";  
        $evtclass[lf]="Lesser Feast";  
        $evtclass[saint]="Saint day";  
        $evtclass[evt]="Event";  
        $evtclass[ser]="Service";  
        $evtclass[read]="Reading";  
        $evtclass[memory]="Memory Bulletin";  
        $evtclass[health]="Health Bulletin"; 
        $evtclass[fast]="Fast day"; 
        $evtclass[fastfree]="Fast Free Day"; 
		$user   = JFactory::getUser();


$user		= JFactory::getUser(); 
$userId		= $user->get('id');
$listOrder	= $this->sortColumn;
$listDirn	= $this->sortDirection;
$saveOrder	= $listOrder == 'ordering';
			$ordering	= ($listOrder == 'ordering');

foreach($this->items as $i => $item): 
			$item->max_ordering = 0; //??
			$canCreate	= $user->authorise('core.create',		'com_content.category.'.$item->catid);
			$canEdit	= $user->authorise('core.edit',			'com_content.article.'.$item->id);
			$canCheckin	= $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
			$canEditOwn	= $user->authorise('core.edit.own',		'com_content.article.'.$item->id) && $item->created_by == $userId;
			$canChange	= $user->authorise('core.edit.state',	'com_content.article.'.$item->id) && $canCheckin;
?>
        <tr class="row<?php echo $i % 2; ?>">
            <td>
		 <?php echo  $this->pagination->getRowOffset( $i ); ?>
	    </td>
                <td>
                        <?php echo JHtml::_('grid.id', $i, $item->ID); ?>
                </td>
            <td>
			        <?php if ($item->checked_out) : ?>
						<?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'events.', $canCheckin); ?>
					<?php endif; ?>
                <a href="<?php echo JRoute::_('index.php?option=com_cmogcal&task=event.edit&ID='.$item->ID);?>">
							<?php echo $this->escape($item->EventText); ?></a>
           </td>
						   <?php if ($state->get('filter.showlinks') == "Yes"){
								 echo "<td>";
								   if ( $item->Link) echo ("<b>Link: </b>" . $item->Link ."<br>");  
								   if ( $item->icon) echo ("<b>Icon: </b>" . $item->icon ."<br>");  
								   if ( $item->hymn) echo ("<b>Hymn: </b>" . $item->hymn );  
								 echo "</td>";
								 }?>
                <td class='center'>
				        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'events.'); ?>
                </td>
                <td>
                        <?php echo $item->Month; ?>
                </td>
                <td>
                        <?php echo $item->Day; ?>
                </td>
                <td>
                        <?php if ($item->Year == "-1") {
						echo ("All");
						} else {
						echo $item->Year;
						}?>
                </td>
                <td>
                        <?php echo $item->category_title; ?>
                </td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid), 'events.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, ($item->catid == @$this->items[$i+1]->catid), 'events.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php elseif ($listDirn == 'desc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, ($item->catid == @$this->items[$i-1]->catid), 'events.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, ($item->catid == @$this->items[$i+1]->catid), 'events.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
            <td><?php
            	switch ($item->gmd) {
	    case -5:
        	echo ( "Pascha" ) ;
			if ($item->tmplt_id)  { echo ( " - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=paschaweek.edit&ID='.$item->tmplt_id) .">".$item->tmplt_id."</a>"); }
        	 break; 
	    case -4:
        	echo ( "Triodion" ) ;
			if ($item->tmplt_id) { echo ( " - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=triodionweek.edit&ID='.$item->tmplt_id) .">".$item->tmplt_id."</a>"); }
        	 break; 
	    case -3:
	        echo ( "Luke" ) ;
			if ($item->tmplt_id) { echo ( " - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=lukeweek.edit&ID='.$item->tmplt_id) .">".$item->tmplt_id."</a>"); }
        	 break; 
	    case -2:
        	echo ( "Pentecost" ) ;
			if ($item->tmplt_id) { echo ( " - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=pentecostweek.edit&ID='.$item->tmplt_id) .">".$item->tmplt_id."</a>"); }
        	 break; 
	    case -1:
        	echo ( "Movable" ) ;
			if ($item->tmplt_id) { echo ( " - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=moveableevent.edit&ID='.$item->tmplt_id) .">".$item->tmplt_id."</a>"); }
        	 break; 
	    default:
	}?>
	</td>
	
					<td class="center">
						<?php echo $this->escape($item->access_level); ?>
					</td>
                <td>
                        <?php echo (int) $item->ID; ?>
                </td>
        </tr>
<?php endforeach; ?>
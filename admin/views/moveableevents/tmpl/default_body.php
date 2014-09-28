<?php
/**
* @package CMOGCAL
* @subpackage Moveable Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Thursday, May 09, 2013 - 9:01:14 AM
* @filename default_body.php
* @folder \cmogcal\admin\views\moveableevents\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access');   


$state= $this->get('state');
$filter_year = (int)$state->get('filter.year');   

if (($filter_year) and ($filter_year <> -1)){
$p_date= MOGDate::getDate_of_Pascha($filter_year);
}
  $savedID = 0;    

foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td>
		 <?php echo  $this->pagination->getRowOffset( $i ); ?>
	    </td>
						<td>
								<?php 
								if ($item->ID <> $savedID){
								echo JHtml::_('grid.ID', $i, $item->ID); 
								}
								?>
						</td>
                <td>
                         <a href="<?php echo JRoute::_('index.php?option=com_cmogcal&task=moveableevent.edit&ID='.$item->ID);?>">
							<?php echo $this->escape($item->EventText); ?></a>
						 <?php 	if 	($p_date) {
						 $load_date = getDate(mktime(0, 0, 0, $p_date[mon], ($p_date[mday] + $item->Offset ), $p_date[year]));
						 echo( " ($load_date[mon]/$load_date[mday]/$load_date[year])");
						 if ($item->Length > 1) {
						 echo( " for " . $item->Length ." days");
						     }
						 }?>
                </td>
								<?php if ($state->get('filter.showlinks') == "Yes"){
									  echo "<td>";
										if ( $item->Link) echo ("<b>Link: </b>" . $item->Link ."<br>");  
										if ( $item->icon) echo ("<b>Icon: </b>" . $item->icon ."<br>");  
										if ( $item->hymn) echo ("<b>Hymn: </b>" . $item->hymn );  
									  echo "</td>";
									  }?>
				<?php if ($state->get('filter.findentries') == "Yes"){
				if ( !$item->entry_id ) {
				echo ('<td>'); 
				 if ($load_date){
				echo ('<a href="');
				echo (JRoute::_('index.php?option=com_cmogcal&task=moveableevent.load&ID=0&tmplt_id='.$item->ID.
				'&Month='.$load_date[mon].
				'&Day='.$load_date[mday].
				'&Year='.$load_date[year]));
				echo ('">');
                       echo ("load ". $filter_year ."</a>"); 
				    } 
				echo (" </td>"); 
				 } else {
				echo ('<td><a href="');
				echo (JRoute::_('index.php?option=com_cmogcal&task=event.edit&ID='.$item->entry_id));
				echo ('">');
				echo ("$item->entry_month/$item->entry_day/$item->entry_year"); 
				echo ('</a></td>');
				 }
				} ?>
                <td class='center'>
				        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'moveableevents.'); ?>
                </td>
                <td>
                        <?php echo $item->Offset; ?>
                </td>
                <td>
                        <?php echo $item->Length; ?>
                </td>
                <td>
                        <?php echo $item->category_title; ?>
                </td>
				
								<td class="center">
									<?php echo $this->escape($item->access_level); ?>
								</td>
												<td>
														<?php 
														echo $item->ID; 
														$savedID = $item->ID;    
														?>
												</td>
        </tr>
<?php endforeach; ?>
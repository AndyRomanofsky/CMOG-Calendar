<?php
/**
* @package CMOGCAL
* @subpackage Luke Weeks
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, April 29, 2013 - 3:02:40 PM
* @filename default_body.php
* @folder \cmogcal\admin\views\lukeweeks\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 
$state= $this->get('state');

$filter_year = $state->get('filter.year'); 

if (($filter_year) and ($filter_year <> -1)){
// - Lukan Jump (and Elevation Sundays)
// Sundays before and after the Elevation

// Elevation date for filter year
$L_date = getDate(mktime(0, 0, 0, 9, 14, $filter_year));

//Sunday after the Elevation
$sal_date = getDate(mktime(0, 0, 0, $L_date[mon], $L_date[mday] + (7 - $L_date[wday]), $L_date[year]));
// - Lukan Jump date
$lj_date = getDate(mktime(0, 0, 0, $L_date[mon], $L_date[mday] + (8 - $L_date[wday]), $L_date[year]));


}

        $dayofweek[0]="Sumday";  
        $dayofweek[1]="Monday";  
        $dayofweek[2]="Tuesday";  
        $dayofweek[3]="Wendsday";  
        $dayofweek[4]="Thursday";  
        $dayofweek[5]="Friday";  
        $dayofweek[6]="Saturday";  
        $dayofweek[7]="Sumday"; 
  $savedID = 0;    
foreach($this->items as $i => $item): 
$load_date = 0;
?>
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
                        <a href="<?php echo JRoute::_('index.php?option=com_cmogcal&task=lukeweek.edit&ID='.$item->ID);?>">
							<?php echo $this->escape($item->EventText); ?></a>
						 <?php 	if 	($lj_date) {
						 $load_date = getDate(mktime(0, 0, 0, $sal_date[mon], ($sal_date[mday] + $item->wday +(($item->week -1)*7)), $sal_date[year]));
						 echo( " ($load_date[mon]/$load_date[mday]/$load_date[year])");
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
				echo (JRoute::_('index.php?option=com_cmogcal&task=lukeweek.load&ID=0&tmplt_id='.$item->ID.
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
				        <?php echo JHtml::_('jgrid.published', $item->published, $i, 'lukeweeks.'); ?>
                </td>
                <td>
                        <?php echo $item->week; ?>
                </td>
                <td>
                        <?php echo $dayofweek[$item->wday]; ?>
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
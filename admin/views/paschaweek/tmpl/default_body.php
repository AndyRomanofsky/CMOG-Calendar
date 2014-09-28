<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php    
        $dayofweek[0]="Sumday";  
        $dayofweek[1]="Monday";  
        $dayofweek[2]="Tuesday";  
        $dayofweek[3]="Wendsday";  
        $dayofweek[4]="Thursday";  
        $dayofweek[5]="Friday";  
        $dayofweek[6]="Saturday";  
        $dayofweek[7]="Sumday"; 
        
foreach($this->items as $i => $item): ?>
        <tr class="row<?php echo $i % 2; ?>">
            <td>
		 <?php echo  $this->pagination->getRowOffset( $i ); ?>
	    </td>
                <td>
                        <?php echo JHtml::_('grid.ID', $i, $item->ID); ?>
                </td>
                <td>
                        <?php echo $item->EventText; ?>
                </td>
                <td>
                        <?php echo $item->week; ?>
                </td>
                <td>
                        <?php echo $dayofweek[$item->wday]; ?>
                </td>
                <td>
                        <?php echo $item->ID; ?>
                </td>
        </tr>
<?php endforeach; ?>
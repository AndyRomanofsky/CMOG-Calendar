<?php
/**
* @package CMOGCAL
* @subpackage calendars
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, April 29, 2013 - 9:26:51 AM
* @filename default_body.php
* @folder \cmogcal\admin\views\calendars\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

 $date = getDate();
$state= $this->get('state');
$SMonth = $state->get('filter.month');  
 if ($SMonth == "") $SMonth = $date["mon"];
$SYear = $state->get('filter.year');
 if ($SYear == "") $SYear = $date["year"];


         $this_month = getDate(mktime(0, 0, 0, $SMonth, 1, $SYear));
         $next_month = getDate(mktime(0, 0, 0, $SMonth + 1, 1, $SYear));
   

         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
         
      $last_sunday = getDate(MKTIME(0, 0, 0, $SMonth,(1 - $first_week_day), $SYear)) ;        
         // Top of caendar



//Fill the first week of the month with the appropriate number of blanks if needed.
         if ($first_week_day <> 0) {
         echo("<tr>");
     //    echo("Year = ". $last_sunday["year"]." month = " . $last_sunday["mon"] . "day = " . $last_sunday["mday"]. "</small></td>");
     //    echo("<td class=weeklable><small>" . $SYear . $SMonth . "1"  . "</small></td>");
          echo("<td class=weeklable><small>".Pentecost_offset($last_sunday["year"],$last_sunday["mon"], $last_sunday["mday"]) . "</small></td>");
     $top_skip = $first_week_day;
     echo("<td  colspan=\"$top_skip\" class=\"blank\"> </td>");
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0){
               echo("</tr><tr border='0'>");
			   //Pentecost_offset($I_year, $I_month, $I_day)
               //echo("<td class=weeklable><small>" . $SYear . $SMonth . $day_counter . "</small></td>");
               echo("<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>");
                               }
               echo("<td  valign='top' class='day'><table hight='100%'class='daytable' ><tr border='0' valign='top'><td border='0' valign='top'>");
               echo("<big><b><A HREF=");
			   echo(JRoute::_('index.php?option=com_cmogcal&view=events&filter_year='.$SYear.'&filter_month='.$SMonth.'&filter_day='.$day_counter ).">");
			   echo($day_counter);
			   echo("</a></b></big></td></tr>");
        //    echo("<tr><td><small>data for $SMonth/$day_counter/$SYear</small></td><tr>");
			// data for this day
			foreach($this->items as $i => $item): 
			   if ($item->Day == $day_counter) {
                echo("<tr><td><span class='" . $item->Class . "'>      ");
			    echo("<a href=". JRoute::_('index.php?option=com_cmogcal&task=event.edit&ID='.$item->ID).">");
							echo ($this->escape($item->EventText) . "</a></span></td><tr>");
			   }
			endforeach;
             echo( "</table></td>"); 

            $week_day++;
            }
?>
<?php
/**
* @package CMOGCAL
* @subpackage Monthly Events
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Monday, May 13, 2013 
* @filename default_body.php
* @folder \cmogcal\site\views\monthlyevents\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

 $date = getDate();
$SMonth = JRequest::getCmd('SMonth'); 
 if ($SMonth == "") $SMonth = $date["mon"];
$SYear = JRequest::getCmd('SYear');
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

			   
               echo("<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>");
                               }
               echo("<td  valign='top' class='day'><table hight='100%'class='daytable' ><tr border='0' valign='top'><td border='0' valign='top'>");
               echo("<big><b><A HREF=");
			   echo('/church-calendar/daily-evets.html?SYear='.$SYear.'&SMonth='.$SMonth.'&SDay='.$day_counter .'&FClass=CNone&Filter=FDate'.">");
			   echo($day_counter);
			   echo("</a></b></big><ul class='calendar'>");
	//		   echo("</a></b></big></td></tr><tr><td><ul class='calendar'>");
        //
			// data for this day
			$service = 0;
			$fastent = 0;
			$saveevts = "";
			foreach($this->items as $i => $item): 
			   if ($item->Day == $day_counter) {
			      $saveevts .= "<li class='" . $item->Class . "' >";
				$saveevts .= $this->escape($item->EventText) . "</li>";
				  if ($item->Class == "ser") $service = 1;
				  if ($item->Class == "fast") $fastent= 1;
				  if ($item->Class == "fastfree") $fastent= 1;
			   }
			 endforeach;
			 			 if (( $fastent == 0) and (($week_day == 3 ) or ($week_day == 5 )))  {
             echo ("<li class='fast'>fast day</li>");
             }
			 if (( $service == 0) and ($week_day == 0 ))  {
             echo ("<li class='ser'> 9:40 AM - Hours</li>");
             echo ("<li class='ser'> 10:00 AM - Divine Liturgy</li>");
             }
        //
	     echo $saveevts; 
             echo( "</ul></td></tr></table></td>"); 

            $week_day++;
            }
			 $bottom_skip = (7 - $week_day);
         if ($bottom_skip > 0) {
           echo("<td  colspan=\"$bottom_skip\" class=\"blank\"></td>");
                               } 
           echo("</tr><tr>");
?>
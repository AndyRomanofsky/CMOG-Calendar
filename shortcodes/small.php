<?php
add_shortcode( 'small_cal', 'cmog_small_calendar' );
 //
 
//-------------------------------------------------------------------------------------------------------------------------
function  s_nav_but($g_action, $g_value, $g_year, $g_month, $g_day, $g_ote=0) {
//echo("$g_action, $g_value, $g_year, $g_month, $g_day"); echo '<br />';
$rout = "";
 $g_date = getDate(mktime(0, 0, 0, $g_month, $g_day, $g_year));

 if ($g_date['year'] < 12) return; 
 if ($g_date['year'] > 2799) return;

$rout .= "<form action='$g_action'  method='put'>" ;
$rout .= "<INPUT type='hidden' name='f_month' VALUE='$g_date[mon]' >" ;
$rout .= "<INPUT type='hidden' name='f_day' VALUE='$g_date[mday]' >" ;
$rout .= "<INPUT type='hidden' name='f_year' VALUE='$g_date[year]' >" ;
 if ($g_day <> 0)  {
$rout .= "<INPUT type='hidden' name='f_day' VALUE='$g_date[mday]' >" ;
$rout .= "<input type='submit' title='$g_date[month] $g_date[mday] $g_date[year]' value='$g_value'>" ;
  }else{
$rout .= "<input type='submit' title='$g_date[month] $g_date[year]' value='$g_value'>" ;
  }
$rout .= "</form>" ;
 return $rout;
}    
    
//------------------------------------------------------------------------------------------------------------------------------------
//
function Smallcalendar($date, $year, $month, $day, $month_name,$oparm='?',$ok_to_edit=0 ,$fdaily )
         {
         //If no parameter is passed use the current date.
$calendar_html = "<section class='pickdate'>";
         $this_month = getDate(mktime(0, 0, 0, $month, 1, $year));
         $next_month = getDate(mktime(0, 0, 0, $month + 1, 1, $year));
         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
         
         // Top of caendar

		 
$calendar_html .= "<small><center>" . PHP_EOL;
	$calendar_html .= "<table class='cal2nav'>" . PHP_EOL;
	$calendar_html .= "<tr><td><center> " . PHP_EOL;
	$calendar_html .= s_nav_but("$fdaily", "<<",  ($year - 1),  $month,  $day, $ok_to_edit); 
	$calendar_html .= "</center></td>" . PHP_EOL;
	$calendar_html .= "<td><center> " . PHP_EOL;
	$calendar_html .= s_nav_but("$fdaily", "<",  $year,  ($month - 1), 1, $ok_to_edit); 
	$calendar_html .= "</center></td>" . PHP_EOL;
	$calendar_html .= "<td><center> " . PHP_EOL;
	$calendar_html .= s_nav_but("$fdaily", ">",  $year,  ($month + 1),  1, $ok_to_edit); 
	$calendar_html .= "</center></td>" . PHP_EOL;
	$calendar_html .= "<td><center> " . PHP_EOL;
	$calendar_html .= s_nav_but("$fdaily", ">>",  ($year + 1),  $month,  $day, $ok_to_edit); 
$calendar_html .= "</center></td></tr></table></center></small> " . PHP_EOL;
 
  //       $calendar_html = "<table class='cal3' BORDER=1 BORDERCOLOR=black style=\"color:ffffff;\">";
         $calendar_html .= "<table class='cal2' >";
         $calendar_html .= "<tr><td colspan=\"7\" align='center' class='dayhead'>" .
                           $month_name .
                           " " . $year . 
                           "</td></tr>";
//Top of calendar day labels
         $calendar_html .= "<tr>";
         $calendar_html .= "<td align='center' class='dayhead'><small>S</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>M</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>T</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>W</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>T</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>F</small></td>";
         $calendar_html .= "<td align='center' class='dayhead'><small>S</small></td></tr>";
    //Fill the first week of the month with the appropriate number of blanks if needed.
         if ($first_week_day <> 0) {
         $calendar_html .= "<tr style=\"height:100\">";
         
     $top_skip = $first_week_day;
     $calendar_html .= "<td  colspan='$top_skip' class='blank'> </td>";
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;
            if($week_day == 0)
               $calendar_html .= "</tr><tr style=\"height:10\">";
 $senddate = "f_year=$year&amp;f_month=$month&amp;f_day=$day_counter";
         //Do something different for the currently selected day.
              //  if (($month == $date["mon"]) and ($year == $date["year"]) and ($day_counter == $date["mday"]) )
                if ($day_counter == $day )
              // $calendar_html .= "<td align='center' valign='top' class='today' ><b><A HREF='$fdaily" . $oparm . $senddate . "'>" . $day_counter . "</a></b></td>";
              $calendar_html .= "<td  align='center' valign='top' class='today' ><b>" . $day_counter . "</b></td>";
            else
               $calendar_html .= "<td   align='center' valign='top' class='day'><A HREF='$fdaily" . $oparm . $senddate . "'>" . $day_counter . "</a></td>";
            
            $week_day++;
            }
//Bottom of calendar day labels
// echo("<br>" . $week_day . "<br>");
         $bottom_skip = (7 - $week_day);
         if ($bottom_skip > 0) {
         $calendar_html .= "<td  colspan='$bottom_skip' class='blank'> </td>";
                               } 
         $calendar_html .= "</tr></table></section>";
 return($calendar_html);
 }
		 
		 
//  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Main Routine
//
function cmog_small_calendar(){  
$outputcal = "";
$me =  "/month/";
$fdaily =  "/today";
//$ok_to_edit=$_GET['ote']; 
$ok_to_edit = 0; 
$date = getDate();
$P_day = (!empty($_REQUEST['f_day'] )) ? $_REQUEST['f_day'] : '';
$P_month = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$P_year = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
if ($P_day == "") $P_day = $date["mday"];
if ($P_month == "") $P_month = $date["mon"];
if ($P_year == "") $P_year = $date["year"];
   if (!isset($ok_to_edit)) $ok_to_edit = 0;
                                                //  echo(" ok_to_edit = $ok_to_edit<br>");
   if ($ok_to_edit <> 0){
              $oparm = "?ote=$ok_to_edit&";
              }else{
              $oparm = "?";
              }
         $date = getDate();
 if (isset($P_day)) { 
             $Day = $P_day;
 } else {
             $Day = $date["mday"];}
             
 if ((isset($P_month)) and ($P_month > 0) and ($P_month < 13)){
             $Month = $P_month;
             $Month_name = "?";
             if  (1 == $Month)  $Month_name = "January";
             if  (2 == $Month)  $Month_name = "February";
             if  (3 == $Month)  $Month_name = "March";
             if  (4 == $Month)  $Month_name = "April";
             if  (5 == $Month)  $Month_name = "May";
             if  (6 == $Month)  $Month_name = "June";
             if  (7 == $Month)  $Month_name = "July";
             if  (8 == $Month)  $Month_name = "August";
             if  (9 == $Month)  $Month_name = "September";
             if  (10 == $Month)  $Month_name = "October";
             if  (11 == $Month)  $Month_name = "November";
             if  (12 == $Month)  $Month_name = "December";
 } else {
             $Month = $date["mon"];
             $Month_name = $date["month"];}
 if ((isset($P_year))and($P_year > 1905)) { 
             $Year = $P_year;
 } else {
             $Year = $date["year"];} 
$outputcal .=  ("<center>" . Smallcalendar($date, $Year, $Month, $Day, $Month_name,$oparm,$ok_to_edit,$fdaily) . "</center>");
 
// footer of calendar
  
If (($Month <> $date["mon"]) or ($Year <> $date["year"]) or ($Day <> $date["mday"])){
 $outputcal .= "<small><center>(<A HREF='$fdaily' title='" .$date['mon']."/".$date['mday']."/".$date['year']."'>Go to today</a>)</center></small>" ;}
 $outputcal .= "<hr><center><table class='cal2nav' >";
 $outputcal .= "<tr><td <small><center>" . s_nav_but("$me", "Large Calendar",  $Year,   $Month ,  $Day) . "</center></small></td></tr></table></center>";
  
RETURN $outputcal;
}?>
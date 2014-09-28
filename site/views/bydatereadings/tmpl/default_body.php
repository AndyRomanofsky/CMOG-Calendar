<?php
/**
* @package CMOGCAL
* @subpackage By Date Readings
* @copyright Copyright Andrew W Romanofsky - 
*                      Orthodox Church of the Mother of God
*                      Mays Landing NJ. All rights reserved.
* @license GNU General Public License version 2 or later.
* 
* @createdate Friday, May 17, 2013 - 9:43:12 AM
* @filename default_body.php
* @folder cmogcal\site\views\bydatereadings\tmpl
*/
 
// No direct access
defined('_JEXEC') or die('Restricted access'); 

$state= $this->get('state');
$filter_month = $state->get('filter.month'); 
$filter_year = $state->get('filter.year'); 

         $date = getDate();
 if (!isset($filter_day)) $filter_day = $date["mday"];
 if (!isset($filter_month)) $filter_month = $date["mon"];
 if (!isset($filter_year)) $filter_year = $date["year"];
 
 $filter_date = getDate(mktime(0, 0, 0, $filter_month, 1, $filter_year));
 $Week_day_n = $filter_date[wday];
 $month_name = $filter_date[month];

$filter_year= $filter_date[year];
$filter_month= $filter_date[mon];
$filter_day= $filter_date[mday];


$R1 =  $filter_year % 19;
$R2 =  $filter_year % 4;
$R3 =  $filter_year % 7;
$RA =  19 * $R1 + 16;
$R4 =  $RA % 30;
$RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
$R5 =  $RB % 7;
$RC =  $R4 + $R5;

$Pascha_date = getDate(mktime(0, 0, 0, 3 ,($RC + 34) , $filter_year));
$Pentecost_date = getDate(mktime(0, 0, 0, 3 ,($RC + 34 + 49)  , $filter_year));

$last_year = $filter_year - 1;

$R1 =  $last_year % 19;
$R2 =  $last_year % 4;
$R3 =  $last_year % 7;
$RA =  19 * $R1 + 16;
$R4 =  $RA % 30;
$RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
$R5 =  $RB % 7;
$RC =  $R4 + $R5;

$Pentecost_lastyear = getDate(mktime(0, 0, 0, 3 ,($RC + 34 + 49)  , $last_year));

 $Sept22 = getDate(mktime(0, 0, 0, 9, 22, $filter_year));
 $Dec19 = getDate(mktime(0, 0, 0, 12, 19, $filter_year));
 $Jan15 = getDate(mktime(0, 0, 0, 1, 15, $filter_year));
 $SatbeforeProdigal = ($Pascha_date[yday] - 64);
 $March25 = getDate(mktime(0, 0, 0, 3, 25, $filter_year));
 
//Find Monday after the Sunday after the Exaltation of the Holy Cross
  $Exaltation = getDate(mktime(0, 0, 0, 9, 14, $filter_year));
	$MonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $Exaltation[wday])), $filter_year));
	//Find Monday after the Sunday after the Exaltation of the Holy Cross from lastyear
  $LExaltation = getDate(mktime(0, 0, 0, 9, 14, $last_year));
	$LMonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $LExaltation[wday])), $last_year));
	
 
echo('<h3>Readings for ' . $month_name . ', ' . $filter_year .' </h3>');


// Build  the report
// ECHO ("<small><br>" . mysql_num_rows ($result) . " entries found <br></small><ul>");
	
 $this->items = $this->get('Items');
foreach($this->items as $i => $row): 

      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventDay=$row->Day;
      $eventMonth=$row->Month;
      $eventYear=$row->Year;
      $eventPopup=$row->popup;
		if ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			echo ("</ul><hr />");
// new
 $filter_date = getDate(mktime(0, 0, 0, $eventMonth, $eventDay, $filter_year));
 $day_name = $filter_date[weekday];
 //before Pascha?

 if ($filter_date[yday] <  $Pascha_date[yday]):

  // is date lent or holy week?
  if     (($Pascha_date[yday] - $filter_date[yday]) == 1) : echo( "Great and Holy Saturday<br>");
	                              $HolyWeek =1; 
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 7) : echo("$day_name, Holy Week<br>Triodion week 10<br>"); 
	                              $HolyWeek =1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 7) : echo( "Entry of Our Lord into Jerusalem<br>Triodion week 10<br>");
	                              $HolyWeek =1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 8) : echo( "Lazarus Saturday<br>Triodion week 10<br>");  
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 14): echo("Great Lent week 6<br>Triodion week 9<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 14): echo("5th Sunday of Great Lent<br>Triodion week 9<br>"); 
                                 $lent = 1;
	elseif (($Pascha_date[yday] - $filter_date[yday]) < 21): echo("$day_name, Great Lent week 5<br>Triodion week 8<br>"); 
                                 $lent = 1;
																 $week5 = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 21): echo("4th Sunday of Great Lent<br>Triodion week 8<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 28): echo("$day_name, Great Lent week 4<br>Triodion week 7<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 28): echo("3rd Sunday of Great Lent<br>Triodion week 7<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 35): echo("$day_name, Great Lent week 3<br>Triodion week 6<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 35): echo("2nd Sunday of Great Lent<br>Triodion week 6<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 42): echo("$day_name, Great Lent week 2<br>Triodion week 5<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 42): echo("1st Sunday of Great Lent<br>Triodion week 5<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) < 49): echo("$day_name, Great Lent week 1<br>Triodion week 4<br>"); 
                                 $lent = 1;
  elseif (($Pascha_date[yday] - $filter_date[yday]) == 49): echo("Sunday before Great Lent<br>Triodion week 4<br>"); 
                                 $lent = 1;
	elseif (($Pascha_date[yday] - $filter_date[yday]) < 57): echo("$day_name, Triodion week 3<br>"); 
	elseif (($Pascha_date[yday] - $filter_date[yday]) < 64): echo("$day_name, Triodion week 2<br>"); 
  
	elseif (($Pascha_date[yday] - $filter_date[yday]) < 71): echo("$day_name, Triodion week 1<br>"); 
  else:  $week_after_Pentecost = (floor((($filter_date[0] -  $Pentecost_lastyear[0])) / 604800));
  
	If ($filter_date[wday] == 0) {
		  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
		  echo( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }

	    //	 Luken Jump (before easter)
				

				   $week_of_Luke = ((floor((($filter_date[0] -  $LMonAfterEx[0])) / 604800 )) +1 );
				   if ($week_of_Luke < 13) echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
		    	 if (($week_of_Luke > 12 and ($week_of_Luke < 16)) and (($filter_date[wday] == 0) or ($filter_date[wday] == 6))) {
					 					               echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
				   }

  endif;
 // is date between Pascha and Ascension?
 elseif (($filter_date[yday] >=  $Pascha_date[yday]) and ($filter_date[yday] < ($Pentecost_date[yday] - 10 ))) :
                   $week_of_Pascha = ( 1 + (floor((($filter_date[yday] -  $Pascha_date[yday])) / 7)));
                 echo( "$day_name, <small>Week $week_of_Pascha of Pascha</small><br>");  
 // is date between Pascha and Pentecost?
 elseif (($filter_date[yday] >=  $Pascha_date[yday]) and ($filter_date[yday] < $Pentecost_date[yday])) :
                   $week_of_Pascha = ( 1 + (floor((($filter_date[yday] -  $Pascha_date[yday])) / 7)));
                 echo( "$day_name, <small>Week $week_of_Pascha of Pascha</small><br>");  

 // is date  Pentecost week?
 elseif (($filter_date[yday] >=  $Pentecost_date[yday]) and ($filter_date[yday] < ($Pentecost_date[yday] + 7))) :
                   echo( "$day_name, <small>Week of Pentecost</small><br>");  


  // must be after Pentecost this year 
 else: 
     $week_after_Pentecost = (floor((($filter_date[yday] -  $Pentecost_date[yday])) / 7));
		 If ($filter_date[wday] == 0) {
		  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
		  echo( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }
			//   
			//	 Luken Jump (after easter)
				if ($filter_date[0] == $MonAfterEx[0]) 	  echo( "<small> Luken Jump Begins<br></small>");
				if ($filter_date[0] > $MonAfterEx[0]) {
				   $week_of_Luke = ((floor((($filter_date[yday] -  $MonAfterEx[yday])) / 7 )) +1 );
				   if ($week_of_Luke < 13) echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
		    	 if (($week_of_Luke > 12) and (($filter_date[wday] == 0) or ($filter_date[wday] == 6))) {
					 					               echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
				   }
				}
	;
 endif;   
//newend			
		echo("<ul>"); 
		  }
	  //echo( "<li> " .$eventMonth. "/" . $eventDay . "/" . $eventYear . " - ");
		echo( "<li> " .$eventMonth. "/" . $eventDay); 
		if ($eventYear > 0) {
	    	echo( "/" . $eventYear . " - ");
		       } else {
        echo( "      - ");
           }
    if ($eventLink <> "") {
	   if ($eventPopup == "locp") {
	  echo("<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>");
	   } else {
          echo(" <A HREF='$eventLink' target=_blank> $eventText</A>");
		   }
	 } else {
          echo($eventText);
           }
    if ($eventHymn <> "") {
		   echo( " - <A HREF='$eventHymn' target=_blank>(hymn)</A> ");
           } else {
        echo( " " ); //- no hymn 
			 } 
	  if ($eventIcon <> "") {
		   echo( " - <A HREF='$eventIcon' target=_blank>(icon)</A>");
           } else {
        echo( " " );  //- no icon
		   //echo( " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
			 }
	echo(	"</li> ");	 
   
endforeach; 
 echo( "</ul><hr>"); 
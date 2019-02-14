<?php
//cmog_allfixedreadings    
 
add_shortcode( 'cmog_all_fixed_readings', 'cmog_allfixedreadings' );
function cmog_allfixedreadings(){
//	$output = PHP_EOL . "(cmog_allfixedreadings not done yet)" . PHP_EOL ;
//	return $output; 
//}


//  --------------------
global $wpdb; //This is used for database queries
$outputcal = '';

 
//$state= $this->get('state');
//$filter_month = $state->get('filter.month'); 
//$filter_year = $state->get('filter.year'); 
         $date = getDate();
 if (!isset($filter_day)) $filter_day = $date["mday"];
 if (!isset($filter_month)) $filter_month = $date["mon"];
 if (!isset($filter_year)) $filter_year = $date["year"];
 
 $filter_date = getDate(mktime(0, 0, 0, $filter_month, 1, $filter_year));
 $Week_day_n = $filter_date['wday'];
 $month_name = $filter_date['month'];
$filter_year= $filter_date['year'];
$filter_month= $filter_date['mon'];
$filter_day= $filter_date['mday'];
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
 $SatbeforeProdigal = ($Pascha_date['yday'] - 64);
 $March25 = getDate(mktime(0, 0, 0, 3, 25, $filter_year));
 
//Find Monday after the Sunday after the Exaltation of the Holy Cross
  $Exaltation = getDate(mktime(0, 0, 0, 9, 14, $filter_year));
  if ($Exaltation['wday'] <> 0) {
	$SunBeforeEx = getDate(mktime(0, 0, 0, 9, (14 - $Exaltation['wday']), $filter_year));
	$SunAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 7 -  $Exaltation['wday'])), $filter_year));
  } else {
	$SunBeforeEx = getDate(mktime(0, 0, 0, 9, 7 , $filter_year));
	$SunAfterEx = getDate(mktime(0, 0, 0, 9, 21 , $filter_year));
  }
  if ($Exaltation['wday'] <> 6) {
	$SatBeforeEx = getDate(mktime(0, 0, 0, 9, (13 - $Exaltation['wday'] ), $filter_year));
	$SatAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 6 -  $Exaltation['wday'])), $filter_year));
	} else {
	$SatBeforeEx = getDate(mktime(0, 0, 0, 9, 7 , $filter_year));
	$SatAfterEx = getDate(mktime(0, 0, 0, 9, 21 , $filter_year));
  }
	$MonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $Exaltation['wday'])), $filter_year));
	//Find Monday after the Sunday after the Exaltation of the Holy Cross from lastyear
  $LExaltation = getDate(mktime(0, 0, 0, 9, 14, $last_year));
	$LMonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $LExaltation['wday'])), $last_year));
//Find Sunday of the  Fathers of the First Six Councils
	$SixCouncils = getDate(mktime(0, 0, 0, 7, 19 , $filter_year));
	$SixCouncils = getDate(mktime(0, 0, 0, 7, (19 - $SixCouncils['wday']), $filter_year));
//Find Sunday of the  Fathers of the Seventh Council
	$SventhCouncil = getDate(mktime(0, 0, 0, 10, 11 , $filter_year));
	$SventhCouncil = getDate(mktime(0, 0, 0, 10, (11 - $SventhCouncil['wday']), $filter_year));
//Find Sundays before and after Nativity
 $Nativity = getDate(mktime(0, 0, 0, 12, 25 , $filter_year));
  if ($Nativity['wday'] <> 0) {
	$SunBeforeNativity = getDate(mktime(0, 0, 0, 12, (25 - $Nativity['wday']), $filter_year));
	$SunAfterNativity = getDate(mktime(0, 0, 0, 12, (25 + ( 7 -  $Nativity['wday'])), $filter_year));
  } else {
	$SunBeforeNativity = getDate(mktime(0, 0, 0, 12, 18 , $filter_year));
	$SunAfterNativity = getDate(mktime(0, 0, 0, 12, 26 ,  $filter_year ));// (monday - next sunday is next year)
  } 
  $TwoSunBeforeNativity = getDate(mktime(0, 0, 0, 12, ($SunBeforeNativity['mday'] - 7) , $filter_year));
$outputcal .= '<h3>Fixed Readings for the year </h3>' .PHP_EOL;
  if ($Nativity['wday'] <> 6) {
	$SatBeforeNativity = getDate(mktime(0, 0, 0, 12, (24 - $Nativity['wday'] ), $filter_year));
	} else {
	$SatBeforeNativity = getDate(mktime(0, 0, 0, 12, 19 , $filter_year));
  }
$NativityTheotokos = getDate(mktime(0, 0, 0, 9, 8 , $filter_year));
$Entrance = getDate(mktime(0, 0, 0, 11, 21 , $filter_year));
$Theophany = getDate(mktime(0, 0, 0, 1, 6 , $filter_year));
$Meeting = getDate(mktime(0, 0, 0, 2, 2 , $filter_year));
$Annunciation = getDate(mktime(0, 0, 0, 3, 25 , $filter_year));
$Transfiguration = getDate(mktime(0, 0, 0, 8, 6 , $filter_year));
$Dormition = getDate(mktime(0, 0, 0, 8, 15 , $filter_year));
// Build  the report
// ECHO ("<small><br>" . mysql_num_rows ($result) . " entries found <br></small><ul>");
	//$outputcal .=  
 $data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_events  where Class = 'read'  and Year = -1  ORDER BY Month , Day "); 
 $lastEventDay = "";
 foreach($data as $i => $row): 
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
			$outputcal .=  "</ul><hr />".PHP_EOL;
// new
 $filter_date = getDate(mktime(0, 0, 0, $eventMonth, $eventDay, $filter_year));
 $day_name = $filter_date['weekday'];
 //before Pascha?
				if ($filter_date[0] == $NativityTheotokos[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Nativity of the Theotokos</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Entrance[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Entrance of the Theotokos into the Temple</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Theophany[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Theophany</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Meeting[0]) 	  $outputcal .=  "<small> Great Feast day: <b>The Meeting of the Lord in the Temple</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Annunciation[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Annunciation</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Transfiguration[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Transfiguration of Christ</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $Dormition[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Dormition of the Theotokos</b><br></small>" .PHP_EOL;
 if ($filter_date['yday'] <  $Pascha_date['yday']):
  // is date lent or holy week?
  if     (($Pascha_date['yday'] - $filter_date['yday']) == 1) : $outputcal .=  "Great and Holy Saturday<br>" .PHP_EOL;
	                              $HolyWeek =1; 
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 7) : $outputcal .= "$day_name, Holy Week<br>Triodion week 10<br>" .PHP_EOL;
	                              $HolyWeek =1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 7) : $outputcal .=  "Entry of Our Lord into Jerusalem<br>Triodion week 10<br>" .PHP_EOL;
	                              $HolyWeek =1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 8) : $outputcal .=  "Lazarus Saturday<br>Triodion week 10<br>" .PHP_EOL;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 14): $outputcal .= "Great Lent week 6<br>Triodion week 9<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 14): $outputcal .= "5th Sunday of Great Lent<br>Triodion week 9<br>" .PHP_EOL;
                                 $lent = 1;
	elseif (($Pascha_date['yday'] - $filter_date['yday']) < 21): $outputcal .= "$day_name, Great Lent week 5<br>Triodion week 8<br>" .PHP_EOL;
                                 $lent = 1;
																 $week5 = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 21): $outputcal .= "4th Sunday of Great Lent<br>Triodion week 8<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 28): $outputcal .= "$day_name, Great Lent week 4<br>Triodion week 7<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 28): $outputcal .= "3rd Sunday of Great Lent<br>Triodion week 7<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 35): $outputcal .= "$day_name, Great Lent week 3<br>Triodion week 6<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 35): $outputcal .= "2nd Sunday of Great Lent<br>Triodion week 6<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 42): $outputcal .= "$day_name, Great Lent week 2<br>Triodion week 5<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 42): $outputcal .= "1st Sunday of Great Lent<br>Triodion week 5<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) < 49): $outputcal .= "$day_name, Great Lent week 1<br>Triodion week 4<br>" .PHP_EOL;
                                 $lent = 1;
  elseif (($Pascha_date['yday'] - $filter_date['yday']) == 49): $outputcal .= "Sunday before Great Lent<br>Triodion week 4<br>" .PHP_EOL;
                                 $lent = 1;
	elseif (($Pascha_date['yday'] - $filter_date['yday']) < 57): $outputcal .= "$day_name, Triodion week 3<br>" .PHP_EOL;
	elseif (($Pascha_date['yday'] - $filter_date['yday']) < 64): $outputcal .= "$day_name, Triodion week 2<br>" .PHP_EOL;
  
	elseif (($Pascha_date['yday'] - $filter_date['yday']) < 71): $outputcal .= "$day_name, Triodion week 1<br>" .PHP_EOL;
  else:  $week_after_Pentecost = (floor((($filter_date[0] -  $Pentecost_lastyear[0])) / 604800));
  
	If ($filter_date['wday'] == 0) {
		  $outputcal .=  "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>" .PHP_EOL;
			 }else{ 
		  $outputcal .=  "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>" .PHP_EOL;
			 }
	    //	 Luken Jump (before easter???)
				
				   $week_of_Luke = ((floor((($filter_date[0] -  $LMonAfterEx[0])) / 604800 )) +1 );
				   if ($week_of_Luke < 13) $outputcal .=  "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>" .PHP_EOL;
				   if (($week_of_Luke == 11) and ($filter_date['wday'] == 0))	{				   
				   $outputcal .=  "<small><sup>(The 11th Sunday of Luke is always read 2 Sundays before the Nativity, and that Sunday’s reading from Luke is read on the 11th Sunday of Luke.)</sup><br></small>" .PHP_EOL;
				   }
		    	 if (($week_of_Luke > 12 and ($week_of_Luke < 16)) and (($filter_date['wday'] == 0) or ($filter_date['wday'] == 6))) {
					 					               $outputcal .=  "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>" .PHP_EOL;
				   }
  endif;
 // is date between Pascha and Ascension?
 elseif (($filter_date['yday'] >=  $Pascha_date['yday']) and ($filter_date['yday'] < ($Pentecost_date['yday'] - 10 ))) :
                   $week_of_Pascha = ( 1 + (floor((($filter_date['yday'] -  $Pascha_date['yday'])) / 7)));
                 $outputcal .=  "$day_name, <small>Week $week_of_Pascha of Pascha</small><br>" .PHP_EOL;
 // is date between Pascha and Pentecost?
 elseif (($filter_date['yday'] >=  $Pascha_date['yday']) and ($filter_date['yday'] < $Pentecost_date['yday'])) :
                   $week_of_Pascha = ( 1 + (floor((($filter_date['yday'] -  $Pascha_date['yday'])) / 7)));
                 $outputcal .=  "$day_name, <small>Week $week_of_Pascha of Pascha</small><br>" .PHP_EOL;
 // is date  Pentecost week?
 elseif (($filter_date['yday'] >=  $Pentecost_date['yday']) and ($filter_date['yday'] < ($Pentecost_date['yday'] + 7))) :
                   $outputcal .=  "$day_name, <small>Week of Pentecost</small><br>" .PHP_EOL;
  // must be after Pentecost this year 
 else: 
     $week_after_Pentecost = (floor((($filter_date['yday'] -  $Pentecost_date['yday'])) / 7));
		 If ($filter_date['wday'] == 0) {
		  $outputcal .=  "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>" .PHP_EOL;
			 }else{ 
		  $outputcal .=  "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>" .PHP_EOL;
			 }
			//  Exaltation
			
				if ($filter_date[0] == $Exaltation[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Elevation of the Precious Cross</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $SatBeforeEx[0]) 	  $outputcal .=  "<small> Saturday before the Elevation<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SatAfterEx[0]) 	  $outputcal .=  "<small> Saturday after the Elevation<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SunBeforeEx[0]) 	  $outputcal .=  "<small> Sunday before the Elevation<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SunAfterEx[0]) 	  $outputcal .=  "<small> Sunday after the Elevation<br></small>" .PHP_EOL;
			//	 Luken Jump (after easter)
				if ($filter_date[0] == $MonAfterEx[0]) 	  $outputcal .=  "<small> Luken Jump Begins<br></small>" .PHP_EOL;
				if ($filter_date[0] > $MonAfterEx[0]) {
				   $week_of_Luke = ((floor((($filter_date['yday'] -  $MonAfterEx['yday'])) / 7 )) +1 );
				   if ($week_of_Luke < 13) $outputcal .=  "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>" .PHP_EOL;
				   if (($week_of_Luke == 11) and ($filter_date['wday'] == 0))	{				   
				   $outputcal .=  "<small><sup>(The 11th Sunday of Luke is always read 2 Sundays before the Nativity, and that Sunday’s reading from Luke is read on the 11th Sunday of Luke.)</sup><br></small>" .PHP_EOL;
				   }
		    	 if (($week_of_Luke > 12) and (($filter_date['wday'] == 0) or ($filter_date['wday'] == 6))) {
					 					               $outputcal .=  "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>" .PHP_EOL;
				   }
				}
				if ($filter_date[0] == $Nativity[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Nativity of Christ</b><br></small>" .PHP_EOL;
				if ($filter_date[0] == $SunBeforeNativity[0]) 	  $outputcal .=  "<small> Sunday before Nativity<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SunAfterNativity[0]) 	  $outputcal .=  "<small> Sunday after Nativity<br></small>" .PHP_EOL;
				if ($filter_date[0] == $TwoSunBeforeNativity[0]) 	  $outputcal .=  "<small> Two Sundays before Nativity<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SatBeforeNativity[0]) 	  $outputcal .=  "<small> Saturday before Nativity<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SixCouncils[0]) 	  $outputcal .=  "<small> Sunday of the Fathers of the First Six Councils<br></small>" .PHP_EOL;
				if ($filter_date[0] == $SventhCouncil[0]) 	  $outputcal .=  "<small> Sunday of the Fathers of the 7th Ecumenical Council<br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $NativityTheotokos[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Nativity of the Theotokos</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Entrance[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Entrance of the Theotokos into the Temple</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Theophany[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Theophany</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Meeting[0]) 	  $outputcal .=  "<small> Great Feast day: <b>The Meeting of the Lord in the Temple</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Annunciation[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Annunciation</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Transfiguration[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Transfiguration of Christ</b><br></small>" .PHP_EOL;
			//	if ($filter_date[0] == $Dormition[0]) 	  $outputcal .=  "<small> Great Feast day: <b>Dormition of the Theotokos</b><br></small>" .PHP_EOL;
 endif;   
//newend			
		$outputcal .= "<ul>" .PHP_EOL;
		  }
	  //$outputcal .=  "<li> " .$eventMonth. "/" . $eventDay . "/" . $eventYear . " - " .PHP_EOL;
		$outputcal .=  "<li> " .$eventMonth. "/" . $eventDay .PHP_EOL;
		if ($eventYear > 0) {
	    	$outputcal .=  "/" . $eventYear . " - " .PHP_EOL;
		       } else {
        $outputcal .=  "      - " .PHP_EOL;
           }
    if ($eventLink <> "") {
	   if ($eventPopup == "locp") {
	  $outputcal .= "<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>" .PHP_EOL;
	   } else {
          $outputcal .= " <A HREF='$eventLink' target=_blank> $eventText</A>" .PHP_EOL;
		   }
	 } else {
          $outputcal .= $eventText .PHP_EOL;
           }
    if ($eventHymn <> "") {
		   $outputcal .=  " - <A HREF='$eventHymn' target=_blank>(hymn)</A> " .PHP_EOL;
           } else {
        $outputcal .=  " "  .PHP_EOL; //- no hymn 
			 } 
	  if ($eventIcon <> "") {
		   $outputcal .=  " - <A HREF='$eventIcon' target=_blank>(icon)</A>" .PHP_EOL;
           } else {
        $outputcal .=  " "  .PHP_EOL;  //- no icon
		   //$outputcal .=  " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
			 }
	$outputcal .= 	"</li> " .PHP_EOL; 
   
endforeach; 
 $outputcal .=  "</ul><hr>" .PHP_EOL;
 RETURN  $outputcal ;
 }
<?php
/**
 * cmog helper
 */
  function number_suffix($number){
// this Function Puts the  'th'  'nd' 'st'  or 'rd' after the number 
    // Validate and translate our input
    if ( is_numeric($number)){
 
        // Get the last two digits (only once)
        $n = $number % 100;
 
    } 
    else {
        // If the last two characters are numbers
        if ( preg_match( '/[0-9]?[0-9]$/', $number, $matches )){
 
            // Return the last one or two digits
            $n = array_pop($matches);
        } 
        else {
 
            // Return the string, we can not add a suffix to it
            return $number;
        }
    }
 
    // Skip the switch for as many numbers as possible.
    if ( $n > 3 && $n < 21 )
        return $number . 'th';
 
    // Determine the suffix for numbers ending in 1, 2 or 3, otherwise add a 'th'
    switch ( $n % 10 ){
        case '1': return $number . 'st';
        case '2': return $number . 'nd';
        case '3': return $number . 'rd';
        default:  return $number . 'th';
    }
}
 

function getDate_of_Pascha($P_year) {
  $R1 =  $P_year % 19;
  $R2 =  $P_year % 4;
  $R3 =  $P_year % 7;
  $RA =  19 * $R1 + 16;
  $R4 =  $RA % 30;
  $RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
  $R5 =  $RB % 7;
  $RC =  $R4 + $R5;
 return getDate(mktime(0, 0, 0, 3 ,($RC + 34) , $P_year));
}
function _Loaddates($I_year, $I_month, $I_day) {
 
 $I_date = getDate(mktime(0, 0, 0, $I_month, $I_day, $I_year));
 $Week_day_n = $I_date['wday'];
 $month_name = $I_date['month'];
 $day_name = $I_date['weekday'];
 $this->_weekday = $day_name;
$Pentecost_day_week['day'] = 0;
$Pentecost_day_week['week'] = 0;
$Pentecost_day_week['lukew'] = 0;
$Pentecost_day_week['lent'] = 0;
$Pentecost_day_week['holyweek'] = 0;
$Pentecost_day_week['Annunciation'] = 0;
$Pentecost_day_week['normal'] = 1;
$Pentecost_day_week['week_of_Triodion'] = 0;
$Pentecost_day_week['week_of_Pascha'] = 0;
$week_after_Pentecost = 0;
//
if ($I_year < 1906) {
$this->_Text_of_day = "<br /> Bad date. ";
return;
}
$Pentecost_day_week['day'] =  $Week_day_n;
$HTML_text = ("<br>$day_name, $month_name  $I_day, $I_year<br>"); 
  //  get pascha date and last and next Pentecost date.
  $Pascha_date= $this->getThisPaschaDate()  ; 
  $Pentecost_date = $this->getThisPentecostDate() ;
  $Pentecost_lastyear =  $this->getLastPentecostDate() ;
  //  get some other feast dates
  $Sept22 = getDate(mktime(0, 0, 0, 9, 22, $I_year));
  $Dec19 = getDate(mktime(0, 0, 0, 12, 19, $I_year));
  $Jan15 = getDate(mktime(0, 0, 0, 1, 15, $I_year));
  $SatbeforeProdigal = ($Pascha_date['yday'] - 64);
  $March25 = getDate(mktime(0, 0, 0, 3, 25, $I_year));
 
//Find Monday after the Sunday after the Exaltation of the Holy Cross
  $Exaltation = getDate(mktime(0, 0, 0, 9, 14, $I_year));
	$MonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $Exaltation['wday'])), $I_year));
	//Find Monday after the Sunday after the Exaltation of the Holy Cross from lastyear
$last_year = $I_year - 1;	
  $LExaltation = getDate(mktime(0, 0, 0, 9, 14, $last_year));
	$LMonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $LExaltation['wday'])), $last_year));
	//+
 
// is it Sept. 22 to Dec. 19?
 if (($I_date['yday'] >= $Sept22['yday']) and ($I_date['yday'] <= $Dec19['yday'])) 	$Pentecost_day_week['normal'] = 0; 
// 	Jan. 15 to the Sat. before Sun. of Prodigal?
 $SatbeforeProdigal = ($Pascha_date['yday'] - 64);
if (($I_date['yday'] >= $Jan15['yday']) and ($I_date['yday'] <= $SatbeforeProdigal)) 	$Pentecost_day_week['normal'] = 0; 
//Annunciation on Thursday of 5th week of lent?
if (($Pascha_date['yday'] - 16) == $March25['yday']) 	$Pentecost_day_week['Annunciation'] = 1;
 
 
 //before Pascha?
 if ($I_date['yday'] <  $Pascha_date['yday']):
  //Pentecost week ( even if lent)
 $week_after_Pentecost = (floor((($I_date[0] -  $Pentecost_lastyear[0])) / 604800));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
			 
  // is date lent or holy week?
  if     (($Pascha_date['yday'] - $I_date['yday']) == 1) : $HTML_text .= ( "Great and Holy Saturday<br>");
	                              $Pentecost_day_week['holyweek'] =1; 
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 7) : $HTML_text .= ("$day_name, Holy Week<br>Triodion week 10<br>"); 
	                              $Pentecost_day_week['holyweek'] =1;
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 7) : $HTML_text .= ( "Entry of Our Lord into Jerusalem<br>Triodion week 10<br>");
	                              $Pentecost_day_week['holyweek'] =1;
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 8) : $HTML_text .= ( "Lazarus Saturday<br>Triodion week 9<br>");  
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 14): $HTML_text .= ("Great Lent week 6<br>Triodion week 9<br>"); 
                                 $Pentecost_day_week['lent'] = 6;
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 14): $HTML_text .= ("St. Mary of Egypt Sunday<br>5th Sunday of Great Lent<br>Triodion week 9<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 6;
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 21): $HTML_text .= ("$day_name, Great Lent week 5<br>Triodion week 8<br>"); 
                                 $Pentecost_day_week['lent'] = 5;
	                              $Pentecost_day_week['week_of_Triodion'] = 8;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 21): $HTML_text .= ("Sunday of St. John of the Ladder<br>4th Sunday of Great Lent<br>Triodion week 8<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 5;
	                              $Pentecost_day_week['week_of_Triodion'] = 8;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 28): $HTML_text .= ("$day_name, Great Lent week 4<br>Triodion week 7<br>"); 
                                 $Pentecost_day_week['lent'] = 4;
	                              $Pentecost_day_week['week_of_Triodion'] = 7;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 28): $HTML_text .= ("Sunday of the Cross<br>3rd Sunday of Great Lent<br>Triodion week 7<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 4;
	                              $Pentecost_day_week['week_of_Triodion'] = 7;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 35): $HTML_text .= ("$day_name, Great Lent week 3<br>Triodion week 6<br>"); 
                                 $Pentecost_day_week['lent'] = 3;
	                              $Pentecost_day_week['week_of_Triodion'] = 6;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 35): $HTML_text .= ("Sunday of St. Gregory Palamas<br>2nd Sunday of Great Lent<br>Triodion week 6<br>");
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>"); 
                                 $Pentecost_day_week['lent'] = 3;
	                              $Pentecost_day_week['week_of_Triodion'] = 6;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 42): $HTML_text .= ("$day_name, Great Lent week 2<br>Triodion week 5<br>"); 
                                 $Pentecost_day_week['lent'] = 2;
	                              $Pentecost_day_week['week_of_Triodion'] = 5;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 42): $HTML_text .= ("Sunday of Orthodoxy<br>1st Sunday of Great Lent<br>Triodion week 5<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 2;
	                              $Pentecost_day_week['week_of_Triodion'] = 5;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 49): $HTML_text .= ("$day_name, Great Lent week 1<br>Triodion week 4<br>"); 
                                 $Pentecost_day_week['lent'] = 1;
	                              $Pentecost_day_week['week_of_Triodion'] = 4;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 49): $HTML_text .= ("Forgiveness Sunday<br>Sunday before Great Lent<br>Triodion week 4<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
                                 $Pentecost_day_week['lent'] = 1;
	                              $Pentecost_day_week['week_of_Triodion'] = 4;
	elseif (($Pascha_date['yday'] - $I_date['yday']) < 56): $HTML_text .= ("$day_name, Triodion week 3<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 3;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 56): $HTML_text .= ("Sunday of Last Judgement<br>Triodion week 3<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 3;
	elseif (($Pascha_date['yday'] - $I_date['yday']) < 63): $HTML_text .= ("$day_name, Triodion week 2<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 2;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 63): $HTML_text .= ("Sunday of the Prodigal Son<br>Triodion week 2<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 2;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) < 70): $HTML_text .= ("$day_name, Triodion week 1<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 1;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 70): $HTML_text .= ("Publican & Pharisee Sunday<br>Triodion week 1<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 1;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 77): $HTML_text .= ("Zacchaeus Sunday<br>"); 
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = -1;
	// Must be before Triodion this year so look at weeks  after last years Pentecost.
  else:  $week_after_Pentecost = (floor((($I_date[0] -  $Pentecost_lastyear[0])) / 604800));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
	   	If ($I_date['wday'] == 0) {
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }
			
	    //	 Luken Jump (before easter)
				
				   $week_of_Luke = ((floor((($I_date[0] -  $LMonAfterEx[0])) / 604800 )) +1 );
				    
				   if ($week_of_Luke < 13){
					                 $HTML_text .= ( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
						$Pentecost_day_week['lukew']= $week_of_Luke;
				   }
		    	 if (($week_of_Luke > 12 and ($week_of_Luke < 16)) and (($I_date['wday'] == 0) or ($I_date['wday'] == 7)or ($I_date['wday'] == 6))) {
					 	$HTML_text .= ( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
						$Pentecost_day_week['lukew']= $week_of_Luke;
				   }
  endif;
 // is date  Pascha?
 elseif ($I_date['yday'] ==  $Pascha_date['yday']) :
                   $Pentecost_day_week['week_of_Pascha'] = 1;                 
                 $HTML_text .= ( "Holy Pascha<br>Christ is Risen!  Truly, He is Risen!<br>");  
                 $HTML_text .= ( "Pascha Sunday<br>"); 
 // is date between Pascha and Ascension?
 elseif (($I_date['yday'] >=  $Pascha_date['yday']) and ($I_date['yday'] < ($Pentecost_date['yday'] - 10 ))) :
                   $Pentecost_day_week['week_of_Pascha'] = ( 1 + (floor((($I_date['yday'] -  $Pascha_date['yday'])) / 7)));                 
                 $HTML_text .= ( "Christ is Risen!  Truly, He is Risen!<br>");  
                 $HTML_text .= ( "$day_name, <small>Week " . $Pentecost_day_week['week_of_Pascha'] . " of Pascha</small><br>");  
 // is date between Pascha and Pentecost?
 elseif (($I_date['yday'] >=  $Pascha_date['yday']) and ($I_date['yday'] < $Pentecost_date['yday'])) :
                   $Pentecost_day_week['week_of_Pascha'] = ( 1 + (floor((($I_date['yday'] -  $Pascha_date['yday'])) / 7)));
                 $HTML_text .= ( "$day_name, <small>Week " . $Pentecost_day_week['week_of_Pascha'] . " of Pascha</small><br>");  
 // is date  Pentecost ?
 elseif ($I_date['yday'] == ($Pentecost_date['yday'])) :
                   $HTML_text .= ( "<small>Pentecost Sunday</small><br>");  
                   $Pentecost_day_week['week_of_Pascha'] = 11;
 // is date  Pentecost week?
 elseif (($I_date['yday'] >  $Pentecost_date['yday']) and ($I_date['yday'] < ($Pentecost_date['yday'] + 7))) :
                   $HTML_text .= ( "$day_name, <small>Week of Pentecost</small><br>");  
                  $week_after_Pentecost = 1;
                  $Pentecost_day_week['week']= $week_after_Pentecost;
  // must be after Pentecost this year 
 else: 
     $week_after_Pentecost = (floor((($I_date['yday'] -  $Pentecost_date['yday'])) / 7));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
   	If ($I_date['wday'] == 0) {
                  $HTML_text .= ( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
		  $HTML_text .= ( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }
 
			//   
			//	 Luken Jump (after easter)
				if ($I_date[0] == $MonAfterEx[0]){
				 	  $HTML_text .= ( "<small> Luken Jump Begins<br></small>");
						$Pentecost_day_week['lukew']= 1;
					}	
				if ($I_date[0] > $MonAfterEx[0]) {
				   $week_of_Luke = ((floor((($I_date['yday'] -  $MonAfterEx['yday'])) / 7 )) +1 );
				   if ($week_of_Luke < 13) {
				     $HTML_text .= ( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
				    $Pentecost_day_week['lukew']= $week_of_Luke;
				    }
		    	 if (($week_of_Luke > 12) and (($I_date['wday'] == 0) or ($I_date['wday'] == 6))) {
				    $HTML_text .= ( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
				    $Pentecost_day_week['lukew']= $week_of_Luke;
				   }
				}
	;
 endif;   
 
 
$this->_day_week           =  $Pentecost_day_week['day'];
$this->_week_of_Pentecost  =  $Pentecost_day_week['week'];
$this->_week_of_luke                    =  $Pentecost_day_week['lukew'];
$this->_week_of_lent                    =  $Pentecost_day_week['lent'];
$this->_holyweek                    =  $Pentecost_day_week['holyweek'];
$this->_Annunciation                    =  $Pentecost_day_week['Annunciation'];
$this->_normal                    =  $Pentecost_day_week['normal'];
$this->_week_of_Triodion                    =  $Pentecost_day_week['week_of_Triodion'];
$this->_week_of_Pascha                    =  $Pentecost_day_week['week_of_Pascha'];
$this->_Text_of_day  =  $HTML_text;
        //+ 2.1 fix 
        //was:$this->Loaded = "Yes";
        //-
   return;
         }

//-----------------------------------------------------------------------------------------------------------------------------------
// this Function echos the Pentecost offset and returns it also.
//  Input: $I_year    - four digit year from 1906 to 2036)  
//         $I_month   - month  1 to 12
//         $I_day     - day of month
//  returns: $Pentecost_day_week['day']  - 8 is Sunday , 1 is Mon, 2 is Tues, ect.
//          $Pentecost_day_week['week']  - week number from last Pentecost
//          $Pentecost_day_week['lukew'] - week number of reading form Luke 
//          $Pentecost_day_week['lent'] - week number of Lent 
//          $Pentecost_day_week['holyweek'] - 1 if holly week 
//          $Pentecost_day_week['Annunciation'] - 1 if Annunciation (used for Psalter readings)
//          $Pentecost_day_week['normal'] - mostly 1 (used for Psalter readings)
//          $Pentecost_day_week['week_of_Triodion'] - week number of readings form Triodion
//          $Pentecost_day_week['week_of_Pascha'] -  week number of readings form Pascha to Pentecost
//
function Pentecost_offset($I_year, $I_month, $I_day) {
 
 $I_date = getDate(mktime(0, 0, 0, $I_month, $I_day, $I_year));
 $Week_day_n = $I_date['wday'];
 $month_name = $I_date['month'];
 $day_name = $I_date['weekday'];
 
$Pentecost_day_week['day'] = 0;
$Pentecost_day_week['week'] = 0;
$Pentecost_day_week['lukew'] = 0;
$Pentecost_day_week['lent'] = 0;
$Pentecost_day_week['holyweek'] = 0;
$Pentecost_day_week['Annunciation'] = 0;
$Pentecost_day_week['normal'] = 1;
$Pentecost_day_week['week_of_Triodion'] = 0;
$Pentecost_day_week['week_of_Pascha'] = 0;
$week_after_Pentecost = 0;
//
if ($I_year < 1906) return($Pentecost_day_week);
$Pentecost_day_week['day'] =  $Week_day_n;
//x echo ("<br>$day_name, $month_name  $I_day, $I_year<br>"); 
  //  get pascha date and last and next Pentecost date.
  $pdate    = Date_of_Pascha($I_year);  
  $Pascha_date = $pdate['Pascha_date'] ; 
  $Pentecost_date = $pdate['Pen_date'] ; 
  $Pentecost_lastyear =  $pdate['Pen_date_lastyear']; 
  //  get some other feast dates
  $Sept22 = getDate(mktime(0, 0, 0, 9, 22, $I_year));
  $Dec19 = getDate(mktime(0, 0, 0, 12, 19, $I_year));
  $Jan15 = getDate(mktime(0, 0, 0, 1, 15, $I_year));
  $SatbeforeProdigal = ($Pascha_date['yday'] - 64);
  $March25 = getDate(mktime(0, 0, 0, 3, 25, $I_year));
 
//Find Monday after the Sunday after the Exaltation of the Holy Cross
  $Exaltation = getDate(mktime(0, 0, 0, 9, 14, $I_year));
	$MonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $Exaltation['wday'])), $I_year));
	//Find Monday after the Sunday after the Exaltation of the Holy Cross from lastyear
$last_year = $I_year - 1;	
  $LExaltation = getDate(mktime(0, 0, 0, 9, 14, $last_year));
	$LMonAfterEx = getDate(mktime(0, 0, 0, 9, (14 + ( 8 -  $LExaltation['wday'])), $last_year));
	//+
 
// is it Sept. 22 to Dec. 19?
 if (($I_date['yday'] >= $Sept22['yday']) and ($I_date['yday'] <= $Dec19['yday'])) 	$Pentecost_day_week['normal'] = 0; 
// 	Jan. 15 to the Sat. before Sun. of Prodigal?
 $SatbeforeProdigal = ($Pascha_date['yday'] - 64);
if (($I_date['yday'] >= $Jan15['yday']) and ($I_date['yday'] <= $SatbeforeProdigal)) 	$Pentecost_day_week['normal'] = 0; 
//Annunciation on Thursday of 5th week of lent?
if (($Pascha_date['yday'] - 16) == $March25['yday']) 	$Pentecost_day_week['Annunciation'] = 1;
 
 
 //before Pascha?
 if ($I_date['yday'] <  $Pascha_date['yday']):
  //Pentecost week ( even if lent)
 $week_after_Pentecost = (floor((($I_date[0] -  $Pentecost_lastyear[0])) / 604800));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
			 
  // is date lent or holy week?
  if     (($Pascha_date['yday'] - $I_date['yday']) == 1) : //echo( "Great and Holy Saturday<br>");
	                              $Pentecost_day_week['holyweek'] =1; 
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 7) : //echo("$day_name, Holy Week<br>Triodion week 10<br>"); 
	                              $Pentecost_day_week['holyweek'] =1;
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 7) : //echo( "Holy week");
	                              $Pentecost_day_week['holyweek'] =1;
	                              $Pentecost_day_week['week_of_Triodion'] = 10;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 8) : //echo( "Lazarus Saturday<br>Triodion week 9<br>");  
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 14): //echo("Great Lent week 6<br>Triodion week 9<br>"); 
                                 $Pentecost_day_week['lent'] = 6;
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 14): //echo("St. Mary of Egypt Sunday<br>5th Sunday of Great Lent<br>Triodion week 9<br>"); 
                  //echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 6;
	                              $Pentecost_day_week['week_of_Triodion'] = 9;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 21): //echo("$day_name, Great Lent week 5<br>Triodion week 8<br>"); 
                                 $Pentecost_day_week['lent'] = 5;
	                              $Pentecost_day_week['week_of_Triodion'] = 8;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 21): //echo("Sunday of St. John of the Ladder<br>4th Sunday of Great Lent<br>Triodion week 8<br>"); 
                  //echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 5;
	                              $Pentecost_day_week['week_of_Triodion'] = 8;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 28): //echo("$day_name, Great Lent week 4<br>Triodion week 7<br>"); 
                                 $Pentecost_day_week['lent'] = 4;
	                              $Pentecost_day_week['week_of_Triodion'] = 7;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 28): //echo("Sunday of the Cross<br>3rd Sunday of Great Lent<br>Triodion week 7<br>"); 
                 // echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 4;
	                              $Pentecost_day_week['week_of_Triodion'] = 7;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 35): //echo("$day_name, Great Lent week 3<br>Triodion week 6<br>"); 
                                 $Pentecost_day_week['lent'] = 3;
	                              $Pentecost_day_week['week_of_Triodion'] = 6;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 35): //echo("Sunday of St. Gregory Palamas<br>2nd Sunday of Great Lent<br>Triodion week 6<br>");
                //  echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>"); 
                                 $Pentecost_day_week['lent'] = 3;
	                              $Pentecost_day_week['week_of_Triodion'] = 6;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 42): //echo("$day_name, Great Lent week 2<br>Triodion week 5<br>"); 
                                 $Pentecost_day_week['lent'] = 2;
	                              $Pentecost_day_week['week_of_Triodion'] = 5;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 42): //echo("Sunday of Orthodoxy<br>1st Sunday of Great Lent<br>Triodion week 5<br>"); 
                 // echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
                                 $Pentecost_day_week['lent'] = 2;
	                              $Pentecost_day_week['week_of_Triodion'] = 5;
  elseif (($Pascha_date['yday'] - $I_date['yday']) < 49): //echo("$day_name, Great Lent week 1<br>Triodion week 4<br>"); 
                                 $Pentecost_day_week['lent'] = 1;
	                              $Pentecost_day_week['week_of_Triodion'] = 4;
  elseif (($Pascha_date['yday'] - $I_date['yday']) == 49): //echo("Forgiveness Sunday<br>Sunday before Great Lent<br>Triodion week 4<br>"); 
                 // echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		 // echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
                                 $Pentecost_day_week['lent'] = 1;
	                              $Pentecost_day_week['week_of_Triodion'] = 4;
	elseif (($Pascha_date['yday'] - $I_date['yday']) < 56): //echo("$day_name, Triodion week 3<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 3;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 56): //echo("Sunday of Last Judgement<br>Triodion week 3<br>"); 
                 // echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		//  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 3;
	elseif (($Pascha_date['yday'] - $I_date['yday']) < 63): //echo("$day_name, Triodion week 2<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 2;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 63): //echo("Sunday of the Prodigal Son<br>Triodion week 2<br>"); 
                //  echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		//  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 2;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) < 70): //echo("$day_name, Triodion week 1<br>"); 
	                              $Pentecost_day_week['week_of_Triodion'] = 1;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 70): //echo("Publican & Pharisee Sunday<br>Triodion week 1<br>"); 
               //   echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		//  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = 1;
  	elseif (($Pascha_date['yday'] - $I_date['yday']) == 77): //echo("Zacchaeus Sunday<br>"); 
                //  echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		//  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
	                              $Pentecost_day_week['week_of_Triodion'] = -1;
	// Must be before Triodion this year so look at weeks  after last years Pentecost.
  else:  $week_after_Pentecost = (floor((($I_date[0] -  $Pentecost_lastyear[0])) / 604800));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
	   	If ($I_date['wday'] == 0) {
               //   echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
		//  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
		//  echo( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }
			
	    //	 Luken Jump (before easter)
				
				   $week_of_Luke = ((floor((($I_date[0] -  $LMonAfterEx[0])) / 604800 )) +1 );
				    //echo("<BR>$week_of_Luke<BR>");
				   if ($week_of_Luke < 13){
					                 //echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
						$Pentecost_day_week['lukew']= $week_of_Luke;
				   }
		    	 if (($week_of_Luke > 12 and ($week_of_Luke < 16)) and (($I_date['wday'] == 0) or ($I_date['wday'] == 7)or ($I_date['wday'] == 6))) {
					 	//echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
						$Pentecost_day_week['lukew']= $week_of_Luke;
				   }
  endif;
 // is date  Pascha?
 elseif ($I_date['yday'] ==  $Pascha_date['yday']) :
                   $Pentecost_day_week['week_of_Pascha'] = 1;                 
                // echo( "Holy Pascha<br>Christ is Risen!  Truly, He is Risen!<br>");  
               //  echo( "Pascha Sunday<br>"); 
 // is date between Pascha and Ascension?
 elseif (($I_date['yday'] >=  $Pascha_date['yday']) and ($I_date['yday'] < ($Pentecost_date['yday'] - 10 ))) :
                   $Pentecost_day_week['week_of_Pascha'] = ( 1 + (floor((($I_date['yday'] -  $Pascha_date['yday'])) / 7)));                 
                // echo( "Christ is Risen!  Truly, He is Risen!<br>");  
//
             //    echo( "$day_name, <small>Week $Pentecost_day_week['week_of_Pascha'] of Pascha</small><br>");  
 // is date between Pascha and Pentecost?
 elseif (($I_date['yday'] >=  $Pascha_date['yday']) and ($I_date['yday'] < $Pentecost_date['yday'])) :
                   $Pentecost_day_week['week_of_Pascha'] = ( 1 + (floor((($I_date['yday'] -  $Pascha_date['yday'])) / 7)));
            //     echo( "$day_name, <small>Week $Pentecost_day_week['week_of_Pascha'] of Pascha</small><br>");  
 // is date  Pentecost ?
 elseif ($I_date['yday'] == ($Pentecost_date['yday'])) :
           //        echo( "<small>Pentecost Sunday</small><br>");  
                   $Pentecost_day_week['week_of_Pascha'] = 8;
 // is date  Pentecost week?
 elseif (($I_date['yday'] >  $Pentecost_date['yday']) and ($I_date['yday'] < ($Pentecost_date['yday'] + 7))) :
                  // echo( "$day_name, <small>Week of Pentecost</small><br>");  
                  $week_after_Pentecost = 1;
                  $Pentecost_day_week['week']= $week_after_Pentecost;
  // must be after Pentecost this year 
 else: 
     $week_after_Pentecost = (floor((($I_date['yday'] -  $Pentecost_date['yday'])) / 7));		
	//(Sunday adjustment)
	      	If (($I_date['wday'] == 0) or ($week_after_Pentecost == 0)) {
	   	$Pentecost_day_week['week']= $week_after_Pentecost;
			 }else{ 
		  $Pentecost_day_week['week']= $week_after_Pentecost + 1	;
			 }
   	If ($I_date['wday'] == 0) {
            //      echo( "<small>Tone " . ((($week_after_Pentecost + 6) % 8) + 1) . " of the Octoechos.<br></small>");
	//	  echo( "<small> " . number_suffix($week_after_Pentecost) . " <b>Sunday after Pentecost</b><br></small>");
			 }else{ 
	//	  echo( "<small> " . number_suffix($week_after_Pentecost + 1) . " " . $day_name . " after Pentecost.<br></small>");
			 }
 
			//   
			//	 Luken Jump (after easter)
				if ($I_date[0] == $MonAfterEx[0]){
				 	//  echo( "<small> Luken Jump Begins<br></small>");
						$Pentecost_day_week['lukew']= 1;
					}	
				if ($I_date[0] > $MonAfterEx[0]) {
				   $week_of_Luke = ((floor((($I_date['yday'] -  $MonAfterEx['yday'])) / 7 )) +1 );
				   if ($week_of_Luke < 13) {
				    // echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke<br></small>");
				    $Pentecost_day_week['lukew']= $week_of_Luke;
				    }
		    	 if (($week_of_Luke > 12) and (($I_date['wday'] == 0) or ($I_date['wday'] == 6))) {
				  //  echo( "<small> " . number_suffix($week_of_Luke ) . " " . $day_name . " of Luke.<br></small>");
				    $Pentecost_day_week['lukew']= $week_of_Luke;
				   }
				}
	;
 endif;   
//newend	
	
  
   if ($Pentecost_day_week['week_of_Pascha'] == 1 ){
   return ("P<br />a<br />s<br />c<br />h<br />a");
   } elseif ($Pentecost_day_week['week_of_Pascha'] == 8 ){
   return ("P<br />e<br />n<br />t<br />e<br />c<br />o<br />s<br />t");
   } elseif ($Pentecost_day_week['week_of_Pascha']){
   return (number_suffix($Pentecost_day_week['week_of_Pascha'])." Week");
   } elseif ($Pentecost_day_week['holyweek']){
   return ("Holy Week");
   } elseif ($Pentecost_day_week['lent']){
   return (number_suffix($Pentecost_day_week['lent'])." Week Lent");
   } else  {
 return (number_suffix($Pentecost_day_week['week']). " Week");
         }
}
//-----------------------------------------------------------------------------------------------------------------------------------
//  this Function returns the getDate arrays of the pascha date and last and next Pentecost date.
//
//  Input:   $P_year                       - four digit year from 1906 to 2036)  
//  returns: $PDate['Pascha_date']           - timestamp of pascha for input date.
//           $PDate['Pen_date']              - timestamp of Pentecost for input date.
//           $PDate['Pen_date_lastyear']     - timestamp of Pentecost for input date.
 function Date_of_Pascha($P_year) {
  $R1 =  $P_year % 19;
  $R2 =  $P_year % 4;
  $R3 =  $P_year % 7;
  $RA =  19 * $R1 + 16;
  $R4 =  $RA % 30;
  $RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
  $R5 =  $RB % 7;
  $RC =  $R4 + $R5;
 $PDate['Pascha_date']  = getDate(mktime(0, 0, 0, 3 ,($RC + 34) , $P_year));
 $PDate['Pen_date']  = getDate(mktime(0, 0, 0, 3 ,($RC + 34 + 49)  , $P_year));
  $last_year = $P_year - 1;
  $R1 =  $last_year % 19;
  $R2 =  $last_year % 4;
  $R3 =  $last_year % 7;
  $RA =  19 * $R1 + 16;
  $R4 =  $RA % 30;
  $RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
  $R5 =  $RB % 7;
  $RC =  $R4 + $R5;
  $PDate['Pen_date_lastyear'] = getDate(mktime(0, 0, 0, 3 ,($RC + 34 + 49)  , $last_year));
  
  return($PDate);
}
/**
//-----------------------------------------------------------------
function  lookup_read($ChurchDates) {
//  input: $ChurchDates['day']  - 7 (or 0) is Sunday , 1 is Mon, 2 is Tues, ect.
//          $ChurchDates['week']  - week number from last Pentecost
//          $ChurchDates['lukew'] - week number of reading form Luke 
//          $ChurchDates['lent'] - week number of reading form Lent
//          $ChurchDates['holyweek'] - 1 if holly week 
//          $ChurchDates[week_of_week_of_Triodion] - week of Triodion (prelent to holy week)
//          $ChurchDates['week_of_Pascha'] - week between Pascha and Pentecaost
// if ($ChurchDates['day'] ==  0) $ChurchDates['day'] = 7;
$lookup = "<small><small>+ (sorry no readings were entered for this day and year) +</small></small>";
 
//Lent?
if ($ChurchDates['week_of_Triodion'] <> 0) {
//$lookup .= "<br>Look up Triodion reading week " . $ChurchDates['week_of_Triodion'] . " day " . $ChurchDates['day']; 
      $result = mysql_query("SELECT * FROM TriodionWeeks WHERE ((`week` = '$ChurchDates['week_of_Triodion']') and (`wday` = '$ChurchDates['day']' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
 }
//Pascha? 
elseif ($ChurchDates['week_of_Pascha'] <> 0) {
//$lookup .= "<br>Look up Pascha reading week " . $ChurchDates['week_of_Pascha'] . " day " . $ChurchDates['day']; 
      $result = mysql_query("SELECT * FROM PaschaWeeks WHERE ((`week` = '$ChurchDates['week_of_Pascha']') and (`wday` = '$ChurchDates['day']' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
}
//(must be after Pentecost of Luke)
else {
if ($ChurchDates['day'] ==  0) $ChurchDates['day'] = 7;
 //$lookup .= "<br>Look up Pentecost reading week " . $ChurchDates['week'] . " day " . $ChurchDates['day']; 
     $result = mysql_query("SELECT * FROM PentecostWeeks WHERE ((`week` = '$ChurchDates['week']') and (`wday` = '$ChurchDates['day']' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
    
  if  ($ChurchDates['lukew'] <> 0) {
      //$lookup .= " and for Luke reading week " . $ChurchDates['lukew'] . " day " . $ChurchDates['day']; 
           $result2 = mysql_query("SELECT * FROM LukeWeeks WHERE ((`week` = '$ChurchDates['lukew']') and (`wday` = '$ChurchDates['day']' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
      }
    
 }
 if (isset($result)) {
$lookup .= "<small><small><br>+ (using calculated readings:) +</small></small><h4>Readings:</h4>";
 //  get the defaults
     while ( $row = mysql_fetch_array($result) ) { 
      $event=$row["ID"];
      $eventclass=$row["Class"];
      $eventLink=$row["Link"];
      $eventIcon=$row["icon"];
      $eventHymn=$row["hymn"];
      $eventText=$row["EventText"];
      $eventPopup=$row["popup"];
      
switch ($eventclass) {    
    case "read":
        $read = 1;
        $read_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $read_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $read_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 } else {
          $read_html .=  $eventText ;
           }
 //       $read_html .=  ae($event) ."</li>";
          $read_html .=  "</li>";
        break;  
    default:
        break;  
      }//	switch	
    }// while
 $lookup .=  $read_html;
 }// if result
        $read_html = "";
//  get the defaults (if LUKE)
if  ($ChurchDates['lukew'] <> 0) {
     while ( $row = mysql_fetch_array($result2) ) { 
      $event=$row["ID"];
      $eventclass=$row["Class"];
      $eventLink=$row["Link"];
      $eventIcon=$row["icon"];
      $eventHymn=$row["hymn"];
      $eventText=$row["EventText"];
      $eventPopup=$row["popup"];
      
switch ($eventclass) {    
    case "read":
        $read = 1;
        $read_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $read_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $read_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 } else {
          $read_html .=  $eventText ;
           }
        $read_html .=  "</li>";
        break;  
    default:
        break;  
      }//	switch	
    }// while
    $read_html .= "<small><small>+ (the gospel reading from Luke replaces the pentecost gospel reading) +</small></small>";
    }// if luke
 $lookup .=  $read_html;
 
//               //debug   
//             $lookup .= "<table>";   
//              foreach($ChurchDates as $variable => $value) {
//               $lookup .= "<tr><td>" . $variable . "</td>";
//               $lookup .= "<td>" . $value . "</td>";
//             }
//                   $lookup .= "</table>";   
 //            // end of debug  
return $lookup;   
} **/
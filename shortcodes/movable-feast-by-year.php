<?php
//cmog_movablefeastbyyear
add_shortcode( 'movable_feast_by_year', 'cmog_movablefeastbyyear' );
function cmog_movablefeastbyyear(){
	//$output = PHP_EOL . "(cmog_movablefeastbyyear not done yet)" . PHP_EOL ;
	//return $output; 
// -------------------------------------------------------------------------------------------------------
global $wpdb; //This is used for database queries
$outputcal = '';
$Y_year = (!empty ($_REQUEST['Year'] )) ? $_REQUEST['Year'] : '';
         $date = getDate();
 if (!isset($Y_year) or ($Y_year == "")) $Y_year = $date["year"];
// -----------------------------------------------------------------------------------------------------
// Heading             
?> 
<?php $outputcal .= "<h3>Movable Feast by Year " . $Y_year . "</h3>" . PHP_EOL ; ?> 
<?php
function process_date($pascha,$offset,$event,$class, $link=NULL, $repeate=1, $hymn=NULL, $icon=NULL, $listorder=50, $popup=NULL)
    {
     $f_date = getDate(mktime(0, 0, 0, $pascha['mon'], $pascha['mday'] + $offset  , $pascha['year']));
	$sql_code = "<a HREF='/day/?f_year=$f_date[year]&f_month=$f_date[mon]&f_day=$f_date[mday]&Month=$f_date[mon]&Day=$f_date[mday]&Year=$f_date[year]'><li class='$class'>$f_date[mon]/$f_date[mday]/$f_date[year]</a> - <b>$event</b> " ;
	
	//$sql_code = "<a Target='_blank' HREF='/church-calendar/daily-evets.html?SYear=$f_date[year]&SMonth=$f_date[mon]&SDay=$f_date[mday]&Month=$f_date[mon]&Day=$f_date[mday]&Year=$f_date[year]'><li class='$class'>$f_date[mon]/$f_date[mday]/$f_date[year]</a> - <b>$event</b> " ;
	
	//?f_year=2019&f_month=2&f_day=14
	
	
	
			if ($link <> "") {
       $sql_code .= " |<A Target='_blank' HREF='$link'> (Link)</a>" ;
      }
			if ($icon <> "") {
       $sql_code .= " |<A Target='_blank' HREF='$icon'> (Icon)</a>" ;
      }
			if ($hymn <> "") {
        $sql_code .= " |<A Target='_blank' HREF='$hymn'> (Hymn)</a>" ;
		  }
     if ($repeate > 1) {
		$sql_code .= " - (For " . $repeate . " days.) " ;
			 }
		$sql_code .= "</li>" ;
    return $sql_code ;
    } 
?>
<?PHP
// The following algorithm is based on the algorithm derived by the German 
// mathematician Gauss. The principal simplification is that substitutions have been made for the 
// case of Julian calendars and Orthodox Easters. This algorithm calculates the number of days 
// AFTER March 21 (Julian) that Easter occurs (Note: It is a much simpler calculation than the Western Easter).
// 
// RMD(x,y) = remainder when x is divided by y.
// 
// R1=RMD(Year,19)
// R2=RMD(Year,4)
// R3=RMD(Year,7)
// RA=19*R1+16
// R4=RMD(RA,30)
// RB=2*R2+4*R3+6*R4
// R5=RMD(RB,7)
// RC=R4+R5
// The number RC ranges from 1 to 35 which corresponds to March 22 to April 25 in the Julian 
// Calendar (currently April 4 to May 8 on the Gregorian). The Julian Calendar is now 13 days 
// behind the Gregorian, and will be until March 1, 2100 when it will be 14 days behind the Gregorian Calendar. 
$R1 =  $Y_year % 19;
$R2 =  $Y_year % 4;
$R3 =  $Y_year % 7;
$RA =  19 * $R1 + 16;
$R4 =  $RA % 30;
$RB =  2 * $R2 + 4 * $R3 + 6 * $R4;
$R5 =  $RB % 7;
$RC =  $R4 + $R5;
$P_date = getDate(mktime(0, 0, 0, 3 ,$RC + 34 , $Y_year));
// Movable Feasts Associated with Easter
// The Ecclesiastical Calendar uses the algorithm above to determine the date of Easter. In addition, the following feasts related to Easter are provided by the Ecclesiastical Calendar.
// 
// Days before Easter 		
// Zacchaeus Sunday             77
// Triodon			70	
// Sat. of Souls		57	
// Meat Fare		        56	
// 2nd Sat. of Souls     	50
// Cheesefare (Forgiveness) Sunday 49	
// Lent Begins		        48
// St. Theodore		        43
// Sun. of Orthodoxy     	42
// Sat. of Lazarus	         8
// Palm Sunday		         7
// Good Friday		         2
// 
// Days after Easter
// 
// Ascension	        39
// Sat. of Souls	48
// Pentecost    	49
// All Saints   	56
// Fast of the Holy Apostles begins 57 
$P_date = getDate(mktime(0, 0, 0, 3 ,$RC + 34 , $Y_year));
$outputcal .= "<h3>$P_date[year] Movable Feast Dates </h3>" . PHP_EOL ; 
$outputcal .= "<FORM ACTION='#' METHOD=GET>Change Year: <INPUT type='text' name='Year' VALUE='$Y_year' size='4'>". PHP_EOL ; 
$outputcal .= "<INPUT TYPE=SUBMIT VALUE='Enter'> </FORM>" . PHP_EOL ; 
$outputcal .= "<hr>". PHP_EOL ; 
//
//-----------------------------------------------------------------
$outputcal .= "<hr />" . PHP_EOL ; 
$outputcal .= "From Pentecost of " . ($Y_year - 1) . "  to Pre-Lent of " . $Y_year . " is " .   Weeks_of_Pentecost($Y_year - 1)  . "  weeks <br>" . PHP_EOL ; 
$outputcal .= "<hr />" . PHP_EOL ; 
// ------------------------------------------------------------------------------------------------ Sunday before Theophany
$outputcal .= "<hr />". PHP_EOL ; 
$T_date = getDate(mktime(0, 0, 0, 1,6, $Y_year)); 
$outputcal .= "<small>(Theophany is on a $T_date[weekday] this year.</small>" . PHP_EOL ; 
$SBT_date = getDate(mktime(0, 0, 0, 1,(6 - $T_date['wday'])  , $Y_year));
if  (($T_date['wday'] == 0) or ($T_date['wday'] == 6)) {
$outputcal .= "<small> Sunday before Theophany would be last year)</small>" . PHP_EOL ; 
      }
$outputcal .= "<ul>" . PHP_EOL ; 
if  ($T_date['wday'] <> 0) {
     $outputcal .= process_date ($T_date,(-$T_date['wday']),'Sunday before Theophany. ', 'lf', '' ,  1 , '' , '') . PHP_EOL ; 
     $outputcal .= process_date ($T_date,((-$T_date['wday'])+ 7),'Sunday after Theophany ', 'lf', '' ,  1 ,'' , '') . PHP_EOL ; 
     } else {
     $outputcal .= process_date ($T_date,-7,'Sunday before Theophany', 'lf', '' ,  1 ,'' , '') . PHP_EOL ; 
     $outputcal .= process_date ($T_date,+7,'Sunday after Theophany ', 'lf', '' ,  1 ,'' , '') . PHP_EOL ; 
     }
$outputcal .= "</ul><hr />" . PHP_EOL ; 
$outputcal .= "<ul>". PHP_EOL ;     
				$data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_moveableevent ORDER BY Offset"); 
foreach($data as $i => $row){
      $offset=$row->Offset;
      $length=$row->Length;
      $eventid=$row->ID;
      $class=$row->Class;
      $link=$row->Link;
      $hymn=$row->hymn;
      $icon=$row->icon;
      $listorder=$row->listorder;
      $eventText=$row->EventText;
$outputcal .=       process_date($P_date,$offset, $eventText, $class , $link, $length, $hymn, $icon, $listorder) . PHP_EOL ;  
   }// for each end
//
// Apostles fast
$outputcal .=  "</ul> <hr />" . PHP_EOL ; 
$f_date = getDate(mktime(0, 0, 0, $P_date['mon'], $P_date['mday'] + 57, $P_date['year']));
$a_date = getDate(mktime(0, 0, 0, 6, 29, $P_date['year']));
     if ($f_date[0] >= $a_date[0]) {
$outputcal .= "(No Fast of the Holy Apostles this year.)<br>" . PHP_EOL ; 
      } else {
$outputcal .= "<ul>" . PHP_EOL ; 
$outputcal .=  process_date($P_date,+57,'Apostles fast begins', 'fast') . PHP_EOL ; 
      if (($f_date['yday'] + 1) < $a_date['yday']) { //more than one day fast//
$outputcal .=  process_date($P_date,+58, 'Apostles fast','fast',NULL,($a_date['yday'] - $f_date['yday'] -1)) . PHP_EOL ; 
       } //more
$outputcal .= "</ul>" . PHP_EOL ; 
      }  
// ------------------------------------------------------------------------------------------------ Sunday Fathers of the First Six Councils 
// Sunday on or before July 19 
$outputcal .= "<hr /><ul>" . PHP_EOL ; 
$F_date = getDate(mktime(0, 0, 0, 7, 19, $Y_year));
     $outputcal .= process_date ($F_date,(-$F_date['wday']),'Fathers of the First Six Councils', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=50' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=50' , 'http://saints.oca.org/IconDirectory/XSM/July/0716Fathers-4thEcumenical-Council.jpg') . PHP_EOL ; 
// ------------------------------------------------------------------------------------------------ Lukan Jump (and Elevation Sundays)
$outputcal .= "</ul><hr /><ul>" . PHP_EOL ; 
// Sundays before and after the Elevation
$L_date = getDate(mktime(0, 0, 0, 9, 14, $Y_year));
if  ($L_date['wday'] <> 0) {
$outputcal .= process_date ($L_date,(-$L_date['wday']),'Sunday before the Elevation','lf') . PHP_EOL ; 
                   } else {
$outputcal .= process_date ($L_date,(-7),'Sunday before the Elevation','lf') . PHP_EOL ; 
                   }
$outputcal .= process_date ($L_date,(7 - $L_date['wday']),'Sunday after the Elevation','lf') . PHP_EOL ; 
// Monday after the Sunday after the Elevation
$outputcal .= process_date ($L_date,(8 - $L_date['wday']),'Lukan Jump','lf') . PHP_EOL ; 
// ------------------------------------------------------------------------------------------------ Sunday Fathers of the 7th Ecumenical Council
// Sunday on or nearest to October 11 (same as on or before 14th)
$outputcal .= "</ul><hr /><ul>"  . PHP_EOL ; 
$S_date = getDate(mktime(0, 0, 0, 10, 14, $Y_year));
     $outputcal .= process_date ($S_date,(-$S_date['wday']),'Fathers of the 7th Ecumenical Council', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=70' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=70' , 'http://saints.oca.org/IconDirectory/XSM/october/1011to1017BFatherssunday.JPG')  . PHP_EOL ;  
// ------------------------------------------------------------------------------------------------ Sunday before Nativity 
$outputcal .= "</ul><hr />" . PHP_EOL ; 
$N_date = getDate(mktime(0, 0, 0, 12 ,25 , $Y_year));
$outputcal .= "<small>(Nativity is on a $N_date[weekday] this year)</small>" . PHP_EOL ; 
$outputcal .= "<ul>" . PHP_EOL ; 
//$SBN_date = getDate(mktime(0, 0, 0, 12 ,(25 - $N_date['wday'])  , $Y_year));
if  ($N_date['wday'] <> 0) {
     $outputcal .= process_date ($N_date,(-($N_date['wday']+7)),'2nd Sunday before Nativity', 'lf' , 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=80', 1,
		                       'http://www.oca.org/FStropars.asp?SID=13&ID=80' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1211to1217sundayofforefathers.jpg' ) . PHP_EOL ;  
     $outputcal .= process_date ($N_date,(-$N_date['wday']),'Sunday before Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . PHP_EOL ; 
    $outputcal .= process_date ($N_date,((-$N_date['wday'])+ 7),'Sunday after Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . PHP_EOL ;  // last line
     } else {
     $outputcal .= process_date ($N_date,-14,'2nd Sunday before Nativity', 'lf' , 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=80', 1,
		                       'http://www.oca.org/FStropars.asp?SID=13&ID=80' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1211to1217sundayofforefathers.jpg' ) . PHP_EOL ;  
     $outputcal .= process_date ($N_date,-7,'Sunday before Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . PHP_EOL ;  
$outputcal .= "<small>(Sunday after Nativity would be next year so readings are done on 12/26/" . $Y_year . ")</small>" . PHP_EOL ; 
     }
//-----------------------------------------------------------------
$outputcal .= "</ul><hr />" . PHP_EOL ; 
$outputcal .= "From Pentecost of " . $Y_year . "  to Pre-Lent of " . ($Y_year + 1) . " is " . Weeks_of_Pentecost($Y_year) . "  weeks "  . PHP_EOL ; 
$outputcal .= "<hr />" . PHP_EOL ; 
// western easter works for  years 1900-2099 only
function int_div($x, $y) {
    return ($x - ($x % $y)) / $y;
}
$WH =  (24 + 19 * ($Y_year % 19 )) % 30;
$WI = $WH - int_div($WH , 28);
$WJ = ($Y_year + int_div($Y_year , 4)  + $WI - 13) % 7;
$WL = $WI - $WJ;
$WEM = 3 + int_div(($WL + 40) , 44 ); // Western Easter month
$WED = $WL +28 - (31 * int_div($WEM , 4)); //Western Easter day
 $Westerm_Easter = getDate(mktime(0, 0, 0, $WEM, $WED, $Y_year));
$outputcal .= "<hr /><b>(Westerm Easter is $Westerm_Easter[mon]/$Westerm_Easter[mday]/$Y_year)</b><hr />"  . PHP_EOL ; 
$outputcal .= "<small>Note that dates are on the Gregorian calendar, even for dates calculated on the Julian calendar and for years before the Gregorian calendar was adopted. Also no corections were made for years after 2099 yet.</small><br /><small>CMOG-Calendar</small>" . PHP_EOL ; 
RETURN $outputcal;
}
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');


$document =& JFactory::getDocument();
$document->addStyleSheet("calendar.css");
$document->addStyleSheet("/plugins/content/highslide/highslide.css");
$document->addStyleSheet("/plugins/content/highslide/config/css/highslide-sitestyles.css");

$document->addScript("/includes/js/joomla.javascript.js");
$document->addScript("/media/system/js/mootools.js");
$document->addScript("/media/system/js/caption.js");
$document->addScript("/plugins/content/highslide/highslide-full.js");
$document->addScript("/plugins/content/highslide/easing_equations.js");
$document->addScript("/plugins/content/highslide/swfobject.js");
$document->addScript("/plugins/content/highslide/language/en.js");
$document->addScript("/plugins/content/highslide/config/js/highslide-sitesettings.js");


$document->setMetaData( 'keywords', 'when is easter, movable feasts, Orthodox church' );

$PHP_SELF=$_SERVER['PHP_SELF'] ;
$HTTP_HOST=$_SERVER['HTTP_HOST'] ;


$Y_year=JRequest::getCmd('Year');

$Print=JRequest::getCmd('print'); 
         $date = getDate();

 if (!isset($Y_year) or ($Y_year == "")) $Y_year = $date["year"];
// -----------------------------------------------------------------------------------------------------
// Heading             
?> 
  <script type="text/javascript">
hs.graphicsDir = '/plugins/content/highslide/graphics/';
		window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
  </script>
<table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Movable Feast by Year </td>
				<td align="right" width="100%" class="buttonheading">

<?php if ($Print==1){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
<a href="<?php 
	echo JRoute::_('index.php?option=com_cmogcal'); 
	?>?year=<?php echo($Y_year);?>&amp;tmpl=component&amp;print=1&amp;layout=default&amp;page=" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>

</table> 
<?PHP

// 
// works from 1902 to 2037
if (($Y_year > 2037) or ($Y_year < 1902)) {

echo("<FORM ACTION='#' METHOD=GET>Change Year: <INPUT type='text' name='Year' VALUE='$Y_year' size='4'>");
 echo("<INPUT TYPE=SUBMIT NAME='Change Year' VALUE='Enter'> </FORM>");
 echo("<small>(Works from 1902 to 2037 only)</small><hr>");
echo (" Year must be from 1902 to 2037. ");
return;
 } 

// Function process date

function process_date($pascha,$offset,$event,$class, $link=NULL, $repeate=1, $hymn=NULL, $icon=NULL, $listorder=50, $popup=NULL)
    {
     $f_date = getDate(mktime(0, 0, 0, $pascha[mon], $pascha[mday] + $offset + $i, $pascha[year]));
     echo ("<li class='$class'>$f_date[mon]/$f_date[mday]/$f_date[year] - <b>$event</b> ");
			if ($link <> "") {
       echo(" |<A Target='_blank' HREF='$link'> (Link)</a>");
      }
			if ($icon <> "") {
       echo(" |<A Target='_blank' HREF='$icon'> (Icon)</a>");
      }
			if ($hymn <> "") {
       echo(" |<A Target='_blank' HREF='$hymn'> (Hymn)</a>");
		  }
     if ($repeate > 1) {
		   echo (" - (For " . $repeate . " days.) ");
			 }
		 echo ("</li>");
		 
    return($sql_code);
    } 



$PHP_SELF=$_SERVER['PHP_SELF'] ;
$F_action = $_GET['Action'];


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
echo ("<h3>$P_date[year] Movable Feast Dates </b></h3>"); 

    if ($Print==1){
	echo("<hr>");
	 } else { 
 echo("<FORM ACTION='#' METHOD=GET>Change Year: <INPUT type='text' name='Year' VALUE='$P_date[year]' size='4'>");
 echo("<INPUT TYPE=SUBMIT NAME='Change Year' VALUE='Enter'> </FORM>");
 echo("<small>(Works from 1902 to 2037 only)</small><hr>");
	 }
//
//-----------------------------------------------------------------
echo ("<hr />");
echo ("From Pentecost of " . ($Y_year - 1) . "  to Pre-Lent of " . $Y_year . " is " . Weeks_of_Pentecost($Y_year - 1) . "  weeks <br>");
echo ("<hr />");

$sql_out = "INSERT INTO `Event` (`EventText` , `Year` , `Month` , `Day` , `Link` , `Class` , `gmd` , `AddDate` , `hymn`, `icon`, `listorder` )"; 
// ------------------------------------------------------------------------------------------------ Sunday before Theophany
echo ("<hr />");
$T_date = getDate(mktime(0, 0, 0, 1,6, $Y_year)); 
echo ("<small>(Theophany is on a $T_date[weekday] this year.</small>"); 
$SBT_date = getDate(mktime(0, 0, 0, 1,(6 - $T_date[wday])  , $Y_year));

if  (($T_date[wday] == 0) or ($T_date[wday] == 6)) {
      echo ("<small> Sunday before Theophany would be last year)</small>"); 
      }else{
      echo (") ");
      }
echo ("<ul>");      
if  ($T_date[wday] <> 0) {
     $sql_out .= process_date ($T_date,(-$T_date[wday]),'Sunday before Theophany. ', 'lf', '' ,  1 , '' , '') . "), ("; 
     $sql_out .= process_date ($T_date,((-$T_date[wday])+ 7),'Sunday after Theophany ', 'lf', '' ,  1 ,'' , '') . "), ("; 
     } else {
     $sql_out .= process_date ($T_date,-7,'Sunday before Theophany', 'lf', '' ,  1 ,'' , '') . "), ("; 
     $sql_out .= process_date ($T_date,+7,'Sunday after Theophany ', 'lf', '' ,  1 ,'' , '') . "), ("; 
     }
echo ("</ul><hr />");
    //
     


echo ("<ul>");      
                $this->items = $this->get('Items');
			
foreach($this->items as $i => $row){

      $offset=$row->Offset;
      $length=$row->Length;
      $eventid=$row->ID;
      $class=$row->Class;
      $link=$row->Link;
      $hymn=$row->hymn;
      $icon=$row->icon;
      $listorder=$row->listorder;
      $eventText=$row->EventText;


     process_date($P_date,$offset, $eventText, $class , $link, $length, $hymn, $icon, $listorder) . ")"; 
   }// for each end


//
// Apostles fast
echo ("</ul><hr />");
$f_date = getDate(mktime(0, 0, 0, $P_date[mon], $P_date[mday] + 57, $P_date[year]));
$a_date = getDate(mktime(0, 0, 0, 6, 29, $P_date[year]));
     if ($f_date[0] >= $a_date[0]) {
     echo ("(No Fast of the Holy Apostles this year.)<br>");
      } else {
      echo ("<ul>");
      process_date($P_date,+57,'Apostles fast begins', 'fast'). ")"; 

      if (($f_date[yday] + 1) < $a_date[yday]) { //more than one day fast//
			 
       process_date($P_date,+58, 'Apostles fast','fast',NULL,($a_date[yday] - $f_date[yday] -1)) . ")"; 
       } //more
      echo ("</ul>");
      }  
// ------------------------------------------------------------------------------------------------ Sunday Fathers of the First Six Councils 
// Sunday on or before July 19 

echo ("<hr /><ul>");
$F_date = getDate(mktime(0, 0, 0, 7, 19, $Y_year));

     $sql_out .= process_date ($F_date,(-$F_date[wday]),'Fathers of the First Six Councils', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=50' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=50' , 'http://saints.oca.org/IconDirectory/XSM/July/0716Fathers-4thEcumenical-Council.jpg') . "), ("; 
// ------------------------------------------------------------------------------------------------ Lukan Jump (and Elevation Sundays)
echo ("</ul><hr /><ul>");
// Sundays before and after the Elevation
$L_date = getDate(mktime(0, 0, 0, 9, 14, $Y_year));
if  ($L_date[wday] <> 0) {
$sql_out .= process_date ($L_date,(-$L_date[wday]),'Sunday before the Elevation','lf');
                   } else {
$sql_out .= process_date ($L_date,(-7),'Sunday before the Elevation','lf');
                   }
$sql_out .= process_date ($L_date,(7 - $L_date[wday]),'Sunday after the Elevation','lf');
// Monday after the Sunday after the Elevation
$sql_out .= process_date ($L_date,(8 - $L_date[wday]),'Lukan Jump','lf');

// ------------------------------------------------------------------------------------------------ Sunday Fathers of the 7th Ecumenical Council
// Sunday on or nearest to October 11 (same as on or before 14th)

echo ("</ul><hr /><ul>");
$S_date = getDate(mktime(0, 0, 0, 10, 14, $Y_year));

     $sql_out .= process_date ($S_date,(-$S_date[wday]),'Fathers of the 7th Ecumenical Council', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=70' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=70' , 'http://saints.oca.org/IconDirectory/XSM/october/1011to1017BFatherssunday.JPG') . "), ("; 

    
// ------------------------------------------------------------------------------------------------ Sunday before Nativity 
echo ("</ul><hr />");
$N_date = getDate(mktime(0, 0, 0, 12 ,25 , $Y_year));
echo ("<small>(Nativity is on a $N_date[weekday] this year)</small>"); 
      echo ("<ul>");
//$SBN_date = getDate(mktime(0, 0, 0, 12 ,(25 - $N_date[wday])  , $Y_year));
if  ($N_date[wday] <> 0) {
     $sql_out .= process_date ($N_date,(-($N_date[wday]+7)),'2nd Sunday before Nativity', 'lf' , 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=80', 1,
		                       'http://www.oca.org/FStropars.asp?SID=13&ID=80' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1211to1217sundayofforefathers.jpg' ) . "), ("; 
     $sql_out .= process_date ($N_date,(-$N_date[wday]),'Sunday before Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . "), ("; 
    $sql_out .= process_date ($N_date,((-$N_date[wday])+ 7),'Sunday after Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . ")"; // last line
     } else {
     $sql_out .= process_date ($N_date,-14,'2nd Sunday before Nativity', 'lf' , 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=80', 1,
		                       'http://www.oca.org/FStropars.asp?SID=13&ID=80' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1211to1217sundayofforefathers.jpg' ) . "), ("; 
     $sql_out .= process_date ($N_date,-7,'Sunday before Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . "), ("; 
    echo ("<small>(Sunday after Nativity would be next year)</small>"); 
    $sql_out .= process_date ($N_date,+7,'Sunday after Nativity', 'lf', 'http://ocafs.oca.org/FeastSaintsLife.asp?FSID=81' , 1 ,
		 'http://www.oca.org/FStropars.asp?SID=13&ID=81' , 'http://saints.oca.org/IconDirectory/XSM/nativity/1225nativity15.jpg') . ")"; // last line
     }


//-----------------------------------------------------------------
echo ("</ul><hr />");
echo ("From Pentecost of " . $Y_year . "  to Pre-Lent of " . ($Y_year + 1) . " is " . Weeks_of_Pentecost($Y_year) . "  weeks ");
echo ("<hr />");

// western easter works for  years 1900-2099 only
function int_div($x, $y) {
    return ($x - ($x % $y)) / $y;
}

$WH =  (24 + 19 * ($Y_year % 19 )) % 30;
 
$WI = $WH - int_div($WH , 28);
 
$WJ = ($Y_year + int_div($Y_year , 4)  + $WI - 13) % 7;
$WL = $WI - $WJ;
$WEM = 3 + int_div(($L + 40) , 44 ); // Western Easter month
$WED = $WL +28 - (31 * int_div($WEM , 4)); //Western Easter day
 $Westerm_Easter = getDate(mktime(0, 0, 0, $WEM, $WED, $Y_year));
echo ( "<hr /><b>(Westerm Easter is $Westerm_Easter[mon]/$Westerm_Easter[mday]/$Y_year)</b><hr />");
 ?>
<small>CMOG-Calendar</small>
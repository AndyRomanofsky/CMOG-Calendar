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


// -----------------------------------------------------------------------------------------------------
// Heading             
?> DailyEventss
<?php  
//------ fix this base address Joomla25 -------------
$me = "/church-calendar/daily-calendar.html";
$pagecal = "/church-calendar/monthly-calendar.html";

     $user =& JFactory::getUser();

//------------------------------------------------------------------------------Global Functions

require_once(JPATH_COMPONENT.DS.'CalendarFunctions.php');    
?>
<script type="text/javascript">
hs.graphicsDir = '/plugins/content/highslide/graphics/';
		window.addEvent('domready', function(){ var JTooltips = new Tips($$('.hasTip'), { maxTitleChars: 50, fixed: false}); });
  </script>
<?php  
//-----------------------------------------------------------------

function  lookup_read($ChurchDates) {
//  input: $ChurchDates[day]  - 7 (or 0) is Sunday , 1 is Mon, 2 is Tues, ect.
//          $ChurchDates[week]  - week number from last Pentecost
//          $ChurchDates[lukew] - week number of reading form Luke 
//          $ChurchDates[lent] - week number of reading form Lent
//          $ChurchDates[holyweek] - 1 if holly week 
//          $ChurchDates[week_of_week_of_Triodion] - week of Triodion (prelent to holy week)
//          $ChurchDates[week_of_Pascha] - week between Pascha and Pentecaost
// if ($ChurchDates[day] ==  0) $ChurchDates[day] = 7;
$lookup = "<small><small>+ (sorry no readings were entered for this day and year) +</small></small>";
 

//Lent?
if ($ChurchDates[week_of_Triodion] <> 0) {
//$lookup .= "<br>Look up Triodion reading week " . $ChurchDates[week_of_Triodion] . " day " . $ChurchDates[day]; 
      $result = mysql_query("SELECT * FROM TriodionWeeks WHERE ((`week` = '$ChurchDates[week_of_Triodion]') and (`wday` = '$ChurchDates[day]' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
 }
//Pascha? 
elseif ($ChurchDates[week_of_Pascha] <> 0) {
//$lookup .= "<br>Look up Pascha reading week " . $ChurchDates[week_of_Pascha] . " day " . $ChurchDates[day]; 
      $result = mysql_query("SELECT * FROM PaschaWeeks WHERE ((`week` = '$ChurchDates[week_of_Pascha]') and (`wday` = '$ChurchDates[day]' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
}
//(must be after Pentecost of Luke)
else {
if ($ChurchDates[day] ==  0) $ChurchDates[day] = 7;
 //$lookup .= "<br>Look up Pentecost reading week " . $ChurchDates[week] . " day " . $ChurchDates[day]; 
     $result = mysql_query("SELECT * FROM PentecostWeeks WHERE ((`week` = '$ChurchDates[week]') and (`wday` = '$ChurchDates[day]' ))
             ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }
    
  if  ($ChurchDates[lukew] <> 0) {
      //$lookup .= " and for Luke reading week " . $ChurchDates[lukew] . " day " . $ChurchDates[day]; 
           $result2 = mysql_query("SELECT * FROM LukeWeeks WHERE ((`week` = '$ChurchDates[lukew]') and (`wday` = '$ChurchDates[day]' ))
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
if  ($ChurchDates[lukew] <> 0) {
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

}
//-------------------------------------------------------------------------------------------------------------
function  nav_but($g_action, $g_value, $g_year, $g_month, $g_day, $g_ote=0) {
//echo("$g_action, $g_value, $g_year, $g_month, $g_day");
 $g_date = getDate(mktime(0, 0, 0, $g_month, $g_day, $g_year));

 echo("<center>");
 if  (($g_date[year] < 1906)or ($g_date[year] > 2036)){
 echo(" </center>");
 return;
 }
 
 echo("<form action='$g_action'  method='get'>");
 echo("<INPUT type='hidden' name='ote' VALUE='$g_ote' >");
 echo("<INPUT type='hidden' name='filter_year' VALUE='$g_date[year]' >");
 echo("<INPUT type='hidden' name='filter_month' VALUE='$g_date[mon]' >");
 echo("<INPUT type='hidden' name='filter_day' VALUE='$g_date[mday]' >");
 echo("<INPUT type='hidden' name='Year' VALUE='$g_date[year]' >");
 echo("<INPUT type='hidden' name='Month' VALUE='$g_date[mon]' >");
 if ($g_day <> 0)  {
 echo("<INPUT type='hidden' name='Day' VALUE='$g_date[mday]' >");
 echo("<input type='submit' title='$g_date[month] $g_date[mday] $g_date[year]' value='$g_value'>");
  }else{
 echo("<input type='submit' title='$g_date[month] $g_date[year]' value='$g_value'>");
  }
 echo("</form></center>");
 return;
}

$PHP_SELF=$_SERVER['PHP_SELF'] ;
$HTTP_HOST=$_SERVER['HTTP_HOST'] ;


//$ok_to_edit=$_GET['ote']; 

                                               //   echo(" ok_to_edit = $ok_to_edit<br>");
$filter_year=$_GET['filter_year']; 
$filter_month=$_GET['filter_month']; 
$filter_day=$_GET['filter_day']; 
$Print=$_GET['print']; 

         $date = getDate();
 if (!isset($ok_to_edit)) $ok_to_edit = 0;
                                              //    echo(" ok_to_edit = $ok_to_edit<br>");
 if (!isset($filter_day)) $filter_day = $date["mday"];
 if (!isset($filter_month)) $filter_month = $date["mon"];
 if (!isset($filter_year)) $filter_year = $date["year"];
 $filter_date = getDate(mktime(0, 0, 0, $filter_month, $filter_day, $filter_year));
 $Week_day_n = $filter_date[wday];
 $day_name = $filter_date[weekday];
 $month_name = $filter_date[month];

$filter_year= $filter_date[year];
$filter_month= $filter_date[mon];
$filter_day= $filter_date[mday];

// edit call function
//
// if ($ok_to_edit <> 0) {

// dump($user, "user");

// if ($user->gid > 19) {
   if ($user->guest <> 1) {
   function ae($id){
//   return(" - <A HREF=/mogCalendarAdmin/AllEventsWP.php?event=$id><img src='/images/M_images/edit.png' alt='edit' title='click to edit' /></a>");
   return(" - <A HREF=churchmotherofgod.org/?option=com_mogcalendar&view=mogcalendar&event=$id><img src='/images/M_images/edit.png' alt='edit' title='click to edit' /></a>");
   }
  }else{
   function ae($id){
   return;
   }
 }
// header of today

// -----------------------------------------------------------------------------------------------------
// Heading             
?> 
<table class="contentpaneopen">

<tr>
		<td class="contentheading" width="100%">
Daily Calendar for <?php echo($day_name.", ".$month_name." ". $filter_day .", " . $filter_year);?>		</td>
				<td align="right" width="100%" class="buttonheading">
<?php if (isset($Print)){ ?>
	<a href="#" title="Print" onclick="window.print();return false;"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		
<?php	} else {   ?>
<a href="<?php echo($me) ?>?tmpl=component&amp;print=1&amp;layout=default&amp;page=<?php 
echo("&filter_year=$filter_year&filter_month=$filter_month&filter_day=$filter_day");
?>" title="Print preview" onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=640,directories=no,location=no'); return false;" rel="nofollow"><img src="/images/M_images/printButton.png" alt="Print"  /></a>		</td>
		</tr>
<?php } ?>

</table>    


<?php if($Print) echo("<hr>");
 
// start of box ------------------------------------------------------------------------------
//
//echo ("<table class='daytable'  style=\"width:100%;border:0;\" ><tr><td colspan=\"2\" align=\"center\" >");

echo("<center><h4><b>");
// this Function echos the Pentecost offset and returns it also.
//  Input: $filter_year    - four digit year from 1906 to 2036)  
//         $filter_month   - month  1 to 12
//         $filter_day     - day of month
//  returns: $ChurchDates[day]  - 8 is Sunday , 1 is Mon, 2 is Tues, ect.
//          $ChurchDates[week]  - week number from last Pentecost
//          $ChurchDates[lukew] - week number of reading form Luke 
//          $ChurchDates[lent] - week number of reading form Lent
//          $ChurchDates[holyweek] - 1 if holly week 
//          $ChurchDates[week_of_Pascha] - week between Pascha and Pentecaos
//
$ChurchDates = Pentecost_offset($filter_year,$filter_month,$filter_day); 


echo("</b></h4></center>");


 
//   Open database ------------------------------------------------------------------------------------------------
//
require("./mogCalendarAdmin/open_churchmo_cal.php");  

// Read the table and build the output -----------------------------------------------------------------------------------
//

    //
    // Request the text of the day's events
  
    $result = mysql_query("SELECT * FROM Event WHERE (((`Year` = '$filter_year') or (`Year` = -1 ))
              and (`Month` = '$filter_month') 
              and (`Day` = '$filter_day') ) ORDER BY `listorder` DESC ");
 
    if (!$result) {
      echo("<P>Error performing query: " .
           mysql_error() . "</P>");
      exit();
    }


    while ( $row = mysql_fetch_array($result) ) { 

      $event=$row["ID"];
      $eventclass=$row["Class"];
      $eventLink=$row["Link"];
      $eventIcon=$row["icon"];
      $eventHymn=$row["hymn"];
      $eventText=$row["EventText"];
      $eventPopup=$row["popup"];
	
    if ($eventHymn <> "") {
		   $hymn_html .= "<li class='read'><A HREF='$eventHymn' target=_blank>$eventText</A>". ae($event) ."</li>";
			 } 
	  if ($eventIcon <> "") {
		   $icon_html .= "<img class='icon'src='$eventIcon' alt='$eventText' title='$eventText' height='150' > ";
			 }

    switch ($eventclass) {
    case "ser":
        if ($service <> 1) $ser_html = "<h4>Service:</h4>";
        $service = 1;  
        $ser_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
        $ser_html .= " <A HREF='$eventLink' target=_blank>$eventText</A>";
           } else {
        $ser_html .=  $eventText ;
           }
        $ser_html .=  ae($event) ."</li>";
        break;  
    case "fast":
        $fast = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	"<A HREF='" . $eventLink . "' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
        $fast_html .= ae($event) ."</span>";
        break;      
    case "fastfree":
        $fastfree = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	"<A HREF='" . $eventLink . "' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
        $fast_html .=  ae($event) ."</span>";
        break;      
    case "gf":
        $gf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$gf_html .=	"<A HREF='" . $eventLink . "' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
			       } else {
					   if ($eventPopup == "locp") {
						  $gf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $gf_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $gf_html .=  $eventText ;
           }
        $gf_html .=  ae($event) ."</li>";
        break;  
    case "lf":
        $lf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$lf_html .=	"<A HREF='" . $eventLink . "' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
			       } else {
					   if ($eventPopup == "locp") {
						  $lf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $lf_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $lf_html .=  $eventText ;
           }
        $lf_html .= ae($event) ."</li>";
        break;  
    case "evt":
          if (!isset($event_html)) $event_html = " ";
          $event_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $event_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $event_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
				     } else {
          $event_html .=  $eventText ;
           }
        $event_html .=  ae($event) ."</li>";
        break;  
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
        $read_html .=  ae($event) ."</li>";
        break;  
    default:
        $more_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$more_html .=	"<A HREF='" . $eventLink . "' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
			       } else {
					   if ($eventPopup == "locp") {
						  $more_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '700', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $more_html .= " <A HREF='$eventLink' target=_blank> $eventText</A>";
						   }
						 }
           } else {
        $more_html .=  $eventText ;
           }
        $more_html .=  ae($event) ."</li>";
        break;  
      }//	switch	
    }// while
    if ( $read == 1) {
         $read_html =  "<h4>Readings:</h4>$read_html";
         } 
		 
		if ($hymn_html <> "") {
				$hymn_html = "<h4>Hymns:</h4>$hymn_html";
				}

    if (( $service == 0) and ($Week_day_n == 0 ))  {
         $ser_html .=  "<h4>Sunday service:</h4><li class='ser'> 9:40 AM - Hours</li>";
         $ser_html .=  "<li class='ser'> 10:00 AM - Divine Liturgy</li>";
         } 
    if (($fastfree == 0 and $fast == 0) and (($Week_day_n == 3 ) or ($Week_day_n == 5)) ) {
         $fast_html  =  " <span class='fast'>fast day</span>";
         } 
// Print the output ---------------------------------------------------------------------------------------------------------
//
       echo("<center>" . $fast_html . "</center>" ); 
       
       //new row - new cell. (only 1 cell)
      // echo("</td></tr><tr><td  align=\"center\" >"); 
       echo("<ul>" . $ser_html ."</ul><ul>" . $event_html . "</ul>" );  
     

       //new row - new cell
      // echo("</td></tr><tr><td  align=\"center\" >" );
       if (!isset($read_html)) $read_html = lookup_read($ChurchDates);
       echo("<ul>" . $read_html. "</ul>"); 
      // echo($read_html. "</td></tr><tr>"); 
       // - new cell
     //  echo("<td  align=\"center\" >"); 

//  This section will list the Kathisma that are read. (It now is fixed for Bright week) ------------------------------------------
//	 
    
     $psalter = "<a target='_blank' href='http://churchmotherofgod.org/text-of-prayers-of-the-church/daily-readings-from-the-psalter/";
	$popup = "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: 'Kathisma', wrapperClassName: 'titlebar' } )\" ";	 
		 
		 echo("<ul><h4>Psalter:</h4><li class='read'>");
		if ($ChurchDates[week_of_Pascha] == 1) : 
		    echo(" no Kathisma reading, <a target='_blank' href='http://churchmotherofgod.org/text-of-prayers-of-the-church/1376-brightweek-prayers.html'>Brightweek Prayers</a>");

		elseif ($ChurchDates[holyweek] == 1): //Holyweek	
    switch ($Week_day_n) {
    case 1:   //Monday  Holyweek
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 2: //Tuesday Holyweek
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a>, ");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 3: //Wednesday Holyweek
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a>, ");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");
        break; 
    case 4: //Thursday Holyweek 
        echo(  "(no Kathisma reading)");
        break; 
    case 5: //Firday Holyweek 
        echo("(no Kathisma reading)");
        break; 
    case 6: //Saturday Holyweek 
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)");
        break; 
    case 0: //Sunday Holyweek
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a>, Polyeleos (Matins)");
        break;    
		default:
        echo($Week_day_n . " - Holyweek?");
    }//	switch	 
 
	
		elseif ($ChurchDates[lent] == 0):  // not lent
     switch ($Week_day_n) {
    case 1:
        if ($ChurchDates[normal] == 1):  //Monday normal
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Vespers)</li>");

        else:           //Monday  
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");

        endif;
        break; 
    case 2:
        if ($ChurchDates[normal] == 1): //Tuesday normal
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (Vespers)</li>");

        else: //Tuesday  
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a>, ");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a>(Vespers)");


        endif;
        break; 
    case 3:
        if ($ChurchDates[normal] == 1): //Wednesday normal
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Vespers)");
				
        else: //Wednesday 
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");


        endif;
        break; 
    case 4:
        if ($ChurchDates[normal] == 1): //Thursday normal
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Vespers)");

        else: //Thursday
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 5: //Friday normal
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");
        break; 
    case 6: //Saturday normal
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a>, ");
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Vespers)");
        break; 
    case 0://Sunday
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (Matins)");
        break; 
   default:
        echo($Week_day_n . " - not lent?");
    }//	switch	 
 
	 else: //Lent
    switch ($Week_day_n) {
    case 1: // Monday lent
        if ($ChurchDates[lent] == 5):  //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (1rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (3th Hour)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (Vespers)");
        else: 
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (Vespers)");
				endif;
				
        else: 
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a>, ");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a>, ");
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 2: //Tuesday lent
        if ($ChurchDates[lent] == 5):    //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (Vespers)");
        else:  
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a>, ");
         echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (Vespers)");
				endif;
				
        else: //not week 5
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a>, ");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a>, ");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 3: //Wednesday lent
        if ($ChurchDates[lent] == 5):     //week 5
				if ($ChurchDates[Annunciation] == 1 ):
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (9th Hour)");
			 else:
         echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
         echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a>, ");
         echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a> (Vespers)");
				endif;
				
        else: //not week 5 
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a>, ");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a>, ");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1031-kathisma-4.html".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1032-kathisma-5.html".$popup.">Kathisma 5</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 4: //Thursday lent
        if ($ChurchDates[lent] == 5):     //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a>, ");
         echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
         echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (9th Hour)");
        else:
	 echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
         echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (3rd Hour)</li><li class='read'>");
         echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (6th Hour)</li><li class='read'>");
         echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (9th Hour)</li><li class='read'>");
         echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (Vespers)");

				endif;
				
        else: //not week 5
        echo(  $psalter . "1033-kathisma-6.html".$popup.">Kathisma 6</a>, ");
        echo(  $psalter . "1034-kathisma-7.html".$popup.">Kathisma 7</a>, ");
        echo(  $psalter . "1035-kathisma-8.html".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1036-kathisma-9.html".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>");
        echo(  $psalter . "1037-kathisma-10.html".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1038-kathisma-11.html".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1039-kathisma-12.html".$popup.">Kathisma 12</a> (9th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        endif;
        break; 
    case 5: //Friday Lent
 
        echo(  $psalter . "1040-kathisma-13.html".$popup.">Kathisma 13</a>, ");
        echo(  $psalter . "1041-kathisma-14.html".$popup.">Kathisma 14</a>, ");
        echo(  $psalter . "1042-kathisma-15.html".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1046-kathisma-19.html".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>");
        echo(  $psalter . "1047-kathisma-20.html".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>");
        echo(  $psalter . "1045-kathisma-18.html".$popup.">Kathisma 18</a> (Vespers)");

        break; 
    case 6:  //Saturday Lent (same as normal)
        echo(  $psalter . "1043-kathisma-16.html".$popup.">Kathisma 16</a>, ");
        echo(  $psalter . "1044-kathisma-17.html".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>");
        echo(  $psalter . "1028-kathisma-1.html".$popup.">Kathisma 1</a> (Vespers)");
        break; 
    case 0: //Sunday Lent (same as normal)
        echo(  $psalter . "1029-kathisma-2.html".$popup.">Kathisma 2</a>, ");
        echo(  $psalter . "1030-kathisma-3.html".$popup.">Kathisma 3</a> (Matins)");
        break; 
   default:
        echo($Week_day_n . " - Lent?");
    }//	switch	 
	   endif;// not 1st week of Pascha
  echo("</li></ul>");
  
       //new row - new cell
   //    echo("</td></tr><tr><td align=\"center\" >"); 
       echo("<ul><h4>On this day the Church remembers:</h4>");
       echo($gf_html . $lf_html . $more_html . "</ul>" );
       //  - new cell
    //   echo("</td></tr><tr><td  align=\"center\" >");
       echo("<ul>" . $hymn_html . "</ul>" );
      
       //new row - new cell. (only 1 cell)
//	echo("</td></tr><tr><td  align=\"center\" >");
	echo("<center>". $icon_html . "</center>");
	
// Navigation links at bottom of box ------------------------------------------------------------------------------
//
   if ($ok_to_edit <> 0){
              $oparm = "?ote=$ok_to_edit&";
              }else{
              $oparm = "?";
              }
   
if($Print) echo("<hr>");
?>


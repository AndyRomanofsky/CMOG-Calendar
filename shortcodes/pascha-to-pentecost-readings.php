<?php
//cmog_pascha-to-pentecost-readings
 
add_shortcode( 'pascha_to_pentecost_readings', 'cmog_paschatopentecostreadings' );
function cmog_paschatopentecostreadings(){
$outputcal = "";
global $wpdb; //This is used for database queries


$weekday[0]= "Sunday";
$weekday[1]= "Monday";
$weekday[2]= "Tuesday";
$weekday[3]= "Wednesday";
$weekday[4]= "Thursday";
$weekday[5]= "Friday";
$weekday[6]= "Saturday";
$weekday[7]= "Sunday";

$outputcal .= '<h3>Pascha Reading cycle</h3>' ;


// Build  the report

	$items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_templates` WHERE  Class = 'read' and gmd = -5 ORDER  BY week, wday asc"); 
$lastEventWeek ="";
 
foreach($items as $i => $row): 

      $eventclass=$row->Class;
      $eventLink=$row->Link;
      $eventIcon=$row->icon;
      $eventHymn=$row->hymn;
      $eventText=$row->EventText;
      $eventDay=$row->wday;
      $eventWeek=$row->week;
      $eventPopup=$row->popup;
	  
		if ($eventWeek <> $lastEventWeek	) {
		  $lastEventWeek =  $eventWeek;
		  $lastEventDay =  $eventDay;
			$outputcal .= "</ul><hr /><ul>" ;
		  }elseif ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			$outputcal .= "<br />" ;
		  }
    if 	 (($eventWeek == 1) and  ($eventDay == 0)) {
	  $outputcal .= "<li>  Pascha Sunday - " ; 
	  } else if (($eventWeek == 8) and  ($eventDay == 0)) {
	  $outputcal .=  "<li>  Pentecost Sunday - " ;  
	  } else {
	  $outputcal .=  "<li>" .number_suffix($eventWeek). " ". $weekday[$eventDay] . " of Pascha  - " ;
	  }
    if ($eventLink <> "") {
	   if ($eventPopup == "locp") {
	  $outputcal .= "<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>" ;
	   } else {
          $outputcal .= " <A HREF='$eventLink' target=_blank> $eventText</A>" ;
		   }
	 } else {
          $outputcal .= $eventText ;
           }
    if ($eventHymn <> "") {
		   $outputcal .=  " - <A HREF='$eventHymn' target=_blank>(hymn)</A> " ;
        		 } 
	  if ($eventIcon <> "") {
		   $outputcal .=  " - <A HREF='$eventIcon' target=_blank>(icon)</A>" ;
          		   //echo( " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
			 }
	$outputcal .= "</li> " ;	 
   
endforeach; 
 $outputcal .=  "</ul><hr>" ;
 RETURN $outputcal; 
 }
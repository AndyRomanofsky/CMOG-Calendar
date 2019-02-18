<?php
//cmog_tridion_readings
 
add_shortcode( 'tridion_readings', 'cmog_tridionreadings' );
function cmog_tridionreadings(){
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
 $outputcal .= '<h3> Tridion Reading cycle</b></h3>' ;
 $outputcal .= '<ul>' ;


// Build  the report

//get data
// needs to be just feasts (saints)
	$items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_templates` WHERE  Class = 'read' and gmd = -4 ORDER  BY week, wday asc"); 
$lastEventWeek = -2;
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
			 $outputcal .= "</ul><hr />" ;
			if ($eventWeek < 5 )  $outputcal .= "<ul>" ;
			if (($eventWeek > 4 ) and ($eventWeek <> 10))  $outputcal .= "<b><center>". number_suffix($eventWeek - 4) . " week of Lent</center></b><ul>" ;
		 	if ($eventWeek == 10)  $outputcal .= "<b><center>Holy Week</center></b><ul>" ;
		 }elseif ($eventDay <> $lastEventDay	) {
		  $lastEventDay =  $eventDay;
			 $outputcal .=  "<br />" ;
		  }
	  if ($eventWeek < 0){
	  $outputcal .=   "<li>" . number_suffix(abs($eventWeek)). " ". $weekday[$eventDay] . " before the Triodion - " ;
	  } else {
	   $outputcal .=  "<li>" . number_suffix($eventWeek). " ". $weekday[$eventDay] . " of the Triodion - " ;
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
		    $outputcal .= " - <A HREF='$eventHymn' target=_blank>(hymn)</A> " ;
        		 } 
	  if ($eventIcon <> "") {
		    $outputcal .=  " - <A HREF='$eventIcon' target=_blank>(icon)</A>";
          		   // $outputcal .=  " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ";
			 }
	 $outputcal .= "</li> " ;	 
   
endforeach; 
  $outputcal .= "</ul><hr>" ; 
  return  $outputcal;
}
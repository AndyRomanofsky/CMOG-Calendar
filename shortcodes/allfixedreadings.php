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


$outputcal .= '<h3>Fixed Readings for the year </h3>' .PHP_EOL;

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
		if ($eventDay <> $lastEventDay	) { // new
		  $lastEventDay =  $eventDay;
		  $outputcal .=  "</ul><hr /><ul>".PHP_EOL;
		}
		$outputcal .=  "<li> " .$eventMonth. "/" . $eventDay .PHP_EOL;
        $outputcal .=  "      - " .PHP_EOL;
            
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
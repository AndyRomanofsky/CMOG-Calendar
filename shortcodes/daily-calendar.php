<?php
//cmog_daily_calendar    
require_once 'C:\wamp64a\www\cmog\wp-content\plugins\CMOG-templates\/cmog-helper.php';
    function ae($id, $dateparms="" ){
       //  $Print= JRequest::getCmd('print'); 
      //    if ($Print <> 1) {
      //return(" - <a href=" . JRoute::_('index.php?option=com_cmogcal&task=event.edit&ID='.$id.'&a.id='.$id) . "><img src='/images/M_images/edit.png' alt='edit' title='click to edit' /></a>");
//	  } else {
   return;
 //  }
   }
add_shortcode( 'cmog_day', 'cmog_daily_calendar' );
function cmog_daily_calendar(){
$read = $read_html = $hymn_htm = $more_html = $service = $Week_day_n = $ser_html = $fastfree = $fast = $fast_html = $hymn_html= $event_html = $icon_html = $gf_html = $lf_html = "";
global $wpdb; //This is used for database queries
$SDay = (!empty($_REQUEST['f_day'] )) ? $_REQUEST['f_day'] : '';
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';
$SClass = (!empty ($_REQUEST['f_class'] )) ? $_REQUEST['f_class'] : '';
 $date = getDate();
//$yesterday = new MOGDate;
//var_dump($yesterday->getTextofday());
 if ($SDay == "") $SDay = $date["mday"];
 if ($SMonth == "") $SMonth = $date["mon"];
 if ($SYear == "") $SYear = $date["year"];
 $display_date =   getDate(mktime(0,0,0,$SMonth,$SDay,$SYear));
    $outputcal = '';
    ?>
	<?php $outputcal .= "<h2>" . $display_date["weekday"] . ", " .   $display_date["month"] . " "  .$display_date["mday"] . ", " . $display_date["year"] . "</h2>" . PHP_EOL;?>
        <?php $outputcal .= "<form id='templates-filter' method='get'>" . PHP_EOL;?>
		  <?php $outputcal .= "<br />" . PHP_EOL;?>
		<?php $outputcal .= "Year: ";?> 
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<?php $outputcal .= "<select name='f_year' >";?>	
			<?php		
			foreach($years as  $y): 
			$outputcal .= "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $y['Year'] . "</option>" . PHP_EOL;	
			endforeach; 
			?>
			<?php $outputcal .= "</select>";?>		
		 <?php $outputcal .= " Month:";?> 
			<?php $outputcal .= "<select name='f_month' >";?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>\n	  ";?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>" . PHP_EOL;?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>" . PHP_EOL;?>
			<?php $outputcal .= "</select>		" . PHP_EOL;?>
		<?php $outputcal .= " Day: <input type='number' name='f_day'  min='0' max='31'  value='" . $SDay . "'>" . PHP_EOL      ?>     	
		  <?php $outputcal .= "<input type='submit' value='Filter'>" . PHP_EOL;?>
		  <?php $outputcal .= "<br />" . PHP_EOL;?>
	<?php	
//get data
				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE (Year = $SYear or Year = -1 ) and Month = $SMonth and Day = $SDay ORDER  BY Day asc", 'ARRAY_A' ); 
	?>		
<?php
foreach($items as $i => $row): 
$event=$row['ID'];
      $eventclass=$row['Class'];
      $eventLink=$row['Link'];
      $eventIcon=$row['icon'];
      $eventHymn=$row['hymn'];
      $eventText=$row['EventText'];
      $eventPopup=$row['popup'];
	  $canedit = false;
    if ($eventHymn <> "") {
		   $hymn_html .= "<li class='read'><A HREF='$eventHymn' target='_blank'>$eventText</A>";
		   if ($canedit)  {
        	$hymn_html .=  ae($event) ."</li>" . PHP_EOL;
			}else{
		   $hymn_html .=  "</li>" . PHP_EOL;
		 }
		} 
	  if ($eventIcon <> "") {
			$icon_html .= "<img class='icon' src='" . $eventIcon . "' alt='$eventText' title='$eventText' height='150' > ";
			 }
    switch ($eventclass) {
    case "ser":
        if ($service <> 1) $ser_html = "<h4>Service:</h4>";
        $service = 1;  
        $ser_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
        $ser_html .= " <A HREF='$eventLink' target='_blank'>$eventText</A>";
           } else {
        $ser_html .=  $eventText ;
           }
		if ($canedit)  {
        $ser_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $ser_html .=  "</li>" . PHP_EOL;
		}
        break;  
    case "fast":
        $fast = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
        if ($canedit)  {
        $fast_html .=  ae($event) ."</span>" . PHP_EOL;
		}else{
        $fast_html .=  "</span>" . PHP_EOL;
		}
        break;      
    case "fastfree":
        $fastfree = 1;  
        $fast_html .= "<span class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$fast_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $fast_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $fast_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 }
           }  else {
        $fast_html .=  $eventText ;
           }
		if ($canedit)  {
        $fast_html .=  ae($event) ."</span>" . PHP_EOL;
		}else{
        $fast_html .=  "</span>" . PHP_EOL;
		}
        break;      
    case "gf":
        $gf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$gf_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $gf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $gf_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 }
           } else {
        $gf_html .=  $eventText ;
           }
        if ($canedit)  {
        $gf_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $gf_html .=  "</li>" . PHP_EOL;
		}
        break;  
    case "lf":
        $lf_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					 $lf_html .= " <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $lf_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $lf_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 }
           } else {
        $lf_html .=  $eventText ;
           }
     if ($canedit)  {
        $lf_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $lf_html .=  "</li>" . PHP_EOL;
		}
        break;  
    case "evt":
          if (!isset($event_html)) $event_html = "<h4>Events:</h4>";
          $event_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $event_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $event_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
				     } else {
          $event_html .=  $eventText ;
           }
       if ($canedit)  {
        $event_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $event_html .=  "</li>" . PHP_EOL;
		}
        break;  
    case "read":
        $read = 1;
        $read_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					   if ($eventPopup == "locp") {
						  $read_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $read_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 } else {
          $read_html .=  $eventText ;
           }
        if ($canedit)  {
        $read_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $read_html .=  "</li>" . PHP_EOL;
		}
        break;  
    default:
        $more_html .= "<li class='$eventclass'>";
          if ($eventLink <> "") {
					 if (substr($eventLink,0,12) == "http://ocafs") {
					$more_html .=	" <A HREF='$eventLink' target='oca'> $eventText</A>";
			       } else {
					   if ($eventPopup == "locp") {
						  $more_html .=	"<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '700', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>";
						   } else {
              $more_html .= " <A HREF='$eventLink' target='_blank'> $eventText</A>";
						   }
						 }
           } else {
        $more_html .=  $eventText ;
           }
        if ($canedit)  {
        $more_html .=  ae($event) ."</li>" . PHP_EOL;
		}else{
        $more_html .=  "</li>" . PHP_EOL;
		}
        break;  
      }//	switch	
endforeach; 
    if ( $read == 1) {
         $read_html =  "<h4>Readings:</h4>" . PHP_EOL . $read_html;
         } 
		if ($hymn_html <> "") {
				$hymn_html = "<h4>Hymns:</h4>" . PHP_EOL .  $hymn_html ;
				}
    if (( $service == 0) and ($display_date["weekday"] == "Sunday" ))  {
         $ser_html .=  "<h4>Sunday service:</h4>" . PHP_EOL . "<li class='ser'> 9:40 AM - Hours</li>" . PHP_EOL;
         $ser_html .=  "<li class='ser'> 10:00 AM - Divine Liturgy</li>" . PHP_EOL; 
         } 
    if (($fastfree == 0 and $fast == 0) and (($display_date["weekday"] == "Wednesday" ) or ($display_date["weekday"] == "Friday")) ) {
         $fast_html  =  " <span class='fast'>fast day</span>" . PHP_EOL;
         } 
// Print the output ---------------------------------------------------------------------------------------------------------
//
// $dday = new MOGDate(getDate(mktime(0,0,0,$SMonth,$SDay,$SYear)));
  $dday = new MOGDate($display_date["year"] . "-".   $display_date["mon"] . "-"  . $display_date["mday"]);
//$display_date["year"] . "-".   $display_date["mon"] . "-"  . $display_date["mday"] 
       $outputcal .= "<center> " .  $dday->getTextofday() . " </center>" ; 
       $outputcal .= "<center>" . $fast_html . "</center>" . PHP_EOL ; 
       $outputcal .= "<ul>" . PHP_EOL . $ser_html . PHP_EOL ."</ul>\n<ul>" . $event_html . PHP_EOL . "</ul>" . PHP_EOL ;  
 // temp test code
 $ChurchDates = Pentecost_offset($SYear, $SMonth, $SDay, TRUE ); 
 //var_dump($ChurchDates);
 $Week_day_n = $ChurchDates['day']; //day of the week, 1 is Monday
   if (empty($read_html)) $read_html = lookup_read($ChurchDates);
       $outputcal .= "<ul>" . PHP_EOL . $read_html . PHP_EOL . "</ul>" . PHP_EOL; 
//  This section will list the Kathisma that are read. (It now is fixed for Bright week) ------------------------------------------
//
     $psalter = "<a target='prayers' href='/prayers/";
//	$popup = "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: 'Kathisma', wrapperClassName: 'titlebar' } )\" ";
		$popup = "'";
		 $outputcal .="<ul><h4>Psalter:</h4><li class='read'>" . PHP_EOL;
		if ($ChurchDates[week_of_Pascha] == 1) : //Bright week
		    $outputcal .=" No Kathisma reading, <a target='prayers' href='/prayers/brightweek-prayers/'>Brightweek Prayers</a>" . PHP_EOL;
		elseif ($ChurchDates[holyweek] == 1): //Holyweek	
    switch ($Week_day_n) {
    case 1:   //Monday  Holyweek
         $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a>(Vespers)" . PHP_EOL;
        break; 
    case 2: //Tuesday Holyweek
         $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a>(Vespers)" . PHP_EOL;
        break; 
    case 3: //Wednesday Holyweek
         $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a>(Vespers)" . PHP_EOL;
        break; 
    case 4: //Thursday Holyweek 
        $outputcal .=  "(no Kathisma reading)" . PHP_EOL;
        break; 
    case 5: //Firday Holyweek 
        $outputcal .="(no Kathisma reading)" . PHP_EOL;
        break; 
    case 6: //Saturday Holyweek 
        $outputcal .=  $psalter . "kathisma-17".$popup.">Kathisma 17</a> (Matins)" . PHP_EOL;
        break; 
    case 0: //Sunday Holyweek
        $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a>, Polyeleos (Matins)" . PHP_EOL;
        break;    
		default:
        $outputcal .= $Week_day_n . " - Holyweek?" . PHP_EOL;
    }//	switch	 
		elseif ($ChurchDates[lent] == 0):  // not lent
     switch ($Week_day_n) {
    case 1:
        if ($ChurchDates[normal] == 1):  //Monday normal
        $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Vespers)" . PHP_EOL;
        else:           //Monday  
        $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a>(Vespers)" . PHP_EOL;
        endif;
        break; 
    case 2:
        if ($ChurchDates[normal] == 1): //Tuesday normal
        $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (Vespers)" . PHP_EOL;
        else: //Tuesday  
        $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a>(Vespers)" . PHP_EOL;
        endif;
        break; 
    case 3:
        if ($ChurchDates[normal] == 1): //Wednesday normal
        $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (Vespers)" . PHP_EOL;
        else: //Wednesday 
        $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 4:
        if ($ChurchDates[normal] == 1): //Thursday normal
        $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (Vespers)" . PHP_EOL;
        else: //Thursday
        $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 5: //Friday normal
        $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        break; 
    case 6: //Saturday normal
        $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-17".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-1".$popup.">Kathisma 1</a> (Vespers)" . PHP_EOL;
        break; 
    case 0://Sunday
        $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a> (Matins)" . PHP_EOL;
        break; 
   default:
        $outputcal .=$Week_day_n . " - not lent?" . PHP_EOL;
    }//	switch	 
	 else: //Lent
    switch ($Week_day_n) {
    case 1: // Monday lent
        if ($ChurchDates[lent] == 5):  //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a> (1rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (3th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (Vespers)" . PHP_EOL;
        else: 
         $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a> (Vespers)" . PHP_EOL;
				endif;
        else: 
        $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 2: //Tuesday lent
        if ($ChurchDates[lent] == 5):    //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a> (Vespers)" . PHP_EOL;
        else:  
         $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a> (Vespers)" . PHP_EOL;
				endif;
        else: //not week 5
        $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 3: //Wednesday lent
        if ($ChurchDates[lent] == 5):     //week 5
				if ($ChurchDates[Annunciation] == 1 ):
        $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-1".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a> (9th Hour)" . PHP_EOL;
			 else:
         $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-1".$popup.">Kathisma 1</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a> (Vespers)" . PHP_EOL;
				endif;
        else: //not week 5 
        $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-1".$popup.">Kathisma 1</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-4".$popup.">Kathisma 4</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-5".$popup.">Kathisma 5</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 4: //Thursday lent
        if ($ChurchDates[lent] == 5):     //week 5
				if ($ChurchDates[Annunciation] == 1 ):
         $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a>, " . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (9th Hour)" . PHP_EOL;
        else:
	     $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
         $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (Vespers)" . PHP_EOL;
				endif;
        else: //not week 5
        $outputcal .=  $psalter . "kathisma-6".$popup.">Kathisma 6</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-7".$popup.">Kathisma 7</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-8".$popup.">Kathisma 8</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-9".$popup.">Kathisma 9</a> (1st Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-10".$popup.">Kathisma 10</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-11".$popup.">Kathisma 11</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-12".$popup.">Kathisma 12</a> (9th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        endif;
        break; 
    case 5: //Friday Lent
        $outputcal .=  $psalter . "kathisma-13".$popup.">Kathisma 13</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-14".$popup.">Kathisma 14</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-15".$popup.">Kathisma 15</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-19".$popup.">Kathisma 19</a> (3rd Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-20".$popup.">Kathisma 20</a> (6th Hour)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-18".$popup.">Kathisma 18</a> (Vespers)" . PHP_EOL;
        break; 
    case 6:  //Saturday Lent (same as normal)
        $outputcal .=  $psalter . "kathisma-16".$popup.">Kathisma 16</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-17".$popup.">Kathisma 17</a> (Matins)</li><li class='read'>" . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-1".$popup.">Kathisma 1</a> (Vespers)" . PHP_EOL;
        break; 
    case 0: //Sunday Lent (same as normal)
        $outputcal .=  $psalter . "kathisma-2".$popup.">Kathisma 2</a>, " . PHP_EOL;
        $outputcal .=  $psalter . "kathisma-3".$popup.">Kathisma 3</a> (Matins)" . PHP_EOL;
        break; 
   default:
        $outputcal .=$Week_day_n . " - Lent?" . PHP_EOL;
    }//	switch	 
	   endif;// not 1st week of Pascha
  $outputcal .="</li></ul>" . PHP_EOL;
// END Kathisma
       $outputcal .= "<ul>" . PHP_EOL . "<h4>On this day the Church remembers:</h4>" . PHP_EOL;
       $outputcal .= $gf_html . $lf_html . $more_html . PHP_EOL . "</ul>" . PHP_EOL ;
       $outputcal .= "<ul>" . PHP_EOL . $hymn_html . PHP_EOL . "</ul>" . PHP_EOL ;
       $outputcal .= "<center>". $icon_html . "</center>" . PHP_EOL;
?>				
       <?php $outputcal .= " </form>" . PHP_EOL;?>
    <?php $outputcal .= "</div>";?>
	<?php return $outputcal;?>
    <?php
}
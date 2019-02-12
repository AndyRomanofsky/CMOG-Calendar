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
    <?php $outputcal .= "<div class='wrap'>\n";?>
        <?php $outputcal .= "<h2>Events - " . $display_date["weekday"] . ", " .   $display_date["month"] . " "  .$display_date["mday"] . ", " . $display_date["year"] . "</h2>\n";?>
        <?php $outputcal .= "<div style='background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;'>\n";?>
        <?php $outputcal .= "<p>(some text) </p>\n";?>
		<?php $outputcal .= "<p> Events </p>\n";?>
        <?php $outputcal .= "</div>\n";?>
		<?php $outputcal .= "<div style='background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;'>\n";?>
        <?php $outputcal .= "</div>\n";?>
      
        <?php $outputcal .= "<form id='templates-filter' method='get'>\n";?>
		  <?php $outputcal .= "<br />\n";?>

	
		<?php $outputcal .= "Year: ";?> 
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<?php $outputcal .= "<select name='f_year' >";?>	
			<?php		
			foreach($years as  $y): 
			$outputcal .= "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $y['Year'] . "</option>\n";	
			endforeach; 
			?>
			<?php $outputcal .= "</select>";?>		
		  
		 <?php $outputcal .= " Month:";?> 
			<?php $outputcal .= "<select name='f_month' >";?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>\n	  ";?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>\n";?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>\n";?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>\n";?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>\n";?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>\n";?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>\n";?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>\n";?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>\n";?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>\n";?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>\n";?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>\n";?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>\n";?>
			<?php $outputcal .= "</select>		\n";?>
			
		<?php $outputcal .= " Day: <input type='text' name='f_day' value='" . $SDay . "'>\n"      ?>     	
			

		  <?php $outputcal .= "<input type='submit' value='Filter'>\n";?>
		  <?php $outputcal .= "<br />\n";?>
            
		
				
	<?php	

//get data



				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE (Year = $SYear or Year = -1 ) and Month = $SMonth and Day = $SDay ORDER  BY Day asc", 'ARRAY_A' ); 

//var_dump($items);
			// data for this day
//				 foreach($items as $i => $item): 
				// var_dump($item);
					 
////						$outputcal .= "<br> <span class='" . $item['Class'] . "'> " ;
//						$outputcal .= "<a href=' " . $item['Link'] ."'>";
////						$outputcal .= $item['EventText'] . "</a></span>";
//					 
// 				endforeach;  
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
      //$this->canDo = CmogCalHelper::getActions($event,'event');
	  //$canedit=$this->canDo->get('core.edit');
	  $canedit = false;
    if ($eventHymn <> "") {
		   $hymn_html .= "<li class='read'><A HREF='$eventHymn' target='_blank'>$eventText</A>";
		   if ($canedit)  {
        	$hymn_html .=  ae($event) ."</li>\n";
			}else{
		   $hymn_html .=  "</li>\n";
		 }
		} 
	  if ($eventIcon <> "") {
		  //if ((JURI::base( true ) == "") & ($eventIcon[0] == "/")) {
						   $icon_html .= "<img class='icon' src='" . $eventIcon . "' alt='$eventText' title='$eventText' height='150' > ";
						  //} else {
							//$icon_html .= "<img class='icon'src='" . JURI::base( true ) . "/" . $eventIcon . "' alt='$eventText' title='$eventText' height='150' > ";
						  //}
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
        $ser_html .=  ae($event) ."</li>\n";
		}else{
        $ser_html .=  "</li>\n";
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
        $fast_html .=  ae($event) ."</li>\n";
		}else{
        $fast_html .=  "</li>\n";
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
        $fast_html .=  ae($event) ."</span>\n";
		}else{
        $fast_html .=  "</span>\n";
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
        $gf_html .=  ae($event) ."</li>\n";
		}else{
        $gf_html .=  "</li>\n";
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
        $lf_html .=  ae($event) ."</li>\n";
		}else{
        $lf_html .=  "</li>\n";
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
        $event_html .=  ae($event) ."</li>\n";
		}else{
        $event_html .=  "</li>\n";
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
        $read_html .=  ae($event) ."</li>\n";
		}else{
        $read_html .=  "</li>\n";
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
        $more_html .=  ae($event) ."</li>\n";
		}else{
        $more_html .=  "</li>\n";
		}
        break;  
      }//	switch	
endforeach; 
    if ( $read == 1) {
         $read_html =  "<h4>Readings:</h4>$read_html";
         } 
		if ($hymn_html <> "") {
				$hymn_html = "<h4>Hymns:</h4>$hymn_html";
				}
    if (( $service == 0) and ($display_date["weekday"] == "Sunday" ))  {
         $ser_html .=  "<h4>Sunday service:</h4>\n<li class='ser'> 9:40 AM - Hours</li>\n";
         $ser_html .=  "<li class='ser'> 10:00 AM - Divine Liturgy</li>\n"; 
         } 
    if (($fastfree == 0 and $fast == 0) and (($display_date["weekday"] == "Wednesday" ) or ($display_date["weekday"] == "Friday")) ) {
         $fast_html  =  " <span class='fast'>fast day</span>\n";
         } 
// Print the output ---------------------------------------------------------------------------------------------------------
//
// $dday = new MOGDate(getDate(mktime(0,0,0,$SMonth,$SDay,$SYear)));
  $dday = new MOGDate($display_date["year"] . "-".   $display_date["mon"] . "-"  . $display_date["mday"]);
//$display_date["year"] . "-".   $display_date["mon"] . "-"  . $display_date["mday"] 
       $outputcal .= "<center> " .  $dday->getTextofday() . " </center>" ; 
       $outputcal .= "<center>" . $fast_html . "</center>\n" ; 
       $outputcal .= "<ul>\n" . $ser_html ."\n</ul>\n<ul>" . $event_html . "\n</ul>\n" ;  
 // temp test code
 $ChurchDates = Pentecost_offset($SYear, $SMonth, $SDay, TRUE ); 
 
   if (empty($read_html)) $read_html = lookup_read($ChurchDates);
       $outputcal .= "<ul>\n" . $read_html. "\n</ul>\n"; 

//  This section will list the Kathisma that are read. (It now is fixed for Bright week) ------------------------------------------
//	 STILL NEEDED

       $outputcal .= "<ul>\n<h4>On this day the Church remembers:</h4>\n";
       $outputcal .= $gf_html . $lf_html . $more_html . "\n</ul>\n" ;
       $outputcal .= "<ul>\n" . $hymn_html . "\n</ul>\n" ;
       $outputcal .= "<center>". $icon_html . "</center>\n";
?>				
       <?php $outputcal .= " </form>\n";?>
    <?php $outputcal .= "</div>";?>
	<?php return $outputcal;?>
    <?php
}
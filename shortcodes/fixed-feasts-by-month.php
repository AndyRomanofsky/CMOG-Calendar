<?php
//cmog_fixed-feasts-by-month    
add_shortcode( 'fixed_feasts_by_month', 'cmog_fixedfeastsbymonth' );
function cmog_fixedfeastsbymonth(){
	$output =PHP_EOL . "(cmog_allfixedreadings not done yet)" .PHP_EOL ;
	//return $output; \

global $wpdb; //This is used for database queries
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';
$SClass = (!empty ($_REQUEST['f_class'] )) ? $_REQUEST['f_class'] : '';

$lastEventDay = 0;

 $date = getDate();

 
 if ($SMonth == "") $SMonth = $date["mon"];

 if ($SYear == "") $SYear = $date["year"];
    $outputcal = '';
 
	
	 $display_date =   getDate(mktime(0,0,0,$SMonth,1,$SYear));
    $outputcal = '';
    ?>
	<?php $outputcal .= "<br /><h2>" .   $display_date["month"] . "</h2>" .PHP_EOL;?>


      
        <?php $outputcal .= "<form id='templates-filter' method='get'>" .PHP_EOL;?>
		  <?php $outputcal .= "<br />" .PHP_EOL;?>
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
		 $outputcal .= "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>" .PHP_EOL; 
		} ?>


		  
		 <?php $outputcal .= " Month:" .PHP_EOL;?> 
			<?php $outputcal .= "<select name='f_month' >" .PHP_EOL;?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>" .PHP_EOL;?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>" .PHP_EOL;?>
			<?php $outputcal .= "</select>		" .PHP_EOL;?>

		  <?php $outputcal .= "<input type='submit' value='Filter'>" .PHP_EOL;?>
		  <?php $outputcal .= "<br />" .PHP_EOL;?>
            
			<?php //$outputcal .= " <input type='hidden' name='page' value=''";?><?php // $outputcal .= $_REQUEST['page'] ?><?php //$outputcal .= " />";?>
            

				
	<?php	

//get data


	$WhereClass = " and ((Class = 'saint') or (Class = 'gf') or (Class = 'lf')) ";


	 
// needs to be just feasts (saints)
	$items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE  Year = -1  and Month = $SMonth $WhereClass ORDER  BY Day asc", 'ARRAY_A' ); 


	// Build  the report
	//$this->items = $this->get('Items');
	//foreach($this->items as $i => $row): 
			$outputcal .= "<ul>";
	foreach($items as $i => $row): 
		$event=$row['ID'];	
		$eventclass=$row['Class'];
		$eventLink=$row['Link'];
		$eventPopup=$row['popup'];
		$eventIcon=$row['icon'];
		$eventHymn=$row['hymn'];
		$eventText=$row['EventText'];
		$eventDay=$row['Day'];
		if ($eventDay <> $lastEventDay	) {
			$lastEventDay =  $eventDay;
			$outputcal .= "</ul><hr /><ul>" .PHP_EOL;
			if (29 == $eventDay and  2 == $SMonth) $outputcal .= "(Leap years only)<br />" .PHP_EOL;
		}

		$outputcal .= "<li class=".$eventclass."> " . $eventDay . " - " ;
		if ($eventLink <> "") {
			if (substr($eventLink,0,12) == "http://ocafs") {
				$outputcal .= "<A HREF='$eventLink' target='oca'> $eventText</A>" ;
			} else {
				if ($eventPopup == "locp") {
					$outputcal .= "<A HREF='" . $eventLink . "?tmpl=component&print=1&page=' onclick=\"return hs.htmlExpand(this,{objectType: 'iframe', width: '678', headingText: '" . $eventText . "', wrapperClassName: 'titlebar' } )\">" . $eventText . " </a>" ;
				} else {
					$outputcal .= "<A HREF='$eventLink' target=_blank> $eventText</A>" ;
				}	
			}
		} else {
			$outputcal .= $eventText;
		}
		if ($eventHymn <> "") {
			$outputcal .= " - <A HREF='$eventHymn' target=_blank>(hymn)</A> " ;
		} else {
			// echo( " - no hymn " );
			$outputcal .= "  " ;
		} 
		if ($eventIcon <> "") {
			$outputcal .= " - <A HREF='$eventIcon' target=_blank>(icon)</A>" ;
		} else {
			// echo( " - no icon " );
			$outputcal .= " "  ;
			//echo( " - <img src='$eventIcon' alt='$eventText' title='$eventText' height='100' > ");
		}
		$outputcal .= "</li> ".PHP_EOL ;	 
	endforeach; // while
	$outputcal .= "</ul></small>" ;
    $outputcal .= " </form>" .PHP_EOL;
    $outputcal .= "</div>\n\n\n" .PHP_EOL;
	return $outputcal;	
}
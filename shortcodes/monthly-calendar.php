<?php
//cmog_monthly_calendar    
 
add_shortcode( 'cmog_calendar', 'cmog_monthly_calendar' );
function cmog_monthly_calendar(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

global $wpdb; //This is used for database queries
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';
$SClass = (!empty ($_REQUEST['f_class'] )) ? $_REQUEST['f_class'] : '';


 $date = getDate();

 
 if ($SMonth == "") $SMonth = $date["mon"];

 if ($SYear == "") $SYear = $date["year"];
    $outputcal = '';
    ?>
    <?php $outputcal .= "<div class='wrap'>";?>
        <?php $outputcal .= "<h2>Events</h2>";?>
        <?php $outputcal .= "<div style='background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;'>";?>
        <?php $outputcal .= "<p>(some text) </p>";?>
		<?php $outputcal .= "<p> Events </p>";?>
        <?php $outputcal .= "</div>";?>
		<?php $outputcal .= "<div style='background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;'>";?>
        <?php $outputcal .= "</div>";?>
      
        <?php $outputcal .= "<form id='templates-filter' method='get'>";?>
		  <?php $outputcal .= "<br />";?>
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
		 $outputcal .= "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>"; 
		} ?>
		<?php $outputcal .= "Show Every Year: <input type='checkbox' name='f_every_year' value='Yes'";?> <?php if ('Yes' == $EveryYear  ) $outputcal .= ' checked';?>  <?php $outputcal .= ">";?>
		<?php $outputcal .= "Year: ";?> 
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<?php $outputcal .= "<select name='f_year' >";?>	
			<?php		
			foreach($years as  $y): 
			$outputcal .= "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $y['Year'] . "</option>;";	
			endforeach; 
			?>
			<?php $outputcal .= "</select>";?>		
		  
		 <?php $outputcal .= " Month:";?> 
			<?php $outputcal .= "<select name='f_month' >";?>	
			<?php $outputcal .= "<option value= '' ";?><?php if (  $SMonth == null  )  $outputcal .= " selected ";?><?php $outputcal .= "></option>;	  ";?>
			<?php $outputcal .= "<option value= 1 ";?><?php if (   $SMonth == 1  )  $outputcal .= " selected ";?><?php $outputcal .= ">January</option>;";?>
			<?php $outputcal .= "<option value= 2 ";?><?php if (   $SMonth == 2  )  $outputcal .= " selected ";?><?php $outputcal .= ">February</option>;";?>
			<?php $outputcal .= "<option value= 3 ";?><?php if (   $SMonth == 3  )  $outputcal .= " selected ";?><?php $outputcal .= ">March</option>;";?>
			<?php $outputcal .= "<option value= 4 ";?><?php if (   $SMonth == 4  )  $outputcal .= " selected ";?><?php $outputcal .= ">April</option>;";?>
			<?php $outputcal .= "<option value= 5 ";?><?php if (  $SMonth == 5  )  $outputcal .= " selected ";?><?php $outputcal .= ">May</option>;";?>
			<?php $outputcal .= "<option value= 6 ";?><?php if (  $SMonth == 6  )  $outputcal .= " selected ";?><?php $outputcal .= ">June</option>;";?>
			<?php $outputcal .= "<option value= 7 ";?><?php if (  $SMonth == 7  )  $outputcal .= " selected ";?><?php $outputcal .= ">July</option>;";?>
			<?php $outputcal .= "<option value= 8 ";?><?php if (  $SMonth == 8  )  $outputcal .= " selected ";?><?php $outputcal .= ">August</option>;";?>
			<?php $outputcal .= "<option value= 9 ";?><?php if (  $SMonth == 9  )  $outputcal .= " selected ";?><?php $outputcal .= ">September</option>;";?>
			<?php $outputcal .= "<option value= 10 ";?><?php if (  $SMonth == 10  )  $outputcal .= " selected ";?><?php $outputcal .= ">October</option>;";?>
			<?php $outputcal .= "<option value= 11 ";?><?php if (  $SMonth == 11  )  $outputcal .= " selected ";?><?php $outputcal .= ">November</option>;";?>
			<?php $outputcal .= "<option value= 12 ";?><?php if (  $SMonth == 12  )  $outputcal .= " selected ";?><?php $outputcal .= ">December</option>;";?>
			<?php $outputcal .= "</select>		";?>
		<?php $outputcal .= "Class:";?>  
			<?php
			$classes = $wpdb->get_results( "SELECT DISTINCT `Class` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?> 
			<?php $outputcal .= "<select name='f_class' >";?>		
			<?php $outputcal .= " <option value=''></option>;	";?>
			<?php
			foreach($classes as  $c): 
			$outputcal .= "<option value=" . $c['Class'] ; 
			if (  $SClass == $c['Class']  )  $outputcal .= " selected "; 
			$outputcal .= ">" . $c['Class'] . "</option>;";	
			endforeach; 
			?>
			<?php $outputcal .= "</select> ";?>
		  <?php $outputcal .= "<input type='submit' value='Filter'>";?>
		  <?php $outputcal .= "<br />";?>
            
			<?php //$outputcal .= " <input type='hidden' name='page' value=''";?><?php // $outputcal .= $_REQUEST['page'] ?><?php //$outputcal .= " />";?>
            
			<?php $outputcal .= "<table class='adminlist' style='border-collapse: collapse; border: 1px solid black;'>";?>
				<?php $outputcal .= "<thead><tr>";?>
					<?php $outputcal .= "<td  width='2%' class='dayhead'><small> </small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Sunday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Monday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Tuesday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Wednesday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Thursday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Friday</small></td>";?>
					<?php $outputcal .= "<td  width='14%' class='dayhead'><small>Saturday</small></td>";?>
				<?php $outputcal .= "</tr></thead>";?>
				<?php $outputcal .= "<tfoot><tr>";?>
					<?php $outputcal .= "<td colspan='8'>foot</td>";?>
				<?php $outputcal .= "</tr></tfoot>";?>
             <?php $outputcal .= "   <tbody>";?>
				
	<?php	

//get data

if (!empty($SClass) ) {
	$WhereClass = " and Class = '" . $SClass . "' ";
	} else {
	$WhereClass = "";
	}
if ("Yes" == $EveryYear){
				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE (Year = $SYear or Year = -1 ) and Month = $SMonth $WhereClass ORDER  BY Day asc", 'ARRAY_A' ); 
} else {
				 $items = $wpdb->get_results( "SELECT * FROM `" . $wpdb->prefix . "cmog_events` WHERE Year = $SYear  and Month = $SMonth $WhereClass ORDER BY Day asc", 'ARRAY_A' ); 
}
//var_dump($items);
         $this_month = getDate(mktime(0, 0, 0, $SMonth, 1, $SYear));
         $next_month = getDate(mktime(0, 0, 0, $SMonth + 1, 1, $SYear));
   

         //Find out when this month starts and ends.
         $first_week_day = $this_month["wday"];
         $days_in_this_month = round(($next_month[0] - $this_month[0]) / (60 * 60 * 24));
         
      $last_sunday = getDate(MKTIME(0, 0, 0, $SMonth,(1 - $first_week_day), $SYear)) ;        
         // Top of caendar



//Fill the first week of the month with the appropriate number of blanks if needed.
         if ($first_week_day <> 0) {
         $outputcal .=("<tr>");
		 
          $outputcal .=("<td class=weeklable><small>".Pentecost_offset($last_sunday["year"],$last_sunday["mon"], $last_sunday["mday"]) . "</small></td>");
     $top_skip = $first_week_day;
     $outputcal .=("<td  colspan=\"$top_skip\" class=\"blank\"> </td>");
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0){
               $outputcal .= "</tr><tr border='0'>" ;
            $outputcal .= "<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>" ;
                               }
               $outputcal .= "<td  valign='top' class='day' border='1' ><table hight='100%'class='daytable' ><tr border='1' valign='top'><td border='1' valign='top'>" ;
			$outputcal .= "<tr><td border='1' ><a href='admin.php?f_year=" . $SYear . "&f_month=" . $SMonth . "&f_day=" . $day_counter . "&page=cmog_list_events'>".$day_counter."</a></td><tr>";// need: to add every year flag (and class)
			 
			// data for this day
				 foreach($items as $i => $item): 
				// var_dump($item);
					if ( $item['Day'] == $day_counter) {
						$outputcal .= "<tr><td><span class='" . $item['Class'] . "'> " ;
						$outputcal .= "<a href=' " . $item['Link'] ."'>";
						$outputcal .= $item['EventText'] . "</a></span></td><tr>";
					}
				endforeach;  
             $outputcal .=( "</table></td>"); 
            $week_day++;
            }		
	?>			
				<?php $outputcal .= "</tbody>";?>
			<?php $outputcal .= "</table>";?>
       <?php $outputcal .= " </form>";?>
    <?php $outputcal .= "</div>";?>
	<?php return $outputcal;?>
    <?php
}
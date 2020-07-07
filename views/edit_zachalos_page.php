<?php
/** edit_zachalos_page 
*/

/** cmog_render_edit_zachalos_page
This is for the Movable template only
*/
function cmog_render_edit_zachalos_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} ?>
	
	 <div class="wrap">
	<?php if ($id) {
			$submit = "Update "?> 
		<h2>Update Zachalos</h2>
	<?php } else { 
			$submit = "Add"?>
		<h2>Add new Zachalos</h2>
	<?php }   ?>
	</div>
	<?php
	$table = $wpdb->prefix . "cmog66_oc_zachalos";
	global $wpdb; //This is used only if making any database queries
	//var_dump($_REQUEST);
	/**  template update **/
		if ($id) {
		 	if ((isset($_REQUEST['action'])) and ($_REQUEST['action'] == 'update'   )){
					//echo "<div class='notice notice-success is-dismissible'>";
					check_admin_referer( 'cmog_movable-update');
					$data	 = array(  
                    'zaNum' => $_REQUEST['zaNum'],
                    'zaBook' => $_REQUEST['zaBook'],
                    'zaDisplay'  => $_REQUEST['zaDisplay'],
			        'zaLink'  => $_REQUEST['zaLink'],
                    'zaSdisplay'  => $_REQUEST['zaSdisplay'],
                    'zaDesc' => $_REQUEST['zaDesc'],
                    'zaPreverse' => $_REQUEST['zaPreverse'],
                    'zaPrefix' => $_REQUEST['zaPrefix'],
                    'zaPrefixb'  => $_REQUEST['zaPrefixb'],
                    'zaVerses'  => $_REQUEST['zaVerses'],
                    'zaSuffix'  => $_REQUEST['zaSuffix'],
                    'zaFlag'  => $_REQUEST['zaFlag'],
                    'zaId' => $_REQUEST['zaId'],	
					);
					$format =  array( 
					
                    '%s', // zaNum   
                    '%s', // zaBook 
                    '%s', // zaDisplay   
			        '%s', // zaLink 
                    '%s', // zaSdisplay 
                    '%s', // zaDesc   
                    '%s', // zaPreverse 
                    '%s', // zaPrefix 
                    '%s', // zaPrefixb 
                    '%s', // zaVerses 
                    '%s', // zaSuffix 
                    '%d', // zaFlag 
                    '%d', // zaId 	
					);
					$rownumber = $wpdb->replace( $table, $data, $format ); 
					if ($rownumber) {
					echo "<div class='notice notice-success is-dismissible'>";
					echo  '<br />Updated '. $_REQUEST['zaDisplay'] . '<br /></div>' ;
					} else {
					echo "<div class='notice notice-error is-dismissible'>";
					echo "<br />No zachalos updated. <br /></div>";
					}
				}		 	
		}
	if ($id == 'update' ) {
		$id = $wpdb->insert_id;
	}
/** read from database/   ***/	
	
	
	if ($id) { // id  = 0 is add not edit
        global $wpdb; //This is used only if making any database queries
				 $row = $wpdb->get_row( "SELECT * FROM `$table` where zaId = $id  ", 'ARRAY_A' ); 
				if ($row == null)    echo "No data"; 
    } else {
		$row['zaId'] = $row['zaFlag'] = $row['zaSuffix'] =$row['zaVerses'] = $row['zaPrefixb'] = $row['zaPrefix'] = $row['zaPreverse'] = $row['zaDesc'] = "";
		$row['zaSdisplay'] = $row['zaLink'] = $row['zaDisplay'] =$row['zaBook'] = $row['zaNum'] = "";
		$row['AddDate'] = "?"; 
	} 
    //$cmog_template_type =  (int)(!empty($row['gmd'])) ? $row['gmd'] : ''; //If no sort, default to null
    ?>

        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(Update/Add template info here) </p>
			<p> Zachalos  </p>
			
				<?php if ($id) { 
				
				Echo "<p>Reading " . $row['zaNum'] . " from " . $row['zaBook'] . "</p>";
						
				if (1 <> zaDesc) {
				Echo "<p>(" .  $row['zaDesc'] . ")</p>";
				}				
				if ($row['zaLink']) {
					echo "<p><a href='" . $row['zaLink']  .  "' target='_blank'>" . $row['zaDisplay'] ." </p></a>";
				}else{
				echo "<p>" . $row['zaDisplay'] ." </p>";
				}
			}?>
			
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get">

			<input type="submit" value="<?php echo $submit;?>">
			<?php if ("Add" == $submit ){;?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_zachalos" >Cancel</a>
			<?php } else { ?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_zachalos&published=<?php echo $row['published']?>" >Close</a>
			<?php }  ?>
  <br />
  		   <input type="hidden" id="page" name="page" value="cmog_list_zachalos">
		   <input type="hidden" id="action" name="action" value="update">
	<?php cmog_input_text_r('zaNum', $row,'zaNum'); ?>
	<?php cmog_input_text_r('zaBook', $row,'zaBook'); ?>
	<?php cmog_input_text_r('zaDisplay', $row,'zaDisplay'); ?>
	<?php cmog_input_text_r('zaLink', $row,'zaLink'); ?>
	<?php cmog_input_text_r('zaSdisplay', $row,'zaSdisplay'); ?>
	<?php cmog_input_text('zaDesc', $row,'zaDesc'); ?>
	<?php cmog_input_text('zaPreverse', $row,'zaPreverse'); ?>
	<?php cmog_input_text('zaPrefix', $row,'zaPrefix'); ?>
	<?php cmog_input_text('zaPrefixb', $row,'zaPrefixb'); ?>
	<?php cmog_input_text('zaVerses', $row,'zaVerses'); ?>
	<?php cmog_input_text('zaSuffix', $row,'zaSuffix'); ?>
	<?php cmog_input_text('zaFlag', $row,'zaFlag'); ?>
	<?php cmog_input_text('zaId', $row,'zaId'); ?>
            <?php
  			if(! isset($_REQUEST['_wpnonce'])){
			wp_nonce_field('cmog_movable-update'); 
			}else{ ?>
			<input type="hidden" name='_wpnonce'   value="<?php echo $_REQUEST['_wpnonce'];?>">
			<input type="hidden" name='_wp_http_referer'   value="<?php echo $_REQUEST['_wp_http_referer'];?>">
			<?php }
			?>

 
  <br /> * required field<br />
			</form>
	</div>	 
    </div>
    <?php
}


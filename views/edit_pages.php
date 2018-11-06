<?php
/** Helper functions for edit fields. **/
/** Render a for text fields. **/
function cmog_input_text($field, $row, $label=null, $id=null  ){
	if ( empty($label)) $label = $field; 
	if ( empty($id))	$id = $field; 
	$value = $row[$field];
    echo "<label for=$id>$label:</label><br />";
    echo "<input type='text' name='$field' id='$id'   value='$value'  ><br />";
}
/** Render a for text fields. Required **/
function cmog_input_text_r($field, $row, $label=null, $id=null  ){
	if ( empty($label)) $label = $field; 
	if ( empty($id))	$id = $field; 
	$value = $row[$field];
    echo "<label class='required' for=$id>$label:</label> *<br />";
    echo "<input type='text' name='$field' id='$id'   value='$value' required ><br />";
}
/** cmog_render_edit_page (templates)
This is for the all templates except Movable
*/
function cmog_render_edit_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	if ($id) { // id  = 0 is add not edit
        global $wpdb; //This is used only if making any database queries
				 $row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_templates` where ID = $id  ", 'ARRAY_A' ); 
				 if ( null == $row ) { 
				 echo "<br />Template $id no longer exists.<br />";
				 echo "<button onclick='history.go(-1);'>Close </button>";


						return false;
				 }
    } else {
		$row['ID'] = $row['EventText'] = $row['week'] =$row['wday'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
	<?php if ($id) { ?>
		<h2>Update CMOG Template</h2>
	<?php } else {  ?>
		<h2>Add new CMOG Template</h2>
	<?php }   ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(Update/Add template info here) </p>
			<p> Template type is <?php echo $cmog_template_type; ?>  </p>
			
			
			
				<?php 
				if ($id) { 
				echo "<p>";
				switch ($row['wday']) {
					case 0:
					echo "Sunday (1st day)" ;
					break;
					case 1:
					echo "Monday" ;
					break;
					case 2:
					echo "Tuesday" ;
					break;
					case 3:
					echo "Wednesday" ;
					break;
					case 4:
					echo "Thursday" ;
					break;
					case 5:
					echo "Friday" ;
					break;
					case 6:
					echo "Saturday" ;
					break;
					case 7:
					echo "Sunday (Last day)" ;
					break;
					default:
					echo "?" ;
				}	
				echo " of week " . $row['week'] . " ";
				
				switch ($row['gmd']) {
					case -5:
					echo " of Pascha";
					break;
					case -4:
					echo " of the Triodion";
					break;
					case -3:
					echo " of Luke";
					break;
					case -2:
					echo " after Pentecost";
					break;
					default:
					echo "?" ;
				}
				echo "</p>";
				
				
				if ($row['Link']) {
					echo "<a href='" . $row['Link']  .  "' target='_blank'><p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p></a>";
				}else{
				echo "<p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p>";
				}
				if ($row['icon']) {
				echo "<img src='" . $row['icon'] . "' alt='icon'   height='60'>";
				}
 			}?>
			
			
			
			
        </div>
        <!-- Form Add/Edit template-->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get"	>
       <fieldset>
          <legend>Selecting elements</legend>
		   <input type="hidden" id="page" name="page" value="cmog_list_luke">
		   <input type="hidden" id="action" name="action" value="update">
  <br />
  <?php cmog_input_text_r('EventText', $row,'Event'); ?>
  week:<br />
  <input type="number" name='week'   value="<?php echo $row['week']; ?>" min="1" max="52" >
  <br />
  wday: *<br />
  <select name='wday' required>  
				<option></option>
 				 <option value="0" <?php if  ( 0 == $row['wday']) echo " selected ";?>>Sunday (1st day)</option>
  				 <option value="1" <?php if  ( 1 == $row['wday']) echo " selected ";?>>Monday</option>
				 <option value="2" <?php if  ( 2 == $row['wday']) echo " selected ";?>>Tuesday</option>
				 <option value="3" <?php if  ( 3 == $row['wday']) echo " selected ";?>>Wednesday</option>
				 <option value="4" <?php if  ( 4 == $row['wday']) echo " selected ";?>>Thursday</option>
				 <option value="5" <?php if  ( 5 == $row['wday']) echo " selected ";?>>Friday</option>
				 <option value="6" <?php if  ( 6 == $row['wday']) echo " selected ";?>>Saturday</option>
				 <option value="7" <?php if  ( 7 == $row['wday']) echo " selected ";?>>Sunday (Last day)</option>
  </select>				 
  <br />
  <?php cmog_input_text('Link', $row,'Link to use'); ?>
  <?php cmog_input_text('icon', $row,'Icon to use'); ?>
  <?php cmog_input_text('hymn', $row,'Hymn to use'); ?>
  Class: *<br />
    <select name='Class' required>
						<option></option>
						<option value="gf" <?php if  ( "gf" == $row['Class']) echo " selected ";?>>Great Feast</option>
                        <option value="lf" <?php if  ( "lf" == $row['Class']) echo " selected ";?>>Lesser Feast</option>
                        <option value="saint" <?php if  ( "saint" == $row['Class']) echo " selected ";?>>Feast such a Saint day (not on month view)</option>
                        <option value="evt" <?php if  ( "evt" == $row['Class']) echo " selected ";?>>Event</option>
                        <option value="ser" <?php if  ( "ser" == $row['Class']) echo " selected ";?>>Service</option>
                        <option value="read" <?php if  ( "read" == $row['Class']) echo " selected ";?>>Reading</option>
                        <option value="fast" <?php if  ( "fast" == $row['Class']) echo " selected ";?>>Fast day</option>
                        <option value="fastfree" <?php if  ( "fastfree" == $row['Class']) echo " selected ";?>>Fast Free day</option>
                        <option value="memory" <?php if  ( "memory" == $row['Class']) echo " selected ";?>>Parish Bulletin Memory (not on month view)</option>
                        <option value="health" <?php if  ( "health" == $row['Class']) echo " selected ";?>>Parish Bulletin Health (not on month view)</option>
    </select>	
  <br />
  <?php cmog_input_text('AddDate', $row,'Date Added'); ?>
    <?php cmog_input_text('listorder', $row,'Order'); ?>
    <?php cmog_input_text('popup', $row,'Display code'); ?>
    <?php cmog_input_text('asset_id', $row); ?>
    <?php cmog_input_text('catid', $row); ?>
    <?php cmog_input_text('created_by', $row,'Created by'); ?>  
	Template type: *<br />
  <select name='gmd' required >
				<option></option>
				 <option value="-5" <?php if  ( -5 == $row['gmd']) echo " selected ";?>>Pascha</option>
  				 <option value="-4" <?php if  ( -4 == $row['gmd']) echo " selected ";?>>Triodion</option>
				 <option value="-3" <?php if  ( -3 == $row['gmd']) echo " selected ";?>>Luke</option>
				 <option value="-2" <?php if  ( -2 == $row['gmd']) echo " selected ";?>>Pentecost</option>
				 <option value="-1" <?php if  ( -1 == $row['gmd']) echo " selected ";?>>Movable</option>
  </select>	
  <br />
  Status:<br />
			<select name='published' >
				<option value= -2 <?php if  ( -2 == $row['published']) echo " selected ";?>> Trashed</option>
				<option value= -1 <?php if  ( -1 == $row['published']) echo " selected ";?>> Archived</option>
				<option value= 0 <?php if  ( 0 == $row['published']) echo " selected ";?>> Draft</option>
				<option value= 1 <?php if  ( 1 == $row['published']) echo " selected ";?>> Published</option>
			</select>	
			<br />

	<hr />
  ID:<br />
  <input type="text" name='ID'  readonly  value="<?php echo $row['ID']; ?>">
  <br />
    <?php cmog_input_text('access', $row,'Access'); ?>
    <?php cmog_input_text('language', $row,'Language'); ?>
    <input type="submit" value="Submit">
  <br />	
  </fieldset>
  <br /> * required field<br />
			</form>
	</div>	 
    </div>
    <?php
}
/** cmog_render_edit_Movable_page
This is for the Movable template only
*/
function cmog_render_edit_Movable_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} ?>
	
	 <div class="wrap">
	<?php if ($id) {
			$submit = "Update "?> 
		<h2>Update Movable Template</h2>
	<?php } else { 
			$submit = "Add"?>
		<h2>Add new Movable Template</h2>
	<?php }   ?>
	</div>
	
	
	
	<?php
	global $wpdb; //This is used only if making any database queries
	//var_dump($_REQUEST);
	
	/** Luke templateLuke template update **/
		if ($id) {
		 	if ((isset($_REQUEST['action'])) and ($_REQUEST['action'] == 'update'   )){
					echo "<div class='notice notice-success is-dismissible'>";
					check_admin_referer( 'cmog_movable-update');
					$data	 = array(  
					'EventText' => $_REQUEST['EventText'],
					'Class' => $_REQUEST['Class'],
					'Offset' => $_REQUEST['Offset'],
					'Length' => $_REQUEST['Length'],
					'Link' => $_REQUEST['Link'],
					'icon' => $_REQUEST['icon'],
					'hymn' => $_REQUEST['hymn'],
					'published' => $_REQUEST['published'],
					'access' => $_REQUEST['access'],
					'language' => $_REQUEST['language'],
					'ID' => $_REQUEST['ID'],
					'AddDate' => $_REQUEST['AddDate'],
					'listorder' => $_REQUEST['listorder'],
					'popup' => $_REQUEST['popup'],
					'asset_id' => $_REQUEST['asset_id'],
					'catid' => $_REQUEST['catid'],
					'created_by' => $_REQUEST['created_by'],
					'gmd' =>  $_REQUEST['gmd'],
					);
					$table = $wpdb->prefix . "cmog_moveableevent";
					$format =  array( 
							'%s', // EventText
							'%s', // Class
							'%d', // Offset
							'%d', // Length
							'%s', // Link
							'%s', // icon
							'%s', // hymn
							
							'%d', // published
							'%d', // access
							'%s', // language
							'%d', // ID
					  		'%s', // AddDate
							'%d', // listorder
							'%s', // popup
							'%d', // asset_id
							'%d', // catid
							'%d', // created_by
							'%d', // gmd
					);
					$rownumber = $wpdb->replace( $table, $data, $format ); 
					if ($rownumber) { 
						echo "<br /> row " . $rownumber . " updated.";
					echo  '<br />Updated '. $_REQUEST['EventText'] . '</div>' ;
					} else {
						echo "<br />No rows updated. </div>";
					//$sendback = remove_query_arg( array('trashed', 'untrashed', 'deleted', 'locked', 'ids'), wp_get_referer() );
					//$sendback = remove_query_arg( array('action' ), wp_get_referer() );
					}
				}		 	
		}
	if ($id == 'update' ) {
		$id = $wpdb->insert_id;
	}
/** read from database/   ***/	
	
	
	if ($id) { // id  = 0 is add not edit
        global $wpdb; //This is used only if making any database queries
				 $row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_moveableevent` where ID = $id  ", 'ARRAY_A' ); 
				if ($row == null)    echo "No data"; 
    } else {
		$row['ID'] = $row['EventText'] = $row['Offset'] =$row['Length'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
    //$cmog_template_type =  (int)(!empty($row['gmd'])) ? $row['gmd'] : ''; //If no sort, default to null
    ?>

        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(Update/Add template info here) </p>
			<p> Template type is Movable  </p>
			
				<?php if ($id) { 
				
				Echo "<p>" . $row['Offset'] . " days from Pascha.</p>";
				
				
				
				if (1 <> $row['Length']) {
				Echo "<p>For " .  $row['Length'] . " days.</p>";
				}
				
				
				/*if (-1 == $row['Year']){
				echo  $row['Month'] . "/" . $row['Day'] . "/(every year)<br />";
				} else{
				echo  $row['Month'] . "/" . $row['Day'] . "/" . $row['Year'] . "<br />";
				}*/
				
				
				if ($row['Link']) {
					echo "<a href='" . $row['Link']  .  "' target='_blank'><p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p></a>";
				}else{
				echo "<p class='" . $row['Class'] ."'>" . $row['EventText'] ." </p>";
				}
				if ($row['icon']) {
				echo "<img src='" . $row['icon'] . "' alt='icon'   height='60'>";
				}
			}?>
			
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get">

			<input type="submit" value="<?php echo $submit;?>">
			<?php if ("Add" == $submit ){;?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_movable" >Cancel</a>
			<?php } else { ?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_movable&published=<?php echo $row['published']?>" >Close</a>
			<?php }  ?>
  <br />
  		   <input type="hidden" id="page" name="page" value="cmog_list_movable">
		   <input type="hidden" id="action" name="action" value="update">
	<?php cmog_input_text_r('EventText', $row,'Event'); ?>
	<?php cmog_input_text_r('Offset', $row,'Offset'); ?>
	<?php cmog_input_text_r('Length', $row,'Length'); ?>
	<?php cmog_input_text('Link', $row,'Link'); ?>
	<?php cmog_input_text('icon', $row,'Icon to use'); ?>
	<?php cmog_input_text('hymn', $row,'Hymn to use'); ?>
  Class:<br />
    <select name='Class' >
                        <option value="gf" <?php if  ( "gf" == $row['Class']) echo " selected ";?>>Great Feast</option>
                        <option value="lf" <?php if  ( "lf" == $row['Class']) echo " selected ";?>>Lesser Feast</option>
                        <option value="saint" <?php if  ( "saint" == $row['Class']) echo " selected ";?>>Feast such as a Saint day (not on month view)</option>
                        <option value="evt" <?php if  ( "evt" == $row['Class']) echo " selected ";?>>Event</option>
                        <option value="ser" <?php if  ( "ser" == $row['Class']) echo " selected ";?>>Service</option>
                        <option value="read" <?php if  ( "read" == $row['Class']) echo " selected ";?>>Reading</option>
                        <option value="fast" <?php if  ( "fast" == $row['Class']) echo " selected ";?>>Fast day</option>
                        <option value="fastfree" <?php if  ( "fastfree" == $row['Class']) echo " selected ";?>>Fast Free day</option>
                        <option value="memory" <?php if  ( "memory" == $row['Class']) echo " selected ";?>>Parish Bulletin Memory (not on month view)</option>
                        <option value="health" <?php if  ( "health" == $row['Class']) echo " selected ";?>>Parish Bulletin Health (not on month view)</option>
    </select>	
	<hr />
  <br />
  <?php cmog_input_text('AddDate', $row,'Date Added'); ?>
    <?php cmog_input_text('listorder', $row,'Order'); ?>
    <?php cmog_input_text('popup', $row,'Display code'); ?>
    <?php cmog_input_text('asset_id', $row); ?>
    <?php cmog_input_text('catid', $row); ?>
    <?php cmog_input_text('created_by', $row,'Created by'); ?>  
	Template type:<br />
  <select name='gmd'   >
				 <option value=" -1"  selected >Movable</option>
  </select>	
  <br />
  ID:<br />
  <input type="text" name='ID'  readonly  value="<?php echo $row['ID']; ?>">
  <br />
  Status:<br />
			<select name='published' >
				<option value= -2 <?php if  ( -2 == $row['published']) echo " selected ";?>> Trashed</option>
				<option value= -1 <?php if  ( -1 == $row['published']) echo " selected ";?>> Archived</option>
				<option value= 0 <?php if  ( 0 == $row['published']) echo " selected ";?>> Draft</option>
				<option value= 1 <?php if  ( 1 == $row['published']) echo " selected ";?>> Published</option>
			</select>	
			<br />
    <?php cmog_input_text('access', $row,'Access'); ?>
    <?php cmog_input_text('language', $row,'Language'); ?>
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



/** cmog_render_edit_luke_page
This is for the Luke templates only
*/
function cmog_render_edit_luke_page($id){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}  ?>
	<div class="wrap">
	<?php if ($id) {
			$submit = "Update "?>
	<h2>Update Luke template</h2>
	<?php } else {  
			$submit = "Add"?>
	<h2>Add new Luke template</h2>
	<?php }  ?>
	</div>
	<?php
	global $wpdb; //This is used only if making any database queries
	//var_dump($_REQUEST);
	
	/** Luke templateLuke template update **/
		if ($id) {
		 	if ((isset($_REQUEST['action'])) and ($_REQUEST['action'] == 'update'   )){
					echo "<div class='notice notice-success is-dismissible'>";
					check_admin_referer( 'cmog-luke-update');
					$data	 = array(  
					'EventText' => $_REQUEST['EventText'],
					'Class' => $_REQUEST['Class'],
					'week' => $_REQUEST['week'],
					'wday' => $_REQUEST['wday'],
					'Link' => $_REQUEST['Link'],
					'icon' => $_REQUEST['icon'],
					'hymn' => $_REQUEST['hymn'],
					'published' => $_REQUEST['published'],
					'access' => $_REQUEST['access'],
					'language' => $_REQUEST['language'],
					'ID' => $_REQUEST['ID'],
					'AddDate' => $_REQUEST['AddDate'],
					'listorder' => $_REQUEST['listorder'],
					'popup' => $_REQUEST['popup'],
					'asset_id' => $_REQUEST['asset_id'],
					'catid' => $_REQUEST['catid'],
					'created_by' => $_REQUEST['created_by'],
					'gmd' =>  $_REQUEST['gmd'],
					);
					$table = $wpdb->prefix . "cmog_templates";
					$format =  array( 
							'%s', // EventText
							'%s', // Class
							'%d', // week
							'%d', // wday
							'%s', // Link
							'%s', // icon
							'%s', // hymn
							'%d', // published
							'%d', // access
							'%s', // language
							'%d', // ID
					  		'%s', // AddDate
							'%d', // listorder
							'%s', // popup
							'%d', // asset_id
							'%d', // catid
							'%d', // created_by
							'%d', // gmd
					);
					$rownumber = $wpdb->replace( $table, $data, $format ); 
					if ($rownumber) { 
						echo "<br /> row " . $rownumber . " updated.";
					echo  '<br />Updated '. $_REQUEST['EventText'] . '</div>' ;
					} else {
						echo "<br />No rows updated. </div>";
					//$sendback = remove_query_arg( array('trashed', 'untrashed', 'deleted', 'locked', 'ids'), wp_get_referer() );
					//$sendback = remove_query_arg( array('action' ), wp_get_referer() );
					}
				}		 	
		}
	if ($id == 'update' ) {
		$id = $wpdb->insert_id;
	}
/** read from database/   ***/	
	if ($id) { // id  = 0 is add not edit
		$row = $wpdb->get_row( "SELECT * FROM `cmog66_cmog_templates` where ID = $id  ", 'ARRAY_A' ); 
		if ($row == null)    echo "No data (" . $id . ")"; 
	} else {
		$row['ID'] = $row['EventText'] = $row['week'] =$row['wday'] = $row['Link'] = $row['Class'] = $row['icon'] = $row['hymn'] = "";
		$row['listorder'] = $row['popup'] = $row['asset_id'] =$row['catid'] = $row['created_by'] = $row['gmd'] = $row['published'] = $row['access'] = $row['language'] = "";
		$row['AddDate'] = "?"; 
	} 
	$cmog_template_type =  (int)(!empty($row['gmd'])) ? $row['gmd'] : ''; //If no sort, default to null
	?>
	 
	<div class="wrap">
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
			<p>(Update/Add Luke template info here) new</p>
			<p> Luke </p>
        <!-- display row here-->
			
		</div>
        <!-- Form Add/Edit template-->
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">			
			<form id="templates-edit" method="get"	>

			<input type="submit" value="<?php echo $submit;?>">
			<?php if ("Add" == $submit ){;?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_luke" >Cancel</a>
			<?php } else { ?>
			<a class="button" href="/wp-admin/admin.php?page=cmog_list_luke&published=<?php echo $row['published']?>" >Close</a>
			<?php }  ?>
       <fieldset>
          <legend>Selecting elements</legend>
		   <input type="hidden" id="page" name="page" value="cmog_list_luke">
		   <input type="hidden" id="action" name="action" value="update">
  <br />
  <?php cmog_input_text_r('EventText', $row,'Event'); ?>
  week:<br />
  <input type="number" name='week'   value="<?php echo $row['week']; ?>" min="1" max="52" >
  <br />
  wday: *<br />
  <select name='wday' required>  
				<option></option>
 				 <option value="0" <?php if  ( 0 == $row['wday']) echo " selected ";?>>Sunday (1st day)</option>
  				 <option value="1" <?php if  ( 1 == $row['wday']) echo " selected ";?>>Monday</option>
				 <option value="2" <?php if  ( 2 == $row['wday']) echo " selected ";?>>Tuesday</option>
				 <option value="3" <?php if  ( 3 == $row['wday']) echo " selected ";?>>Wednesday</option>
				 <option value="4" <?php if  ( 4 == $row['wday']) echo " selected ";?>>Thursday</option>
				 <option value="5" <?php if  ( 5 == $row['wday']) echo " selected ";?>>Friday</option>
				 <option value="6" <?php if  ( 6 == $row['wday']) echo " selected ";?>>Saturday</option>
				 <option value="7" <?php if  ( 7 == $row['wday']) echo " selected ";?>>Sunday (Last day)</option>
  </select>				 
  <br />
  <?php cmog_input_text('Link', $row,'Link to use'); ?>
  <?php cmog_input_text('icon', $row,'Icon to use'); ?>
  <?php cmog_input_text('hymn', $row,'Hymn to use'); ?>
  Class: *<br />
    <select name='Class' required>
						<option></option>
						<option value="gf" <?php if  ( "gf" == $row['Class']) echo " selected ";?>>Great Feast</option>
                        <option value="lf" <?php if  ( "lf" == $row['Class']) echo " selected ";?>>Lesser Feast</option>
                        <option value="saint" <?php if  ( "saint" == $row['Class']) echo " selected ";?>>Feast such a Saint day (not on month view)</option>
                        <option value="evt" <?php if  ( "evt" == $row['Class']) echo " selected ";?>>Event</option>
                        <option value="ser" <?php if  ( "ser" == $row['Class']) echo " selected ";?>>Service</option>
                        <option value="read" <?php if  ( "read" == $row['Class']) echo " selected ";?>>Reading</option>
                        <option value="fast" <?php if  ( "fast" == $row['Class']) echo " selected ";?>>Fast day</option>
                        <option value="fastfree" <?php if  ( "fastfree" == $row['Class']) echo " selected ";?>>Fast Free day</option>
                        <option value="memory" <?php if  ( "memory" == $row['Class']) echo " selected ";?>>Parish Bulletin Memory (not on month view)</option>
                        <option value="health" <?php if  ( "health" == $row['Class']) echo " selected ";?>>Parish Bulletin Health (not on month view)</option>
    </select>	
  <br />
  <?php cmog_input_text('AddDate', $row,'Date Added'); ?>
    <?php cmog_input_text('listorder', $row,'Order'); ?>
    <?php cmog_input_text('popup', $row,'Display code'); ?>
    <?php cmog_input_text('asset_id', $row); ?>
    <?php cmog_input_text('catid', $row); ?>
    <?php cmog_input_text('created_by', $row,'Created by'); ?>  
	Template type: *<br />
  <select name='gmd' required >
				 <option value="-3" selected >Luke</option>
  </select>	
  <br />
  Status:<br />
			<select name='published' >
				<option value= -2 <?php if  ( -2 == $row['published']) echo " selected ";?>> Trashed</option>
				<option value= -1 <?php if  ( -1 == $row['published']) echo " selected ";?>> Archived</option>
				<option value= 0 <?php if  ( 0 == $row['published']) echo " selected ";?>> Draft</option>
				<option value= 1 <?php if  ( 1 == $row['published']) echo " selected ";?>> Published</option>
			</select>	
			<br />

	<hr />
  ID:<br />
  <input type="text" name='ID'  readonly  value="<?php echo $row['ID']; ?>">
  <br />
    <?php cmog_input_text('access', $row,'Access'); ?>
    <?php cmog_input_text('language', $row,'Language'); ?>
  <br />	
            <?php
  			if(! isset($_REQUEST['_wpnonce'])){
			wp_nonce_field('cmog-luke-update'); 
			}else{ ?>
			<input type="hidden" name='_wpnonce'   value="<?php echo $_REQUEST['_wpnonce'];?>">
			<input type="hidden" name='_wp_http_referer'   value="<?php echo $_REQUEST['_wp_http_referer'];?>">
			<?php }
			?>
  </fieldset>
  <br /> * required field<br />
			</form>
	</div>	 
    </div>
    <?php
}
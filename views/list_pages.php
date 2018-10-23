<?php
/** **************** function cmog_render_list_page ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items();
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>CMOG Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is All CMOG Templates </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_templates`  GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(2 =>"?", 1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_test'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_test&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Luke list page ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function  cmog_render_luke_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();  
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-3);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Luke Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Luke Templates </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_templates` WHERE gmd = -3 GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(2 =>"?", 1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_luke'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_luke&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Pentecost list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_pentecost_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-2);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Pentecost Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Pentecost Templates  </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_templates` WHERE gmd = -2 GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(2 =>"?", 1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_pentecos'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_pentecos&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Pascha list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_pascha_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-5);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Pascha Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Pascha Templates  </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_templates` WHERE gmd = -5 GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(2 =>"?", 1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_pascha'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_pascha&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Triodion list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_triodion_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateListTable = new CMOG_Template_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateListTable->prepare_items(-4);
	if( 'edit' === $TemplateListTable->current_action() | 'add' === $TemplateListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Triodion Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is Triodion Templates  </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_templates` WHERE gmd = -4 GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(2 =>"?", 1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_triodion'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_triodion&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateListTable->display() ?>
        </form>
    </div>
    <?php
}
/** *************************** RENDER Movable list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_movable_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
    //Create an instance of our package class...
    $TemplateMovableListTable = new CMOG_Movable_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $TemplateMovableListTable->prepare_items();
	if( 'edit' === $TemplateMovableListTable->current_action() | 'add' === $TemplateMovableListTable->current_action()) RETURN;
    $cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
    ?>
    <div class="wrap">
        <h2>Movable Templates</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(template info here) </p>
			<p> Template type is the Movable Templates </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_moveableevent` GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_movable'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_movable&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
            <?php $TemplateMovableListTable->display() ?>
        </form>
    </div>
    <?php
}
//cmog_render_events_list_page
/** *************************** RENDER Events list PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_events_list_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
echo "<br> request: " ;  var_dump($_REQUEST);
echo "<br> post: " ;  var_dump($_POST);
echo "<br> get: " ;  var_dump($_GET);
echo "<br> " ;
echo "<br> server url: " ;  var_dump($_SERVER["REQUEST_URI"]);

    //Create an instance of our package class...
    $Events_List = new CMOG_Events_List_Table();
    //Fetch, prepare, sort, and filter our data...
    $Events_List->prepare_items(); 
	if( 'edit' === $Events_List->current_action() | 'add' === $Events_List->current_action()) RETURN;
	if( 'Calendar' === $Events_List->current_action()) {
		//cmog_render_events_calendar_page();
	
	}
    $cmog_template_type =  (int)(!empty($_REQUEST['f_gmd'])) ? $_REQUEST['f_gmd'] : ''; //If no sort, default to null
	global $wpdb; //This is used only if making any database queries
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';

$SGmd = (!empty ($_REQUEST['f_gmd'] )) ? $_REQUEST['f_gmd'] : '';

 //$date = getDate(); 
// if ($SMonth == "") $SMonth = $date["mon"];
 //if ($SYear == "") $SYear = $date["year"];
    ?>
    <div class="wrap">
        <h2>Events</h2> 
		<a href="/wp-admin/admin.php?page=cmog_list_events&action=add&event=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
		<a href="/wp-admin/admin.php?page=cmog_month_calendaer" class="page-title-action">Calendaer</a>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(some text) </p>
			<p> Events </p>
        </div>
		<div>
		  
<?php $counts = $wpdb->get_results( "SELECT COUNT(ID), published FROM `" . $wpdb->prefix . "cmog_events` GROUP BY published ORDER BY published  DESC ", 'ARRAY_A' ); ?>
<?php $cl =  array(1 =>"Published", 0 =>"Draft", -1 =>"Archived" , -2 =>"Trashed");

			$total = 0;
			foreach($counts as  $c): 
			if ( $c['published'] == 0 | $c['published'] == 1){
			$total += $c['COUNT(ID)'];
			}
			endforeach; 
			echo "<br /><a  href='/wp-admin/admin.php?page=cmog_list_events'> All </a>($total)";
			foreach($counts as  $c): 
			echo " | <a  href='/wp-admin/admin.php?page=cmog_list_events&published=" . $c['published']. "'>" . $cl[$c['published']] ; 
			echo "</a> (" . $c['COUNT(ID)'] . ") ";	
			endforeach; 
			?><br />
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <br />
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
		Show Every Year: <input type="checkbox" name="f_every_year" value="Yes" <?php if ('Yes' == $EveryYear  ) echo ' checked';?>  >
		Year:  
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<select name='f_year' >	
			<?php
			echo "<option value=''> </option>;";	
			foreach($years as  $y): 
			echo "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  echo " selected "; 
			echo ">" . $y['Year'] . "</option>;";	
			endforeach; 
			?>
			</select>		
		  
		  Month: 
			<select name='f_month' >	
			<option value= "" <?php if (  $SMonth == null  )  echo " selected ";?>></option>;	  
			<option value= 1 <?php if (   $SMonth == 1  )  echo " selected ";?>>January</option>;
			<option value= 2 <?php if (   $SMonth == 2  )  echo " selected ";?>>February</option>;
			<option value= 3 <?php if (   $SMonth == 3  )  echo " selected ";?>>March</option>;
			<option value= 4 <?php if (   $SMonth == 4  )  echo " selected ";?>>April</option>;
			<option value= 5 <?php if (  $SMonth == 5  )  echo " selected ";?>>May</option>;
			<option value= 6 <?php if (  $SMonth == 6  )  echo " selected ";?>>June</option>;
			<option value= 7 <?php if (  $SMonth == 7  )  echo " selected ";?>>July</option>;
			<option value= 8 <?php if (  $SMonth == 8  )  echo " selected ";?>>August</option>;
			<option value= 9 <?php if (  $SMonth == 9  )  echo " selected ";?>>September</option>;
			<option value= 10 <?php if (  $SMonth == 10  )  echo " selected ";?>>October</option>;
			<option value= 11 <?php if (  $SMonth == 11  )  echo " selected ";?>>November</option>;
			<option value= 12 <?php if (  $SMonth == 12  )  echo " selected ";?>>December</option>;
			</select>				
		  
		  Day: <input type="text" name='f_day' <?php if ( !empty($_REQUEST['f_day'] ))     echo "Value='" . $_REQUEST['f_day'] . "'";?>> 
		  
		  Template:
			 <select name='f_gmd' >
				<option></option>
				 <option value="any" <?php if  ( "any" == $SGmd) echo " selected ";?>>From any template</option>
				 <option value="none" <?php if  ( "none" == $SGmd) echo " selected ";?>>Not from a template</option>
				 <option value="-5"  <?php if  ( -5 == $SGmd) echo " selected ";?>>Pascha template</option>
  				 <option value="-4" <?php if  ( -4 == $SGmd) echo " selected ";?>>Triodion template</option>
				 <option value="-3" <?php if  ( -3 == $SGmd) echo " selected ";?>>Luke template</option>
				 <option value="-2" <?php if  ( -2 == $SGmd) echo " selected ";?>>Pentecost template</option>
				 <option value="-1" <?php if  ( -1 == $SGmd) echo " selected ";?>>Movable template</option>
			 </select>	
		  
		  
		  <input type="submit" value='Filter'>
		  <br />
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->

            <?php $Events_List->display() ?>
        </form>
    </div>
    <?php
}
//cmog_render_events_calendar_page
/** *************************** RENDER calendar PAGE ********************************
 *******************************************************************************
 * This function renders the admin page and the template list table. Although it's
 * possible to call prepare_items() and display() from the constructor, there
 * are often times where you may need to include logic here between those steps,
 * so we've instead called those methods explicitly. It keeps things flexible, and
 * it's the way the list tables are used in the WordPress core.
 */
function cmog_render_events_calendar_page(){
	if ( !current_user_can( 'manage_options' ) )  	{
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
global $wpdb; //This is used only if making any database queries
$SMonth = (!empty($_REQUEST['f_month'] )) ? $_REQUEST['f_month'] : '';
$SYear = (!empty ($_REQUEST['f_year'] )) ? $_REQUEST['f_year'] : '';
$EveryYear = (!empty ($_REQUEST['f_every_year'] )) ? $_REQUEST['f_every_year'] : '';
$SClass = (!empty ($_REQUEST['f_class'] )) ? $_REQUEST['f_class'] : '';
$screen = get_current_screen();
//var_dump($screen);
 $date = getDate();
//$state= $this->get('state');
//$SMonth = $state->get('filter.month');  
 if ($SMonth == "") $SMonth = $date["mon"];
//$SYear = $state->get('filter.year');
 if ($SYear == "") $SYear = $date["year"];
    ?>
    <div class="wrap">
        <h2>Events</h2> 
		<?php cmog_top_menu(); ?>
        <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
            <p>(some text) </p>
			<p> Events </p>
        </div>
		<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
        </div>
        <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
        <form id="templates-filter" method="get">
		  <br />
		  <?php if ( array_key_exists('published',$_REQUEST )) {
			//$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
			echo "<input type='hidden' id='published' name='published' value='" . $_REQUEST['published'] . "'>";
		} ?>
		Show Every Year: <input type="checkbox" name="f_every_year" value="Yes" <?php if ('Yes' == $EveryYear  ) echo ' checked';?>  >
		Year:  
			<?php
			$years = $wpdb->get_results( "SELECT DISTINCT `Year` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?>
			<select name='f_year' >	
			<?php		
			foreach($years as  $y): 
			echo "<option value=" . $y['Year'] ; 
			if (  $SYear == $y['Year']  )  echo " selected "; 
			echo ">" . $y['Year'] . "</option>;";	
			endforeach; 
			?>
			</select>		
		  
		  Month: 
			<select name='f_month' >	
			<option value= "" <?php if (  $SMonth == null  )  echo " selected ";?>></option>;	  
			<option value= 1 <?php if (   $SMonth == 1  )  echo " selected ";?>>January</option>;
			<option value= 2 <?php if (   $SMonth == 2  )  echo " selected ";?>>February</option>;
			<option value= 3 <?php if (   $SMonth == 3  )  echo " selected ";?>>March</option>;
			<option value= 4 <?php if (   $SMonth == 4  )  echo " selected ";?>>April</option>;
			<option value= 5 <?php if (  $SMonth == 5  )  echo " selected ";?>>May</option>;
			<option value= 6 <?php if (  $SMonth == 6  )  echo " selected ";?>>June</option>;
			<option value= 7 <?php if (  $SMonth == 7  )  echo " selected ";?>>July</option>;
			<option value= 8 <?php if (  $SMonth == 8  )  echo " selected ";?>>August</option>;
			<option value= 9 <?php if (  $SMonth == 9  )  echo " selected ";?>>September</option>;
			<option value= 10 <?php if (  $SMonth == 10  )  echo " selected ";?>>October</option>;
			<option value= 11 <?php if (  $SMonth == 11  )  echo " selected ";?>>November</option>;
			<option value= 12 <?php if (  $SMonth == 12  )  echo " selected ";?>>December</option>;
			</select>		
		Class:  
			<?php
			$classes = $wpdb->get_results( "SELECT DISTINCT `Class` FROM `" . $wpdb->prefix . "cmog_events`", 'ARRAY_A' ); 
			?> 
			<select name='f_class' >		
			echo "<option value=''></option>;";	
			<?php
			foreach($classes as  $c): 
			echo "<option value=" . $c['Class'] ; 
			if (  $SClass == $c['Class']  )  echo " selected "; 
			echo ">" . $c['Class'] . "</option>;";	
			endforeach; 
			?>
			</select> 
		  <input type="submit" value='Filter'>
		  <br />
            <!-- For plugins, we also need to ensure that the form posts back to our current page -->
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <!-- Now we can render the completed list table -->
			<table class="adminlist" style="border-collapse: collapse; border: 1px solid black;">
				<thead><tr>
					<td  width='2%' class='dayhead'><small> </small></td>
					<td  width='14%' class='dayhead'><small>Sunday</small></td>
					<td  width='14%' class='dayhead'><small>Monday</small></td>
					<td  width='14%' class='dayhead'><small>Tuesday</small></td>
					<td  width='14%' class='dayhead'><small>Wednesday</small></td>
					<td  width='14%' class='dayhead'><small>Thursday</small></td>
					<td  width='14%' class='dayhead'><small>Friday</small></td>
					<td  width='14%' class='dayhead'><small>Saturday</small></td>
				</tr></thead>
				<tfoot><tr>
					<td colspan="8">foot</td>
				</tr></tfoot>
                <tbody>
				
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
         echo("<tr>");
     //    echo("Year = ". $last_sunday["year"]." month = " . $last_sunday["mon"] . "day = " . $last_sunday["mday"]. "</small></td>");
        //  echo("<td class=weeklable><small>" . $SYear . $SMonth . "1"  . "</small></td>");
          echo("<td class=weeklable><small>".Pentecost_offset($last_sunday["year"],$last_sunday["mon"], $last_sunday["mday"]) . "</small></td>");
     $top_skip = $first_week_day;
     echo("<td  colspan=\"$top_skip\" class=\"blank\"> </td>");
         }
         $week_day = $first_week_day;
         for($day_counter = 1; $day_counter <= $days_in_this_month; $day_counter++)
            {
            $week_day %= 7;

            if($week_day == 0){
               echo "</tr><tr border='0'>" ;
			   //Pentecost_offset($I_year, $I_month, $I_day)
             //   echo("<td class=weeklable><small>" . $SYear . $SMonth . $day_counter . "</small></td>");
            echo "<td class=weeklable><small>".Pentecost_offset($SYear,$SMonth,$day_counter) . "</small></td>" ;
                               }
               echo "<td  valign='top' class='day' border='1' ><table hight='100%'class='daytable' ><tr border='1' valign='top'><td border='1' valign='top'>" ;
            // echo "<big><b><A HREF=" ;
			//   echo(JRoute::_('index.php?option=com_cmogcal&view=events&filter_year='.$SYear.'&filter_month='.$SMonth.'&filter_day='.$day_counter ).">");
			 // echo $day_counter;
			 //  echo "</a></b></big></td></tr>" ;
            //echo"<tr><td border='1' ><small>data for $SMonth/$day_counter/$SYear</small></td><tr>" ;
			echo "<tr><td border='1' ><a href='admin.php?f_year=" . $SYear . "&f_month=" . $SMonth . "&f_day=" . $day_counter . "&page=cmog_list_events'>".$day_counter."</a></td><tr>";// need to add every year flag (and class)
			 
			// data for this day
				 foreach($items as $i => $item): 
				// var_dump($item);
					if ( $item['Day'] == $day_counter) {
						echo "<tr><td><span class='" . $item['Class'] . "'>      " ;
						echo "<a href='/wp-admin/admin.php?page=cmog_list_events&action=edit&event=". $item['ID']  ."'>";
						echo $item['EventText'] . "</a></span></td><tr>";
						//echo $item['EventText'] . "</span></td><tr>" ;
						/**if ( $item->icon){	
							if ((JURI::root( true ) == "") & ($item->icon[0] == "/")) {
								echo  "<img src='" . $item->icon ."'  height='42' width='42'><br>" ;
							}else{	
								echo  "<img src='" . JURI::root( true ) . "/" . $item->icon ."'  height='42' width='42'><br>" ;	
							}  
							echo  "<b>Icon: </b>" . $item->icon ."<br>" ;  		
						}**/							
					}
				endforeach;  
             echo( "</table></td>"); 
            $week_day++;
            }		
	?>			
				</tbody>
			</table>
        </form>
    </div>
    <?php
}

/** *************************** RENDER top menu PAGE part********************************
 *******************************************************************************
 */
function cmog_top_menu(){
	?>
		<a href="/wp-admin?page=cmog_list_test&action=add&template=0" class="page-title-action">Add New</a>
		<a href="/wp-admin/admin.php?page=cmog_list_luke" class="page-title-action">Luke Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pentecos" class="page-title-action">Pentecost Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_pascha" class="page-title-action">Pascha Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_triodion" class="page-title-action">Triodion Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_movable" class="page-title-action">Movable Templates</a>
		<a href="/wp-admin/admin.php?page=cmog_list_events" class="page-title-action">Events</a>
		<a href="/wp-admin/admin.php?page=cmog_month_calendaer" class="page-title-action">Calendaer</a>
	<?php
}
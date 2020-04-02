<?php
/************************** CREATE A PACKAGE CLASS ****CMOG_Movable_List_Table**
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 */
class CMOG_Readings_List_Table extends WP_List_Table {
    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'reading',     //singular name of the listed records
            'plural'    => 'readings',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }
/** this removes 'fixed' from the table classes **/	
	protected function get_table_classes() {
    return array( 'widefat',  'striped', $this->_args['plural'] );
}
	    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For template, if the class needs to process a column
     * named 'EventText', it would first see if a method named $this->column_EventText() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_EventText() method later on, this method doesn't
     * need to concern itself with any column with a name of 'EventText'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
       function column_default($item, $column_name){  
        switch($column_name){
            case 'reMonth' :
            case 'reDay'  :
            case 'rePday' :
            case 'reType'  :
            case 'reDesc' :
            case 'reBook' :
            case 'reNum' :
            case 'reIndex'  :
            case 'reFlag' :
            case 'reId' :
			     return $item[$column_name];
            default:
                return  "? - ". $column_name . "?";
        }
    }
	 
    /** ************************************************************************
     * Recommended. This is a custom column method and is responsible for what
     * is rendered in any column with a name/slug of 'EventText'. Every time the class
     * needs to render a column, it first looks for a method named 
     * column_{$column_EventText} - if it exists, that method is run. If it doesn't
     * exist, column_default() is called instead.
     * 
     * This template also illustrates how to implement rollover actions. Actions
     * should be an associative array formatted as 'slug'=>'link html' - and you
     * will need to generate the URLs yourself. You could even ensure the links
     * 
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (Template title only)
     **************************************************************************/
    function column_EventText($item){
        //Build row actions
        $returnurl = $_SERVER['REQUEST_URI'];
		if( 0 == $item['published'] ){ //draft
		$actions = array(	
            'edit'      => sprintf('<a href="?page=%s&action=%s&template=%s">Edit</a>',$_REQUEST['page'],'edit',$item['daId']),
            'trash'    => sprintf('<a href="?page=%s&action=%s&template=%s">Trash</a>',$_REQUEST['page'],'trash',$item['daId']),
            'publish'    => sprintf('<a href="?page=%s&action=%s&template=%s">Publish</a>',$_REQUEST['page'],'publish',$item['daId']),
        );
		$row_status = " <b>(Draft)</b>";
		} elseif ( -2 == $item['published'] ){ //trash
		$actions = array(	
            'delete'    => sprintf('<a href="?page=%s&action=%s&template=%s">Delete</a>',$_REQUEST['page'],'delete',$item['daId']),
            'draft'    => sprintf('<a href="?page=%s&action=%s&template=%s">Draft</a>',$_REQUEST['page'],'draft',$item['daId']),
            'publish'    => sprintf('<a href="?page=%s&action=%s&template=%s">Publish</a>',$_REQUEST['page'],'publish',$item['daId']),
        );
		$row_status = " <b>(In Trash)</b>";
		} elseif ( -1 == $item['published'] ){ //archived
		$actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&template=%s">Edit</a>',$_REQUEST['page'],'edit',$item['daId']),
            'trash'    => sprintf('<a href="?page=%s&action=%s&template=%s">Trash</a>',$_REQUEST['page'],'trash',$item['daId']),
        );
		$row_status = " <b>(Archived)</b>";
		} else { // published 
		$actions = array(			
            'edit'      => sprintf('<a href="?page=%s&action=%s&template=%s">Edit</a>',$_REQUEST['page'],'edit',$item['daId']),
            'draft'    => sprintf('<a href="?page=%s&action=%s&template=%s">Draft</a>',$_REQUEST['page'],'draft',$item['daId']),
            'trash'    => sprintf('<a href="?page=%s&action=%s&template=%s">Trash</a>',$_REQUEST['page'],'trash',$item['daId']),
        );
		$row_status = "";
		}
 
         return $item['EventText'] . $row_status . $this->row_actions($actions);
    }
    /** ************************************************************************
     * REQUIRED if displaying checkboxes or using bulk actions! The 'cb' column
     * is given special treatment when columns are processed. It ALWAYS needs to
     * have it's own method.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (EventText only)
     **************************************************************************/
    function column_cb($item){
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            /*$1%s*/ $this->_args['singular'],  //Let's simply repurpose the table's singular label ("movable")
            /*$2%s*/ $item['daId']                //The value of the checkbox should be the record's id
        );
    }
	
    function column_reMonth($item){
		switch($item['reMonth']){
            case 0  : return "(movable)";
            case 1  : return "January";
            case  2  : return "February";
            case  3  : return "March";
            case  4  : return "April";
            case  5  : return "May";
            case  6  : return "June";
            case  7  : return "July";
            case  8  : return "August";
            case  9  : return "September";
            case  10  : return "October";
            case  11  : return "November";
            case  12  : return "December";
            default:
                 return "?";
                //return print_r($item,true); //Show the item for troubleshooting purposes
        }
	} 
    function column_gmd($item){
		 switch($item['gmd']){
            case -5: return "Pascha";
            case -4  : return "Triodion";
            case  -3  : return "Luke";
            case  -2  : return "Pentecost";
            case  -1  : return "Movable";
            default:
                return print_r($item,true); //Show the item for troubleshooting purposes
        }
	}
    function column_wday($item){
		switch($item['wday']){
            case 0: return "Sunday";
            case 1  : return "Monday";
            case  2  : return "Tuesday";
            case  3  : return "Wednesday";
            case  4  : return "Thursday";
            case  5  : return "Friday";
            case  6  : return "Saturday";
            case  7  : return "Sunday";
            default:
                return print_r($item,true); //Show the item for troubleshooting purposes
        }
	}
	function column_published($item){
		         //  'tmplt_id' /
				 if (empty($item['published']))	 RETURN ;
		 switch($item['published']){
            case -2: return "Trashed"; 
            case -1: return "Archived"; 
            case 0  : return "Draft"; 
            case 1  : return "Published"; 
            default:
                return "(" . $item['published'] . ")";
        }
	}
	function column_Link($item){
		$out = "";
		if ( $item['Link'] ) $out .=  "Link: <a href='" . $item['Link'] . "' target='_blank'>" . $item['Link'] . "</a><br />";
		if ( $item['hymn'] ) $out .=  "Hymn: <a href='" . $item['hymn'] . "' target='_blank'>" . $item['hymn'] . "</a><br />";
		if ( $item['icon'] ) $out .=  "<img src='" . $item['icon'] . "' alt='icon'   height='50'><br />";
		return $out;
	}
    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    /*
            case 'reMonth' :
            case 'reDay'  :
            case 'rePday' :
            case 'reType'  :
            case 'reDesc' :
            case 'reBook' :
            case 'reNum' :
            case 'reIndex'  :
            case 'reFlag' :
            case 'reId' :
	*/
	function get_columns(){
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'reMonth'     => 'Month',
            'reDay'     => 'Day',
            'rePday'     => 'P Day',
            'reType'     => 'Type',
             'reDesc'      => 'Desc.',
            'reBook'      => 'Book',
             'reNum'     => 'Number',
            'reIndex'     => 'Index',
             'reFlag'     => 'Flag',
             'reId'     => 'ID',
        );
	  return $columns;
	}
    function get_hidden(){
        $hidden = array(
             'reFlag' ,
        );
        return $hidden;
    }
    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items() and sort
     * your data accordingly (usually by modifying your query).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns(){ 
        $sortable_columns = array(
            'rePday'     => array('rePday',false),     //true means it's already sorted
            'reDay'    => array('reDay',false),            
            'reMonth'    => array('reMonth',false),            
			'reId'  => array('reId',false),
			'reType'  => array('reType',false),
			'reBook'   => array('reBook',false),
			'reIndex'   => array('reIndex',false),
			'reNum'  => array('reNum',false),
			
        ); 
        return $sortable_columns;
    }
    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
		parse_str($_SERVER['QUERY_STRING'], $query); 
		if (array_key_exists('published',$query)){
			switch($query['published']){	
			  case 0  :	//Draft
				$actions = array(
					'trash'   => 'Trash',
					'publish'    => 'Publish',
				);
				return $actions;
			  case 1  :	 //Published
				$actions = array(
					'trash'   => 'Trash',
					'draft'    => 'Draft',
				);
				return $actions;
			  case -1  :	// Archived
				$actions = array(
					'trash'   => 'Trash',
					'publish'    => 'Publish',
				);
				return $actions;
			  case  -2  :	// Trashed
				$actions = array(
					'publish'    => 'Publish',
					'draft'    => 'Draft',
					'delete' => 'Delete',
				);
				return $actions;
			  default:
                return ;
			}	
		} else {
			$actions = array(
					'trash'   => 'Trash',
			);
		}
        return $actions;
    }
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this template package, we will handle it in the class to keep things
     * clean and organized.
     * (For now all actions processed here)
     * @see $this->prepare_items()
     **************************************************************************/

    function process_bulk_action() {
		global $wpdb;
	
		parse_str($_SERVER['QUERY_STRING'], $query); 
/** template trash **/		
	        if( 'trash'===$this->current_action() ) {
				if (!isset($query['template']) and !isset($_POST['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for the trash!</div>' ;
					RETURN;
				}
			
			if (is_array($_REQUEST['template'])){
				$values = $_REQUEST['template'];
				
					echo "<div class='notice notice-success is-dismissible'>";
						// (code to trash many row)
					$table = $wpdb->prefix . "cmog_templates";
					$data	 = array( 'published' => -2);
					$format =  array( '%d');
					echo  	'<br /> (bulk) ';
					foreach ( $values as $value ) {
						$where  = array ('zaId' => $value);
						$wpdb->update( $table, $data, $where, $format ); 	
						echo  '<br />template ' .  $value . ' moved to the trash.' ;
					}				 
					echo '</div>';
			} else {
				$id = $_REQUEST['template'];
				echo "<div class='notice notice-success is-dismissible'>";
					// (code to trash row)
				$where  = array ('zaId' => $id);
				$table = $wpdb->prefix . "cmog_templates";
				$data	 = array( 'published' => -2);
				$format =  array( '%d');
				$wpdb->update( $table, $data, $where, $format ); 	
			 	echo  '<br />template ' .  $id . ' moved to the trash.</div>' ;
			} 
			}

/** template delete **/		
	        if( 'delete'===$this->current_action() ) {
				if (!isset($query['template']) and !isset($_POST['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked to delete!</div>' ;
					RETURN;
				} 
			if (array_key_exists('template',$_REQUEST)){
				$values = $_REQUEST['template'];
			echo "<div class='notice notice-success is-dismissible'>";
				// (code to delete many row)
				$table = $wpdb->prefix . "cmog_templates";
				$format =  array( '%d');
				echo  	'<br /> (bulk) <br />';
				foreach ( $values as $value ){
					$where  = array ('ID' => $value);
					$wpdb->delete( $table,  $where, $format ); 					
					echo  "<br />Deleted " . $value . "!";
					} 
				echo '</div>';
			} else {
			$id = $_REQUEST;
			echo "<div class='notice notice-success is-dismissible'>";
				// (code to delete row)
				$where  = array ('zaId' => $id);
				$table = $wpdb->prefix . "cmog_templates";
				$format =  array( '%d');
				$wpdb->delete( $table,  $where, $format ); 
				echo  '<br />deleted ' .  $id . ' !</div>' ;
			} 
        }   
/** template publish **/
	        if( 'publish'===$this->current_action() ) {
				if (!isset($_REQUEST['template']) and !isset($_REQUEST['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked to be publish!</div>' ;
					RETURN;
				}
			
			if (is_array($_REQUEST['template'])){
				$values = $_REQUEST['template'];
				
					echo "<div class='notice notice-success is-dismissible'>";
						// (code to publish many row)
					$table = $wpdb->prefix . "cmog_templates";
					$data	 = array( 'published' => 1 );
					$format =  array( '%d');
					echo  	'<br /> (bulk) ';
					foreach ( $values as $value ) {
						$where  = array ('ID' => $value);
						$wpdb->update( $table, $data, $where, $format ); 	
						echo  '<br />template ' .  $value . '   published.' ;
					}				 
					echo '</div>';
			} else {
				$id = $_REQUEST['template'];
				echo "<div class='notice notice-success is-dismissible'>";
					// (code to publish row)
				$where  = array ('ID' => $id);
				$table = $wpdb->prefix . "cmog_templates";
				$data	 = array( 'published' => 1);
				$format =  array( '%d');
				$wpdb->update( $table, $data, $where, $format ); 	
				echo  '<br />template ' .  $id  . '   published.' ;	 
				echo '</div>';
			} 
			}

/** template draft **/
	        if( 'draft'===$this->current_action() ) {
				if (!isset($_REQUEST['template']) and !isset($_REQUEST['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked to be set to draft!</div>' ;
					RETURN;
				}
			
			if (array_key_exists('template',$_REQUEST)){
				$values = $_REQUEST['template'];
				 if (is_array($values)){
				
					echo "<div class='notice notice-success is-dismissible'>b";
						// (code to draft many row)cmog-template-update
					$table = $wpdb->prefix . "cmog_templates";
					$data	 = array( 'published' => 0 );
					$format =  array( '%d');
					echo  	'<br /> (bulk) ';
					foreach ( $values as $value ) {
						$where  = array ('zaId' => $value);
						$wpdb->update( $table, $data, $where, $format ); 	
						echo  '<br />template ' .  $value . ' set to draft.' ;
					}				 
					echo '</div>';
					} else {
					$id = $values;
					echo "<div class='notice notice-success is-dismissible'>s";
						// (code to draft row)
					$where  = array ('zaId' => $id);
					$table = $wpdb->prefix . "cmog_templates";
					$data	 = array( 'published' => 0);
					$format =  array( '%d');
					$wpdb->update( $table, $data, $where, $format ); 	
					echo  '<br />template ' .  $id . ' set to draft.<br /></div>' ;
					} 
			}
			}
/** template edit **/
		if ('edit'===$this->current_action() ){
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for edit!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to edit many row)
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not bulk edit at this time) <br /></div>';
			} else {
				// (code to edit row)  
				cmog_render_edit_Movable_page($id);
				exit;
			}
        }  
/** template add **/    
		if( 'add'===$this->current_action() ) {
				//if (!isset($query['template'])) {
				//	echo "<div class='notice notice-success is-dismissible'>";
				//	echo  '<br />No rows are checked for add!</div>' ;
				//	RETURN;
				//}
			//$id = $query['template'];
			//if (is_array($id)){
				// (code to add many row)
			//	echo "<div class='notice notice-error is-dismissible'>";
			//	echo  	'<br /> (can not bulk add at this time) <br /></div>';
			//} else {
				// (code to add row)  
				cmog_render_edit_Movable_page(0);
				exit;
			//}
        }    
/** template reload **/
		if( 'reload'===$this->current_action() ) {
				if (!isset($query['template'])) {
					echo "<div class='notice notice-error is-dismissible'>";
					echo  '<br />No rows are checked for reload!</div>' ;
					RETURN;
				}
			$id = $query['template'];
			if (is_array($id)){
				// (code to reload many row)
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not bulk reload at this time) <br /></div>';
			} else {
				// (code to reload row)  
				echo "<div class='notice notice-error is-dismissible'>";
				echo  	'<br /> (can not reload at this time) <br /></div>';
			}
        } 
/** template update **/    
		if( 'update'===$this->current_action() ) {

				// (code to add row)  
				cmog_render_edit_Movable_page("update");
				exit;

        }    


	}
    /** ************************************************************************ 
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items($cmog_template_type='ALL') {

        global $wpdb; //This is used only if making any database queries
        /**
         * First, lets decide how many records per page to show
         */
		 
		 // get the current user ID
		$user = get_current_user_id();
		// get the current admin screen
		$screen = get_current_screen();
		// retrieve the "per_page" option
		$screen_option = $screen->get_option('per_page', 'option'); 
		
		// retrieve the value of the option stored for the current user
		$per_page = get_user_meta($user, $screen_option, true);
		//var_dump($per_page);
		if ( empty ( $per_page) || $per_page < 1 ) {
			// get the default value if none is set
			$per_page = $screen->get_option( 'per_page', 'default' );
		}
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns($cmog_template_type);
        $hidden = $this->get_hidden($cmog_template_type);
        $sortable = $this->get_sortable_columns($cmog_template_type);
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
        /**
         * Fetch the template data
         * use sort and pagination data to build a custom query.
         */
		//$tquert = "SELECT * FROM cmog_templates";
		//$cmog_template_type =  (int)(!empty($_REQUEST['gmd'])) ? $_REQUEST['gmd'] : ''; //If no sort, default to null
        /**
         * This checks for sorting 
         */
		 
		$status_filter = ' and published >= 0 ';
		if ( array_key_exists('published',$_REQUEST )) {
			$status_filter =  " and published = " . $_REQUEST['published'] . " " ;
		} 
		
		$order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc'; //If no order, default to asc
		$orderby = "  $order " ;
				if ( empty($_REQUEST['orderby'])) {
						$orderby = " `rePday`, `reMonth` , `reDay` $order " ;
				} elseif ($_REQUEST['orderby']  == 'rePday'){
					  $orderby = " `rePday`  $order, `reMonth` $order, `reDay` $order " ;
				} elseif ($_REQUEST['orderby']  == 'reMonth'){
					  $orderby = " `reMonth` $order, `reDay` $order" ;   
				} elseif ($_REQUEST['orderby']  == 'reDay'){
					  $orderby = " `reDay` $order, `reMonth` $order" ;   
				} else {			
					$orderby = $_REQUEST['orderby'] . " " .$order ;
				}
        //$data = $wpdb->get_results( "SELECT * FROM cmog66_cmog_moveableevent WHERE gmd = -1 //$status_filter ORDER BY   $orderby  ", 'ARRAY_A' ); 
	 $data = $wpdb->get_results( "SELECT * FROM cmog66_oc_readings  ORDER BY   $orderby  ", 'ARRAY_A' ); 
 	// $data = $wpdb->get_results( "SELECT * FROM cmog66_oc_days", 'ARRAY_A' ); 
  //echo "<pre>";var_dump($orderby); echo "</pre>";  exit;
        /***********************************************************************
         * http://codex.wordpress.org/Class_Reference/wpdb
         **********************************************************************/
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);
        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
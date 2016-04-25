<?	
	// helper variable
	$ALL_ACTIONS = array(MODE_NEW, MODE_EDIT, MODE_LIST, MODE_VIEW, MODE_DELETE);
	
	/* ========================================================================================================	*/	
	$APP = array(		
		'plugins' => array('plugin.php'),
		'title' => 'dbWebGen Demo',
		'view_display_null_fields' => false,
		'page_size'	=> 10,
		'max_text_len' => 250,
		'pages_prevnext' => 2,
		'mainmenu_tables_autosort' => true,
		'search_lookup_resolve' => true,
		'search_string_transformation' => 'lower(%s)',
		'null_label' => "<span class='nowrap' title='If you check this box, no value will be stored for this field. This may reflect missing, unknown, unspecified or inapplicable information. Note that no value (missing information) is different to providing an empty value: an empty value is a value.'>No Value</span>",		
		'render_main_page_proc' => 'main_page'
	);
	
	/* ========================================================================================================	*/	
	$DB = array(
		'type' => DB_POSTGRESQL,
		'host' => 'localhost',
		'port' => 5432,
		'user' => 'demo_user',
		'pass' => 'test123', 
		'db'   => 'demo'
	);		
	
	/* ========================================================================================================	*/	
	$LOGIN = array(
		'users_table' => 'users',
		'primary_key' => 'id',
		'username_field' => 'login',
		'password_field' => 'password',
		'name_field' => 'name',
		'password_hash_func' => 'md5',
		'form' => array('username' => 'Username', 'password' => 'Password'),
	);
	
	/* ========================================================================================================	*/		
	$TABLES = array(	
		// ----------------------------------------------------------------------------------------------------
		'users' => array(
			'actions' => $ALL_ACTIONS,
			'display_name' => 'Users',
			'description' => 'Users of this application.',
			'item_name' => 'User',
			'primary_key' => array('auto' => true, 'columns' => array('id'), 'sequence_name' => 'users_id_seq'),		
			'sort' => array('name' => 'asc'),
			'additional_steps' => array(
				'user_location_reviews' => array('label' => 'Location Review', 'foreign_key' => 'user_id')
			),
			'fields' => array(			
				'id' => array('label' => 'ID', 'type' => T_NUMBER, 'editable' => false),
				'name' => array('label' => 'Full Name', 'type' => T_TEXT_LINE, 'len' => 50, 'required' => true),				
				'login' => array('label' => 'Login ID', 'type' => T_TEXT_LINE, 'len' => 10, 'required' => true),				
				'password' => array('label' => 'Password', 'type' => T_PASSWORD, 'len' => 32, 'required' => true, 'min_len' => 3),
				'user_buildings_visited' => array('label' => 'Buildings Visited', 'required' => false, 
					'type' => T_LOOKUP, 
					'lookup' => array(
						'cardinality' => CARDINALITY_MULTIPLE,
						'table' => 'buildings',
						'field' => 'id',
						'display' => 'name'),
					'linkage' => array(
						'table' => 'user_buildings_visited',
						'fk_self' => 'user_id',
						'fk_other' => 'building_id')
				),
			)			
		),
		
		// ----------------------------------------------------------------------------------------------------
		'pictures' => array(
			'actions' => $ALL_ACTIONS,
			'display_name' => 'Pictures',
			'description' => 'Pictures of buildings.',
			'item_name' => 'Picture',
			'primary_key' => array('auto' => true, 'columns' => array('id'), 'sequence_name' => 'pictures_id_seq'),
			'sort' => array('filename' => 'asc'),			
			'fields' => array(
				'id' => array('label' => 'ID', 'type' => T_NUMBER, 'editable' => false),				
				'filename' => array('label' => 'File', 'type' => T_UPLOAD, 'required' => true, 
					'max_size' => 10485760, 'location' => 'pics', 
					'store' => STORE_FOLDER,
					'allowed_ext' => array('jpg', 'jpeg', 'png'),
					'help' => 'Upload JPG and PNG images only.'),				
				'label' => array('label' => 'Label', 'type' => T_TEXT_LINE, 'len' => 100, 'required' => true)
			)			
		),
		
		// ----------------------------------------------------------------------------------------------------
		'locations' => array(
			'actions' => $ALL_ACTIONS,
			'display_name' => 'Locations',
			'description' => 'Locations in our beautiful world.',
			'item_name' => 'Location',
			'primary_key' => array('auto' => true, 'columns' => array('id'), 'sequence_name' => 'locations_id_seq'),
			'sort' => array('title' => 'asc'),			
			'fields' => array(
				'id' => array('label' => 'ID', 'type' => T_NUMBER, 'editable' => false),				
				'title' => array('label' => 'Title', 'type' => T_TEXT_LINE, 'len'=>100),
				/* if you like to test the postgis extension: */ // 'spot' => array('label' => 'Spot', 'type' => T_POSTGIS_GEOM, 'SRID' => '4326', 'help' => 'Enter text representation of geometry, e.g. POINT(-71.06 32.4485). See <a href="http://postgis.net/docs/ST_GeomFromText.html" target="_blank">here</a> for help.'),
				'pretty' => array('label'=>'Is this Pretty?', 'type'=>T_ENUM, 'default' => '0', 'values' => array('1' => 'Yes', '0' => 'No'))
			)			
		),
		
		// ----------------------------------------------------------------------------------------------------
		'buildings' => array(
			'actions' => $ALL_ACTIONS,
			'display_name' => 'Buildings',
			'description' => 'Interesting buildings.',
			'item_name' => 'Building',
			'primary_key' => array('auto' => true, 'columns' => array('id'), 'sequence_name' => 'buildings_id_seq'),
			'sort' => array('name' => 'asc'),			
			'fields' => array(
				'id' => array('label' => 'ID', 'type' => T_NUMBER, 'editable' => false),				
				'name' => array('label' => 'Name', 'type' => T_TEXT_LINE, 'len'=>50, 'required'=>true),
				'nr' => array('label' => 'Nr', 'type' => T_NUMBER),
				'picture_id' => array('label' => 'Picture', 'type' => T_LOOKUP, 'required' => false, 'lookup' => array(
					'cardinality' => CARDINALITY_SINGLE,
					'table'   => 'pictures',
					'field'   => 'id',
					'display' => array(
						'columns' => array('filename', 'label'),
						'expression' => "%2 || ' (' || %1 || ')'"))
				),
				'location_id' => array('label' => 'Location', 'type' => T_LOOKUP, 'required' => true, 'lookup' => array(
					'cardinality' => CARDINALITY_SINGLE,
					'table'   => 'locations',
					'field'   => 'id',
					'display' => 'title')
				)
			)			
		),
		
		// ----------------------------------------------------------------------------------------------------
		'user_location_reviews' => array(
			'actions' => $ALL_ACTIONS,
			'display_name' => 'Location Reviews',
			'description' => 'Location reviews by users.',
			'item_name' => 'Location Review',
			'primary_key' => array('auto' => false, 'columns' => array('user_id', 'location_id')),
			'sort' => array('location_id' => 'asc', 'user_id' => 'asc'),			
			'fields' => array(
				'user_id' => array('label' => 'User', 'type' => T_LOOKUP, 'required' => true, 'lookup' => array(
					'cardinality' => CARDINALITY_SINGLE,
					'table'   => 'users',
					'field'   => 'id',
					'display' => 'name')
				),
				'location_id' => array('label' => 'Location', 'type' => T_LOOKUP, 'required' => true, 'lookup' => array(
					'cardinality' => CARDINALITY_SINGLE,
					'table'   => 'locations',
					'field'   => 'id',
					'display' => 'title')
				),
				'rating' => array('label' => 'Rating (1-10)', 'type' => T_NUMBER, 'required' => true),
				'review' => array('label' => 'Review Text', 'type' => T_TEXT_LINE, 'len' => 1000) 
			)			
		),
	);
?>
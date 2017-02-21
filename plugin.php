<?
	//------------------------------------------------------------------------------------------
	// registered via $APP['render_main_page_proc']
	function demo_main_page() {
	//------------------------------------------------------------------------------------------
		// provides the main page text
		echo '<p>This is a demo of <a href="https://github.com/eScienceCenter/dbWebGen">dbWebGen</a>. It is great.</p>';
		echo '<p>Via the <i>New</i> menu, you can create new records in the database</p>';
		echo '<p>Via the <i>Browse &amp; Edit</i> menu, you can browse, edit and delete existing records in the database</p>';
		echo '<p>Via the <i>Extras</i> menu, you can query the database</p>';
	}
	
	//------------------------------------------------------------------------------------------
	// registered via $APP['menu_complete_proc']
	function demo_menu_complete(&$menu) {	
	//------------------------------------------------------------------------------------------
		global $APP;
		
		// we append an "Extras" dropdown to the main menu, allowing the user to query the DB
		$extras_menu = array(
			'name' => 'Extras', 
			'items' => array(
				array(
					'label' => 'Query the DB',
					'href' => '?' . http_build_query(array('mode' => MODE_QUERY))
				),
				array(
					'label' => 'Stored Queries',
					'href' => '?' . http_build_query(array('table' => $APP['querypage_stored_queries_table']))
				)
			)
		);
		
		global $TABLES;
		if(isset($_GET['table'])) {
			$extras_menu['items'][] = array(
				'label' => 'Download all ' . $TABLES[$_GET['table']]['display_name'] . ' as .CSV',
				'href' => '?' . http_build_query(array(
					'mode' => MODE_PLUGIN,
					PLUGIN_PARAM_FUNC => 'demo_download_csv',
					'table' => $_GET['table']
				))
			);
		}
		
		$menu[] = $extras_menu;
	}
?>
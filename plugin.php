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
		// we append an "Extras" dropdown to the main menu, allowing the user to query the DB
		$menu[] = array(
			'name' => 'Extras', 
			'items' => array(
				array(
					'label' => 'Query the DB',
					'href' => '?' . http_build_query(array('mode' => MODE_QUERY))
				)
			)
		);				
	}
?>
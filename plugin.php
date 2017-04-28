<?
	//------------------------------------------------------------------------------------------
	// registered via $APP['render_main_page_proc']
	function demo_main_page() {
	//------------------------------------------------------------------------------------------
		// provides the main page text
		echo l10n('demo.main-page');
	}

	//------------------------------------------------------------------------------------------
	// registered via $APP['preprocess_func']
	function demo_preprocess() {
	//------------------------------------------------------------------------------------------
		$new = l10n('menu.new');
		$browse = l10n('menu.browse+edit');

		l10n_register('demo.plugin', 'en', array(
			'demo.menu.extras' => 'Extras',
			'demo.menu.extras.new-query' => 'Query the Database',
			'demo.menu.extras.list-queries' => 'Stored Queries',
			'demo.main-page' => <<<HTML
				<p>This is a demo of <a href="https://github.com/eScienceCenter/dbWebGen">dbWebGen</a>. It is great.</p>
				<p>Via the <i>$new</i> menu, you can create new records in the database</p>
				<p>Via the <i>$browse</i> menu, you can browse, edit and delete existing records in the database</p>
				<p>Via the <i>Extras</i> menu, you can query the database</p>
HTML
		));

		l10n_register('demo.plugin', 'de', array(
			'demo.menu.extras' => 'Extras',
			'demo.menu.extras.new-query' => 'Neue Abfrage',
			'demo.menu.extras.list-queries' => 'Gespeicherte Abfragen',
			'demo.main-page' => <<<HTML
				<p>Das ist eine Demo von <a href="https://github.com/eScienceCenter/dbWebGen">dbWebGen</a>. Es ist großartig.</p>
				<p>Im Menü <i>$new</i> können neue Datensätze angelegt werden.</p>
				<p>Im Menü <i>$browse</i> können bestehende Datensätze durchsucht, gefiltert, bearbeitet, und gelöscht werden.</p>
				<p>Im Menü <i>Extras</i> können Datenbankabfragen erstellt und gesehen werden.</p>
HTML
		));
	}

	//------------------------------------------------------------------------------------------
	// registered via $APP['menu_complete_proc']
	function demo_menu_complete(&$menu) {
	//------------------------------------------------------------------------------------------
		global $APP;

		// we append an "Extras" dropdown to the main menu, allowing the user to query the DB
		$extras_menu = array(
			'name' => l10n('demo.menu.extras'),
			'items' => array(
				array(
					'label' => l10n('demo.menu.extras.new-query'),
					'href' => '?' . http_build_query(array('mode' => MODE_QUERY))
				),
				array(
					'label' => l10n('demo.menu.extras.list-queries'),
					'href' => '?' . http_build_query(array('table' => $APP['querypage_stored_queries_table']))
				)
			)
		);

		$menu[] = $extras_menu;
	}
?>

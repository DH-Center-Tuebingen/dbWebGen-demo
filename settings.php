<?php

$DB = array (
  'type' => 'postgresql',
  'host' => 'localhost',
  'port' => 5432,
  'user' => 'demo_user',
  'pass' => 'test123',
  'db' => 'demo',
);

$APP = array (
  'title' => 'dbWebGen Demo',
  'page_size' => 10,
  'pages_prevnext' => 2,
  'max_text_len' => 250,
  'mainmenu_tables_autosort' => true,
  'view_display_null_fields' => false,
  'search_lookup_resolve' => true,
  'search_string_transformation' => 'lower((%s)::text)',
  'null_label' => '<span class=\'nowrap\' title=\'If you check this box, no value will be stored for this field. This may reflect missing, unknown, unspecified or inapplicable information. Note that no value (missing information) is different to providing an empty value: an empty value is a value.\'>No Value</span>',
  'list_mincolwidth_max' => 300,
  'list_mincolwidth_pxperchar' => 6,
  'lookup_allow_edit_default' => false,
  'plugins' => array(
    0 => 'plugin.php',
  ),
  'render_main_page_proc' => 'demo_main_page',
  'menu_complete_proc' => 'demo_menu_complete',
  'querypage_stored_queries_table' => 'stored_queries',
  'global_search' => array(
    'include_table' => true,
    'min_search_len' => 3,
    'max_preview_results_per_table' => 10,
    'max_detail_results' => 100,
    'transliterator_rules' => ':: Any-Latin; :: Latin-ASCII;',
    'cache_ttl' => 3600,
  ),
  'preprocess_func' => 'demo_preprocess',
  'super_users' => array(
    0 => 'test',
  ),
);

$LOGIN = array (
  'users_table' => 'users',
  'primary_key' => 'id',
  'username_field' => 'login',
  'password_field' => 'password',
  'name_field' => 'name',
  'password_hash_func' => 'md5',
  'form' => array(
    'username' => 'Username',
    'password' => 'Password',
  ),
);

$TABLES = array (
  'buildings' => array(
    'display_name' => 'Buildings',
    'item_name' => 'Building',
    'description' => 'Interesting buildings.',
    'actions' => array(
      0 => 'new',
      1 => 'edit',
      2 => 'list',
      3 => 'view',
      4 => 'delete',
      5 => 'link',
      6 => 'merge',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => true,
      'columns' => array(
        0 => 'id',
      ),
      'sequence_name' => 'buildings_id_seq',
    ),
    'show_in_related' => true,
    'sort' => array(
      'name' => 'asc',
    ),
    'fields' => array(
      'id' => array(
        'label' => 'ID',
        'type' => 'T_Number',
        'required' => false,
        'editable' => false,
      ),
      'name' => array(
        'label' => 'Name',
        'type' => 'T_TextLine',
        'required' => true,
        'len' => 50,
      ),
      'nr' => array(
        'label' => 'Nr',
        'type' => 'T_Number',
        'required' => false,
      ),
      'picture_id' => array(
        'label' => 'Picture',
        'type' => 'T_ForeignKeyLookup',
        'required' => false,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_SINGLE',
          'table' => 'pictures',
          'field' => 'id',
          'display' => array(
            'columns' => array(
              0 => 'filename',
              1 => 'label',
            ),
            'expression' => '%2 || \' (\' || %1 || \')\'',
          ),
          'related_label' => 'Buildings In This Picture',
        ),
      ),
      'location_id' => array(
        'label' => 'Location',
        'type' => 'T_ForeignKeyLookup',
        'required' => true,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_SINGLE',
          'table' => 'locations',
          'field' => 'id',
          'display' => 'title',
          'related_label' => 'Buildings At This Location',
          'async' => array(
            'min_input_len' => 2,
            'delay' => 0,
          ),
          'label_display_expr_only' => true,
        ),
      ),
      'dummy_conditional' => array(
        'label' => 'Position within Location',
        'type' => 'T_TextArea',
        'required' => false,
        'conditional_display' => array(
          0 => 'OPERATOR_GROUP_OPEN',
          1 => array(
            'field' => 'location_id',
            'operator' => 'OPERATOR_NOT_EQUALS',
            'value' => '',
          ),
          2 => 'OPERATOR_AND',
          3 => array(
            'field' => 'nr',
            'operator' => 'OPERATOR_BETWEEN',
            'value' => array(
              0 => 3,
              1 => 7,
            ),
          ),
          4 => 'OPERATOR_GROUP_CLOSE',
          5 => 'OPERATOR_OR',
          6 => array(
            'field' => 'name',
            'operator' => 'OPERATOR_EQUALS',
            'value' => array(
              0 => 'Staatsoper',
              1 => 'Dönerladen',
            ),
          ),
        ),
      ),
      'user_buildings_visited' => array(
        'label' => 'Previous Visitors',
        'type' => 'T_ForeignKeyLookup',
        'required' => false,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_MULTIPLE',
          'table' => 'users',
          'field' => 'id',
          'display' => array(
            'columns' => array(
              0 => 'name',
              1 => 'login',
            ),
            'expression' => 'concat(%1, \' (\', %2, \')\')',
          ),
          'async' => array(
            'min_input_len' => 2,
            'delay' => 0,
          ),
          'related_label' => 'Buildings Visited By This User',
          'label_display_expr_only' => true,
          'create_new_label' => 'Add Visitor',
          'allow_edit' => true,
        ),
        'linkage' => array(
          'table' => 'user_buildings_visited',
          'fk_self' => 'building_id',
          'fk_other' => 'user_id',
        ),
      ),
    ),
  ),
  'user_location_reviews' => array(
    'display_name' => 'Location Reviews',
    'item_name' => 'Location Review',
    'description' => 'Location reviews by users.',
    'actions' => array(
      0 => 'new',
      1 => 'edit',
      2 => 'list',
      3 => 'view',
      4 => 'delete',
      5 => 'link',
      6 => 'merge',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => false,
      'columns' => array(
        0 => 'user_id',
        1 => 'location_id',
      ),
      'sequence_name' => '',
    ),
    'show_in_related' => true,
    'sort' => array(
      'location_id' => 'asc',
      'user_id' => 'asc',
    ),
    'fields' => array(
      'user_id' => array(
        'label' => 'User',
        'type' => 'T_ForeignKeyLookup',
        'required' => true,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_SINGLE',
          'table' => 'users',
          'field' => 'id',
          'display' => 'name',
          'related_label' => 'Reviews By This User',
        ),
      ),
      'location_id' => array(
        'label' => 'Location',
        'type' => 'T_ForeignKeyLookup',
        'required' => true,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_SINGLE',
          'table' => 'locations',
          'field' => 'id',
          'display' => 'title',
          'related_label' => 'Reviews Of This Location',
        ),
      ),
      'rating' => array(
        'label' => 'Rating (1-10)',
        'type' => 'T_Number',
        'required' => true,
        'min' => 1,
        'max' => 10,
      ),
      'review' => array(
        'label' => 'Review Text',
        'type' => 'T_TextArea',
        'required' => false,
        'len' => 1000,
      ),
    ),
  ),
  'locations' => array(
    'display_name' => 'Locations',
    'item_name' => 'Location',
    'description' => 'Locations in our beautiful world.',
    'actions' => array(
      0 => 'new',
      1 => 'edit',
      2 => 'list',
      3 => 'view',
      4 => 'delete',
      5 => 'link',
      6 => 'merge',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => true,
      'columns' => array(
        0 => 'id',
      ),
      'sequence_name' => 'locations_id_seq',
    ),
    'show_in_related' => true,
    'sort' => array(
      'title' => 'asc',
    ),
    'validation_func' => 'validate_form',
    'fields' => array(
      'id' => array(
        'label' => 'ID',
        'type' => 'T_Number',
        'required' => false,
        'editable' => false,
      ),
      'title' => array(
        'label' => 'Title',
        'type' => 'T_TextLine',
        'required' => false,
        'len' => 100,
      ),
      'pretty' => array(
        'label' => 'Is this Pretty?',
        'type' => 'T_Boolean',
        'required' => false,
        'default' => 'off',
        'options' => array(
          'on' => 'Oh yeah!',
          'off' => 'No way!',
        ),
      ),
      'user_location_reviews' => array(
        'label' => 'User Reviews',
        'type' => 'T_ForeignKeyLookup',
        'required' => false,
        'lookup' => array(
          'cardinality' => 'CARDINALITY_MULTIPLE',
          'table' => 'users',
          'field' => 'id',
          'display' => array(
            'columns' => array(
              0 => 'name',
              1 => 'login',
            ),
            'expression' => 'concat(%1, \' (\', %2, \')\')',
          ),
          'related_label' => 'Locations Reviewed By This User',
          'create_new_label' => 'Create New User Review',
          'allow_edit' => true,
        ),
        'linkage' => array(
          'table' => 'user_location_reviews',
          'fk_self' => 'location_id',
          'fk_other' => 'user_id',
          'maxnum' => 2,
        ),
      ),
    ),
    'additional_steps' => array(
      'buildings' => array(
        'label' => 'Building At This Location',
        'foreign_key' => 'location_id',
      ),
      'user_location_reviews' => array(
        'label' => 'Review Of This Location',
        'foreign_key' => 'location_id',
      ),
    ),
  ),
  'pictures' => array(
    'display_name' => 'Pictures',
    'item_name' => 'Picture',
    'description' => 'Pictures of buildings.',
    'actions' => array(
      0 => 'new',
      1 => 'edit',
      2 => 'list',
      3 => 'view',
      4 => 'delete',
      5 => 'link',
      6 => 'merge',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => true,
      'columns' => array(
        0 => 'id',
      ),
      'sequence_name' => 'pictures_id_seq',
    ),
    'show_in_related' => true,
    'render_links' => array(
      0 => array(
        'icon' => 'eye-open',
        'href_format' => 'pics/%s',
        'field' => 'filename',
        'title' => 'Show This Picture',
      ),
    ),
    'sort' => array(
      'filename' => 'asc',
    ),
    'fields' => array(
      'id' => array(
        'label' => 'ID',
        'type' => 'T_Number',
        'required' => false,
        'editable' => false,
      ),
      'filename' => array(
        'label' => 'File',
        'type' => 'T_FileUpload',
        'required' => true,
        'max_size' => 10485760,
        'location' => 'pics',
        'store' => 1,
        'allowed_ext' => array(
          0 => 'jpg',
          1 => 'jpeg',
          2 => 'png',
        ),
        'help' => 'Upload JPG and PNG images only.',
      ),
      'label' => array(
        'label' => 'Label',
        'type' => 'T_TextLine',
        'required' => true,
        'len' => 100,
      ),
      'time_taken' => array(
        'label' => 'Timestamp',
        'type' => 'T_TextLine',
        'required' => false,
        'datetime_picker' => array(
          'format' => 'YYYY-MM-DD HH:mm',
          'showTodayButton' => true,
          'showClose' => true,
          'allowInputToggle' => true,
        ),
      ),
    ),
  ),
  'stored_queries' => array(
    'display_name' => 'Stored Queries',
    'item_name' => 'Stored Query',
    'description' => 'A <b>stored query</b> allows you to view a live visualization of a database query result based on current data.',
    'actions' => array(
      0 => 'link',
      1 => 'view',
      2 => 'edit',
      3 => 'list',
      4 => 'delete',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => false,
      'columns' => array(
        0 => 'id',
      ),
      'sequence_name' => '',
    ),
    'show_in_related' => false,
    'sort' => array(
      'title' => 'asc',
    ),
    'render_links' => array(
      0 => array(
        'icon' => 'eye-open',
        'href_format' => '?mode=query&navbar=on&id=%s',
        'field' => 'id',
        'title' => 'Show visualization of stored query',
      ),
      1 => array(
        'icon' => 'export',
        'href_format' => '?mode=query&navbar=on&view=full&id=%s',
        'field' => 'id',
        'title' => 'Open this stored query in editor',
      ),
    ),
    'fields' => array(
      'title' => array(
        'label' => 'Title',
        'type' => 'T_TextLine',
        'required' => false,
      ),
      'description' => array(
        'label' => 'Description',
        'type' => 'T_TextArea',
        'required' => false,
      ),
      'id' => array(
        'label' => 'ID',
        'type' => 'T_TextLine',
        'required' => false,
        'editable' => false,
        'list_hide' => false,
      ),
      'params_json' => array(
        'label' => 'JSON Params',
        'type' => 'T_TextArea',
        'required' => false,
        'list_hide' => true,
      ),
      'create_time' => array(
        'label' => 'Created',
        'type' => 'T_TextLine',
        'required' => false,
        'editable' => false,
        'list_hide' => true,
      ),
    ),
  ),
  'users' => array(
    'display_name' => 'Users',
    'item_name' => 'User',
    'description' => 'Users of this application.',
    'actions' => array(
      0 => 'new',
      1 => 'edit',
      2 => 'list',
      3 => 'view',
      4 => 'delete',
      5 => 'link',
      6 => 'merge',
    ),
    'hide_from_menu' => array(
    ),
    'primary_key' => array(
      'auto' => true,
      'columns' => array(
        0 => 'id',
      ),
      'sequence_name' => 'users_id_seq',
    ),
    'show_in_related' => true,
    'sort' => array(
      'name' => 'asc',
    ),
    'additional_steps' => array(
      'user_location_reviews' => array(
        'label' => 'Location Review',
        'foreign_key' => 'user_id',
      ),
    ),
    'fields' => array(
      'id' => array(
        'label' => 'ID',
        'type' => 'T_Number',
        'required' => false,
        'editable' => false,
      ),
      'name' => array(
        'label' => 'Full Name',
        'type' => 'T_TextLine',
        'required' => true,
        'len' => 50,
      ),
      'login' => array(
        'label' => 'Login ID',
        'type' => 'T_TextLine',
        'required' => true,
        'len' => 10,
      ),
      'password' => array(
        'label' => 'Password',
        'type' => 'T_Password',
        'required' => true,
        'len' => 32,
        'min_len' => 3,
        'placeholder' => 'Mind. 3 Zeichen',
      ),
    ),
  ),
);


<?php
/**
 * 
 * 
 */
// 

NU__ContentTypes::_register_custom_post_type(
	$literal = 'faces',
	$name = 'Faces',
	$singular = 'Faces Item',
	$rewrite = 'faces',
	$hierarchical = false, 
	$dashicon = 'dashicons-smiley'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'faces-categories',
	$post_type = 'faces',
	$name = 'Faces Categories',
	$singular = 'Faces Category',
	$rewrite = 'Faces Categories'
);
NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'faces-tags',
	$post_type = 'faces',
	$name = 'Faces Tags',
	$singular = 'Faces Tag',
	$hierarchical = false
);

NU__ContentTypes::_register_custom_taxonomy(
	$literal = 'faces-type',
	$post_type = 'faces',
	$name = 'Faces Types',
	$singular = 'Faces Item Type',
	$hierarchical = false
);


?>
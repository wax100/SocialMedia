<?php
	
	return array(
	    array(
	        'name' 		=> 'limit',
	        'desc' 		=> 'socialmedia_snippet_limit_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '0',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    ),
	    array(
	        'name' 		=> 'providers',
	        'desc' 		=> 'socialmedia_snippet_providers_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '{"twitter": ["@Oetzienl", "#oetzienl"]}',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    )
	);

?>
<?php
	
	return array(
	    array(
	        'name' 		=> 'group',
	        'desc' 		=> 'socialmedia_snippet_group_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    ),
	    array(
	        'name' 		=> 'limit',
	        'desc' 		=> 'socialmedia_snippet_limit_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '6',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    ),
	    array(
	        'name' 		=> 'sort',
	        'desc' 		=> 'socialmedia_snippet_sort_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '{"created": "DESC"}',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    ),
	    array(
	        'name' 		=> 'sources',
	        'desc' 		=> 'socialmedia_snippet_sources_desc',
	        'type' 		=> 'textfield',
	        'options' 	=> '',
	        'value'		=> '{}',
	        'area'		=> PKG_NAME_LOWER,
	        'lexicon' 	=> PKG_NAME_LOWER.':default'
	    )
	);

?>
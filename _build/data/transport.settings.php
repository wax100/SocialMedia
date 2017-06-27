<?php

	$settings = array();
	
	$settings[0] = $modx->newObject('modSystemSetting');
	$settings[0]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.api_useragent',
		'value' 	=> 'SocialMediaOAuth v'.PKG_VERSION,
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);

	$settings[1] = $modx->newObject('modSystemSetting');
	$settings[1]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.default_active',
		'value' 	=> '1',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[2] = $modx->newObject('modSystemSetting');
	$settings[2]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.default_sources',
		'value' 	=> '{"twitter": ["@modx", "#modx"], "instagram": ["#modx"]}',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[3] = $modx->newObject('modSystemSetting');
	$settings[3]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.log_email',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[4] = $modx->newObject('modSystemSetting');
	$settings[4]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.log_lifetime',
		'value' 	=> '7',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[5] = $modx->newObject('modSystemSetting');
	$settings[5]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.log_send',
		'value' 	=> 'false',
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[6] = $modx->newObject('modSystemSetting');
	$settings[6]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_facebook_access_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[7] = $modx->newObject('modSystemSetting');
	$settings[7]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_facebook_client_id',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[8] = $modx->newObject('modSystemSetting');
	$settings[8]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_facebook_client_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[9] = $modx->newObject('modSystemSetting');
	$settings[9]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_facebook_empty_posts',
		'value' 	=> false,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[10] = $modx->newObject('modSystemSetting');
	$settings[10]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_instagram_access_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[11] = $modx->newObject('modSystemSetting');
	$settings[11]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_instagram_client_id',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[12] = $modx->newObject('modSystemSetting');
	$settings[12]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_instagram_client_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[13] = $modx->newObject('modSystemSetting');
	$settings[13]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_instagram_empty_posts',
		'value' 	=> true,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[14] = $modx->newObject('modSystemSetting');
	$settings[14]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_linkedin_access_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[15] = $modx->newObject('modSystemSetting');
	$settings[15]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_linkedin_client_id',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[16] = $modx->newObject('modSystemSetting');
	$settings[16]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_linkedin_client_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[17] = $modx->newObject('modSystemSetting');
	$settings[17]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_linkedin_empty_posts',
		'value' 	=> false,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[18] = $modx->newObject('modSystemSetting');
	$settings[18]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_pinterest_access_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[19] = $modx->newObject('modSystemSetting');
	$settings[19]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_pinterest_client_id',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[20] = $modx->newObject('modSystemSetting');
	$settings[20]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_pinterest_client_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[21] = $modx->newObject('modSystemSetting');
	$settings[21]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_pinterest_empty_posts',
		'value' 	=> false,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[22] = $modx->newObject('modSystemSetting');
	$settings[22]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_twitter_access_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[23] = $modx->newObject('modSystemSetting');
	$settings[23]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_twitter_access_token_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[24] = $modx->newObject('modSystemSetting');
	$settings[24]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_twitter_consumer_key',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[25] = $modx->newObject('modSystemSetting');
	$settings[25]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_twitter_consumer_key_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[26] = $modx->newObject('modSystemSetting');
	$settings[26]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_twitter_empty_posts',
		'value' 	=> false,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[27] = $modx->newObject('modSystemSetting');
	$settings[27]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_youtube_client_id',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[28] = $modx->newObject('modSystemSetting');
	$settings[28]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_youtube_client_secret',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[29] = $modx->newObject('modSystemSetting');
	$settings[29]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_youtube_refresh_token',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[30] = $modx->newObject('modSystemSetting');
	$settings[30]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.source_youtube_empty_posts',
		'value' 	=> false,
		'xtype' 	=> 'combo-boolean',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	$settings[31] = $modx->newObject('modSystemSetting');
	$settings[31]->fromArray(array(
		'key' 		=> PKG_NAME_LOWER.'.word_filter',
		'value' 	=> '',
		'xtype' 	=> 'textfield',
		'namespace' => PKG_NAME_LOWER,
		'area' 		=> PKG_NAME_LOWER
	), '', true, true);
	
	return $settings;
	
?>
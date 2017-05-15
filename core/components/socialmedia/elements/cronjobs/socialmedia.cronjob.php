<?php
	
	/**
	 * Social Media
	 *
	 * Copyright 2017 by Oene Tjeerd de Bruin <modx@oetzie.nl>
	 *
	 * Social Media is free software; you can redistribute it and/or modify it under
	 * the terms of the GNU General Public License as published by the Free Software
	 * Foundation; either version 2 of the License, or (at your option) any later
	 * version.
	 *
	 * Social Media is distributed in the hope that it will be useful, but WITHOUT ANY
	 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
	 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
	 *
	 * You should have received a copy of the GNU General Public License along with
	 * Social Media; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
	 * Suite 330, Boston, MA 02111-1307 USA
	 */

	require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config.core.php';
	
	require_once MODX_CORE_PATH.'model/modx/modx.class.php';
	
	$modx = new modX();
	$modx->initialize('web');
	
	$modx->getService('error', 'error.modError');
	$modx->setLogLevel(modX::LOG_LEVEL_INFO);
	$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

	/*
	 * Put the options in the $options variable.
	 * We use getopt for CLI executions and $_GET for http executions.
	 */
	$options = array();
	
	if (XPDO_CLI_MODE) {
	    $options = getopt('', array('sources::', 'debug'));
	} else {
	    $options = $_GET;
	}
	
	$service = $modx->getService('socialmediacronjob', 'SocialMediaCronjob', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/');

	if ($service instanceof SocialMedia) {
		if (isset($options['sources'])) {
        	$service->setDebugMode($options['sources']);
		}
		
		if (isset($options['debug'])) {
        	$service->setDebugMode(true);
		}
		
		$service->run();
	} else {
		$modx->log(modX::LOG_LEVEL_INFO, 'ERROR:: Cannot initialize service.');
	}
		
?>
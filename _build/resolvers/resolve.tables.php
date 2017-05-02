<?php

	if ($object->xpdo) {
	    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
	        case xPDOTransport::ACTION_INSTALL:
	            $modx =& $object->xpdo;
	            $modx->addPackage('socialmedia', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path').'components/socialmedia/').'model/');
	
	            $manager = $modx->getManager();
	
	            $manager->createObjectContainer('SocialMediaMessages');
	
	            break;
	        case xPDOTransport::ACTION_UPGRADE:
	            break;
	    }
	}
	
	return true;

?>
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
	
	if ($modx->loadClass('SocialMedia', $modx->getOption('socialmedia.core_path', null, $modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/', true, true)) {
        $socialmedia = new SocialMedia($modx);

	    if ($socialmedia instanceOf SocialMedia) {
	        return $socialmedia->run($scriptProperties);
	    }
	}
	
	return ' ';
	
?>
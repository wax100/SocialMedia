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

	class SocialMediaMessagesUpdateProcessor extends modObjectUpdateProcessor {
		/**
		 * @access public.
		 * @var String.
		 */
		public $classKey = 'SocialMediaMessages';
		
		/**
		 * @access public.
		 * @var Array.
		 */
		public $languageTopics = array('socialmedia:default');
		
		/**
		 * @access public.
		 * @var String.
		 */
		public $objectType = 'socialmedia.messages';
		
		/**
		 * @access public.
		 * @var Object.
		 */
		public $socialmedia;
		
		/**
		 * @acces public.
		 * @return Mixed.
		 */
		public function initialize() {
			$this->socialmedia = $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/');

			return parent::initialize();
		}
		
		/**
		 * @access public.
		 * @return Mixed.
		 */
		public function afterSave() {
			$this->modx->cacheManager->refresh(array(
				'socialmedia' => array()
			));
			
			$this->modx->invokeEvent('onSocialMediaUpdate');
			
			return parent::afterSave();
		}
	}
	
	return 'SocialMediaMessagesUpdateProcessor';
	
?>
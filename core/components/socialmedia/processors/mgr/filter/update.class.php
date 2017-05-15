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
	 
	class SocialMediaFilterUpdateProcessor extends modProcessor {
		/**
		 * @access public.
		 * @var Array.
		 */
		public $languageTopics = array('socialmedia:default');
				
		/**
		 * @access public.
		 * @var String.
		 */
		public $objectType = 'socialmedia.filter';
		
		/**
		 * @access public.
		 * @var Object.
		 */
		public $socialmedia;
		
		/**
		 * @access public.
		 * @return Mixed.
		 */
		public function initialize() {
			$this->socialmedia = $this->modx->getService('socialmedia', 'SocialMedia', $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/');
			
			return parent::initialize();
		}
		
		/**
		 * @access public.
		 * @return Array.
		 */
		public function process() {
			$this->modx->cacheManager->clearCache();
			
			$words = explode(',', $this->getProperty('filter'));
			
			foreach ($words as $key => $word) {
				$words[$key] = trim($word);
			}
			
			$filter = implode(', ', array_unique(array_filter($words)));
			
			$criterea = array(
				'key' => 'socialmedia.word_filter'	
			);
			
			if (null === ($setting = $this->modx->getObject('modSystemSetting', $criterea))) {
				$setting = $this->modx->newObject('modSystemSetting');
			}
				
			$setting->fromArray(array_merge($criterea, array(
				'value' => $filter
			)));
			
			if ($setting->save()) {
				return $this->success($filter);
			} else {
				return $this->failure();
			}
		}
	}

	return 'SocialMediaFilterUpdateProcessor';
	
?>
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

	abstract class SocialMediaManagerController extends modExtraManagerController {
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
			
			$this->addJavascript($this->socialmedia->config['js_url'].'mgr/socialmedia.js');
			
			$this->addHtml('<script type="text/javascript">
				Ext.onReady(function() {
					MODx.config.help_url = "'.$this->socialmedia->getHelpUrl().'";

					SocialMedia.config = '.$this->modx->toJSON(array_merge($this->socialmedia->config, array(
                        'branding_url'          => $this->socialmedia->getBrandingUrl(),
                        'branding_url_help'     => $this->socialmedia->getHelpUrl()
                    ))).';
				});
			</script>');
			
			return parent::initialize();
		}
		
		/**
		 * @access public.
		 * @return Array.
		 */
		public function getLanguageTopics() {
			return $this->socialmedia->config['lexicons'];
		}
		
		/**
		 * @access public.
		 * @returns Boolean.
		 */	    
		public function checkPermissions() {
			return $this->modx->hasPermission('socialmedia');
		}
	}
		
	class IndexManagerController extends SocialMediaManagerController {
		/**
		 * @access public.
		 * @return String.
		 */
		public static function getDefaultController() {
			return 'home';
		}
	}

?>
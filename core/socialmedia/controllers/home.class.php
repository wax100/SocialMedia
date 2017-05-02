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

	class SocialMediaHomeManagerController extends SocialMediaManagerController {
		/**
		 * @access public.
		 */
		public function loadCustomCssJs() {
			$this->addCss($this->socialmedia->config['css_url'].'mgr/socialmedia.css');
			
			$this->addJavascript($this->socialmedia->config['js_url'].'mgr/widgets/home.panel.js');
			
			$this->addJavascript($this->socialmedia->config['js_url'].'mgr/widgets/messages.grid.js');
			
			$this->addLastJavascript($this->socialmedia->config['js_url'].'mgr/sections/home.js');
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getPageTitle() {
			return $this->modx->lexicon('socialmedia');
		}
		
		/**
		* @access public.
		* @return String.
		*/
		public function getTemplateFile() {
			return $this->socialmedia->config['templates_path'].'home.tpl';
		}
	}

?>
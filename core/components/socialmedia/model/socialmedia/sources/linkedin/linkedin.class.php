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
	
	require_once dirname(dirname(dirname(__FILE__))).'/socialmediasourcerequest.class.php';
	
	class LinkedIn extends SocialMediaSourceRequest {
		const API_URL = 'https://api.linkedin.com/v1/';
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiKey() {
			return $this->modx->getOption('socialmedia.source_linkedin_client_id');
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiSecret() {
			return $this->modx->getOption('socialmedia.source_linkedin_client_secret');
		}
	
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiAccessToken() {
			return $this->modx->getOption('socialmedia.source_linkedin_access_token');
		}
		
		/**
		 * @access public.
		 * @param String $url.
		 * @param Array $paramters.
		 * @param String $method.
		 * @param Array $options.
		 * @return Mixed.
		 */
		public function request($url, $parameters = array(), $method = 'GET', $options = array()) {
			if (false === strrpos($url, 'https://') && false === strrpos($url, 'http://')) {
				$url = rtrim(LinkedIn::API_URL, '/').'/'.rtrim($url, '/').'/';
			}
			
			$parameters = array_merge($parameters, array(
	        	'oauth2_access_token' 	=> $this->getApiAccessToken(),
	        	'format' 				=> 'json'
        	));
	
			return $this->requestApi($url, $parameters, $method, $options);
	    }
	}
	
?>
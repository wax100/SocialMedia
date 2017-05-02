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
	
	class Youtube extends SocialMediaSourceRequest {
		const API_URL 	= 'https://www.googleapis.com/youtube/v3/';
		const TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiKey() {
			return $this->modx->getOption('socialmedia.source_youtube_client_id');
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiSecret() {
			return $this->modx->getOption('socialmedia.source_youtube_client_secret');
		}
	
		/**
		 * @access public.
		 * @return String.
		 */
		public function getApiAccessToken() {
			return $this->getApiRefreshAccessToken();
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
				$url = rtrim(Youtube::API_URL, '/').'/'.rtrim($url, '/').'/';
			}
			
			$parameters = array_merge($parameters, array(
	        	'access_token' => $this->getApiAccessToken()	
        	));
	
			return $this->requestApi($url, $parameters, $method, $options);
	    }
	    
	    /**
		 * @access public.
		 * @return String.
		 */
		public function getApiRefreshAccessToken() {
			$parameters = array(
				'refresh_token' 	=> $this->modx->getOption('socialmedia.source_youtube_refresh_token'),
				'client_id' 		=> $this->getApiKey(),
				'client_secret' 	=> $this->getApiSecret(),
				'redirect_uri'		=> rtrim($this->modx->getOption('site_url'), '/').$this->modx->getOption('manager_url'),
				'grant_type'		=> 'refresh_token'
			);
			
			if (false !== ($token = $this->requestApi(Youtube::TOKEN_URL, $parameters, 'POST'))) {
				if (isset($token['access_token'])) {
					return $token['access_token'];
				}
			}

			return false;
		}
	}
	
?>
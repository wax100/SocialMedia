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
	
	class Twitter extends SocialMediaSourceRequest {
		const API_URL = 'https://api.twitter.com/1.1/';
	    
	    /**
		 * @access private.
		 * @retrun String.
		 */
	    private function getConsumerKey() {
		    return $this->modx->getOption('socialmedia.source_twitter_consumer_key');
	    }
	    
	    /**
		 * @access private.
		 * @retrun String.
		 */
	    private function getConsumerKeySecret() {
		    return $this->modx->getOption('socialmedia.source_twitter_consumer_key_secret');
	    }
	    
	    /**
		 * @access private.
		 * @retrun String.
		 */
	    private function getAccesToken() {
		    return $this->modx->getOption('socialmedia.source_twitter_access_token');
	    }
	    
	    /**
		 * @access private.
		 * @retrun String.
		 */
	    private function getAccesTokenSecret() {
			return $this->modx->getOption('socialmedia.source_twitter_access_token_secret');   
	    }
		
		/**
		 * @access public.
		 * @param String $url.
		 * @param String $method.
		 * @param Array $parameters.
		 * @return Array.
		 */
    	private function buildOAuth($url, $method, $parameters = array()) {
	        $oauth = array(
	            'oauth_consumer_key' 		=> $this->getConsumerKey(),
	            'oauth_nonce' 				=> time(),
	            'oauth_signature_method' 	=> 'HMAC-SHA1',
	            'oauth_token' 				=> $this->getAccesToken(),
	            'oauth_timestamp' 			=> time(),
	            'oauth_version' 			=> '1.0'
	        );
	        
	        foreach ($parameters as $key => $value) {
		        $oauth[$key] = $value;
	        }

	        $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $this->buildOAuthString($url, $method, $oauth), rawurlencode($this->getConsumerKeySecret()).'&'.rawurlencode($this->getAccesTokenSecret()), true));
	        
	        return $oauth;
    	}

    	/**
		 * @access private.
		 * @param String $url.
		 * @param String $method.
		 * @param Array $parameters.
		 * @return String.
		 */
    	private function buildOAuthString($url, $method, $parameters = array()) {
        	$output = array();
        	
			ksort($parameters);
			
			foreach($parameters as $key => $value) {
            	$output[] = rawurlencode($key).'='.rawurlencode($value);
        	}
        	
			return $method.'&'.rawurlencode($url).'&'.rawurlencode(implode('&', $output));
    	}
    	
    	/**
	     * @access private.
	     * @param Arrray $oauth.
	     * @return String.
	     */
	    private function buildAuthorizationHeader($oauth) {
	        $output = array();
	        
	        foreach($oauth as $key => $value) {
	            if (in_array($key, array('oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp', 'oauth_token', 'oauth_version'))) {
	                $output[] = $key.'="'.rawurlencode($value).'"';
	            }
	        }

	        return 'Authorization: OAuth '.implode(', ', $output);
    	}
    	
    	/**
		 * @access public.
		 * @param String $url.
		 * @param Array $parameters.
		 * @param String $method.
		 * @param Array $options.
		 * @return Mixed.
		 */
		public function request($url, $parameters = array(), $method = 'GET', $options = array()) {
			if (false === strrpos($url, 'https://') && false === strrpos($url, 'http://')) {
				$url = rtrim(Twitter::API_URL, '/').'/'.$url.'.json';
			}

			$options = array(
				CURLOPT_HTTPHEADER => array($this->buildAuthorizationHeader($this->buildOAuth($url, $method, $parameters)), 'Expect:')
			) + $options;
			
	        return $this->requestApi($url, $parameters, $method, $options);
	    }
	}
	
?>
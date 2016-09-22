<?php
	
	/**
	 * Social Media
	 *
	 * Copyright 2016 by Oene Tjeerd de Bruin <info@oetzie.nl>
	 *
	 * This file is part of Social Media, a real estate property listings component
	 * for MODX Revolution.
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
	
	class Twitter {
		/**
		 * @acces public.
		 * @var Object.
		 */
		public $modx;
		
		/**
		 * @acces public.
	     * @var String
	     */
	    public $url;
	    
	    /**
		 * @acces public.
		 * @var Array.
		 */
		public $params;
	    
	    /**
		 * @acces public.
	     * @var String
	     */
	    public $method;
	    
	    /**
		 * @acces protected.
	     * @var Mixed
	     */
	    protected $oauth;
    
    	/**
		 * @acces public.
		 * @param Object $modx.
		 */
		public function __construct(modX &$modx) {
			$this->modx =& $modx;
		}
		
		/**
		 * @acces public.
		 * @param String $url.
		 */
		public function setUrl($url) {
			$this->url = $url;
		}
		
		/**
		 * @acces public.
		 * @return String.
		 */
		public function getUrl() {
			return $this->url;
		}

		/**
		 * @acces public.
		 * @param Array $params.
		 */
		public function setParams($params) {
			foreach ($params as $key => $param) {
				$this->params[$key] = $param;
			}
		}
		
		/**
		 * @acces public.
		 * @return Array.
		 */
		public function getParams() {
			return $this->params;
		}
		
		/**
		 * @acces public.
		 * @param String $method.
		 */
		public function setMethod($method) {
			$this->method = strtoupper($method);
		}
		
		/**
		 * @acces public.
		 * @return String.
		 */
		public function getMethod() {
			return $this->method;
		}
		
		/**
		 * @acces public.
		 * @param String $url.
		 * @param Array $params.
		 * @param String $method.
		 * @param Array $options.
		 * @return Mixed.
		 */
		public function request($url, $params = array(), $method = 'GET', $options = array()) {
	        return $this->buildOauth($url, $params, $method)->callApi($options);
	    }
		
		/**
		 * @acces public.
		 * @param String $url.
		 * @param String $method.
		 * @return Object.
		 */
    	public function buildOauth($url, $params = array(), $method = 'GET') {
	    	$this->setParams($params);
	    	
	    	if (0 !== strrpos($url, 'https://') && 0 !== strrpos($url, 'http://')) {
				$this->setUrl(rtrim($this->modx->getOption('socialmedia.twitter_api_url'), '/').'/'.$url.'.json');
			} else {
				$this->setUrl($url);
			}
			
			$this->setMethod($method);
			
	        $oauth = array(
	            'oauth_consumer_key' 		=> $this->modx->getOption('socialmedia.twitter_consumer_key'),
	            'oauth_nonce' 				=> time(),
	            'oauth_signature_method' 	=> 'HMAC-SHA1',
	            'oauth_token' 				=> $this->modx->getOption('socialmedia.twitter_access_token'),
	            'oauth_timestamp' 			=> time(),
	            'oauth_version' 			=> '1.0'
	        );
	        
	        foreach ($this->getParams() as $key => $value) {
		        $oauth[$key] = $value;
	        }

	        $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $this->buildBaseString($oauth), rawurlencode($this->modx->getOption('socialmedia.twitter_consumer_key_secret')).'&'.rawurlencode($this->modx->getOption('socialmedia.twitter_access_token_secret')), true));
	        
	        $this->oauth = $oauth;
	        
	        return $this;
    	}
    	
    	/**
		 * @acces private.
		 * @param Array $params.
		 * @return String.
		 */
    	private function buildBaseString($params = array()) {
        	$output = array();
        	
			ksort($params);
			
			foreach($params as $key => $value) {
            	$output[] = rawurlencode($key).'='.rawurlencode($value);
        	}
        	
			return $this->getMethod().'&'.rawurlencode($this->getUrl()).'&'.rawurlencode(implode('&', $output));
    	}
    	
    	/**
	     * @acces private.
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
	     * @acces public.
	     * @param Array $options.
	     * @return Mixed.
	     */
		public function callApi($options = array()) {
	        $options = array(
	            CURLOPT_HTTPHEADER 		=> array($this->buildAuthorizationHeader($this->oauth), 'Expect:'),
	            CURLOPT_HEADER 			=> false,
	            CURLOPT_USERAGENT 		=> $this->modx->getOption('socialmedia.api_useragent'), 
	            CURLOPT_RETURNTRANSFER 	=> true,
	            CURLOPT_TIMEOUT 		=> 10
	        ) + $options;
	        
	        switch ($this->method) {
		        case 'POST':
		        	$options = array(
			        	CURLOPT_URL 			=> $this->url,
			        	CURLOPT_POSTFIELDS		=> http_build_query($this->getParams())
		        	) + $options;
		        	
		        	break;
		        default:
		        	$options = array(
			        	CURLOPT_URL 			=> $this->url.'?'.http_build_query($this->getParams())
		        	) + $options;
		        	
		        	break;
	        }
	      
	        $curl = curl_init();
	        
	        curl_setopt_array($curl, $options);

	        $response 	= curl_exec($curl);
			
			if ('200' != curl_getinfo($curl, CURLINFO_HTTP_CODE) || '' != ($error = curl_error($curl))) {
				return false;
			}
	        
	        curl_close($curl);
	        
	        return $this->modx->fromJSON($response);
	    }
	}
?>
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

	class SocialMediaSourceRequest {
		/**
		 * @access public.
		 * @var Object.
		 */
		public $modx;
	    
		/**
		 * @access public.
		 * @param Object $modx.
		 */
		public function __construct(modX &$modx) {
			$this->modx =& $modx;
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getName() {
			return $this->name;
		}
		
		/**
	     * @access public.
	     * @param Array $options.
	     * @return Mixed.
	     */
		public function requestApi($url, $parameters = array(), $method = 'GET', $options = array()) {
	        $options = $options + array(
	            CURLOPT_HEADER 			=> false,
	            CURLOPT_USERAGENT 		=> 'SocialMediaApi 1.0', 
	            CURLOPT_RETURNTRANSFER 	=> true,
	            CURLOPT_TIMEOUT 		=> 10
	        );

	        switch (strtoupper($method)) {
		        case 'POST':
		        	$options = array(
			        	CURLOPT_URL 		=> $url,
			        	CURLOPT_POSTFIELDS	=> http_build_query($parameters)
		        	) + $options;
		        	
		        	break;
		        default:
		        	$options = array(
			        	CURLOPT_URL 		=> $url.'?'.http_build_query($parameters)
		        	) + $options;
		        	
		        	break;
	        }

	        $curl = curl_init();
	        
	        curl_setopt_array($curl, $options);

	        $response 	= curl_exec($curl);
	        $info		= curl_getinfo($curl);

	        if (!isset($info['http_code']) || '200' != $info['http_code']) {
		        //if (null !== ($response = $this->modx->fromJSON($response))) {
			    //    if (isset($response['error']['message'])) {
				//        return false;
			    //    }
		        //}
		        
				return false;
			}
	        
	        curl_close($curl);
	        
	        return $this->modx->fromJSON($response);
	    }
	}

?>
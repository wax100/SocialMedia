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

	require_once dirname(dirname(dirname(__FILE__))).'/socialmediasource.class.php';
	
	require_once dirname(__FILE__).'/facebook.class.php';
	
	class SocialMediaSourceFacebook extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'Facebook';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Facebook($this->modx);
		}
		
		/**
		 * @access public.
		 * @param String|Array $types.
		 * @param Integer $limit.
		 * @return Array.
		 */
		public function getData($types, $limit = 10) {
			$output = array();
			
			if (is_string($types)) {
				$types = array($types);
			}
			
			foreach ($types as $type) {
				switch (substr($type, 0, 1)) {
					default:
						$type = str_replace(array('@', '$'), '', $type);
						
						if (in_array($type, array('self', 'me'))) {
							$type = 'me';
						}
						
						$criterea = array(
							'fields' => 'id,name,link,picture.width(200).height(200)'
						);
						
						if (false !== ($account = $this->getSource()->request($type, $criterea))) {
							$criterea = array(
								'fields' 	=> 'id,from,message,created_time,full_picture,permalink_url,type,source,link',
								'limit'		=> $limit
							);
							
							if (false !== ($data = $this->getSource()->request($type.'/posts', $criterea))) {
								if (isset($data['data'])) {
									foreach ($data['data'] as $value) {
										$output[] = $this->getFormat($value, $account);
									}
								}
							}
						}

						break;
				}
			}
			
			return $this->getDataSort($output);
		}

		/**
		 * @access private.
		 * @param Array $data.
		 * @param Array $account.
		 * @return Array.
		 */
		private function getFormat($data, $account = array()) {
			$userAccount 	= explode('/', trim($account['link'], '/'));
			$userImage 		= '';
			$userUrl		= '';
			
			$content 		= '';
				
			$image 			= '';
			$video 			= '';

			if (isset($account['picture']['data']['url'])) {
				$userImage = $account['picture']['data']['url'];
			}
			
			if (isset($data['message'])) {
				$content = $data['message'];
			}
			
			if (isset($data['link'])) {
				if ('link' == $data['type']) {
					$content = str_replace($data['link'], '', $content);
					
					$content .= ' '.$data['link']; 
				}
			}
			
			if (isset($data['full_picture'])) {
				$image = str_replace(array('https:', 'http:'), array('', ''), $data['full_picture']);
			}
			
			if (isset($data['source'])) {
				$video = str_replace(array('https:', 'http:'), array('', ''), $data['source']);
			}
			
			return array(
				'key'			=> $data['id'],
				'source'		=> strtolower($this->getName()),
				'user_name'		=> $this->getEmojiFormat($account['name']),
				'user_account'	=> $this->getEmojiFormat(end($userAccount)),
				'user_image'	=> str_replace(array('https:', 'http:'), array('', ''), $userImage),
				'user_url'		=> 'https://www.facebook.com/'.end($userAccount),
				'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', trim($content)))),
				'image'			=> $image,
				'video'			=> $video,
				'url'			=> $data['permalink_url'],
				'created'		=> date('Y-m-d H:i:s', strtotime($data['created_time']))
			);
		}
	}

?>
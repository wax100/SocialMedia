<?php

	/**
	 * Social Media
	 *
	 * Copyright 2016 by Oene Tjeerd de Bruin <info@oetzie.nl>
	 *
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
	
	require_once dirname(__FILE__).'/instagram.class.php';
	
	class SocialMediaSourceInstagram extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'Instagram';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Instagram($this->modx);
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
					case '#':
						$type = str_replace('#', '', $type);
					
						$criterea = array(
							'count'	=> $limit	
						);
						
						if (false !== ($data = $this->getSource()->request('tags/'.$type.'/media/recent', $criterea))) {
							if (isset($data['data'])) {
								foreach ($data['data'] as $value) {
									$output[] = $this->getFormat($value);
								}
							}
						}
						
						break;
					default:
						$type = str_replace(array('@', '$'), '', $type);
					
						$criterea = array(
							'count'	=> $limit	
						);
						
						if (false !== ($data = $this->getSource()->request('users/'.$type.'/media/recent', $criterea))) {
							if (isset($data['data'])) {
								foreach ($data['data'] as $value) {
									$output[] = $this->getFormat($value);
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
		 * @return Array.
		 */
		private function getFormat($data) {
			$userName 	= $data['user']['full_name'];
			
			$image 		= '';
			$video 		= '';
			
			if (empty($userName)) {
				$userName = $data['user']['username'];
			}
			
			if (isset($data['images'])) {
				foreach ($data['images'] as $value) {
					$image = str_replace(array('https:', 'http:'), array('', ''), $value['url']);
				}
			}
			
			if (isset($data['videos'])) {
				foreach ($data['videos'] as $value) {
					$video = str_replace(array('https:', 'http:'), array('', ''), $value['url']);
				}
			}
			
			return array(
				'key'			=> $data['id'],
				'source'		=> strtolower($this->getName()),
				'user_name'		=> $this->getEmojiFormat($userName),
				'user_account'	=> $this->getEmojiFormat($data['user']['username']),
				'user_image'	=> str_replace(array('https:', 'http:'), array('', ''), $data['user']['profile_picture']),
				'user_url'		=> 'https://www.instagram.com/'.$data['user']['username'],
				'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', $data['caption']['text']))),
				'image'			=> $image,
				'video'			=> $video,
				'url'			=> $data['link'],
				'created'		=> date('Y-m-d H:i:s', $data['created_time'])
			);
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
		 */
		public function getHtmlFormat($content) {
			$content = preg_replace("/@(\w+)/", "<a href=\"https://www.instagram.com/\\1\" target=\"_blank\">@\\1</a>", $content);
			$content = preg_replace("/#(\w+)/", "<a href=\"https://www.instagram.com/explore/tags/\\1\" target=\"_blank\">#\\1</a>", $content);
			
			return $content;
		}
	}

?>
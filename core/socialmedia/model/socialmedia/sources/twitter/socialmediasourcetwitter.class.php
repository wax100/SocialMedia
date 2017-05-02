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
	
	require_once dirname(__FILE__).'/twitter.class.php';
	
	class SocialMediaSourceTwitter extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'Twitter';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Twitter($this->modx);
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
						$criterea = array(
							'q'				=> $type,
							'count'			=> $limit,
							'result_type'	=> 'recent'
						);
	
						if (false !== ($data = $this->getSource()->request('search/tweets', $criterea))) {
							if (isset($data['statuses'])) {
								foreach ($data['statuses'] as $value) {
									$output[] = $this->getFormat($value);
								}
							}
						}
						
						break;
					default:
						$type = str_replace(array('@', '$'), '', $type);
						
						if (in_array($type, array('self', 'me'))) {
							$criterea = array(
								'count' => $limit
							);
						} else {
							$criterea = array(
								'screen_name' 	=> $type,
								'count'			=> $limit
							);
						}
						
						if (false !== ($data = $this->getSource()->request('statuses/user_timeline', $criterea))) {							
							foreach ($data as $key => $value) {
								$output[] = $this->getFormat($value);
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
			$image		= '';
			$video 		= '';
			
			$content	= $data['text'];
			
			if (isset($data['entities']['media'])) {
				foreach ($data['entities']['media'] as $media) {
					if ('photo' == $media['type']) {
						$image 		= str_replace(array('https:', 'http:'), array('', ''), $media['media_url']);
						$content 	= str_replace($media['url'], '', $content);
					}
				}
			}
			
			if (isset($data['extended_entities']['media'])) {
				foreach ($data['extended_entities']['media'] as $media) {
					if ('video' == $media['type']) {
						if (isset($media['video_info']['variants'])) {
							foreach ($media['video_info']['variants'] as $media) {
								if ('video/mp4' == $media['content_type']) {
									$video 		= str_replace(array('https:', 'http:'), array('', ''), $media['url']);
									$content 	= str_replace($media['url'], '', $content);
									
									break;
								}
							}
						}
					}
				}
			}
			
			return array(
				'key'			=> $data['id'],
				'source'		=> strtolower($this->getName()),
				'user_name'		=> $this->getEmojiFormat($data['user']['name']),
				'user_account'	=> $this->getEmojiFormat($data['user']['screen_name']),
				'user_image'	=> str_replace(array('https:', 'http:', '_normal'), array('', '', '_200x200'), $data['user']['profile_image_url']),
				'user_url'		=> 'https://www.twitter.com/'.$data['user']['screen_name'],
				'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', $content))),
				'image'			=> $image,
				'video'			=> $video,
				'url'			=> 'https://www.twitter.com/'.$data['user']['screen_name'].'/status/'.$data['id'],
				'created'		=> date('Y-m-d H:i:s', strtotime($data['created_at']))
			);
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
		 */
		public function getHtmlFormat($content) {
			$content = preg_replace("/@(\w+)/", "<a href=\"https://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $content);
			$content = preg_replace("/#(\w+)/", "<a href=\"https://twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $content);
			
			return $content;
		}
	}

?>
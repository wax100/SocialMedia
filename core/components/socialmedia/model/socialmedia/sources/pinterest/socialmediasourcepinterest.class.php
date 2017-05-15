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
	
	require_once dirname(__FILE__).'/pinterest.class.php';
	
	class SocialMediaSourcePinterest extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'Pinterest';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Pinterest($this->modx);
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
							'limit'		=> $limit,
							'query'		=> str_replace('#', '', $type),
							'fields' 	=> 'id,link,creator(id,first_name,last_name,url,image[236x],username),image,note,created_at'
						);

						if (false !== ($data = $this->getSource()->request('me/search/pins/', $criterea))) {
							if (isset($data['data'])) {
								foreach ($data['data'] as $value) {
									$output[] = $this->getFormat($value);
								}
							}
						}
						break;
					default:						
						$criterea = array(
							'limit'		=> $limit,
							'fields' 	=> 'id,link,creator(id,first_name,last_name,url,image[236x],username),image,note,created_at'
						);

						if (false !== ($data = $this->getSource()->request('me/pins/', $criterea))) {
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
		 * @param Array $account.
		 * @return Array.
		 */
		private function getFormat($data, $account = array()) {
			$userImage		= '';
			
			$image 			= '';
			$video 			= '';

			foreach ($data['creator']['image'] as $value) {
				$userImage = $value['url'];
			}
			
			if (isset($data['image'])) {
				if (isset($data['image']['original'])) {
					$image = $data['image']['original']['url'];
				} else {
					foreach ($data['image'] as $value) {
						$image = $value['url'];
					}
				}
			}
			
			return array(
				'key'			=> $data['id'],
				'source'		=> strtolower($this->getName()),
				'user_name'		=> $this->getEmojiFormat($data['creator']['first_name'].' '.$data['creator']['last_name']),
				'user_account'	=> $this->getEmojiFormat($data['creator']['username']),
				'user_image'	=> str_replace(array('https:', 'http:'), array('', ''), $userImage),
				'user_url'		=> 'https://www.pinterest.com/'.$data['creator']['username'],
				'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', $data['note']))),
				'image'			=> $image,
				'video'			=> $video,
				'url'			=> 'https://www.pinterest.com/pin/'.$data['id'],
				'created'		=> date('Y-m-d H:i:s', strtotime($data['created_at']))
			);
		}
	}

?>
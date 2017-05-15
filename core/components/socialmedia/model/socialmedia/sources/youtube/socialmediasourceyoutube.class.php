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
	
	require_once dirname(__FILE__).'/youtube.class.php';
	
	class SocialMediaSourceYoutube extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'Youtube';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Youtube($this->modx);
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
							'q'				=> str_replace('#', '', $type),
							'part'			=> 'snippet',
							'maxResults'	=> $limit,
							'type'			=> 'video'
						);
						
						if (false !== ($data = $this->getSource()->request('search', $criterea))) {
							if (isset($data['items'])) {
								foreach ($data['items'] as $value) {
									if (isset($value['snippet']['channelId'])) {
										$criterea = array(
											'id' 	=> $value['snippet']['channelId'],
											'part' 	=> 'snippet,contentDetails,status',
										);

										if (false !== ($account = $this->getSource()->request('channels', $criterea))) {
											if (isset($account['items'])) {
												foreach ($account['items'] as $account) {
													$output[] = $this->getFormat($value, $account);
												}
											}
										}
									}
								}
							}
						}
						
						break;
					default:
						$type = str_replace('@', '', $type);
						
						if (in_array($type, array('self', 'me'))) {
							$criterea = array(
								'mine' => 'true'
							);
						} else {
							if ('$' == substr($type, 0, 1)) {
								$criterea = array(
									'id' => str_replace('$', '', $type)
								);
							} else {
								$criterea = array(
									'forUsername' => $type
								);
							}
						}
						
						$criterea = array_merge($criterea, array(
							'part' => 'snippet,contentDetails,status',
						));
						
						if (false !== ($account = $this->getSource()->request('channels', $criterea))) {
							if (isset($account['items'])) {
								foreach ($account['items'] as $account) {
									if (isset($account['contentDetails']['relatedPlaylists']['uploads'])) {
										$criterea = array(
											'part'			=> 'snippet,contentDetails,status',
											'playlistId'	=> $account['contentDetails']['relatedPlaylists']['uploads'],
											'maxResults'	=> $limit
										);

										if (false !== ($data = $this->getSource()->request('playlistItems', $criterea))) {
											if (isset($data['items'])) {
												foreach ($data['items'] as $value) {
													$output[] = $this->getFormat($value, $account);
												}
											}
										}
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
			if (isset($data['snippet'])) {
				$id				= '';
				
				$userName 		= '';
				$userAccount 	= '';
				$userImage 		= '';
				$userUrl		= '';
				
				$image 			= '';
				$video 			= '';
				
				if (isset($data['id']['videoId'])) {
					$id = $data['id']['videoId'];
				} else {
					$id = $data['snippet']['resourceId']['videoId'];
				}
				
				if (isset($account['snippet'])) {
					$userName 		= $account['snippet']['title'];

					if (isset($account['snippet']['customUrl'])) {
						$userAccount 	= $account['snippet']['customUrl'];
						$userUrl		= 'https://www.youtube.com/'.$account['snippet']['customUrl'];
					} else {
						$userAccount 	= $account['snippet']['title'];
						$userUrl		= 'https://www.youtube.com/channel/'.$account['id'];
					}
					
					foreach ($account['snippet']['thumbnails'] as $thumbnail) {
						$userImage	= $thumbnail['url'];
					}
				}
				
				if (isset($data['snippet']['thumbnails'])) {
					foreach ($data['snippet']['thumbnails'] as $media) {
						$image = str_replace(array('https:', 'http:'), array('', ''), $media['url']);
					}
				}
				
				return array(
					'key'			=> $id,
					'source'		=> strtolower($this->getName()),
					'user_name'		=> $this->getEmojiFormat($userName),
					'user_account'	=> $this->getEmojiFormat($userAccount),
					'user_image'	=> str_replace(array('https:', 'http:'), array('', ''), $userImage),
					'user_url'		=> $userUrl,
					'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', $data['snippet']['title']))),
					'image'			=> $image,
					'video'			=> 'https://www.youtube.com/watch?v='.$id,
					'url'			=> 'https://www.youtube.com/watch?v='.$id,
					'created'		=> date('Y-m-d H:i:s', strtotime($data['snippet']['publishedAt']))
				);
			}
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
		 */
		public function getHtmlFormat($content) {
			$content = preg_replace("/@(\w+)/", "<a href=\"https://www.youtube.com/user/\\1\" target=\"_blank\">@\\1</a>", $content);
			$content = preg_replace("/#(\w+)/", "<a href=\"https://www.youtube.com/results?search_query=\\1\" target=\"_blank\">#\\1</a>", $content);
			
			return $content;
		}
	}

?>
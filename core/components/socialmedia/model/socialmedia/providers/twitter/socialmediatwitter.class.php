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

	require_once dirname(dirname(dirname(__FILE__))).'/socialmediaprovider.class.php';
	
	require_once dirname(__FILE__).'/twitter.class.php';
	
	class SocialMediaTwitter extends SocialMediaProvider {
		/**
		 * @acces protected.
		 * @var Object.
		 */
		protected $provider;
		
		/**
		 * @acces private.
		 */
		private function setProvider() {
			$this->provider = new Twitter($this->modx);
		}
		
		/**
		 * @acces private.
		 * @return Object.
		 */
		private function getProvider() {
			if (null === $this->provider) {
				$this->setProvider();
			}
			
			return $this->provider;
		}
		/**
		 * @acces public.
		 * @param String|Array $types.
		 * @return Array.
		 */
		public function get($types) {
			$output = false;
			
			if (is_string($types)) {
				$types = array($types);
			}
			
			foreach ($types as $type) {
				switch (substr($type, 0, 1)) {
					case '@':
						$data = $this->getProvider()->request('statuses/user_timeline', array(
							'screen_name'	=> substr($type, 1, strlen($type))
						));
						
						if ($data) {
							foreach ($data as $key => $value) {
								$media		= '';
								$content	= $value['text'];
								
								if (isset($value['entities']['media'])) {
									foreach ($value['entities']['media'] as $mediaValue) {
										$media 		= $mediaValue['media_url'];
										$content 	= str_replace($mediaValue['url'], '', $content);
									}
								}
								
								$output[] = array(
									'type'				=> 'Twitter',
									'id'				=> $value['id'],
									'createdon'			=> $value['created_at'],
									'content'			=> trim($content),
									'user_id'			=> $value['user']['id'],
									'user_name'			=> $value['user']['name'],
									'user_account'		=> $value['user']['screen_name'],
									'user_location'		=> $value['user']['location'],
									'user_description'	=> $value['user']['description'],
									'user_url'			=> 'http://www.twitter.com/'.$value['user']['screen_name'],
									'user_followers'	=> $value['user']['followers_count'],
									'user_following'	=> $value['user']['friends_count'],
									'user_tweets'		=> $value['user']['statuses_count'],
									'user_image'		=> isset($value['user']['profile_image_url']) ? $value['user']['profile_image_url'] : '',
									'user_banner'		=> isset($value['user']['profile_banner_url']) ? $value['user']['profile_banner_url'] : '',
									'media'				=> $media
								);
							}
						}
				
						break;
					case '#':
						$data = $this->getProvider()->request('search/tweets', array(
							'q'	=> $type
						));
	
						if ($data) {
							foreach ($data['statuses'] as $key => $value) {
								$media		= '';
								$content	= $value['text'];
								
								if (isset($value['entities']['media'])) {
									foreach ($value['entities']['media'] as $mediaValue) {
										$media 		= $mediaValue['media_url'];
										$content 	= str_replace($mediaValue['url'], '', $content);
									}
								}
								
								$output[] = array(
									'type'				=> 'Twitter',
									'id'				=> $value['id'],
									'createdon'			=> $value['created_at'],
									'content'			=> trim($content),
									'user_id'			=> $value['user']['id'],
									'user_name'			=> $value['user']['name'],
									'user_account'		=> $value['user']['screen_name'],
									'user_location'		=> $value['user']['location'],
									'user_description'	=> $value['user']['description'],
									'user_url'			=> 'http://www.twitter.com/'.$value['user']['screen_name'],
									'user_followers'	=> $value['user']['followers_count'],
									'user_following'	=> $value['user']['friends_count'],
									'user_tweets'		=> $value['user']['statuses_count'],
									'user_image'		=> isset($value['user']['profile_image_url']) ? $value['user']['profile_image_url'] : '',
									'user_banner'		=> isset($value['user']['profile_banner_url']) ? $value['user']['profile_banner_url'] : '',
									'media'				=> $media
								);
							}
						}
						
						break;
				}
			}

			if (is_array($output)) {
				$sort = array();
				
				foreach ($output as $key => $value) {
				    $sort[$key] = strtotime($value['createdon']);
				}
				
				array_multisort($sort, SORT_DESC, $output);
			}

			return $output;
		}
	}

?>
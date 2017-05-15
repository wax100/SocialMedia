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
	
	require_once dirname(__FILE__).'/linkedin.class.php';
	
	class SocialMediaSourceLinkedin extends SocialMediaSource {
		/**
		 * @access public.
		 * @var String.
		 */
		public $name = 'LinkedIn';
		
		/**
		 * @access public.
		 */
		public function setSource() {
			$this->source = new Linkedin($this->modx);
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
						
						$criterea = array(
							'count' => $limit	
						);
						
						if (false !== ($account = $this->getSource()->request('companies/'.$type.':(id,name,logo-url,universal-name)'))) {
							if (false !== ($data = $this->getSource()->request('companies/'.$type.'/updates', $criterea))) {
								if (isset($data['values'])) {
									foreach ($data['values'] as $value) {
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
			if (isset($data['updateContent']['companyStatusUpdate']['share'])) {
				$image = '';
				$video = '';
				
				$url = array();
				
				if (isset($data['updateContent']['companyStatusUpdate']['share']['content']['submittedUrl'])) {
					if (!isset($data['updateContent']['companyStatusUpdate']['share']['content']['title'])) {
						$image = str_replace(array('https:', 'http:'), array('', ''), $data['updateContent']['companyStatusUpdate']['share']['content']['submittedUrl']);
					}
				}
				
				$url = explode('-', $data['updateKey']);

				return array(
					'key'			=> $data['updateContent']['companyStatusUpdate']['share']['id'],
					'source'		=> strtolower($this->getName()),
					'user_name'		=> $this->getEmojiFormat($account['name']),
					'user_account'	=> $this->getEmojiFormat($account['universalName']),
					'user_image'	=> str_replace(array('https:', 'http:'), array('', ''), $account['logoUrl']),
					'user_url'		=> 'https://www.linkedin.com/company-beta/'.$account['id'],
					'content'		=> $this->getEmojiFormat(trim(preg_replace('/\s+/', ' ', $data['updateContent']['companyStatusUpdate']['share']['comment']))),
					'image'			=> $image,
					'video'			=> $video,
					'url'			=> 'https://www.linkedin.com/hp/update/'.end($url),
					'created'		=> date('Y-m-d H:i:s', $data['updateContent']['companyStatusUpdate']['share']['timestamp'] / 1000)
				);
			}
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
		 */
		public function getHtmlFormat($content) {
			return preg_replace("/#(\w+)/", "<a href=\"https://www.linkedin.com/search/results/index/?keywords=\\1\" target=\"_blank\">#\\1</a>", $content);
		}
	}

?>
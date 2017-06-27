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

	class SocialMediaSource {
		/**
		 * @access public.
		 * @var Object.
		 */
		public $modx;
		
		/**
		 * @access public.
		 * @var Object.
		 */
		public $socialmedia;
		
		/**
		 * @access protected.
		 * @var Object.
		 */
		protected $source;

		/**
		 * @access public.
		 * @param Object $modx.
		 * @param Object $socialmedia.
		 */
		public function __construct(modX &$modx, &$socialmedia) {
			$this->modx =& $modx;
			$this->socialmedia =& $socialmedia;
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
		 * @return Object.
		 */
		public function getSource() {
			if (null === $this->source) {
				$this->setSource();
			}
			
			return $this->source;
		}
		
		/**
		 * @access public.
		 * @return Boolean.
		 */
		public function showEmptyPosts() {
			return (bool) $this->modx->getOption('socialmedia.source_'.strtolower($this->getName()).'_empty_posts', null, false);
		}
		
		/**
		 * @access public.
		 * @param Array $data.
		 * @return Array.
	     */
		public function getDataSort($data) {
			$sort = array();
			
			foreach ($data as $key => $value) {
			    $sort[$key] = strtotime($value['created']);
			}
			
			array_multisort($sort, SORT_DESC, $data);
			
			return $data;
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
	     */
		public function getHtmlFormat($content) {
	    	return $content;
    	}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @return String.
	     */
	    public function getEmojiFormat($content) {
	        $replaceCharacters = '/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}';
	        $replaceCharacters .= '|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|';
	        $replaceCharacters .= '\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?';
	        $replaceCharacters .= '|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?';
	        $replaceCharacters .= '|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?';
	        $replaceCharacters .= '|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?';
	        $replaceCharacters .= '|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u';

	        return preg_replace($replaceCharacters, '', $content);
    	}
	}

?>
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

	class SocialMedia {
		/**
		 * @access public.
		 * @var Object.
		 */
		public $modx;
		
		/**
		 * @access public.
		 * @var Array.
		 */
		public $config = array();
		
		/**
		 * @access public.
		 * @var Array.
		 */
		public $properties = array();

		/**
		 * @access public.
		 * @param Object $modx.
		 * @param Array $config.
		 */
		public function __construct(modX &$modx, array $config = array()) {
			$this->modx =& $modx;

			$corePath 		= $this->modx->getOption('socialmedia.core_path', $config, $this->modx->getOption('core_path').'components/socialmedia/');
			$assetsUrl 		= $this->modx->getOption('socialmedia.assets_url', $config, $this->modx->getOption('assets_url').'components/socialmedia/');
			$assetsPath 	= $this->modx->getOption('socialmedia.assets_path', $config, $this->modx->getOption('assets_path').'components/socialmedia/');
		
			$this->config = array_merge(array(
				'namespace'				=> $this->modx->getOption('namespace', $config, 'socialmedia'),
				'lexicons'				=> array('socialmedia:default'),
				'base_path'				=> $corePath,
				'core_path' 			=> $corePath,
				'model_path' 			=> $corePath.'model/',
				'processors_path' 		=> $corePath.'processors/',
				'elements_path' 		=> $corePath.'elements/',
				'chunks_path' 			=> $corePath.'elements/chunks/',
				'cronjobs_path' 		=> $corePath.'elements/cronjobs/',
				'plugins_path' 			=> $corePath.'elements/plugins/',
				'snippets_path' 		=> $corePath.'elements/snippets/',
				'assets_path' 			=> $assetsPath,
				'js_url' 				=> $assetsUrl.'js/',
				'css_url' 				=> $assetsUrl.'css/',
				'assets_url' 			=> $assetsUrl,
				'connector_url'			=> $assetsUrl.'connector.php',
				'version'				=> '1.1.0',
				'branding'				=> (boolean) $this->modx->getOption('socialmedia.branding', null, true),
				'branding_url'			=> 'http://www.oetzie.nl',
				'branding_help_url'		=> 'http://www.werkvanoetzie.nl/extras/socialmedia',
				'word_filter'			=> $this->modx->getOption('socialmedia.word_filter', null, '')
			), $config);
			
			$this->modx->addPackage('socialmedia', $this->config['model_path']);
			
			if (is_array($this->config['lexicons'])) {
				foreach ($this->config['lexicons'] as $lexicon) {
					$this->modx->lexicon->load($lexicon);
				}
			} else {
				$this->modx->lexicon->load($this->config['lexicons']);
			}
		}
		
		/**
		 * @access public.
		 * @return String.
		 */
		public function getHelpUrl() {
			return $this->config['branding_help_url'].'?v='.$this->config['version'];
		}
				
		/**
		 * @access protected.
		 * @param String $tpl.
		 * @param Array $properties.
		 * @param String $type.
		 * @return String.
		 */
		protected function getTemplate($template, $properties = array(), $type = 'CHUNK') {
			if (0 === strpos($template, '@')) {
				$type 		= substr($template, 1, strpos($template, ':') - 1);
				$template	= substr($template, strpos($template, ':') + 1, strlen($template));
			}
			
			switch (strtoupper($type)) {
				case 'INLINE':
					$chunk = $this->modx->newObject('modChunk', array(
						'name' => $this->config['namespace'].uniqid()
					));
				
					$chunk->setCacheable(false);
				
					$output = $chunk->process($properties, ltrim($template));
				
					break;
				case 'CHUNK':
					$output = $this->modx->getChunk(ltrim($template), $properties);
				
					break;
			}
			
			return $output;
		}
		
		/**
		 * @access public.
		 * @param String $source.
		 * @return Object|Null.
		 */
		public function getSource($source) {
			$class = 'SocialMediaSource'.ucfirst($source);
			
			if ($this->modx->loadClass($class, $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/sources/'.$source.'/', true, true)) {
				$instance = new $class($this->modx, $this);
				
				if ($instance instanceOf SocialMediaSource) {
					return $instance;
				}
			}
			
			return null;
		}
		
		/**
		 * @access public.
		 * @param Array $scriptProperties.
		 * @return Boolean.
		 */
		public function setScriptProperties($scriptProperties = array()) {
			$this->properties = array_merge(array(
				'group'			=> '',
				'limit'			=> 5,
				'tpls'			=> '{}',
				'tplsGroup'		=> '{}',
				'toJson'		=> false,
				'sort'			=> '{"created": "DESC"}',
				'sources'		=> '{}'
			), $scriptProperties);

			return $this->setDefaultProperties();
		}
		
		/**
		 * @access protected.
		 * @return Boolean.
		 */
		protected function setDefaultProperties() {
			if (is_string($this->properties['limit'])) {
				$this->properties['limit'] = (int) $this->properties['limit'];
			}
			
			if (is_string($this->properties['tpls'])) {
				$this->properties['tpls'] = $this->modx->fromJSON($this->properties['tpls']);
			}
			
			if (is_string($this->properties['tplsGroup'])) {
				$this->properties['tplsGroup'] = $this->modx->fromJSON($this->properties['tplsGroup']);
			}
			
			if (is_string($this->properties['sources'])) {
				$this->properties['sources'] = $this->modx->fromJSON($this->properties['sources']);
			}
			
			if (is_string($this->properties['sort'])) {
				if (!in_array(strtoupper($this->properties['sort']), array('RAND', 'RAND()'))) {
					if (false === strstr($this->properties['sort'], '{')) {
						$this->properties['sort'] = array(
							$this->properties['sort'] => 'ASC'
						);
					} else {
						$this->properties['sort'] = $this->modx->fromJSON($this->properties['sort']);
					}
				}
			}
			
			return true;
		}
		
		/**
		 * @access public.
		 * @param Array $properties.
		 * @return String.
		 */
		public function run($properties = array()) {
			$this->setScriptProperties($properties);
			
			$c = $this->modx->newQuery('SocialMediaMessages');
			
			$c->where(array(
				'active' 		=> 1,
				'content:!='	=> ''
			));
			
			foreach (array_filter(explode(',', $this->config['word_filter'])) as $word) {
				if (empty($words)) {
					$c->where(array(
						'content:NOT LIKE'	=> '%'.trim($word).'%'
					));
				}
			}
			
			if (!empty($this->properties['sources'])) {
				$sources = array();
				
				foreach ($this->properties['sources'] as $key => $value) {
					if (is_numeric($key)) {
						$sources[] = array(
							'source'			=> $value
						);
					} else {
						if (is_string($value)) {
							$value = array($value);
						}

						$sources[] = array(
							'source'			=> $key,
							'AND:criterea:IN'	=> $value
						);
					}
				}
				
				$c->where($sources, xPDOQuery::SQL_OR);
			}

			if (is_array($this->properties['sort'])) {
				foreach ($this->properties['sort'] as $key => $value) {
					$c->sortby($key, $value);
				}
			} else if (is_string($this->properties['sort'])) {
				if (in_array(strtoupper($this->properties['sort']), array('RAND', 'RAND()'))) {
					$c->sortby('RAND()');
				}
			}
			
			if (0 != $this->properties['limit']) {
				$c->limit($this->properties['limit']);
			}
			
			$output	= array();
			$data	= array_values($this->modx->getCollection('SocialMediaMessages', $c));
			
			if ('' != ($group = $this->properties['group'])) {
				if (is_numeric($group)) {
					$output = array_chunk($data, (int) $group, true);
				} else {
					foreach ($data as $key => $value) {
						if (in_array($group, array('source', 'user_name', 'user_account'))) {
							$output[$value->{$group}][] = $value;
						}
					}
				}
			} else {
				$output = array($data);
			}

			foreach ($output as $mainKey => $group) {
				foreach ($group as $key => $value) {
					$class = array();
								
					if (0 == $key) {
						$class[] = 'first';
					}
					
					if (count($output) - 1 == $key) {
						$class[] = 'last';
					}
					
					$class[] = 0 == $key % 2 ? 'odd' : 'even';
					$class[] = strtolower($value->source);
					
					if (!empty($value->image)) {
						$class[] = 'has-image';
					}
					
					if (!empty($value->video)) {
						$class[] = 'has-video';
					}
					
					//if ((bool) $this->properties['toJson']) {
					//	$group[$key] = array_merge(array(
					//		'content_html'	=> $this->getHtmlFormat($value->content, $value->source),
					//		'time_ago'		=> $this->getTimeAgo($value->created)
					//	), $value->toArray());
					//} else {
						$tpl = '';
						
						if (isset($this->properties['tpl'])) {
							$tpl = $this->properties['tpl'];
						}
						
						if (isset($this->properties['tpls'])) {
							$tpls = $this->properties['tpls'];
							
							if (isset($tpls[strtolower($value->source)])) {
								$tpl = $tpls[strtolower($value->source)];
							}
						}
						
						$group[$key] = $this->getTemplate($tpl, array_merge(array(
							'class' 		=> implode(' ', $class),
							'content_html'	=> $this->getHtmlFormat($value->content, $value->source),
							'time_ago'		=> $this->getTimeAgo($value->created)
						), $value->toArray()));
					//}
				}
				
				//if (!(bool) $this->properties['toJson']) {
					$tpl = '';
					
					if (isset($this->properties['tplGroup'])) {
						$tpl = $this->properties['tplGroup'];
					}
					
					if (isset($this->properties['tplsGroup'])) {
						$tpls = $this->properties['tplsGroup'];
						
						if (isset($tpls[$mainKey])) {
							$tpl = $tpls[$mainKey];
						}
					}
					
					if (!empty($tpl)) {
						$output[$mainKey] = $this->getTemplate($this->properties['tplWrapper'], array(
							'output' => implode(PHP_EOL, $group)
						));
					} else {
						$output[$mainKey] = implode(PHP_EOL, $group);
					}
				//}
			}
			
			if (0 < count($output)) {
				//if ((bool) $this->properties['toJson']) {
				//	return $this->modx->toJSON(array(
				//		'total'		=> count($output),
				//		'output'	=> $output
				//	));
				//} else {
					if (isset($this->properties['tplWrapper'])) {
						return $this->getTemplate($this->properties['tplWrapper'], array(
							'output' => implode(PHP_EOL, $output)
						));
					}
					
					return implode(PHP_EOL, $output);
				//}
			}
			
			//if ((bool) $this->properties['toJson']) {
			//	return $this->modx->toJSON(array(
			//		'total'		=> 0,
			//		'output'	=> array()
			//	));
			//} else {
				if (isset($this->properties['tplWrapperEmpty'])) {
					return $this->getTemplate($this->properties['tplWrapperEmpty']);
				}
			//}

			return '';	
		}
		
		/**
		 * @access public.
		 * @param String $content.
		 * @param String $source.
		 * @return String.
		 */
		public function getHtmlFormat($content, $source) {
            $content = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $content);
            $content = preg_replace("#(^|[\n ])((http|www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $content);
            
            if (null !== ($source = $this->getSource($source))) {
	            $content = $source->getHtmlFormat($content);
            }
            
            return $content;
		}
		
		/**
		 * @access public.
		 * @param String|Integer $timestamp.
		 * @return String.
		 */
		public function getTimeAgo($timestamp) {
			if (is_string($timestamp)) {
				$timestamp = strtotime($timestamp);
			}
			
			$days = floor((time() - $timestamp) / 86400);
            $minutes = floor((time() - $timestamp) / 60);
               
            $output = array(
	            'minutes'	=> $minutes,
	            'hours'		=> ceil($minutes / 60),
    		    'days'      => $days,
    		    'weeks'     => ceil($days / 7),
    		    'months'    => ceil($days / 30),
    		    'date'      => $date
    	    );
    	    
        	if ($days < 1) {
	        	if ($minutes < 1) {
		        	return $this->modx->lexicon('socialmedia.time_seconds', $output);
	        	} else if ($minutes == 1) {
		        	return $this->modx->lexicon('socialmedia.time_minute', $output);
	        	} else if ($minutes <= 59) {
		        	return $this->modx->lexicon('socialmedia.time_minutes', $output);
	        	} else if ($minutes == 60) {
		        	return $this->modx->lexicon('socialmedia.time_hour', $output);
	        	} else if ($minutes <= 1380) {
		        	return $this->modx->lexicon('socialmedia.time_hours', $output);
	        	} else {
		        	return $this->modx->lexicon('socialmedia.time_day', $output);
	        	}
        	} else if ($days == 1) {
	        	return $this->modx->lexicon('socialmedia.time_day', $output);
        	} else if ($days <= 6) {
	        	return $this->modx->lexicon('socialmedia.time_days', $output);
        	} else if ($days <= 7) {
	        	return $this->modx->lexicon('socialmedia.time_week', $output);
        	} else if ($days <= 29) {
        		return $this->modx->lexicon('socialmedia.time_weeks', $output);
        	} else if ($days <= 30) {
        		return $this->modx->lexicon('socialmedia.time_month', $output);
        	} else if ($days <= 180) {
        		return $this->modx->lexicon('socialmedia.time_months', $output);
        	} else {
        		return $this->modx->lexicon('socialmedia.time_to_long', $output);
        	}
		}
	}

?>
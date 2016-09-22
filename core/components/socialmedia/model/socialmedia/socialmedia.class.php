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

	class SocialMedia {
		/**
		 * @acces public.
		 * @var Object.
		 */
		public $modx;
		
		/**
		 * @acces public.
		 * @var Array.
		 */
		public $config = array();
		
		/**
		 * @acces public.
		 * @var Array.
		 */
		public $properties = array();

		/**
		 * @acces public.
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
				'helpurl'				=> $this->modx->getOption('helpurl', $config, 'socialmedia'),
				'language'				=> 'socialmedia:default',
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
				'connector_url'			=> $assetsUrl.'connector.php'
			), $config);
			
			$this->modx->addPackage('socialmedia', $this->config['model_path']);
		}
				
		/**
		 * @acces protected.
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
		 * @acces public.
		 * @param Array $scriptProperties.
		 * @return Boolean.
		 */
		public function setScriptProperties($scriptProperties = array()) {
			$this->properties = array_merge(array(
				'limit'			=> 0,
				'tpls'			=> '{}',
				'toJson'		=> false,
				'providers'		=> '{}',
			), $scriptProperties);

			return $this->setDefaultProperties();
		}
		
		/**
		 * @acces protected.
		 * @return Boolean.
		 */
		protected function setDefaultProperties() {
			if (is_string($this->properties['limit'])) {
				$this->properties['limit'] = (int) $this->properties['limit'];
			}
			
			if (is_string($this->properties['tpls'])) {
				$this->properties['tpls'] = $this->modx->fromJSON($this->properties['tpls']);
			}
			
			if (is_string($this->properties['providers'])) {
				$this->properties['providers'] = $this->modx->fromJSON($this->properties['providers']);
			}
			
			return true;
		}
		
		/**
		 * @acces public.
		 * @param Array $properties.
		 * @return String.
		 */
		public function run($properties = array()) {
			$this->setScriptProperties($properties);

			$output = array();
			
			foreach ($this->getProviders() as $type => $provider) {
				if (isset($this->properties['providers'][$type])) {
					if (false !== ($data = $provider->get($this->properties['providers'][$type]))) {
						foreach ($data as $key => $value) {
							$output[] = $value;
							
							if (0 != $this->properties['limit'] && $this->properties['limit'] - 1 == $key) {
								break;
							}
						}
					}
				}
			}
			
			foreach ($output as $key => $value) {
				$class = array();
							
				if (0 == $key) {
					$class[] = 'first';
				}
				
				if (count($output) - 1 == $key) {
					$class[] = 'last';
				}
				
				$class[] = 0 == $key % 2 ? 'odd' : 'even';
				$class[] = strtolower($value['type']);
				
				$tpl = $this->properties['tpl'];
				
				if (isset($this->properties['tpls'])) {
					$tpls = $this->properties['tpls'];
					
					if (isset($tpls[$value['type']])) {
						$tpl = $tpls[$value['type']];
					}
				}
				
				if (!(bool) $this->properties['toJson']) {
					$output[$key] = $this->getTemplate($tpl, array_merge(array(
						'class' => implode(' ', $class)
					), $value));
				}
			}
			
			if (0 < count($output)) {
				if ((bool) $this->properties['toJson']) {
					return $this->modx->toJSON(array(
						'total'		=> count($output),
						'output'	=> $output
					));
				} else {
					if (isset($this->properties['tplWrapper'])) {
						return $this->getTemplate($this->properties['tplWrapper'], array(
							'output' => implode(PHP_EOL, $output)
						));
					}
					
					return implode(PHP_EOL, $output);
				}
			}
			
			if (isset($this->properties['tplWrapperEmpty'])) {
				return $this->getTemplate($this->properties['tplWrapperEmpty']);
			}

			return '';	
		}
		
		/**
		 * @acces protected.
		 */
		protected function getProviders() {
			$providers = array();
			
			foreach ($this->properties['providers'] as $key => $value) {
				$class = 'SocialMedia'.ucfirst($key);
				
				if ($this->modx->loadClass($class, $this->modx->getOption('socialmedia.core_path', null, $this->modx->getOption('core_path').'components/socialmedia/').'model/socialmedia/providers/'.$key.'/', true, true)) {
					$provider = new $class($this->modx, $this);
					
					if ($provider instanceOf SocialMediaProvider) {
						$providers[$key] = $provider;
					}
				}
			}
			
			return $providers;
		}
	}

?>
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
	 
	require_once dirname( __FILE__ ).'/socialmedia.class.php';

	class SocialMediaCronjob extends SocialMedia {
		/**
		 * @access protected.
		 * @var Array.
		 */
	    protected $timer = array(
	    	'start'	=> null,
	    	'end'	=> null,
	    	'time'	=> null
	    );
	    
	    /**
		 * @access protected.
		 * @var Boolean.
		 */
	    protected $debugMode = false;
	    
	    /**
		 * @access protected.
		 * @var Array|String.
		 */
	    protected $sources = array();
	    
	    /**
		 * @access protected.
		 * @var Array.
		 */
	    protected $logs = array(
		    'log'	=> array(),
		    'html'	=> array(),
		    'clean'	=> array()
	    );
	    
	    /**
		 * @access public.
		 * @param Object $modx.
		 * @param Array $config.
		*/
		public function __construct(modX &$modx, array $config = array()) {
			parent::__construct($modx, $config);
		}
		
		/**
	     * @access public.
	     * @param Boolean $debugMode.
	     * @return Boolean.
	     */
	    public function setDebugMode($debugMode) {
	        if ($debugMode) {
	            $this->log('Debug mode is enabled. No database queries or send actions will be executed.', 'notice');
	        }
	
	        $this->debugMode = $debugMode;
	
	        return true;
	    }
	
	    /**
	     * @access public.
	     * @return Boolean.
	     */
	    public function getDebugMode() {
	        return $this->debugMode;
	    }
	    
	    /**
		 * @access public.
		 * @param Array|String $sources.
		 * @return Boolean.
		 */
	    public function setSources($sources = array()) {
		    if (is_string($sources)) {
			    $sources = $this->modx->fromJSON($sources);
		    }
		    
		    $this->sources = $sources;
		    
		    return true;
	    }
	    
	    /**
		 * @access public.
		 * @return Array.
		 */
		public function getSources() {
			if (empty($this->sources)) {
				$this->setSources($this->modx->getOption('socialmedia.default_sources'));
			}
			
			return $this->sources;
		}
	    
	    /**
	     * @access protected.
	     * @return Boolean.
	     */
	    protected function setTimer($type) {
		    $this->timer[$type] = microtime(true);
		    
		    switch ($type) {
				case 'start':
					$this->log('Start import process at '.date('d-m-Y H:i:s').'.');
					
					break;
				case 'end':
					$this->timer['time'] = $this->timer['end'] - $this->timer['start'];
					 
					$this->log('End import process at '.date('d-m-Y H:i:s').'.');
					$this->log('Total execution time in seconds: '.number_format($this->timer['time'], 2).'.');
				
					break;
		    }
	    }
	    
		/**
	     * @access protected.
	     * @param String $message.
	     * @param String $level.
	     * @return Boolean.
	     */
		protected function log($message, $level = 'info') {
	        switch ($level) {
	            case 'error':
	                $prefix = 'ERROR::';
	                $color = 'red';
	                break;
	            case 'notice':
	                $prefix = 'NOTICE::';
	                $color = 'yellow';
	                break;
	            case 'success':
	                $prefix = 'SUCCESS::';
	                $color = 'green';
	                break;
	            default:
	                $prefix = 'INFO::';
	                $color = 'blue';
	                
	                break;
	        }
	
	        $log 	= $this->colorize($prefix, $color).' '.$message;
	        $html 	= '<span style="color: '.$color.'">'.$prefix.'</span> '.$message;
	
	        if (XPDO_CLI_MODE) {
	            $this->modx->log(MODX_LOG_LEVEL_INFO, $log);
	        } else {
	            $this->modx->log(MODX_LOG_LEVEL_INFO, $html);
	        }
	
	        /*
	         * logMessage has CLI markup
	         * htmlMessage has HTML markup
	         * cleanMessage has no markup
	         */
	        $this->logs['log'][]   = $log;
	        $this->logs['html'][]  = $html;
	        $this->logs['clean'][] = $prefix.' '.$message;
	
	        return true;
	    }
	    
	    /**
	     * @access protected.
	     * @param String $string.
	     * @param String $color.
	     * @return String.
	     */
	    protected function colorize($string, $color = 'white') {
	        switch ($color) {
	            case 'red':
	                return "\033[31m".$string."\033[39m";
	                
	                break;
	            case 'green':
	                return "\033[32m".$string."\033[39m";
	                
	                break;
	            case 'yellow':
	                return "\033[33m".$string."\033[39m";
	                
	                break;
	            case 'blue':
	                return "\033[34m".$string."\033[39m";
	                
	                break;
	            default:
	                return $string;
	                
	                break;
	        }
	    }
	    
	    /**
		 * @access public.
		 * @return Boolean.
		 */
		public function run() {
			$this->setState('start');
			$this->setTimer('start');
			
			$this->import();
			
			$this->setTimer('end');
			$this->setState('end');

			return true;
		}
		
		/**
		 * @access protected.
		 * @param String $type.
		 * @return Boolean.
		 */
		protected function setState($type) {
			switch ($type) {
				case 'start':
					
					break;
				case 'end':
					if ($log = $this->setLogFile()) {
						if (1 == $this->modx->getOption('socialmedia.log_send') && !$this->getDebugMode()) {
							$this->sendLogFile($log);
						}
					}
					
					$this->cleanFiles();
					
					break;
			}
		
			return true;
		}
		
		/**
	     * @access protected.
	     * @return String|Boolean.
	     */
	    protected function setLogFile() {
	        $path 		= dirname(dirname(dirname(__FILE__))).'/logs/';
	        $filename 	= $path.date('Ymd_His').'.log';
	
	        if ($this->getDebugMode()) {
	            $filename = $path.'_DEBUG_'.date('Ymd_His').'.log';
	        }

	        if (is_dir($path) && is_writable($path)) {
		        if ($handle = fopen($filename, 'w')) {
			        if (isset($this->logs['clean']) || 0 == count($this->logs['clean'])) {
						fwrite($handle, implode(PHP_EOL, $this->logs['clean']));
						fclose($handle);
						
						$this->log('Log file created `'.$filename.'`.', 'success');  
						
						return $filename;
				    } else {
						$this->log('No messages to log', 'notice'); 
				    }
		        } else {
			        $this->log('Could not create log file.', 'notice');
		        }
	        } else {
				$this->log('Log directory `'.$path.'` does not exists or is not readable.', 'notice');
			}

	        return false;
	    }
	    
	    /**
	     * @access protected.
	     * @param String $log.
	     * @return Boolean.
	     */
	    protected function sendLogFile($log) {
	        if (null !== ($mail = $this->modx->getService('mail', 'mail.modPHPMailer'))) {
	        	$mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
				$mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
				$mail->set(modMail::MAIL_SUBJECT, $this->modx->getOption('site_name').' | Social Media sync');
	       
				$mail->set(modMail::MAIL_BODY, $this->modx->getOption('socialmedia.log_body', null, 'Log file is attached to this email.'));
				
				$mail->mailer->AddAttachment($log);
	
				$emails = $this->modx->getOption('socialmedia.log_email', null, $this->modx->getOption('emailsender'));
				
				if (is_string($emails)) {
					$emails = array($emails);
				}
				
	            foreach ($emails as $email) {
	                $mail->address('to', $email);
	            }
	
		        if ($mail->send()) {
			        $this->log('Log file send to `'.implode(', ', $emails).'`.', 'success');
			    } else {
		            $this->log('Log file send failed.', 'error');
		        }
	
				$mail->reset();
			}
			
			return true;
	    }
	    
	    /**
	     * @access protected.
	     * @return Boolean.
	     */
	    protected function cleanFiles() {
		    $this->log('Start clean up process.');
		    
		    $lifetime = $this->modx->getOption('socialmedia.log_lifetime', null, 7);
		    
            $this->log('Log file lifetime is `'.$lifetime.'` days.');
			
	        $files = array(
	        	'logs'	=> 0
	        );
	        
	        $path = dirname(dirname(dirname(__FILE__))).'/logs/';
	        
	        foreach (glob($path.'*.log') as $file) {
	            if (filemtime($file) < (time() - (86400 * $lifetime))) {
	                unlink($file);
	
	                $files['logs']++;
	            }
	        }

			$this->log($files['logs'].' log file(s) cleaned due lifetime.');
			
			$this->log('End clean up process.');
			
			return true;
		}

		/**
		 * @access public.
		 * @return Boolean.
		 */
		protected function import() {
			foreach ($this->getSources() as $key => $criterea) {
				if (null !== ($source = $this->getSource($key))) {
					if (is_string($criterea)) {
						$criterea = array($criterea);
					}
					
					foreach ($criterea as $search) {
						$count = array(
							'create' => array(),
							'update' => array()
						);
			
						$this->log('Import process for `'.$source->getName().'` with `'.$search.'`.');

						foreach ($source->getData($search) as $value) {
							$criterea = array(
								'key' 		=> $value['key'],
								'source'	=> $value['source']
							);
							
							if (null !== ($object = $this->modx->getObject('SocialMediaMessages', $criterea))) {
								$count['update'][] = $value['key'];
							} else {
								$object = $this->modx->newObject('SocialMediaMessages');
								
								$value = array_merge($value, array(
									'active' => $this->modx->getOption('socialmedia.default_active', null, 1)
								));
								
								$count['create'][] = $value['key'];
							}
							
							if (null !== $object) {
								$object->fromArray(array_merge($value, array(
									'criterea'	=> $search
								)));
								
								$object->save();
							}
						}
						
						$this->log(' - Created '.count($count['create']).' messages.');
						$this->log(' - Updated '.count($count['update']).' messages.');
					}
				} else {
					$this->log('Cannot initialize "'.$key.'" service.', 'error');
				}
			}
			
			return true;
		}
	}
	
?>
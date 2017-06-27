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

	$_lang['socialmedia'] 													= 'Social media';
	$_lang['socialmedia.desc']												= 'Manage all social media messages.';
		
	$_lang['area_socialmedia']												= 'Social media';
	
	$_lang['setting_socialmedia.api_useragent']								= 'API useragent';
	$_lang['setting_socialmedia.api_useragent_desc']						= 'The useragent for the APIs. Default is "SocialMediaOAuth v1.1.0".';
	$_lang['setting_socialmedia.default_active']							= 'Default status';
	$_lang['setting_socialmedia.default_active_desc']						= 'The default status of the social media messages during the synchronizing of the social media channels.';
	$_lang['setting_socialmedia.default_sources']							= 'Default channels';
	$_lang['setting_socialmedia.default_sources_desc']						= 'De default social media channels, this must be a valid JSON format. Default is "{"twitter": ["@modx", "#modx"], "instagram": ["#modx"]}" (# is a search query, @ is an username and $ is an users ID).';
	$_lang['setting_socialmedia.log_send']									= 'Send log';
	$_lang['setting_socialmedia.log_send_desc']								= 'When yes, send the log file that will be created by email.';
	$_lang['setting_socialmedia.log_email']									= 'Log e-mail address(es)';
	$_lang['setting_socialmedia.log_email_desc']							= 'The e-mail address(es) where the log file needs to be send. Separate e-mail addresses with a comma.';	
	$_lang['setting_socialmedia.log_lifetime']								= 'Log lifetime';
	$_lang['setting_socialmedia.log_lifetime_desc']							= 'The number of days that a log file needs to be saved, after this the log file will be deleted automatically.';
	$_lang['setting_socialmedia.word_filter']								= 'Word filter';
	$_lang['setting_socialmedia.word_filter_desc']							= 'The words that are not allowed in the social media messages, the social media messages that contains these words would not be shown. Separate words with a comma.';
	
	$_lang['setting_socialmedia.source_twitter_access_token']				= 'Twitter access token';
	$_lang['setting_socialmedia.source_twitter_access_token_desc']			= 'The Twitter access token, you can get this at https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_access_token_secret']		= 'Twitter access token secret';
	$_lang['setting_socialmedia.source_twitter_access_token_secret_desc']	= 'The Twitter access token secret, you can get this at https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_consumer_key']				= 'Twitter consumer key';
	$_lang['setting_socialmedia.source_twitter_consumer_key_desc']			= 'The Twitter consumer key, you can get this at https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_consumer_key_secret']		= 'Twitter consumer key secret';
	$_lang['setting_socialmedia.source_twitter_consumer_key_secret_desc']	= 'The Twitter consumer key secret, you can get this at https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_empty_posts']				= 'Twitter "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_twitter_empty_posts_desc']			= 'If yes, the Twitter message with "Unknown or empty message" will shown.';
	$_lang['setting_socialmedia.source_instagram_client_id']				= 'Instagram client ID';
	$_lang['setting_socialmedia.source_instagram_client_id_desc']			= 'The Instagram client ID, you can get this at https://www.instagram.com/developer/.';
	$_lang['setting_socialmedia.source_instagram_client_secret']			= 'Instagram client secret';
	$_lang['setting_socialmedia.source_instagram_client_secret_desc']		= 'The Instagram client secret, you can get this at https://www.instagram.com/developer/.';
	$_lang['setting_socialmedia.source_instagram_access_token']				= 'Instagram access token';
	$_lang['setting_socialmedia.source_instagram_access_token_desc']		= 'The Instagram access token, you can get this with oAuth';
	$_lang['setting_socialmedia.source_instagram_empty_posts']				= 'Instagram "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_instagram_empty_posts_desc']			= 'If yes, the Instagram message with "Unknown or empty message" will shown.';
	$_lang['setting_socialmedia.source_youtube_client_id']					= 'Youtube client ID';
	$_lang['setting_socialmedia.source_youtube_client_id_desc']				= 'The Youtube client ID, you can get this at https://console.developers.google.com/.';
	$_lang['setting_socialmedia.source_youtube_client_secret']				= 'Youtube client secret';
	$_lang['setting_socialmedia.source_youtube_client_secret_desc']			= 'The Youtube client secret, you can get this at https://console.developers.google.com/.';
	$_lang['setting_socialmedia.source_youtube_refresh_token']				= 'Youtube refresh token';
	$_lang['setting_socialmedia.source_youtube_refresh_token_desc']			= 'The Youtube refresh token, you can get this with oAuth with the minimum scope "https://www.googleapis.com/auth/youtube.readonly".';
	$_lang['setting_socialmedia.source_youtube_empty_posts']				= 'Youtube "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_youtube_empty_posts_desc']			= 'If yes, the Youtube message with "Unknown or empty message" will shown.';
	$_lang['setting_socialmedia.source_linkedin_client_id']					= 'LinkedIn client ID';
	$_lang['setting_socialmedia.source_linkedin_client_id_desc']			= 'The LinkedIn client ID, you can get this at https://www.linkedin.com/developer/.';
	$_lang['setting_socialmedia.source_linkedin_client_secret']				= 'LinkedIn client secret';
	$_lang['setting_socialmedia.source_linkedin_client_secret_desc']		= 'The LinkedIn client secret, you can get this at https://www.linkedin.com/developer/.';
	$_lang['setting_socialmedia.source_linkedin_access_token']				= 'LinkedIn access token';
	$_lang['setting_socialmedia.source_linkedin_access_token_desc']			= 'The LinkedIn access token, you can get this with oAuth with the minimum scope "rw_company_admin".';
	$_lang['setting_socialmedia.source_linkedin_empty_posts']				= 'LinkedIn "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_linkedin_empty_posts_desc']			= 'If yes, the LinkedIn message with "Unknown or empty message" will shown.';
	$_lang['setting_socialmedia.source_facebook_client_id']					= 'Facebook client ID';
	$_lang['setting_socialmedia.source_facebook_client_id_desc']			= 'The Facebook client ID, you can get this at https://developers.facebook.com/.';
	$_lang['setting_socialmedia.source_facebook_client_secret']				= 'Facebook client secret';
	$_lang['setting_socialmedia.source_facebook_client_secret_desc']		= 'The Facebook client secret, you can get this at https://developers.facebook.com/.';
	$_lang['setting_socialmedia.source_facebook_access_token']				= 'Facebook access token';
	$_lang['setting_socialmedia.source_facebook_access_token_desc']			= 'The Facebook access token, you can get this at oAuth with the minimum scope "user_posts".';
	$_lang['setting_socialmedia.source_facebook_empty_posts']				= 'Facebook "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_facebook_empty_posts_desc']			= 'If yes, the Facebook message with "Unknown or empty message" will shown.';
	$_lang['setting_socialmedia.source_pinterest_client_id']				= 'Pinterest client ID';
	$_lang['setting_socialmedia.source_pinterest_client_id_desc']			= 'The Pinterest client ID, you can get this at https://developers.pinterest.com/.';
	$_lang['setting_socialmedia.source_pinterest_client_secret']			= 'Pinterest client secret';
	$_lang['setting_socialmedia.source_pinterest_client_secret_desc']		= 'The Pinterest client secret, you can get this at https://developers.pinterest.com/.';
	$_lang['setting_socialmedia.source_pinterest_access_token']				= 'Pinterest access token';
	$_lang['setting_socialmedia.source_pinterest_access_token_desc']		= 'The Pinterest access token, you can get this with oAuth with the minimum scope "read_public".';
	$_lang['setting_socialmedia.source_pinterest_empty_posts']				= 'Pinterest "Unknown or empty message" show.';
	$_lang['setting_socialmedia.source_pinterest_empty_posts_desc']			= 'If yes, the Pinterest message with "Unknown or empty message" will shown.';
	
	$_lang['socialmedia.snippet_group_desc']								= 'The criteria to group the social media channels.';
	$_lang['socialmedia_snippet_limit_desc']								= 'The number of social media message that will be shown. Default is "5".';
	$_lang['socialmedia_snippet_sort_desc']									= 'The sort direction of the social media messages. Default is "{"created": "DESC"}".';
	$_lang['socialmedia_snippet_sources_desc']								= 'The default social media channels criteria, this must be a valid JSON format. When empty, all social media channels will be shown.';
	
	$_lang['socialmedia.message']											= 'Message';
	$_lang['socialmedia.messages']											= 'Messages';
	$_lang['socialmedia.messages_desc']										= 'Here you can manage all the message from the social media channels. Social media channels like <span class="twitter">Twitter</span>, <span class="instagram">Instagram</span>, <span class="facebook">Facebook</span>, <span class="linkedin">LinkedIn</span> or <span class="youtube">Youtube</span> will be synchronized automatically with MODX.';
	$_lang['socialmedia.message_show']										= 'Show on [[+source]]';
	$_lang['socialmedia.message_activate']									= 'Show message';
	$_lang['socialmedia.message_activate_confirm']							= 'Are you sure you want to show this message?';
	$_lang['socialmedia.message_deactivate']								= 'Hide message';
	$_lang['socialmedia.message_deactivate_confirm']						= 'Are you sure you want to hide this message?';
	
	$_lang['socialmedia.label_source']										= 'Channel';
	$_lang['socialmedia.label_source_desc']									= '';
	$_lang['socialmedia.label_user_account']								= 'Account';
	$_lang['socialmedia.label_user_account_desc']							= '';
	$_lang['socialmedia.label_content']										= 'Message';
	$_lang['socialmedia.label_content_desc']								= '';
	$_lang['socialmedia.label_status']										= 'Status';
	$_lang['socialmedia.label_status_desc']									= '';
	$_lang['socialmedia.label_created']										= 'Posted';
	$_lang['socialmedia.label_created_desc']								= '';
	
	$_lang['socialmedia.label_words']										= 'Forbidden words';
	$_lang['socialmedia.label_words_desc']									= 'Separate forbidden words with a comma.';
	
	$_lang['socialmedia.filter_criterea']									= 'Filter on criteria...';
	$_lang['socialmedia.filter_source']										= 'Filter on channel...';
	$_lang['socialmedia.filter_status']										= 'Filter on status...';
	$_lang['socialmedia.show_source']										= 'Show on [[+source]]';
	
	$_lang['socialmedia.word_filter']										= 'Word filter';
	$_lang['socialmedia.word_filter_desc']									= 'With the word filter you can exclude social media messages from your website. Please enter the words that are not allowed in the social media messages below, the social media messages that contains these words would not be shown.';
	$_lang['socialmedia.activate']											= 'Show';
	$_lang['socialmedia.deactivate']										= 'Hide';
	$_lang['socialmedia.unknow_message']									= 'Unknown or empty message';
	$_lang['socialmedia.time_seconds']										= 'Less than a minute ago';
	$_lang['socialmedia.time_minute']										= '1 minute ago';
	$_lang['socialmedia.time_minutes']										= '[[+minutes]] minutes ago';
	$_lang['socialmedia.time_hour']											= '1 hour ago';
	$_lang['socialmedia.time_hours']										= '[[+hours]] hours ago';
	$_lang['socialmedia.time_day']											= '1 day ago';
	$_lang['socialmedia.time_days']											= '[[+days]] days ago';
	$_lang['socialmedia.time_week']											= '1 week ago';
	$_lang['socialmedia.time_weeks']										= '[[+weeks]] weeks ago';
	$_lang['socialmedia.time_month']										= '1 month ago';
	$_lang['socialmedia.time_months']										= '[[+months]] months ago';
	$_lang['socialmedia.time_to_long']										= 'More than a half year ago';
	
?>
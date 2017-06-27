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
	$_lang['socialmedia.desc']												= 'Beheer alle social media berichten.';
		
	$_lang['area_socialmedia']												= 'Social media';
	
	$_lang['setting_socialmedia.api_useragent']								= 'API useragent';
	$_lang['setting_socialmedia.api_useragent_desc']						= 'De useragent voor de API\'s. Standaard is "SocialMediaOAuth v1.1.0".';
	$_lang['setting_socialmedia.default_active']							= 'Standaard status';
	$_lang['setting_socialmedia.default_active_desc']						= 'De standaard status van de social media berichten tijdens het synchroniseren van de social media kanalen.';
	$_lang['setting_socialmedia.default_sources']							= 'Standaard kanalen';
	$_lang['setting_socialmedia.default_sources_desc']						= 'De standaard social media kanalen, dit moet een geldig JSON formaat zijn. Standaard is "{"twitter": ["@modx", "#modx"], "instagram": ["#modx"]}" (# is een zoekterm, @ is een gebruikersnaam en $ is een gebruikers ID).';
	$_lang['setting_socialmedia.log_send']									= 'Log versturen';
	$_lang['setting_socialmedia.log_send_desc']								= 'Indien ja, het aangemaakte log bestand die automatisch word aangemaakt versturen via e-mail.';
	$_lang['setting_socialmedia.log_email']									= 'Log e-mailadres(sen)';
	$_lang['setting_socialmedia.log_email_desc']							= 'De e-mailadres(sen) waar het log bestand heen gestuurd dient te worden. Meerdere e-mailadressen scheiden met een komma.';	
	$_lang['setting_socialmedia.log_lifetime']								= 'Log levensduur';
	$_lang['setting_socialmedia.log_lifetime_desc']							= 'Het aantal dagen dat een log bestand bewaard moet blijven, hierna word het log bestand automatisch verwijderd.';
	$_lang['setting_socialmedia.word_filter']								= 'Woordfilter';
	$_lang['setting_socialmedia.word_filter_desc']							= 'De woorden in die niet mogen voorkomen in de social media berichten, de social media berichten waar deze woorden wel in voorkomen zullen niet weergegeven worden. Woorden scheiden met een komma.';
	
	$_lang['setting_socialmedia.source_twitter_access_token']				= 'Twitter access token';
	$_lang['setting_socialmedia.source_twitter_access_token_desc']			= 'De Twitter access token, deze is te verkrijgen via https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_access_token_secret']		= 'Twitter access token secret';
	$_lang['setting_socialmedia.source_twitter_access_token_secret_desc']	= 'De Twitter access token secret, deze is te verkrijgen via https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_consumer_key']				= 'Twitter consumer key';
	$_lang['setting_socialmedia.source_twitter_consumer_key_desc']			= 'De Twitter consumer key, deze is te verkrijgen via https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_consumer_key_secret']		= 'Twitter consumer key secret';
	$_lang['setting_socialmedia.source_twitter_consumer_key_secret_desc']	= 'De Twitter consumer key secret, deze is te verkrijgen via https://dev.twitter.com/.';
	$_lang['setting_socialmedia.source_twitter_empty_posts']				= 'Twitter "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_twitter_empty_posts_desc']			= 'Indien ja, worden de Twitter berichten met "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_instagram_client_id']				= 'Instagram client ID';
	$_lang['setting_socialmedia.source_instagram_client_id_desc']			= 'De Instagram client ID, deze is te verkrijgen via https://www.instagram.com/developer/.';
	$_lang['setting_socialmedia.source_instagram_client_secret']			= 'Instagram client secret';
	$_lang['setting_socialmedia.source_instagram_client_secret_desc']		= 'De Instagram client secret, deze is te verkrijgen via https://www.instagram.com/developer/.';
	$_lang['setting_socialmedia.source_instagram_access_token']				= 'Instagram access token';
	$_lang['setting_socialmedia.source_instagram_access_token_desc']		= 'De Instagram access token, deze is te verkrijgen via oAuth';
	$_lang['setting_socialmedia.source_instagram_empty_posts']				= 'Instagram "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_instagram_empty_posts_desc']			= 'Indien ja, worden de Instagram berichten met "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_youtube_client_id']					= 'Youtube client ID';
	$_lang['setting_socialmedia.source_youtube_client_id_desc']				= 'De Youtube client ID, deze is te verkrijgen via https://console.developers.google.com/.';
	$_lang['setting_socialmedia.source_youtube_client_secret']				= 'Youtube client secret';
	$_lang['setting_socialmedia.source_youtube_client_secret_desc']			= 'De Youtube client secret, deze is te verkrijgen via https://console.developers.google.com/.';
	$_lang['setting_socialmedia.source_youtube_refresh_token']				= 'Youtube refresh token';
	$_lang['setting_socialmedia.source_youtube_refresh_token_desc']			= 'De Youtube refresh token, deze is te verkrijgen via oAuth met de minimale scope "https://www.googleapis.com/auth/youtube.readonly".';
	$_lang['setting_socialmedia.source_youtube_empty_posts']				= 'Youtube "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_youtube_empty_posts_desc']			= 'Indien ja, worden de Youtube berichten met "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_linkedin_client_id']					= 'LinkedIn client ID';
	$_lang['setting_socialmedia.source_linkedin_client_id_desc']			= 'De LinkedIn client ID, deze is te verkrijgen via https://www.linkedin.com/developer/.';
	$_lang['setting_socialmedia.source_linkedin_client_secret']				= 'LinkedIn client secret';
	$_lang['setting_socialmedia.source_linkedin_client_secret_desc']		= 'De LinkedIn client secret, deze is te verkrijgen via https://www.linkedin.com/developer/.';
	$_lang['setting_socialmedia.source_linkedin_access_token']				= 'LinkedIn access token';
	$_lang['setting_socialmedia.source_linkedin_access_token_desc']			= 'De LinkedIn access token, deze is te verkrijgen via oAuth met de minimale scope "rw_company_admin".';
	$_lang['setting_socialmedia.source_linkedin_empty_posts']				= 'LinkedIn "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_linkedin_empty_posts_desc']			= 'Indien ja, worden de LinkedIn berichten met "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_facebook_client_id']					= 'Facebook client ID';
	$_lang['setting_socialmedia.source_facebook_client_id_desc']			= 'De Facebook client ID, deze is te verkrijgen via https://developers.facebook.com/.';
	$_lang['setting_socialmedia.source_facebook_client_secret']				= 'Facebook client secret';
	$_lang['setting_socialmedia.source_facebook_client_secret_desc']		= 'De Facebook client secret, deze is te verkrijgen via https://developers.facebook.com/.';
	$_lang['setting_socialmedia.source_facebook_access_token']				= 'Facebook access token';
	$_lang['setting_socialmedia.source_facebook_access_token_desc']			= 'De Facebook access token, deze is te verkrijgen via oAuth met de minimale scope "user_posts".';
	$_lang['setting_socialmedia.source_facebook_empty_posts']				= 'Facebook "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_facebook_empty_posts_desc']			= 'Indien ja, worden de Facebook berichten met "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_pinterest_client_id']				= 'Pinterest client ID';
	$_lang['setting_socialmedia.source_pinterest_client_id_desc']			= 'De Pinterest client ID, deze is te verkrijgen via https://developers.pinterest.com/.';
	$_lang['setting_socialmedia.source_pinterest_client_secret']			= 'Pinterest client secret';
	$_lang['setting_socialmedia.source_pinterest_client_secret_desc']		= 'De Pinterest client secret, deze is te verkrijgen via https://developers.pinterest.com/.';
	$_lang['setting_socialmedia.source_pinterest_access_token']				= 'Pinterest access token';
	$_lang['setting_socialmedia.source_pinterest_access_token_desc']		= 'De Pinterest access token, deze is te verkrijgen via oAuth met de minimale scope "read_public".';
	$_lang['setting_socialmedia.source_pinterest_empty_posts']				= 'Pinterest "Onbekend of leeg bericht" weergegeven.';
	$_lang['setting_socialmedia.source_pinterest_empty_posts_desc']			= 'Indien ja, worden de Pinterest berichten met "Onbekend of leeg bericht" weergegeven.';
	
	$_lang['socialmedia.snippet_group_desc']								= 'De criteria waarop de social media kanalen gegroepeerd moeten worden.';
	$_lang['socialmedia_snippet_limit_desc']								= 'Het maximaal aantal social media berichten wat weergegeven moet worden. Standaard is "5".';
	$_lang['socialmedia_snippet_sort_desc']									= 'De volgorde waarin de social media berichten weergegeven moeten worden. Standaard is "{"created": "DESC"}".';
	$_lang['socialmedia_snippet_sources_desc']								= 'De standaard social media kanalen criteria, dit moet een geldig JSON formaat zijn. Indien leeg, worden alle social media kanalen weergegeven.';
	
	$_lang['socialmedia.message']											= 'Bericht';
	$_lang['socialmedia.messages']											= 'Berichten';
	$_lang['socialmedia.messages_desc']										= 'Hier kun je alle berichten van de social media kanalen beheren. Social media kanalen zoals <span class="twitter">Twitter</span>, <span class="instagram">Instagram</span>, <span class="facebook">Facebook</span>, <span class="linkedin">LinkedIn</span> of <span class="youtube">Youtube</span> worden automatisch gesynchroniseerd met MODX.';
	$_lang['socialmedia.message_show']										= 'Bekijk op [[+source]]';
	$_lang['socialmedia.message_activate']									= 'Bericht weergeven';
	$_lang['socialmedia.message_activate_confirm']							= 'Weet je zeker dat je dit bericht wilt weergeven?';
	$_lang['socialmedia.message_deactivate']								= 'Bericht verbergen';
	$_lang['socialmedia.message_deactivate_confirm']						= 'Weet je zeker dat je dit bericht wilt verbergen?';
	
	$_lang['socialmedia.label_source']										= 'Kanaal';
	$_lang['socialmedia.label_source_desc']									= '';
	$_lang['socialmedia.label_user_account']								= 'Profiel';
	$_lang['socialmedia.label_user_account_desc']							= '';
	$_lang['socialmedia.label_content']										= 'Bericht';
	$_lang['socialmedia.label_content_desc']								= '';
	$_lang['socialmedia.label_status']										= 'Status';
	$_lang['socialmedia.label_status_desc']									= '';
	$_lang['socialmedia.label_created']										= 'Geplaatst';
	$_lang['socialmedia.label_created_desc']								= '';
	
	$_lang['socialmedia.label_words']										= 'Verboden woorden';
	$_lang['socialmedia.label_words_desc']									= 'Verboden woorden scheiden met een komma.';
	
	$_lang['socialmedia.filter_criterea']									= 'Filter op criteria...';
	$_lang['socialmedia.filter_source']										= 'Filter op kanaal...';
	$_lang['socialmedia.filter_status']										= 'Filter op status...';
	$_lang['socialmedia.show_source']										= 'Bekijk op [[+source]]';
	
	$_lang['socialmedia.word_filter']										= 'Woordfilter';
	$_lang['socialmedia.word_filter_desc']									= 'Met het woordfilter kun je social media berichten uitsluiten van de website. Vul hieronder de woorden in die niet mogen voorkomen in de social media berichten, de social media berichten waar deze woorden wel in voorkomen zullen niet weergegeven worden.';
	$_lang['socialmedia.activate']											= 'Weergeven';
	$_lang['socialmedia.deactivate']										= 'Verbergen';
	$_lang['socialmedia.unknow_message']									= 'Onbekend of leeg bericht';
	$_lang['socialmedia.time_seconds']										= 'Minder dan 1 minuut geleden';
	$_lang['socialmedia.time_minute']										= '1 minuut geleden';
	$_lang['socialmedia.time_minutes']										= '[[+minutes]] minuten geleden';
	$_lang['socialmedia.time_hour']											= '1 uur geleden';
	$_lang['socialmedia.time_hours']										= '[[+hours]] uren geleden';
	$_lang['socialmedia.time_day']											= '1 dag geleden';
	$_lang['socialmedia.time_days']											= '[[+days]] dagen geleden';
	$_lang['socialmedia.time_week']											= '1 week geleden';
	$_lang['socialmedia.time_weeks']										= '[[+weeks]] weken geleden';
	$_lang['socialmedia.time_month']										= '1 maand geleden';
	$_lang['socialmedia.time_months']										= '[[+months]] maanden geleden';
	$_lang['socialmedia.time_to_long']										= 'Meer dan een half jaar geleden';
	
?>
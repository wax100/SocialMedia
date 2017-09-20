SocialMedia.panel.Home = function(config) {
	config = config || {};
	
    Ext.apply(config, {
        id			: 'socialmedia-panel-home',
        cls			: 'container',
        items		: [{
            html		: '<h2>' + _('socialmedia') + '</h2>',
            id			: 'socialmedia-header',
            cls			: 'modx-page-header'
        }, {
        	layout		: 'form',
            items		: [{
            	html			: '<p>' + _('socialmedia.messages_desc') + '</p>',
                bodyCssClass	: 'panel-desc'
            }, {
	            html			: 0 == parseInt(MODx.config['socialmedia.cronjob']) ? '<p>' + _('socialmedia.socialmedia_cronjob_notice_desc') + '</p>' : '',
				cls				: 0 == parseInt(MODx.config['socialmedia.cronjob']) ? 'modx-config-error panel-desc' : ''
            }, {
                xtype			: 'socialmedia-grid-messages',
                cls				: 'main-wrapper',
                preventRender	: true
            }]
        }]
    });

	SocialMedia.panel.Home.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.panel.Home, MODx.FormPanel);

Ext.reg('socialmedia-panel-home', SocialMedia.panel.Home);
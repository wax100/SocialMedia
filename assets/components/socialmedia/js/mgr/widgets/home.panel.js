SocialMedia.panel.Home = function(config) {
	config = config || {};
	
    Ext.apply(config, {
        id			: 'socialmedia-panel-home',
        cls			: 'container',
        defaults	: {
        	collapsible	: false,
        	autoHeight	: true,
        	border 		: false
        },
        items		: [{
            html		: '<h2>'+_('socialmedia')+'</h2>',
            id			: 'socialmedia-header',
            cls			: 'modx-page-header'
        }, {
        	layout		: 'form',
        	border 		: true,
            defaults	: {
            	autoHeight	: true,
            	border		: false
            },
            items		: [{
            	html			: '<p>' + _('socialmedia.messages_desc') + '</p>',
                bodyCssClass	: 'panel-desc'
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
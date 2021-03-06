Ext.onReady(function() {
	MODx.load({xtype: 'socialmedia-page-home'});
});

SocialMedia.page.Home = function(config) {
	config = config || {};
	
	config.buttons = [];
	
	if (SocialMedia.config.branding_url) {
		config.buttons.push({
			text 		: 'SocialMedia ' + SocialMedia.config.version,
			cls			: 'x-btn-branding',
			handler		: this.loadBranding
		});
	}
	
	if (SocialMedia.config.branding_url_help) {
		config.buttons.push({
			text		: _('help_ex'),
			handler		: MODx.loadHelpPane,
			scope		: this
		});
	}
	
	Ext.applyIf(config, {
		components	: [{
			xtype		: 'socialmedia-panel-home',
			renderTo	: 'socialmedia-panel-home-div'
		}]
	});
	
	SocialMedia.page.Home.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.page.Home, MODx.Component, {
	loadBranding: function(btn) {
		window.open(SocialMedia.config.branding_url);
	}
});

Ext.reg('socialmedia-page-home', SocialMedia.page.Home);
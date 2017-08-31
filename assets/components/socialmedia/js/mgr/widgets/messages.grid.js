SocialMedia.grid.Messages = function(config) {
    config = config || {};

	config.tbar = [{
        text		: _('socialmedia.word_filter'),
        cls			:'primary-button',
        handler		: this.updateWordFilter,
        scope		: this
    }, {
		text		: _('bulk_actions'),
		menu		: [{
			text		: _('socialmedia.messages_reset'),
			handler		: this.resetMessages,
			scope		: this
		}]
	}, '->', {
    	xtype		: 'socialmedia-combo-criterea',
    	name		: 'socialmedia-filter-criterea',
        id			: 'socialmedia-filter-criterea',
        emptyText	: _('socialmedia.filter_criterea'),
        listeners	: {
        	'select'	: {
	            fn			: this.filterCriterea,
	            scope		: this   
		    }
		}
    }, {
    	xtype		: 'socialmedia-combo-source',
    	name		: 'socialmedia-filter-source',
        id			: 'socialmedia-filter-source',
        emptyText	: _('socialmedia.filter_source'),
        listeners	: {
        	'select'	: {
	            fn			: this.filterSource,
	            scope		: this   
		    }
		}
    }, {
    	xtype		: 'socialmedia-combo-status',
    	name		: 'socialmedia-filter-status',
        id			: 'socialmedia-filter-status',
        emptyText	: _('socialmedia.filter_status'),
        listeners	: {
        	'select'	: {
	            fn			: this.filterStatus,
	            scope		: this   
		    }
		}
    }, '-', {
        xtype		: 'textfield',
        name 		: 'socialmedia-filter-search',
        id			: 'socialmedia-filter-search',
        emptyText	: _('search')+'...',
        listeners	: {
	        'change'	: {
	        	fn			: this.filterSearch,
	        	scope		: this
	        },
	        'render'	: {
		        fn			: function(cmp) {
			        new Ext.KeyMap(cmp.getEl(), {
				        key		: Ext.EventObject.ENTER,
			        	fn		: this.blur,
				        scope	: cmp
			        });
		        },
		        scope		: this
	        }
        }
    }, {
    	xtype		: 'button',
    	cls			: 'x-form-filter-clear',
    	id			: 'socialmedia-filter-clear',
    	text		: _('filter_clear'),
    	listeners	: {
        	'click'		: {
        		fn			: this.clearFilter,
        		scope		: this
        	}
        }
    }];
    
    columns = new Ext.grid.ColumnModel({
        columns: [{
            header		: _('socialmedia.label_source'),
            dataIndex	: 'source',
            sortable	: true,
            editable	: false,
            width		: 100,
            fixed		: true,
            renderer	: this.renderSource
        }, {
            header		: _('socialmedia.label_user_account'),
            dataIndex	: 'user_name',
            sortable	: true,
            editable	: false,
            width		: 250,
            fixed		: true,
            renderer	: this.renderUserAccount
        }, {
            header		: _('socialmedia.label_content'),
            dataIndex	: 'content',
            sortable	: true,
            editable	: false,
            width		: 250,
            renderer	: this.renderContent
        }, {
            header		: _('socialmedia.label_status'),
            dataIndex	: 'active',
            sortable	: true,
            editable	: false,
            width		: 100,
            fixed		: true,
			renderer	: this.renderStatus
        }, {
            header		: _('socialmedia.label_created'),
            dataIndex	: 'time_ago',
            sortable	: true,
            editable	: false,
            fixed		: true,
			width		: 200,
			renderer	: this.renderDate
        }]
    });
    
    Ext.applyIf(config, {
    	cm			: columns,
        id			: 'socialmedia-grid-messages',
        url			: SocialMedia.config.connector_url,
        baseParams	: {
        	action		: 'mgr/messages/getlist'
        },
        fields		: ['id', 'key', 'source', 'user_name', 'user_account', 'user_image', 'user_account', 'user_url', 'content', 'image', 'video', 'url', 'active', 'created', 'time_ago'],
        paging		: true,
        pageSize	: MODx.config.default_per_page > 30 ? MODx.config.default_per_page : 30,
        sortBy		: 'created'
    });
    
    SocialMedia.grid.Messages.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.grid.Messages, MODx.grid.Grid, {
	filterCriterea: function(tf, nv, ov) {
        this.getStore().baseParams.criterea = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
	filterSource: function(tf, nv, ov) {
        this.getStore().baseParams.source = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
	filterStatus: function(tf, nv, ov) {
        this.getStore().baseParams.status = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    filterSearch: function(tf, nv, ov) {
        this.getStore().baseParams.query = tf.getValue();
        
        this.getBottomToolbar().changePage(1);
    },
    clearFilter: function() {
	    this.getStore().baseParams.criterea = '';
	    this.getStore().baseParams.source = '';
	    this.getStore().baseParams.status = '';
	    this.getStore().baseParams.query = '';

		Ext.getCmp('socialmedia-filter-criterea').reset();
		Ext.getCmp('socialmedia-filter-source').reset();
		Ext.getCmp('socialmedia-filter-status').reset();
	    Ext.getCmp('socialmedia-filter-search').reset();
	    
        this.getBottomToolbar().changePage(1);
    },
    getMenu: function() {
	    var menu = [{
	    	text	: _('socialmedia.message_show', {
		    	source	: Ext.util.Format.capitalize(this.menu.record.source)
	    	}),
			handler	: this.showMessage
		}, '-'];
	    
		if (1 == parseInt(this.menu.record.active) || this.menu.record.active) {
			menu.push({
		    	text	: _('socialmedia.message_deactivate'),
				handler	: this.deactivateMessage
			});
		} else {
			menu.push({
		    	text	: _('socialmedia.message_activate'),
				handler	: this.activateMessage
			});
		}
		
		return menu;
    },
    updateWordFilter: function(btn, e) {
        if (this.updateWordFilterWindow) {
	        this.updateWordFilterWindow.destroy();
        }
        
        this.updateWordFilterWindow = MODx.load({
	        xtype		: 'socialmedia-window-word-filter',
	        closeAction	: 'close',
	        listeners	: {
		        'success'	: {
		        	fn			: function(data) {
			        	SocialMedia.config.word_filter = data.a.result.message;

			        	this.refresh();
			        },
		        	scope		: this
		        }
	         }
        });
        
        
        this.updateWordFilterWindow.show(e.target);
    },
    showMessage: function(btn, e) {
    	window.open(this.menu.record.url);
    },
    activateMessage: function(btn, e) {
    	MODx.msg.confirm({
        	title 		: _('socialmedia.message_activate'),
        	text		: _('socialmedia.message_activate_confirm'),
        	url			: SocialMedia.config.connector_url,
        	params		: {
            	action		: 'mgr/messages/update',
            	id			: this.menu.record.id,
            	active 		: 1
            },
            listeners	: {
            	'success'	: {
            		fn			: this.refresh,
            		scope		: this
            	}
            }
    	});
    },
    deactivateMessage: function(btn, e) {
    	MODx.msg.confirm({
        	title 		: _('socialmedia.message_deactivate'),
        	text		: _('socialmedia.message_deactivate_confirm'),
        	url			: SocialMedia.config.connector_url,
        	params		: {
            	action		: 'mgr/messages/update',
            	id			: this.menu.record.id,
            	active 		: 0
            },
            listeners	: {
            	'success'	: {
            		fn			: this.refresh,
            		scope		: this
            	}
            }
    	});
    },
    resetMessages: function(btn, e) {
    	MODx.msg.confirm({
        	title 		: _('socialmedia.messages_reset'),
        	text		: _('socialmedia.messages_reset_confirm'),
        	url			: SocialMedia.config.connector_url,
        	params		: {
            	action		: 'mgr/messages/reset'
            },
            listeners	: {
            	'success'	: {
            		fn			: this.refresh,
            		scope		: this
            	}
            }
    	});
    },
    renderSource: function(d, c, e) {
	    c.css = e.json.source;
	    
	    return String.format('<span class="icon icon-{0}"></span> {1}', d, Ext.util.Format.capitalize(d));
    },
    renderUserAccount: function(d, c, e) {
	    return String.format('<a href="{0}" target="_blank" title="{1}" class="x-grid-link">{2}</a>', e.json.user_url, d, d);
    },
    renderContent: function(d, c, e) {
	    if (Ext.isEmpty(d)) {
			d = _('socialmedia.unknow_message');    
		}
		
	    return String.format('<a href="{0}" target="_blank" title="{1}" class="x-grid-link">{2}</a>', e.json.url, _('socialmedia.show_source', {
		    'source' : Ext.util.Format.capitalize(e.json.source)
	    }), d);
    },
    renderStatus: function(d, c) {
    	c.css = 1 == parseInt(d) || d ? 'green' : 'red';
    	
    	return 1 == parseInt(d) || d ? _('socialmedia.activate') : _('socialmedia.deactivate');
    },
	renderDate: function(a) {
        if (Ext.isEmpty(a)) {
            return '—';
        }

        return a;
    }
});

Ext.reg('socialmedia-grid-messages', SocialMedia.grid.Messages);

SocialMedia.window.WordFilter = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
    	autoHeight	: true,
        title 		: _('socialmedia.word_filter'),
        url			: SocialMedia.config.connector_url,
        baseParams	: {
            action		: 'mgr/filter/update'
        },
        fields		: [{
        	html		: '<p>' + _('socialmedia.word_filter_desc') + '</p>',
            cls			: 'panel-desc'
        }, {
        	xtype		: 'textarea',
        	fieldLabel	: _('socialmedia.label_words'),
		    description	: MODx.expandHelp ? '' : _('socialmedia.label_words_desc'),
        	name		: 'filter',
        	anchor		: '100%',
        	value 		: SocialMedia.config.word_filter
        }, {
        	xtype		: MODx.expandHelp ? 'label' : 'hidden',
            html		: _('socialmedia.label_words_desc'),
            cls			: 'desc-under'
        }]
    });
    
    SocialMedia.window.WordFilter.superclass.constructor.call(this, config);
};

Ext.extend(SocialMedia.window.WordFilter, MODx.Window);

Ext.reg('socialmedia-window-word-filter', SocialMedia.window.WordFilter);

SocialMedia.combo.Criterea = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        url			: SocialMedia.config.connector_url,
        baseParams 	: {
            action		: 'mgr/messages/getcriterea'
        },
        fields		: ['criterea'],
        hiddenName	: 'criterea',
        pageSize	: 15,
        valueField	: 'criterea',
        displayField: 'criterea'
    });
    
    SocialMedia.combo.Criterea.superclass.constructor.call(this,config);
};

Ext.extend(SocialMedia.combo.Criterea, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-criterea', SocialMedia.combo.Criterea);

SocialMedia.combo.Source = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        url			: SocialMedia.config.connector_url,
        baseParams 	: {
            action		: 'mgr/sources/getlist'
        },
        fields		: ['type', 'label'],
        hiddenName	: 'source',
        pageSize	: 15,
        valueField	: 'type',
        displayField: 'label',
        tpl			: new Ext.XTemplate('<tpl for=".">' + 
        	'<div class="x-combo-list-item {type}">' + 
        		'<span class="icon icon-{type}"></span> {label}' + 
			'</div>' + 
		'</tpl>')
    });
    
    SocialMedia.combo.Source.superclass.constructor.call(this,config);
};

Ext.extend(SocialMedia.combo.Source, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-source', SocialMedia.combo.Source);

SocialMedia.combo.Status = function(config) {
    config = config || {};
    
    Ext.applyIf(config, {
        store: new Ext.data.ArrayStore({
            mode	: 'local',
            fields	: ['type', 'label'],
            data	: [
            	['0', _('socialmedia.message_deactivate')],
            	['1', _('socialmedia.message_activate')]
            ]
        }),
        remoteSort	: ['label', 'asc'],
        hiddenName	: 'active',
        valueField	: 'type',
        displayField: 'label',
        mode		: 'local'
    });
    
    SocialMedia.combo.Status.superclass.constructor.call(this,config);
};

Ext.extend(SocialMedia.combo.Status, MODx.combo.ComboBox);

Ext.reg('socialmedia-combo-status', SocialMedia.combo.Status);
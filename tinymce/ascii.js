(function() {
	tinymce.create('tinymce.plugins.AsciiFactoryShortcode', {
		/*initializes the input window for entering an url and tweak some parameters*/
		init: function(ed, url) {
			ed.addCommand('asciiCommand', function() {
				ed.windowManager.open({
					file: ajaxurl + '?action=ascii_shortcode',
					width: 240 + parseInt(ed.getLang('ascii.delta_width', 0)),
					height: 170 + parseInt(ed.getLang('ascii.delta_height', 0)),
					inline: 1
				}, {
					plugin_url: url
				});
			});
			/*adds the ascii factory button to the tinymce editor*/
			ed.addButton('ascii', {
				title: 'Ascii Factory',
				image: url + '/ascii-factory.png',
				cmd: 'asciiCommand'
			});
		},
		/*returns information of the plugin*/
		getInfo: function() {
			return {
				longname: 'Ascii Shortcode',
				author: 'Joscha Probst & David Neubauer',
			};
		}
	});

	tinymce.PluginManager.add('ascii', tinymce.plugins.AsciiFactoryShortcode);
})();

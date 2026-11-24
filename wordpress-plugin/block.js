( function ( wp ) {
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	var InspectorControls = ( wp.blockEditor || wp.editor ).InspectorControls;
	var useBlockProps = wp.blockEditor && wp.blockEditor.useBlockProps;
	var PanelBody = wp.components.PanelBody;
	var SelectControl = wp.components.SelectControl;
	var ToggleControl = wp.components.ToggleControl;
	var ServerSideRender = wp.serverSideRender;
	var options = window.gtjotdOptions || { languages: [], categories: [] };
	var domain = 'giggletime-joke-of-the-day';

	wp.blocks.registerBlockType( 'giggletime/joke-of-the-day', {
		apiVersion: 2,
		title: __( 'Joke of the Day', domain ),
		description: __( 'A new family-friendly joke every day, in 26 languages.', domain ),
		icon: 'smiley',
		category: 'widgets',
		keywords: [ 'joke', 'humor', 'funny', 'giggletime' ],
		attributes: {
			lang: { type: 'string', default: '' },
			category: { type: 'string', default: '' },
			theme: { type: 'string', default: 'auto' },
			size: { type: 'string', default: 'm' },
			attribution: { type: 'boolean', default: false }
		},
		edit: function ( props ) {
			var a = props.attributes;
			var set = function ( key ) {
				return function ( value ) {
					var change = {};
					change[ key ] = value;
					props.setAttributes( change );
				};
			};
			var blockProps = useBlockProps ? useBlockProps() : {};
			return el(
				'div',
				blockProps,
				el(
					InspectorControls,
					null,
					el(
						PanelBody,
						{ title: __( 'Widget settings', domain ) },
						el( SelectControl, {
							label: __( 'Language', domain ),
							value: a.lang,
							options: [ { value: '', label: __( 'Same as this site', domain ) } ].concat( options.languages ),
							onChange: set( 'lang' )
						} ),
						el( SelectControl, { label: __( 'Category', domain ), value: a.category, options: options.categories, onChange: set( 'category' ) } ),
						el( SelectControl, {
							label: __( 'Theme', domain ),
							value: a.theme,
							options: [
								{ value: 'auto', label: __( 'Auto', domain ) },
								{ value: 'light', label: __( 'Light', domain ) },
								{ value: 'dark', label: __( 'Dark', domain ) }
							],
							onChange: set( 'theme' )
						} ),
						el( SelectControl, {
							label: __( 'Size', domain ),
							value: a.size,
							options: [
								{ value: 's', label: __( 'Small', domain ) },
								{ value: 'm', label: __( 'Medium', domain ) },
								{ value: 'l', label: __( 'Large', domain ) }
							],
							onChange: set( 'size' )
						} ),
						el( ToggleControl, {
							label: __( 'Show a credit link under the joke', domain ),
							checked: !! a.attribution,
							onChange: set( 'attribution' )
						} )
					)
				),
				el( ServerSideRender, { block: 'giggletime/joke-of-the-day', attributes: a } )
			);
		},
		save: function () {
			return null;
		}
	} );
} )( window.wp );

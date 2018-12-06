/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

 CKEDITOR.editorConfig = function( config ) {
 	config.extraPlugins = 'widgetselection,lineutils,imageuploader,dialog,btgrid,bootstrapTabs,accordionList,collapsibleItem,inserthtml4x,lightbox';
 	config.language = 'es';	
 	config.extraAllowedContent = 'a[data-lightbox,data-title,data-lightbox-saved], h2[*], <i>[*]';
 	config.protectedSource.push(/<\?[\s\S]*?\?>/g); 
 	config.allowedContent = true;
 
 };
 // allow i tags to be empty (for font awesome)
CKEDITOR.dtd.$removeEmpty['i'] = false;

 // allow svg tags to be empty (for vector)
CKEDITOR.dtd.$removeEmpty['svg'] = false;

 // allow use tags to be empty (for vector)
CKEDITOR.dtd.$removeEmpty['use'] = false;
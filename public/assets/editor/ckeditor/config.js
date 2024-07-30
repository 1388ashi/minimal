/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.height = 300;
	config.language = 'fa';
	config.uiColor = '#d4dcdc';
    //config.filebrowserBrowseUrl = '/assets/editor/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl = '/assets/editor/ckfinder/ckfinder.html?Type=Images';
    //config.filebrowserUploadUrl = '/assets/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/assets/editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserWindowWidth = '1000';
    config.filebrowserWindowHeight = '700';
    config.font_names = 'sans; ' + config.font_names;
};

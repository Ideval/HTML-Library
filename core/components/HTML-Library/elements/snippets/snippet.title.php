<?php
$defaultCorePath = $modx->getOption('core_path') .'components/HTML-Library/';
$myCorePath = $modx->getOption('html-library.core_path', null, $defaultCorePath);
$title = $modx->getService(
	'title',
	'Title',
	$myCorePath .'model/HTML-Library/',
	$scriptProperties
);


/**
 * Questo snippet genera un titolo HTML rispettando gli stardard SEO
 **/
$title = $modx->resource->get('longtitle');

$ancestor = $modx->resource;
while($ancestor->get('parent') > 0){
	$ancestor = $modx->getObject('modResource', $ancestor->get('parent'));
}
if( $ancestor->get('id') != $modx->resource->get('id') ){
	$title .= ' - '. $ancestor->get('longtitle');
}
unset($ancestor);

return '<title>'. $title .' | '. $modx->getOption('site_name') .'</title>';

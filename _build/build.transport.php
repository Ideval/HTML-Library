<?php
$tstart = explode(' ', microtime());
$tstart = $tstart[1] + $tstart[0];
set_time_limit(0);
 
/* Definire i nomi */
define('PKG_NAME','HTML-Library');
define('PKG_NAME_LOWER','html-library');
define('PKG_VERSION','1.0');
define('PKG_RELEASE','beta');
 
/* Definire i percorsi */
$root = dirname(dirname(__FILE__)).'/';
$sources = array(
    'root'          => $root,
    'build'         => $root .'_build/',
    'data'          => $root .'_build/data/',
    'resolvers'     => $root .'_build/resolvers/',
    'chunks'        => $root .'core/components/'. PKG_NAME_LOWER .'/chunks/',
    'lexicon'       => $root .'core/components/'. PKG_NAME_LOWER .'/lexicon/',
    'docs'          => $root .'core/components/'. PKG_NAME_LOWER .'/docs/',
    'elements'      => $root .'core/components/'. PKG_NAME_LOWER .'/elements/',
    'source_assets' => $root .'assets/components/'. PKG_NAME_LOWER,
    'source_core'   => $root .'core/components/'. PKG_NAME_LOWER,
);
unset($root);
 
/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . 'build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
 
$modx= new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting of log messages */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
 
$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/'. PKG_NAME_LOWER .'/');
 
/* Comprimere il package */
$modx->log(modX::LOG_LEVEL_INFO,'Packing up transport package zip...');
$builder->pack();
 
$tend= explode(" ", microtime());
$tend= $tend[1] + $tend[0];
$totalTime= sprintf("%2.4f s",($tend - $tstart));
$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");
 
 
session_write_close();
exit ();

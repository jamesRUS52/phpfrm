<?php
/* 
 * priority by routes from begin
 * certain route should by in begin list of routes then general routes
 */

use jamesRUS52\phpfrm\Router;

# default routes

Router::add('^admin$', ['controller'=>'Main', 'action'=>'index','prefix'=>'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$',['prefix'=>'admin']);

Router::add('^ajax$', ['controller'=>'Main', 'action'=>'index','prefix'=>'ajax']);
Router::add('^ajax/?(?P<controller>[a-z-]+)/?(?P<action>[a-z0-9-_]+)?$',['prefix'=>'ajax']);

Router::add('^request/view/(?<param>\d+)?$', ['controller'=>'Request', 'action'=>'view']);

Router::add('^$', ['controller'=>'Main', 'action'=>'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z0-9-_]+)?$');



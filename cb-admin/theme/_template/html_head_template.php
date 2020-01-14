<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 25/09/14
 */
if ( !defined('H-KEI') ) { exit; }

$TEMPLATE[] = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="hu">
<head>
<title>{#PAGETITLE}</title>
<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
<meta content='text/html; charset=utf-8' http-equiv='content-type' />
{#LOADMETA}
{#LOADSHE}
</head>
HTML;

return; ?>
<?php
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v004
 * @date 04/12/17
 */
if ( !defined('H-KEI') ) { exit; }

$JSEND['default'][0] = 'docs.min.js';
$JSEND['default'][1] = 'jssor.slider.min.js';
$JSEND['default'][2] = 'jssor.slider.settings.js';
$CSS['default'][0] = 'jssor.slider.settings.css';

$TEMPLATE['default'] = <<<HTML
    <div id="slider1_container" class="cb-sliderContainer" data-width="{#WIDTH}" data-height="{#HEIGHT}" style="display: none; position: relative; margin: 0 auto; width: {#WIDTH}px; height: {#HEIGHT}px; overflow: hidden;">

        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="cb-module/slide/img/spin.svg" />
        </div>

        <div u="slides" class="cb-sliderContainer-img" style="cursor: move; position: absolute; left: 0px; top: 0px; width: {#WIDTH}px; height: {#HEIGHT}px; overflow: hidden;">
            {#IMAGES}
        </div>
        
        <div data-u="navigator" class="jssorb031" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:16px;height:16px;">
                <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        
        <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewBox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div>
HTML;

$TEMPLATE['default_images'] = <<<HTML
    <div><img u="image" src="{#IMAGE_PATH}" /></div>
HTML;

return ?>

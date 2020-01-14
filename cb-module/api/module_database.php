<?php
namespace module\api;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v001
 * @date 06/05/19
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use corebeat\database;
    use facebook\database;
    use google\database;
}

return; ?>

<?php
namespace module\admin\contact;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 11/11/17
 */
if ( !defined('H-KEI') ) { exit; }

class database extends module {
    use forms\database;
    use posts\database;
    use maps\database;
}

return; ?>

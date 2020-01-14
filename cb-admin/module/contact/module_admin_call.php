<?php
namespace module\admin\contact;
/**
 * CoreBeat SyStem Manager
 * @author Gábor Érdi [erdi.gabor@webed.hu]
 * @version v002
 * @date 16/11/18
 */
if ( !defined('H-KEI') ) { exit; }

// TODO: form ellenörzés és js elemek nincsenek még megírva!
class call extends funct {
    use forms\call;
    use posts\call;
    use maps\call;
    
    public function __call_main() {
        global $module;
        
        $html = $module->loadAdminFunction('admin','adminmodulemenu');
        
        return $html;
    }

}

return; ?>
<?php
/**
* HTML Jelix response for full screen map.
* @package   lizmap
* @subpackage lizmap
* @author    3liz
* @copyright 2011 3liz
* @link      http://3liz.com
* @license Mozilla Public License : http://www.mozilla.org/MPL/
*/


require_once (JELIX_LIB_CORE_PATH.'response/jResponseHtml.class.php');

class myHtmlMapResponse extends jResponseHtml {

  public $bodyTpl = 'view~map';

  function __construct() {
    parent::__construct();

    $bp = jApp::config()->urlengine['basePath'];

    $this->title = '';

    // CSS
    $this->addCSSLink($bp.'css/jquery-ui-1.8.23.custom.css');
    $this->addCSSLink($bp.'css/bootstrap.css');
    $this->addCSSLink($bp.'css/bootstrap-responsive.css');
    $this->addCSSLink($bp.'TreeTable/stylesheets/jquery.treeTable.css');
    $this->addCSSLink($bp.'OpenLayers-2.12/theme/default/style.css');
    $this->addCSSLink($bp.'css/main.css');
    $this->addCSSLink($bp.'css/map.css');
    $this->addCSSLink($bp.'css/media.css');

#    $this->addCSSLink($bp.'css/bootstrap-responsive.css');

    // META
    $this->addMetaDescription('');
    $this->addMetaKeywords('');
    $this->addHeadContent('<meta name="Revisit-After" content="10 days" />');
    $this->addHeadContent('<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />');

    // JS
    $this->addJSLink($bp.'OpenLayers-2.12/OpenLayers.js');
    $this->addJSLink($bp.'OpenLayers-2.12/lib/OpenLayers/Format/SLD/v1_1_0.js');
    $this->addJSLink($bp.'OpenLayers-2.12/lib/OpenLayers/Control/Scale.js');
    $this->addJSLink($bp.'OpenLayers-2.12/lib/OpenLayers/Control/ScaleLine.js');
    $this->addJSLink($bp.'OpenLayers-2.12/lib/OpenLayers/Popup/lizmapAnchored.js');
    $this->addJSLink($bp.'Proj4js/proj4js-compressed.js');
    $this->addJSLink($bp.'js/jquery-1.9.1.js');
    $this->addJSLink($bp.'js/bootstrap.js');
    $this->addJSLink($bp.'js/jquery-ui-1.10.3.custom.min.js');
    $this->addJSLink($bp.'js/jquery.combobox.js');
    $this->addJSLink($bp.'TreeTable/javascripts/jquery.treeTable.js');
    $this->addJSLink($bp.'js/map.js');


    $generalJSConfig = '
      Proj4js.libPath = "'.$bp.'Proj4js/";
      ';
    $this->addJSCode($generalJSConfig);

  }

  protected function doAfterActions() {
      // Include all process in common for all actions, like the settings of the
      // main template, the settings of the response       $tpl = new jTpl();

  }
}

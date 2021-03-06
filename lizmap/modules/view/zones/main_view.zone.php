<?php
/**
* Construct the main view list.
* @package   lizmap
* @subpackage view
* @author    3liz
* @copyright 2011 3liz
* @link      http://3liz.com
* @license    Mozilla Public License : http://www.mozilla.org/MPL/
 */

class main_viewZone extends jZone {

   protected $_tplname='view';

   protected function _prepareTpl(){
        $protocol = jApp::coord()->request->getProtocol();
        $this->_tpl->assign('protocol', $protocol);
        $domain = jApp::coord()->request->getDomainName();
        $this->_tpl->assign('domain', $domain);

        jClasses::inc('lizmapMainViewItem');
        $maps = array();

        // Get repository data
        $repository = $this->param('repository');

        $repositories = Array();
        if ($repository != null && jacl2::check('lizmap.repositories.view', $repository)) {
          $repositories[] = $repository;
        } else {
          $repositories = lizmap::getRepositoryList();
        }

        foreach ($repositories as $r) {
          if(jacl2::check('lizmap.repositories.view', $r)){
            $lrep = lizmap::getRepository($r);
            $mrep = new lizmapMainViewItem($r, $lrep->getData('label'));
            $lprojects = $lrep->getProjects();
            foreach ($lprojects as $p) {
              $pOptions = $p->getOptions();
              if (
                property_exists($pOptions,'hideProject')
                && $pOptions->hideProject == 'True'
              ){
                continue;
              }
              $mrep->childItems[] = new lizmapMainViewItem(
                $p->getData('id'),
                $p->getData('title'),
                $p->getData('abstract'),
                $p->getData('proj'),
                $p->getData('bbox'),
                jUrl::get('view~map:index', array("repository"=>$p->getData('repository'),"project"=>$p->getData('id'))),
                jUrl::get('view~media:illustration', array("repository"=>$p->getData('repository'),"project"=>$p->getData('id'))),
                0,
                $r,
                'map'
              );
            }
            $maps[$r] = $mrep;
          }
        }

        $items = jEvent::notify('mainviewGetMaps')->getResponse();

        foreach ($items as $item) {
            if($item->parentId) {
                if(!isset($maps[$item->parentId])) {
                  $maps[$item->parentId] = new lizmapMainViewItem($item->parentId, '', '');
                }
                $replaced = false;
                foreach( $maps[$item->parentId]->childItems as $k => $i ) {
                  if ( $i->id == $item->id ) {
                    $maps[$item->parentId]->childItems[$k] = $item;
                    $replaced = true;
                  }
                }
                if( !$replaced )
                  $maps[$item->parentId]->childItems[] = $item;
            }
            else {
                if(isset($maps[$item->id])) {
                  $maps[$item->id]->copyFrom($item);
                }
                else {
                    $maps[$item->id] = $item;
                }
            }
        }

        usort($maps, "mainViewItemSort");
        foreach($maps as $topitem) {
            usort($topitem->childItems, "mainViewItemSort");
        }
        $this->_tpl->assign('mapitems', $maps);

   }
}

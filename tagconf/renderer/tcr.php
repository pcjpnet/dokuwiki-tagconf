<?php
/**
 * DokuWiki Plugin tagconf (Renderer Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  pcjpnet <webmaster _a_t_ pc-jp.net>
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class renderer_plugin_tagconf_tcr extends Doku_Renderer_xhtml {

    /**
     * Make available as XHTML replacement renderer
     
     * @param string $format requested format
     */
    public function canRender($format){
        if($format == 'xhtml') return true;
        return false;
    }

    // FIXME override any methods of Doku_Renderer_xhtml here

function cdata($text) {
    if ($this->getConf('replace_eol_to_br')) {
        $this->doc .= str_replace("\n","<br />\n",$this->_xmlEntities($text));
    } else {
        $this->doc .= $this->_xmlEntities($text);
    }
}

function externallink($url, $name = NULL) {
    if ($this->getConf('use_link_extern_prefix')) {
        $name = ($name) ? $name : "$url";
        if ($this->getConf('use_internal_redirector_for_extern')) {
            $protocol = ($_SERVER["HTTPS"]) ? "https" : "http";
            $url = $protocol . "://" . $_SERVER["HTTP_HOST"] . DOKU_BASE . 'lib/plugins/tagconf/redirect.php?' . urlencode($url);
        } else {
            $url = $this->getConf('link_extern_prefix') . urlencode($url);
        }
    }
    return parent::externallink($url, $name);
}

}


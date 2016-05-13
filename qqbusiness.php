<?php
namespace Grav\Plugin;
use Grav\Common\Plugin;
class QQBusinessPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onAssetsInitialized' => ['onAssetsInitialized', 0]
        ];
    }
    public function onAssetsInitialized()
    {
        if ($this->isAdmin()) {
            return;
        }

        $nameAccount = trim($this->config->get('plugins.qqbusiness.nameAccount'));
        $selector = trim($this->config->get('plugins.qqbusiness.selector'));
        $aty = trim($this->config->get('plugins.qqbusiness.aty'));
        $a = trim($this->config->get('plugins.qqbusiness.a'));
        $visitor = trim($this->config->get('plugins.qqbusiness.visitor'));
        if ($selector) {
          if ($nameAccount) {
            $url = "http://wpa.b.qq.com/cgi/wpa.php";
            $this->grav['assets']->addJs($url);
            $code1 = "BizQQWPA.addCustom({aty:'{$aty}', a:'{$a}', nameAccount:'{$nameAccount}', selector:'{$selector}'});";
            $this->grav['assets']->addInlineJs($code1, null, 'bottom');
            if ($visitor) {
              $code2 = "BizQQWPA.visitor({nameAccount:'{$nameAccount}'});";
              $this->grav['assets']->addInlineJs($code2, null, 'bottom');
            }
          }
        }
    }
}

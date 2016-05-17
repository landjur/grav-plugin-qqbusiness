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
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    public function onPluginsInitialized() {
      if ($this->isAdmin()) {
        return;
      }

      $this->enable([
          'onAssetsInitialized' => ['onAssetsInitialized', 0],
          'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0]
      ]);
    }

    // Add current directory to twig lookup paths.
    public function onTwigTemplatePaths() {
      $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onAssetsInitialized()
    {
        $position = trim($this->config->get('plugins.qqbusiness.position'));
        $nameAccount = trim($this->config->get('plugins.qqbusiness.nameAccount'));
        $selector = trim($this->config->get('plugins.qqbusiness.selector'));
        $aty = trim($this->config->get('plugins.qqbusiness.aty'));
        $a = trim($this->config->get('plugins.qqbusiness.a'));
        $visitor = trim($this->config->get('plugins.qqbusiness.visitor'));
        if ($selector !='' && $nameAccount !='') {
            $url = "http://wpa.b.qq.com/cgi/wpa.php";
            $codeCore = "BizQQWPA.addCustom({aty:'{$aty}', a:'{$a}', nameAccount:'{$nameAccount}', selector:'{$selector}'});";
            $codeVisitor = "BizQQWPA.visitor({nameAccount:'{$nameAccount}'});";
            if ($position == '' || $position == 'head') {
              $this->grav['assets']->addJs($url);
              $this->grav['assets']->addInlineJs($codeCore);
              if ($visitor) {
                $this->grav['assets']->addInlineJs($codeVisitor);
              }
            } else {
              $this->grav['assets']->addJs($url, null, $position);
              $this->grav['assets']->addInlineJs($codeCore, null, $position);
              if ($visitor) {
                $this->grav['assets']->addInlineJs($codeVisitor, null, $position);
              }
            }

            $this->grav['assets']->addCss('plugin://qqbusiness/css/qqbusiness.css');
        }
    }
}

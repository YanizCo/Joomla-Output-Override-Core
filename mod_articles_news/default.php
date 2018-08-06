<?php

defined('_JEXEC') or die;

echo '<div class="newsflash' . $moduleclass_sfx . '">';

foreach ($list as $item) {
  require JModuleHelper::getLayoutPath('mod_articles_news', '_item');
}

echo '</div>';

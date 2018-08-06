<?php


defined('_JEXEC') or die;

echo '<ul class="newsflash-vert' . $params->get('moduleclass_sfx') . '">';

for ($i = 0, $n = count($list); $i < $n; $i ++) {
	$item = $list[$i];
	echo '<li>';
	require JModuleHelper::getLayoutPath('mod_articles_news', '_item');

	if ($n > 1 && (($i < $n - 1) || $params->get('showLastSeparator'))) {
		echo '<span class="article-separator">&#160;</span>';
	}
	echo '</li>';
}

echo '</ul>';

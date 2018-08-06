<?php

defined('JPATH_BASE') or die;

$item = $displayData['item'];

echo '<dd class="hits">';
echo '<span class="icon-eye-open" aria-hidden="true"></span>';
echo '<meta itemprop="interactionCount" content="UserPageVisits:' . $item->hits . '" />';
echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $item->hits);
echo '</dd>';

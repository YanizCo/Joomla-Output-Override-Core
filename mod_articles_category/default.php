<?php

defined('_JEXEC') or die;

echo '<ul class="category-module' . $moduleclass_sfx . '">';
if ($grouped) {
	foreach ($list as $group_name => $group) {
		echo '<li>';
		echo '<div class="mod-articles-category-group">' . $group_name . '</div>';
		echo '<ul>';

    foreach ($group as $item) {
			echo '<li>';
				if ($params->get('link_titles') == 1) {
					echo '<a class="mod-articles-category-title ' . $item->active . '" href="' . $item->link . '">';
					echo $item->title;
					echo '</a>';
				} else {
					echo $item->title;
				}

				if ($item->displayHits) {
					echo '<span class="mod-articles-category-hits">';
					echo '(' . $item->displayHits . ')';
					echo '</span>';
				}

				if ($params->get('show_author')) {
					echo '<span class="mod-articles-category-writtenby">';
					echo $item->displayAuthorName;
					echo '</span>';
				}

				if ($item->displayCategoryTitle) {
					echo '<span class="mod-articles-category-category">';
					echo '(' . $item->displayCategoryTitle . ')';
					echo '</span>';
				}

				if ($item->displayDate) {
					echo '<span class="mod-articles-category-date">' . $item->displayDate . '</span>';
				}

				if ($params->get('show_introtext')) {
					echo '<p class="mod-articles-category-introtext">';
					echo $item->displayIntrotext;
					echo '</p>';
				}

				if ($params->get('show_readmore')) {
					echo '<p class="mod-articles-category-readmore">';
					echo '<a class="mod-articles-category-title ' . $item->active . '" href="' . $item->link . '">';

          if ($item->params->get('access-view') == false) {
						echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE');
					} elseif ($readmore = $item->alternative_readmore) {
						echo $readmore;
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));

            if ($params->get('show_readmore_title', 0) != 0) {
							echo JHtml::_('string.truncate', $this->item->title, $params->get('readmore_limit'));
						}

          } elseif ($params->get('show_readmore_title', 0) == 0) {
						echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE');
					} else {
						echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE');
						echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit'));
					}
					echo '</a>';
					echo '</p>';
				}
				echo '</li>';
			}

      echo '</ul>';
		  echo '</li>';
		}
	} else {
    foreach ($list as $item) {
		  echo '<li>';
			if ($params->get('link_titles') == 1) {
					<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
				<?php else : ?>
					<?php echo $item->title; ?>
				<?php endif; ?>

				<?php if ($item->displayHits) : ?>
					<span class="mod-articles-category-hits">
						(<?php echo $item->displayHits; ?>)
					</span>
				<?php endif; ?>

				<?php if ($params->get('show_author')) : ?>
					<span class="mod-articles-category-writtenby">
						<?php echo $item->displayAuthorName; ?>
					</span>
				<?php endif; ?>

				<?php if ($item->displayCategoryTitle) : ?>
					<span class="mod-articles-category-category">
						(<?php echo $item->displayCategoryTitle; ?>)
					</span>
				<?php endif; ?>

				<?php if ($item->displayDate) : ?>
					<span class="mod-articles-category-date">
						<?php echo $item->displayDate; ?>
					</span>
				<?php endif; ?>

				<?php if ($params->get('show_introtext')) : ?>
					<p class="mod-articles-category-introtext">
						<?php echo $item->displayIntrotext; ?>
					</p>
				<?php endif; ?>

				<?php if ($params->get('show_readmore')) : ?>
					<p class="mod-articles-category-readmore">
						<a class="mod-articles-category-title <?php echo $item->active; ?>" href="<?php echo $item->link; ?>">
							<?php if ($item->params->get('access-view') == false) : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_REGISTER_TO_READ_MORE'); ?>
							<?php elseif ($readmore = $item->alternative_readmore) : ?>
								<?php echo $readmore; ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
								<?php echo JText::sprintf('MOD_ARTICLES_CATEGORY_READ_MORE_TITLE'); ?>
							<?php else : ?>
								<?php echo JText::_('MOD_ARTICLES_CATEGORY_READ_MORE'); ?>
								<?php echo JHtml::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
							<?php endif; ?>
						</a>
					</p>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>

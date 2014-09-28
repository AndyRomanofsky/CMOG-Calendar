<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h3><?php echo $this->item->info.(($this->item->category and $this->item->params->get('show_category'))
                                      ? (' ('.$this->item->category.')') : ''); ?>
</h3>
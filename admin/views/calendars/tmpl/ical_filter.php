<?php/** *  */  $date = getDate();$search = JRequest::getCmd('search');$SDay = JRequest::getCmd('SDay'); if ($SDay == "") $SDay = $date["mday"];$SMonth = JRequest::getCmd('SMonth'); if ($SMonth == "") $SMonth = $date["mon"];$SYear = JRequest::getCmd('SYear'); if ($SYear == "") $SYear = $date["year"];$WYear= JRequest::getCmd('WYear');$Filter = JRequest::getCmd('Filter'); if ($Filter == "") $Filter  = "FMonth";$FClass = JRequest::getCmd('FClass'); if ($FClass == "") $FClass  = "CNone";$Templates= JRequest::getCmd('Templates');$hidelinks= JRequest::getCmd('hidelinks'); if ($hidelinks== "") $hidelinks = JRequest::getCmd('savedhidelinks');$state= $this->get('state');$fo = $state->filter_order;?>		<fieldset id="filter-bar">			<div class="filter-search fltlft">	<?php $filter_month = $state->get('filter.month'); ?>					<label for="filter_month">Date: </label>					<input size="3" type="text" name="filter_month" class="inputbox"  id="filter_month" value="<?php if ($filter_month == 0 ) {					 echo ( "all" );					  }else{					echo ($filter_month);					   }?>" title="<?php echo JText::_('COM_CMOGCAL_FILTER_MONTH'); ?>"  ;" /> 	<?php $filter_year = $state->get('filter.year'); ?>					<label for="filter_year">/ </label>					<input size="4" type="text" name="filter_year" class="inputbox"  id="filter_year" value="<?php if ($filter_year == 0 ) {					 echo ( "all" );					  }else{					echo ($filter_year);					   }?>" title="<?php echo JText::_('COM_CMOGCAL_FILTER_YEAR'); ?>" ;" />				<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>				<button type="button" onclick="				document.id('filter_month').value='<?php echo($date[mon])?>';document.id('filter_year').value='<?php echo($date[year])?>';				this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>			</div>						<div class="filter-select fltrt">				<select name="filter_published" class="inputbox" onchange="this.form.submit()">					<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>					<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $state->get('filter.published'), true);?>				</select>				<select name="filter_category_id" class="inputbox" onchange="this.form.submit()">					<option value=""><?php echo JText::_('JOPTION_SELECT_CATEGORY');?></option>					<?php echo JHtml::_('select.options', JHtml::_('category.options', 'com_cmogcal'), 'value', 'text', $state->get('filter.category_id') );?>				</select>								<?php $filter_template = $state->get('filter.template'); ?>			<select name="filter_template" class="inputbox" onchange="this.form.submit()">					<option value="0" <?php if ($filter_template == 0 ) echo " selected";?> >- Select template -</option>					<option value="-5" <?php if ($filter_template == -5 ) echo " selected";?> >Pascha</option>					<option value="-4" <?php if ($filter_template == -4 ) echo " selected";?> >Triodion</option>					<option value="-3" <?php if ($filter_template == -3 ) echo " selected";?> >Luke</option>					<option value="-2" <?php if ($filter_template == -2 ) echo " selected";?> >Pentecost</option>					<option value="-1" <?php if ($filter_template == -1 ) echo " selected";?> >Movable</option>			</select>			</div>		</fieldset>		
<?php/** *  */  $date = getDate();$Print= JRequest::getCmd('print');$search = JRequest::getCmd('search');$SDay = JRequest::getCmd('SDay'); if ($SDay == "") $SDay = $date["mday"];$SMonth = JRequest::getCmd('SMonth'); if ($SMonth == "") $SMonth = $date["mon"];$SYear = JRequest::getCmd('SYear'); if ($SYear == "") $SYear = $date["year"];$WYear= JRequest::getCmd('WYear');$Filter = JRequest::getCmd('Filter'); if ($Filter == "") $Filter  = "FDate";$FClass = JRequest::getCmd('FClass'); if ($FClass == "") $FClass  = "CNone";$Templates= JRequest::getCmd('Templates');$hidelinks= JRequest::getCmd('hidelinks'); if ($hidelinks== "") $hidelinks = JRequest::getCmd('savedhidelinks');$state= $this->get('state');$fo = $state->filter_order;?><?php if ($Print==1){  echo(" ");  } else {?>		<hr class="filterstart">		<table>			<tr><td >					<button onclick="this.form.submit();"><?php echo JText::_( 'Change date' ); ?></button>				<input type="hidden" name="Filter" value="FMonth" />				        Month: <input type="text" name="SMonth" id="SMonth" value="<?php echo ($SMonth);?>" size="4" maxlength="4" class="text_area" ;" />				</td></tr>		</table>		<hr class="filterend"><?php } ?>
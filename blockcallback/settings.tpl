{literal}
<style type="text/css">
	form.blockcallback table {
		text-align: center;
	}

	form.blockcallback table td {
		padding: 1em;
	}

	form.blockcallback table td label {
		display: block;
		float: none;
		padding-bottom: .5em;
		width: auto;
	}
</style>
{/literal}
<form action="{$smarty.server.REQUEST_URI}" method="POST" class="blockcallback">
	<fieldset>
		<legend>{l s='Settings' mod='blockcallback'}</legend>
		<label for="CALLBACKEMAIL">{l s='Email address:' mod='blockcallback'}</label>
		<div class="margin-form">
			<input type="text" id="CALLBACKEMAIL" name="CALLBACK_EMAIL" maxlength="50" value="{$CALLBACK_EMAIL}" />
			<p class="clear"></p>
		</div>
	</fieldset>
	<br>
	<fieldset>
		<legend>{l s='Display time' mod='blockcallback'}</legend>
		<table>
			<tr style="text-align: center">
				<td><label for="CallbackDisplayDay0">{l s='Monday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_0" id="CallbackDisplayDay0" type="checkbox"{if $CALLBACK_DISPLAY_DAY_0} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay1">{l s='Tuesday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_1" id="CallbackDisplayDay1" type="checkbox"{if $CALLBACK_DISPLAY_DAY_1} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay2">{l s='Wednesday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_2" id="CallbackDisplayDay2" type="checkbox"{if $CALLBACK_DISPLAY_DAY_2} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay3">{l s='Thursday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_3" id="CallbackDisplayDay3" type="checkbox"{if $CALLBACK_DISPLAY_DAY_3} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay4">{l s='Friday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_4" id="CallbackDisplayDay4" type="checkbox"{if $CALLBACK_DISPLAY_DAY_4} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay5">{l s='Saturday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_5" id="CallbackDisplayDay5" type="checkbox"{if $CALLBACK_DISPLAY_DAY_5} checked="checked"{/if} /></td>
				<td><label for="CallbackDisplayDay6">{l s='Sunday' mod='blockcallback'}</label><input name="CALLBACK_DISPLAY_DAY_6" id="CallbackDisplayDay6" type="checkbox"{if $CALLBACK_DISPLAY_DAY_6} checked="checked"{/if} /></td>
			</tr>
		</table>
		<br>
		<label style="width: auto" for="CallbackDisplayTimeFrom">{l s='From:' mod='blockcallback'} </label>
		<select id="CallbackDisplayTimeFrom" name="CALLBACK_DISPLAY_TIME_FROM">
			<option value=""{if $CALLBACK_DISPLAY_TIME_FROM === ''} selected="selected"{/if}></option>
			<option value="0"{if $CALLBACK_DISPLAY_TIME_FROM === '0'} selected="selected"{/if}>00:00</option>
			<option value="1"{if $CALLBACK_DISPLAY_TIME_FROM == '1'} selected="selected"{/if}>01:00</option>
			<option value="2"{if $CALLBACK_DISPLAY_TIME_FROM == '2'} selected="selected"{/if}>02:00</option>
			<option value="3"{if $CALLBACK_DISPLAY_TIME_FROM == '3'} selected="selected"{/if}>03:00</option>
			<option value="4"{if $CALLBACK_DISPLAY_TIME_FROM == '4'} selected="selected"{/if}>04:00</option>
			<option value="5"{if $CALLBACK_DISPLAY_TIME_FROM == '5'} selected="selected"{/if}>05:00</option>
			<option value="6"{if $CALLBACK_DISPLAY_TIME_FROM == '6'} selected="selected"{/if}>06:00</option>
			<option value="7"{if $CALLBACK_DISPLAY_TIME_FROM == '7'} selected="selected"{/if}>07:00</option>
			<option value="8"{if $CALLBACK_DISPLAY_TIME_FROM == '8'} selected="selected"{/if}>08:00</option>
			<option value="9"{if $CALLBACK_DISPLAY_TIME_FROM == '9'} selected="selected"{/if}>09:00</option>
			<option value="10"{if $CALLBACK_DISPLAY_TIME_FROM == '10'} selected="selected"{/if}>10:00</option>
			<option value="11"{if $CALLBACK_DISPLAY_TIME_FROM == '11'} selected="selected"{/if}>11:00</option>
			<option value="12"{if $CALLBACK_DISPLAY_TIME_FROM == '12'} selected="selected"{/if}>12:00</option>
			<option value="13"{if $CALLBACK_DISPLAY_TIME_FROM == '13'} selected="selected"{/if}>13:00</option>
			<option value="14"{if $CALLBACK_DISPLAY_TIME_FROM == '14'} selected="selected"{/if}>14:00</option>
			<option value="15"{if $CALLBACK_DISPLAY_TIME_FROM == '15'} selected="selected"{/if}>15:00</option>
			<option value="16"{if $CALLBACK_DISPLAY_TIME_FROM == '16'} selected="selected"{/if}>16:00</option>
			<option value="17"{if $CALLBACK_DISPLAY_TIME_FROM == '17'} selected="selected"{/if}>17:00</option>
			<option value="18"{if $CALLBACK_DISPLAY_TIME_FROM == '18'} selected="selected"{/if}>18:00</option>
			<option value="19"{if $CALLBACK_DISPLAY_TIME_FROM == '19'} selected="selected"{/if}>19:00</option>
			<option value="20"{if $CALLBACK_DISPLAY_TIME_FROM == '20'} selected="selected"{/if}>20:00</option>
			<option value="21"{if $CALLBACK_DISPLAY_TIME_FROM == '21'} selected="selected"{/if}>21:00</option>
			<option value="22"{if $CALLBACK_DISPLAY_TIME_FROM == '22'} selected="selected"{/if}>22:00</option>
			<option value="23"{if $CALLBACK_DISPLAY_TIME_FROM == '23'} selected="selected"{/if}>23:00</option>
		</select>
		<label style="width: auto; float: none" for="CallbackDisplayTimeTo">{l s='To:' mod='blockcallback'} </label>
		<select id="CallbackDisplayTimeTo" name="CALLBACK_DISPLAY_TIME_TO">
			<option value=""{if $CALLBACK_DISPLAY_TIME_TO === ''} selected="selected"{/if}></option>
			<option value="1"{if $CALLBACK_DISPLAY_TIME_TO == '1'} selected="selected"{/if}>01:00</option>
			<option value="2"{if $CALLBACK_DISPLAY_TIME_TO == '2'} selected="selected"{/if}>02:00</option>
			<option value="3"{if $CALLBACK_DISPLAY_TIME_TO == '3'} selected="selected"{/if}>03:00</option>
			<option value="4"{if $CALLBACK_DISPLAY_TIME_TO == '4'} selected="selected"{/if}>04:00</option>
			<option value="5"{if $CALLBACK_DISPLAY_TIME_TO == '5'} selected="selected"{/if}>05:00</option>
			<option value="6"{if $CALLBACK_DISPLAY_TIME_TO == '6'} selected="selected"{/if}>06:00</option>
			<option value="7"{if $CALLBACK_DISPLAY_TIME_TO == '7'} selected="selected"{/if}>07:00</option>
			<option value="8"{if $CALLBACK_DISPLAY_TIME_TO == '8'} selected="selected"{/if}>08:00</option>
			<option value="9"{if $CALLBACK_DISPLAY_TIME_TO == '9'} selected="selected"{/if}>09:00</option>
			<option value="10"{if $CALLBACK_DISPLAY_TIME_TO == '10'} selected="selected"{/if}>10:00</option>
			<option value="11"{if $CALLBACK_DISPLAY_TIME_TO == '11'} selected="selected"{/if}>11:00</option>
			<option value="12"{if $CALLBACK_DISPLAY_TIME_TO == '12'} selected="selected"{/if}>12:00</option>
			<option value="13"{if $CALLBACK_DISPLAY_TIME_TO == '13'} selected="selected"{/if}>13:00</option>
			<option value="14"{if $CALLBACK_DISPLAY_TIME_TO == '14'} selected="selected"{/if}>14:00</option>
			<option value="15"{if $CALLBACK_DISPLAY_TIME_TO == '15'} selected="selected"{/if}>15:00</option>
			<option value="16"{if $CALLBACK_DISPLAY_TIME_TO == '16'} selected="selected"{/if}>16:00</option>
			<option value="17"{if $CALLBACK_DISPLAY_TIME_TO == '17'} selected="selected"{/if}>17:00</option>
			<option value="18"{if $CALLBACK_DISPLAY_TIME_TO == '18'} selected="selected"{/if}>18:00</option>
			<option value="19"{if $CALLBACK_DISPLAY_TIME_TO == '19'} selected="selected"{/if}>19:00</option>
			<option value="20"{if $CALLBACK_DISPLAY_TIME_TO == '20'} selected="selected"{/if}>20:00</option>
			<option value="21"{if $CALLBACK_DISPLAY_TIME_TO == '21'} selected="selected"{/if}>21:00</option>
			<option value="22"{if $CALLBACK_DISPLAY_TIME_TO == '22'} selected="selected"{/if}>22:00</option>
			<option value="23"{if $CALLBACK_DISPLAY_TIME_TO == '23'} selected="selected"{/if}>23:00</option>
			<option value="24"{if $CALLBACK_DISPLAY_TIME_TO == '24'} selected="selected"{/if}>24:00</option>
		</select>
	</fieldset>
	<br>
	<fieldset>
		<input name="btnSubmitBlockCallback" class="button" type="submit" value="{l s='Save' mod='blockcallback'}" />
	</fieldset>
</form>

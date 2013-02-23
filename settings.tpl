<form action="{$smarty.server.REQUEST_URI}" method="POST">
	<fieldset>
		<legend>{l s='Settings' mod='blockcallback'}</legend>
		<label for="CALLBACKEMAIL">{l s='Email address:' mod='blockcallback'}</label>
		<div class="margin-form">
			<input type="text" id="CALLBACKEMAIL" name="CALLBACK_EMAIL" maxlength="50" value="{$CALLBACK_EMAIL}" />
			<p class="clear"></p>
		</div>

		<input name="btnSubmitBlockCallback" class="button" type="submit" value="{l s='Save' mod='blockcallback'}" />
	</fieldset>
</form>

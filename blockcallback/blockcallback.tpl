<!-- Block blockcallback -->
<div id="blockcallback_block_left" class="block">
	<h4>{l s='We call you back' mod='blockcallback'}</h4>
	<div class="block_content">
		<form action="{$smarty.server.REQUEST_URI}" method="post">
		{if !empty($blockcallback_msg)}
			<p class="{if isset($blockcallback_error) && $blockcallback_error}blockcallback_error{else}blockcallback_success{/if}">{$blockcallback_msg}</p>
		{/if}
			<label for="BlockCallbackName">{l s='Your name:' mod='blockcallback'}</label>
			<input id="BlockCallbackName" name="BlockCallbackName" value="{if isset($blockcallback_error) && $blockcallback_error}{$smarty.post.BlockCallbackName|escape:'htmlall':'UTF-8'}{/if}" type="text" />

			<label for="BlockCallbackPhone">{l s='Your phone:' mod='blockcallback'}</label>
			<input id="BlockCallbackPhone" name="BlockCallbackPhone" value="{if isset($blockcallback_error) && $blockcallback_error}{$smarty.post.BlockCallbackPhone|escape:'htmlall':'UTF-8'}{/if}" type="text" />

			<p>
				<input type="submit" value="{l s='Give me a call' mod='blockcallback'}" class="exclusive" name="submitBlockCallback">
			</p>
		</form>
	</div>
</div>
<!-- /Block blockcallback -->

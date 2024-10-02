{assign 'allowed_pages' ['index', 'category', 'product', 'search', 'best-sales', 'prices-drop']}
{if in_array($page_name, $allowed_pages)} 
<!-- Block mymodule -->
<div id="arw_block" class="block">
		{if isset($my_module_name) && $my_module_name}
			{$my_module_name}
		{/if}
		<a href="{$adr_link}" target="_blank"><img src="{$modules_dir}adrandom/img/{$adr_img}" alt="{l s='banner' mod='adrandom'}" title="{l s='open in new window' mod='adrandom'}"></a>
</div>
<!-- /Block mymodule -->
{/if}
{$formAction="session.php"}
{extends file="form.tpl"}

{block name="form-content"}
	{if count($sessions) > 0}
		<div class="form-group">
			<div class="input-group col-sm-6">
				<select class="form-control" name="session">
					{foreach $sessions as $session}
						<option value="{$session['id']}">{$session['tokbox']} (Created {$session['created']|date_format:"%A %b %e"})</option>
					{/foreach}
				</select>
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit">Connect</button>
				</span>
			</div>
		</div>
		{$formButton="Join Session"}
	{else}
		<p>No sessions are available.</p>
	{/if}
{/block}

{block name="form-buttons"}{/block}

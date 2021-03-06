{tmplinclude file="header.tpl" pageTitle="IXP Manager :: Member Dashboard"}

<div class="yui-g">

{tmplinclude file="message.tpl"}

<div id='ajaxMessage'></div>

<div id="content">

<table>
<tr>
<td width="100%">

<table align="right">
<tr>
    <form method="post">
       <td>
	        <label for="dt_input">{$config.identity.orgname} Network: </label>
	        <select id="dt_input" name="vlan">
	            <option></option>
	            {foreach from=$vlans item=vlan}
	                <option value="{$vlan.number}" {if isset( $vlannum ) and $vlannum eq $vlan.number}selected{/if}>{$vlan.name}</option>
	            {/foreach}
	        </select>
        </td>
        <td>
            <input type="submit" name="submit" class="button" value="Filter" />
        </td>
    </form>
</tr>
</table>

</td>
</tr>
<tr>
<td>

<table id="ixpDataTable" class="display" cellspacing="0" cellpadding="0" border="0">
    <thead>
        <tr>
            <th>Member</th>
            <th>Switch</th>
            <th>Port</th>
            <th>Speed</th>
            <th>ASN</th>
            <th>Route Server</th>
            <th>IPv4 Address</th>
            <th>IPv6 Address</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
{foreach from=$swconf item=swc}
        <tr>
            <td><a {if $swc.ViewCustCurrentActive.corpwww}href="{$swc.ViewCustCurrentActive.corpwww}"{/if}>{$swc.ViewCustCurrentActive.name}</a></td>
            <td>{$swc.switch}</td>
            <td>{$swc.switchport}</td>
            <td>{$swc.speed}Mbps</td>
            <td>{$swc.ViewCustCurrentActive.autsys|asnumber}</td>
            <td>{if $swc.ViewVlaninterfaceDetailsByCustid.rsclient}Yes{else}No{/if}</td>
            <td>{$swc.ViewVlaninterfaceDetailsByCustid.ipv4address}</td>
            <td>{$swc.ViewVlaninterfaceDetailsByCustid.ipv6address}</td>
            <td>{$swc->getPhysicalInterfaceStatusString()}</td>
        </tr>
{/foreach}

    </tbody>
</table>

</td>
</tr>
</table>

</div>
</div>

{literal}
<script>
	
oTable = $('#ixpDataTable').dataTable({
	"bJQueryUI": true,
	"sPaginationType": "full_numbers",
	"iDisplayLength": 100
});

</script>
{/literal}

{tmplinclude file="footer.tpl"}


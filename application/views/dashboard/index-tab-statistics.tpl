
<p>
	Please see the <em>Statistics</em> menu above right for more graphs and options.
</p>


<p>

<form action="{genUrl controller="dashboard" action="statistics"}" method="post">
<table>
<tr>
    <td width="20"></td>
    <td valign="middle"><strong>Graph Type:</strong></td>
    <td>
        <select name="category" onchange="this.form.submit();">
            {foreach from=$categories key=cname item=cvalue}
                <option value="{$cvalue}">{$cname}</option>
            {/foreach}
        </select>
    </td>
</tr>
</table>
</form>
</p>

<h2>Aggregate Traffic Statistics</h2>

<p>
    <a href="{genUrl controller="dashboard" action="statistics-drilldown" shortname=$customer.shortname category='bits' monitorindex='aggregate'}">
        {genMrtgImgUrlTag shortname=$customer.shortname category='bits' monitorindex='aggregate' graphBackend=$graphBackend}
    </a>
</p>


{foreach from=$connections item=connection}
    {foreach from=$connection.Physicalinterface item=physicalinterface}

    <h2>
        Connection:
                {$physicalinterface.Switchport.SwitchTable.Cabinet.Location.name}
            / {$physicalinterface.Switchport.SwitchTable.name}
            / {$physicalinterface.Switchport.name} ({$physicalinterface.speed}Mb/s)
    </h2>


    <p>
        <a href="{genUrl controller="dashboard" action="statistics-drilldown" shortname=$customer.shortname category='bits' monitorindex=$physicalinterface.monitorindex}">
            {genMrtgImgUrlTag shortname=$customer.shortname monitorindex=$physicalinterface.monitorindex switchport=$physicalinterface.Switchport.id graphBackend=$graphBackend}
        </a>
    </p>

    {/foreach}
{/foreach}

{tmplinclude file="header.tpl" pageTitle="IXP Manager :: Provision New Interface"}

<div class="yui-g">

<table class="adminheading" border="0" style="display: block;">
<tr>
    <th class="Provision">
        Provisioning: New Interfaces
    </th>
</tr>
</table>

{tmplinclude file="message.tpl"}

<div id="ajaxMessage"></div>

<table id="ixpDataTable" class="display" cellspacing="0" cellpadding="0" border="0" style="display: none;">

<thead>
<tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Created By</th>
    <th>Started At</th>
    <th>Progress</th>
</tr>
</thead>

<tbody>

    {foreach from=$outstanding item=o}
	{counter name='id' assign='idcount'}
    <tr>
        <td>{$o.id}</td>
        <td>
			<span id="viewPanel-customer-{$o.Cust.id}-{$idcount}" class="blueLink">
				<script>
					$( '#viewPanel-customer-{$o.Cust.id}-{$idcount}' ).click( function() {ldelim}
						ixpViewPanel( 'Customer', 'customer', {$o.Cust.id} );
					{rdelim} );
				</script>
				{$o.Cust.name}
			</span>
		</td>
        <td>{$o.CreatedBy.username}</td>
        <td>{$o.created_at|strtotime|date_format:"%Y-%m-%d %H:%m:%d"}</td>
        <td>{$o->stepsComplete()}</td>
    </tr>
    {/foreach}
</tbody>

</table>

<table align="right">
<tr><td>
    <form action="{genUrl controller="provision" action="interface-overview" new="yes"}" method="post">
        <input type="submit" name="submit" value="Provision New Interface..."  />
    </form>
</td></tr>
</table>


</div>


<ul id="myMenu" class="contextMenu">
	<li class="edit">
		<a href="#edit">Continue</a>
	</li>
</ul>


<div id="dialog-viewpanel" title="Loading..." style="display: none">
	<p>Loading...</p>
</div>

<script>
{literal}

function ixpViewPanel( title, controller, id ) {
	$.get(
        "{/literal}{genUrl}{literal}/" + controller + "/view/id/" + id + "/perspective/panel",
        function( data ){
        	$( '#dialog-viewpanel' ).html( data );
        	$( '#dialog-viewpanel' ).dialog( 'option', 'title', title );
        	$( '#dialog-viewpanel' ).dialog( 'open' );
    	});
}

$(document).ready(function() {

	$( "#dialog-viewpanel" ).dialog({
		width: 500,
		autoOpen: false,
		modal: true
	});

	oTable = $('#ixpDataTable').dataTable({

		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"iDisplayLength": 25,
		"aoColumns": [
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false},
			{"bSortable": false}
  		]
	});

	$('#ixpDataTable').show();
	
	$( oTable.fnGetNodes() ).each( function( index, element ){

        $( element ).bind('dblclick', function() { window.location.assign( "/provision/interface-overview/edit/id/"  + oTable.fnGetData( index )[0] ); } );

		$( element ).contextMenu({
				menu: "myMenu"
			},
			function( action, el, pos ) {

				var aData = oTable.fnGetData( index );

				switch( action )
				{
					case 'edit':
						window.location.assign( "/provision/interface-overview/edit/id/"  + aData[0] );
						break;
				}
			}
		);

	});

} );
{/literal}
</script>


{tmplinclude file="footer.tpl"}


{literal}

$( element ).contextMenu({

		menu: "myMenu"
	},
	function( action, el, pos ) {

		var aData = oTable.fnGetData( index );

		switch( action )
		{
            case 'view':
                window.location.assign( "/{/literal}{$controller}{literal}/view/id/"  + aData[0] );
                break;

            case 'edit':
                window.location.assign( "/{/literal}{$controller}{literal}/edit/id/" + aData[0] );
        		break;

            case 'delete':
                if( confirm( "Are you sure you want to delete this record?" ) )
                    window.location.assign( "/{/literal}{$controller}{literal}/delete/id/" + aData[0] );
                break;
                
            case 'meetings':
                window.location.assign( {/literal}"{genUrl controller='meeting-item' action='list' meeting_id=''}{literal}"  + aData[0] );
                break;
                
            case 'mail':
                window.location.assign( {/literal}"{genUrl controller='meeting' action='compose' id=''}{literal}"  + aData[0] );
                break;
                
		}
	}
);


{/literal}

<?php

/*
 * {$config.identity.orgname} - My Peering Manager: {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}
 *
 * Copyright (c) Internet Neutral Exchange Association Ltd T/A INEX {$smarty.now|date_format:"%Y"}. All rights reserved.
 *
 * http://www.inex.ie/
 */

$inex_peerings = array(
{foreach from=$matrix item=m}
    '{$m.y_as}' => array(
        'lan'             => '{$m.vlan}',
        'peered'          => '{$m.MyPeeringMatrix.peered}',
        'peering_matrix'  => '{$m.peering_status}',
        'route_server'    => '{if $rsclient[$m.Y_Cust.id]}YES{else}NO{/if}',
        {if $ipv6[$customer.id]}'ipv6'            => '{if $ipv6[$m.Y_Cust.id]}{if $m.MyPeeringMatrix.ipv6}PEERED_IPv6{else}NOT_PEERING_IPv6{/if}',{else}N/A',{/if}{/if}

        'name'            => "{$m.Y_Cust.name}",
        'asn'             => '{$m.y_as}',
        'peering_policy'  => '{$m.Y_Cust.peeringpolicy}',
        'peering_contact' => '{$m.Y_Cust.peeringemail}',
        'member_since'    => '{$m.Y_Cust.datejoin}'
    ),

{/foreach}
);

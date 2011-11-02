<style>
/* Define a style for top menu */

.yui-skin-sam .yuimenu {ldelim}

    line-height: 2;  /* ~24px */
    *line-height: 1.9; /* For IE */

{rdelim}


.yui-skin-sam #topMenu li.yuimenuitem .yuimenuitemlabel {ldelim}
    background: no-repeat 4px; 
    padding: 0 20px 0 24px; 
{rdelim}
 
.yui-skin-sam #topMenu li.yuimenuitem {ldelim}

    /*
        For IE 7 Quirks and IE 6 Strict Mode and Quirks Mode:
        Used to collapse superfluous white space between <li> 
        elements that is triggered by the "display" property of the
        <a> elements being set to "block."
    */

    _border-bottom: solid 1px #ccc;

{rdelim}


/* Add icons to menu items. */

{if $identity.user.privs eq 3}
/* Super User menu */
.yui-skin-sam #topMenu li#menuItemLocations .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/globe4.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemCabinets .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/cabinets.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemCurcuits .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemSwitches .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/switch.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemSwitchPorts .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemAddPorts .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemIPAddresses .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemPatchPanels .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/connection.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemPatchPanelPorts .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemVendors .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/vendors.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemConsoleConnections .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/console.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemVlans .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/vlan.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemNetworkInfo .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/network.png);
{rdelim}

/* Admin menu */
.yui-skin-sam #topMenu li#menuItemMembers .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemInterfaces .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemProvisioning .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/install.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemNewInterface .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/interface.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemContacts .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/kontact.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemUsers .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/system-users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemCustomerKit .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/drive-optical.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMeetings .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/meetings.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemChangeLog .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/contents.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemIrrdbConfig .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/config.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemUtils .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/config.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemUtilsSecEvents .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/contents.png);
{rdelim}
{/if}

{if $identity.user.privs neq 2}
/* Member Information menu */
.yui-skin-sam #topMenu li#menuItemSwitchConfiguration .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/switch.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMemberDetails .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMemberInformationMeetings .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/meetings.png);
{rdelim}
{/if}

{if $identity.user.privs neq 2}
/* Peering menu */
.yui-skin-sam #topMenu div#menuPeering .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/joomla_16x16.png);
{rdelim}
{/if}

{if $identity.user.privs eq 1 or $identity.user.privs eq 3}
/* Documentation menu */
.yui-skin-sam #topMenu div#menuDocumentation .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/document.png);
{rdelim}
{/if}

/* Statistics menu */
{if $identity.user.privs eq 3}
.yui-skin-sam #topMenu li#menuItemLastLogins .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/system-users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMemberStatisticsAggregate .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMemberStatisticsByLan .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemListMembers .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/users.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemLeagueTable .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItem95thPercentiles .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}
{/if}

.yui-skin-sam #topMenu li#menuItemOverallPeeringStatistics .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemMyStatistics .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemTrunkGraphs .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemSwitchAggregateGraphs .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/rack.png);
{rdelim}

{if $identity.user.privs eq 3 and isset( $config.menu.staff_links )}
/* Staff Links menu */
.yui-skin-sam #topMenu div#menuStaffLinks .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/globe1.png);
{rdelim}
{/if}

{if $identity.user.privs eq 1}
/* Profile menu */
.yui-skin-sam #topMenu li#menuItemUserProfile .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/personal.png);
{rdelim}

.yui-skin-sam #topMenu li#menuItemSecEventNotifications .yuimenuitemlabel {ldelim}
    background-image: url({genUrl}/images/joomla-admin/menu/controlpanel.png);
{rdelim}
{/if}

</style>

<div id="topMenu" style="visibility: hidden">
    <div class="bd">
    <ul>

        <li>
        {if $identity.user.privs eq 3}
            <a href="{genUrl controller="customer"}">Home</a>
        {elseif $identity.user.privs eq 2}
            <a href="{genUrl controller="cust-admin"}">User Admin</a>
        {elseif $identity.user.privs eq 1}
            <a href="{genUrl controller="dashboard"}">Dashboard</a>
        {/if}
        </li>

        {if $identity.user.privs eq 3}
        <li>
            <a href="#menuSuperUser">Super User</a>
            <div id="menuSuperUser">
                <div class="bd">
                <ul>
                    <li id="menuItemLocations">
                        <a href="{genUrl controller="location"}">Locations</a>
                    </li>
                    <li id="menuItemCabinets">
                        <a href="{genUrl controller="cabinet"}">Cabinets</a>
                    </li>
                    <li id="menuItemCurcuits">
                        <a href="{genUrl controller="logical-circuit"}">Circuits</a>
                        <div id="menuCircuits">
                            <div class="bd">
                            <ul>
                                <li id="menuItemLogicalCurcuits">
                                    <a href="{genUrl controller="logical-circuit"}">Logical Circuits</a>
                                </li>
                                <li id="menuItemPhysicalCurcuits">
                                    <a href="{genUrl controller="physical-circuit"}">Physical Circuits</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemSwitches">
                        <a href="{genUrl controller="switch"}">Switches</a>
                        <div id="menuSwitches">
                            <div class="bd">
                            <ul>
                                <li id="menuItemSwitchPorts">
                                    <a href="{genUrl controller="switch-port"}">Switch Ports</a>
                                </li>
                                <li id="menuItemAddPorts">
                                    <a href="{genUrl controller="switch" action="add-ports"}">Add Ports</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemIPAddresses">
                        <a href="#menuIPAddresses">IP Addresses</a>
                        <div id="menuIPAddresses">
                            <div class="bd">
                            <ul>
                                <li id="menuItemAddIPAddresses">
                                    <a href="{genUrl controller="ipv4-address" action="add-addresses"}">Add IP Addresses</a>
                                </li>
                                <li id="menuItemIPv4Addresses">
                                    <a href="{genUrl controller="ipv4-address" action="list"}">IPv4 Addresses</a>
                                </li>
                                <li id="menuItemIPv6Addresses">
                                    <a href="{genUrl controller="ipv6-address" action="list"}">IPv6 Addresses</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemPatchPanels">
                        <a href="{genUrl controller="patch-panel"}">Patch Panels</a>
                        <div id="menuPatchPanels">
                            <div class="bd">
                            <ul>
                                <li id="menuItemPatchPanelPorts">
                                    <a href="{genUrl controller="patch-panel-port"}">Patch Panel Ports</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemVendors">
                        <a href="{genUrl controller="vendor"}">Vendors</a>
                    </li>
                    <li id="menuItemConsoleConnections">
                        <a href="{genUrl controller="console-server-connection"}">Console Connections</a>
                    </li>
                    <li id="menuItemVlans">
                        <a href="{genUrl controller="vlan"}">VLANs</a>
                    </li>
                    <li id="menuItemNetworkInfo">
                        <a href="{genUrl controller="networkinfo"}">Network Info</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>

        <li>
            <a href="#menuAdmin">Admin</a>
            <div id="menuAdmin">
                <div class="bd">
                <ul>
                    <li id="menuItemMembers">
                        <a href="{genUrl controller="customer"}">Members</a>
                    </li>
                    <li id="menuItemInterfaces">
                        <a href="{genUrl controller="virtual-interface"}">Interfaces</a>
                        <div id="menuInterfaces">
                            <div class="bd">
                            <ul>
                                <li id="menuItemQuickAdd">
                                    <a href="{genUrl controller="vlan-interface" action="quick-add"}">Quick Add</a>
                                </li>
                                <li id="menuItemPhysicalInterfaces">
                                    <a href="{genUrl controller="physical-interface"}">Physical Interfaces</a>
                                </li>
                                <li id="menuItemVirtualInterfaces">
                                    <a href="{genUrl controller="virtual-interface"}">Virtual Interfaces</a>
                                </li>
                                <li id="menuItemVlanInterfaces">
                                    <a href="{genUrl controller="vlan-interface"}">VLAN Interfaces</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemProvisioning">
                        <a href="#menuProvisioning">Provisioning</a>
                        <div id="menuProvisioning">
                            <div class="bd">
                            <ul>
                                <li id="menuItemNewInterface">
                                    <a href="{genUrl controller="provision" action="interface"}">New Interface</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemContacts">
                        <a href="{genUrl controller="contact"}">Contacts</a>
                    </li>
                    <li id="menuItemUsers">
                        <a href="{genUrl controller="user"}">Users</a>
                    </li>
                    <li id="menuItemCustomerKit">
                        <a href="{genUrl controller="cust-kit"}">Customer Kit</a>
                    </li>
                    <li id="menuItemMeetings">
                        <a href="{genUrl controller="meeting"}">Meetings</a>
                        <div id="menuMeetings">
                            <div class="bd">
                            <ul>
                                <li id="menuItemMeetingsAddEdit">
                                    <a href="{genUrl controller="meeting"}">Add / Edit</a>
                                </li>
                                <li id="menuItemMeetingsPresentations">
                                    <a href="{genUrl controller="meeting-item"}">Presentations</a>
                                </li>
                                <li id="menuItemMeetingMemberView">
                                    <a href="{genUrl controller="meeting" action="read"}">Member View</a>
                                </li>
                                <li id="menuItemMeetingInstructions">
                                    <a href="{genUrl controller="admin" action="static" page="instructions-meetings"}">Instructions</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemChangeLog">
                        <a href="{genUrl controller="change-log"}">Change Log</a>
                    </li>
                    <li id="menuItemIrrdbConfig">
                        <a href="{genUrl controller="irrdb-config"}">IRRDB Config</a>
                    </li>
                    <li id="menuItemUtils">
                        <a href="#menuUtils">Utils</a>
                        <div id="menuUtils">
                            <div class="bd">
                            <ul>
                                <li id="menuItemUtilsPhpInfo">
                                    <a href="{genUrl controller="utils" action="phpinfo"}">PHP Info</a>
                                </li>
                                <li id="menuItemUtilsApcInfo">
                                    <a href="{genUrl controller="utils" action="apcinfo"}">APC Info</a>
                                </li>
                                <li id="menuItemUtilsSecEvents">
                                    <a href="{genUrl controller="sec-viewer"}">SEC Events</a>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs neq 2}
        <li>
            <a href="#menuMemberInformation">Member Information</a>
            <div id="menuMemberInformation">
                <div class="bd">
                <ul>
                    <li id="menuItemSwitchConfiguration">
                        <a href="{genUrl controller="dashboard" action="switch-configuration"}">Switch Configuration</a>
                    </li>
                    <li id="menuItemMemberDetails">
                        <a href="{genUrl controller="dashboard" action="members-details-list"}">Member Details</a>
                    </li>
                    <li id="menuItemMemberInformationMeetings">
                        <a href="{genUrl controller="meeting" action="read"}">Meetings</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs neq 2}
        <li>
            <a href="#menuPeering">Peering</a>
            <div id="menuPeering">
                <div class="bd">
                <ul>
                    <li id="menuItemPeeringMatrices">
                        <a href="#menuPeeringMatrices">Peering Matrices</a>
                        <div id="menuPeeringMatrices">
                            <div class="bd">
                            <ul>
                                {foreach from=$config.peering_matrix.public key=index item=lan}
                                <li>
                                    <a href="{genUrl controller="dashboard" action="peering-matrix" lan=$index}" target="_blank">{$lan.name}</a>
                                </li>
                                {/foreach}
                            </ul>
                            </div>
                        </div>
                    </li>
                    {if $identity.user.privs eq 1 and $customer->isFullMember()}
                    <li id="menuItemMyPeeringManager">
                        <a href="{genUrl controller="dashboard" action="my-peering-matrix"}">My Peering Manager</a>
                    </li>
                    {/if}
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs eq 1 or $identity.user.privs eq 3}
        <li>
            <a href="#menuDocumentation">Documentation</a>
            <div id="menuDocumentation">
                <div class="bd">
                <ul>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="fees"}">Fees and Charges</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="housing"}">Equipment Housing</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="misc-benefits"}">Miscellaneous Benefits</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="support"}">Technical Support</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="switches"}">Connecting Switches</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="static" page="port-security"}">Port Security Policies</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="as112"}">AS112 Service</a>
                    </li>
                    <li>
                        <a href="{genUrl controller="dashboard" action="rs-info"}">Route Servers</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs eq 3}
        <li>
            <a href="#menuStatistics">Statistics</a>
            <div id="menuStatistics">
                <div class="bd">
                <ul>
                    <li id="menuItemLastLogins">
                        <a href="{genUrl controller="user" action="last"}">Last Logins</a>
                    </li>
                    <li id="menuItemOverallPeeringStatistics">
                        <a href="{genUrl controller="dashboard" action="traffic-stats"}">Overall Peering Statistics</a>
                    </li>
                    <li id="menuItemMemberStatisticsAggregate">
                        <a href="{genUrl controller="customer" action="statistics-overview"}">Member Statistics - Aggregate</a>
                    </li>
                    <li id="menuItemMemberStatisticsByLan">
                        <a href="#menuMemberStatisticsByLan">Member Statistics - By LAN</a>
                        <div id="menuMemberStatisticsByLan">
                            <div class="bd">
                            <ul>
                                {foreach from=$config.peering_matrix.public key=index item=lan}
                                <li>
                                    <a href="{genUrl controller="customer" action="statistics-by-lan" lan=$lan.number}">{$lan.name}</a>
                                </li>
                                {/foreach}
                            </ul>
                            </div>
                        </div>
                    </li>
                    <li id="menuItemListMembers">
                        <a href="{genUrl controller="customer" action="statistics-list"}">List Members</a>
                    </li>
                    <li id="menuItemTrunkGraphs">
                        <a href="{genUrl controller="dashboard" action="trunk-graphs"}">Trunk Graphs</a>
                    </li>
                    <li id="menuItemSwitchAggregateGraphs">
                        <a href="{genUrl controller="dashboard" action="switch-graphs"}">Switch Aggregate Graphs</a>
                    </li>
                    <li id="menuItemLeagueTable">
                        <a href="{genUrl controller="customer" action="league-table"}">League Table</a>
                    </li>
                    <li id="menuItem95thPercentiles">
                        <a href="{genUrl controller="customer" action="ninety-fifth"}">95th Percentiles</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {elseif $identity.user.privs eq 1 and $customer->isFullMember()}
        <li>
            <a href="#menuStatistics">Statistics</a>
            <div id="menuStatistics">
                <div class="bd">
                <ul>
                    <li id="menuItemOverallPeeringStatistics">
                        <a href="{genUrl controller="dashboard" action="traffic-stats"}">Overall Peering Statistics</a>
                    </li>
                    <li id="menuItemMyStatistics">
                        <a href="{genUrl controller="dashboard" action="statistics"}">My Statistics</a>
                    </li>
                    <li id="menuItemTrunkGraphs">
                        <a href="{genUrl controller="dashboard" action="trunk-graphs"}">Trunk Graphs</a>
                    </li>
                    <li id="menuItemSwitchAggregateGraphs">
                        <a href="{genUrl controller="dashboard" action="switch-graphs"}">Switch Aggregate Graphs</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs eq 1}
        <li>
            <a href="{genUrl controller="dashboard" action="static" page="support"}">Support</a>
        </li>
        {/if}

        {if $identity.user.privs eq 3 and isset( $config.menu.staff_links )}
        <li>
            <a href="#menuStaffLinks">Staff Links</a>
            <div id="menuStaffLinks">
                <div class="bd">
                <ul>
                    {foreach from=$config.menu.staff_links item=i}
                    <li>
                        <a href="{$i.link}">{$i.name}</a>
                    </li>
                    {/foreach}
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs neq 1}
        <li>
            <a href="{genUrl controller="profile"}">Profile</a>
        </li>
        {else}
        <li>
            <a href="#menuProfile">Profile</a>
            <div id="menuProfile">
                <div class="bd">
                <ul>
                    <li id="menuItemUserProfile">
                        <a href="{genUrl controller="profile"}">User Profile</a>
                    </li>
                    <li id="menuItemSecEventNotifications">
                        <a href="{genUrl controller="dashboard" action="sec-event-email-config"}">SEC Event Notifications</a>
                    </li>
                </ul>
                </div>
            </div>
        </li>
        {/if}

        {if $identity.user.privs eq 3}
        <li>
            <a href="{genUrl controller="index" action="help"}">Help</a>
        </li>
        {/if}

        {if isset( $session->switched_user_from ) and $session->switched_user_from}
        <li>
            <a href="{genUrl controller="auth" action="switch-back"}">[Switch Back]</a>
        </li>
        {else}
        <li>
            <a href="{genUrl controller="auth" action="logout"}">[Logout]</a>
        </li>
        {/if}

    </ul>
    </div>
</div>
<script language="JavaScript" type="text/javascript">

    YAHOO.util.Event.onContentReady("topMenu", function () {ldelim}
        var topMenu = new YAHOO.widget.MenuBar("topMenu", {ldelim}
            autosubmenudisplay: true
        {rdelim});
        topMenu.render();
        topMenu.show();
    {rdelim});
</script>

<div id="bd">

<br />


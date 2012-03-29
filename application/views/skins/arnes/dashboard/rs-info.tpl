{tmplinclude file="header.tpl" pageTitle="IXP Manager :: Member Dashboard"}

<div class="yui-g">

<div id="content">

<table class="adminheading" border="0">
<tr>
    <th class="Switch">
        SIX Route Server Details
    </th>
</tr>
</table>

{tmplinclude file="message.tpl"}

<div id='ajaxMessage'></div>

<div id="overviewMessage">
	{if $user.privs eq 3}
    {elseif $rsSessionsEnabled}
        <div class="message message-success">
            You are now enabled to use SIX's robust route server cluster.<br />
            <br />
            Please note that the provisioning system updates the route servers once a day
            so please allow up to 24 hours for your configuration to become active on
            our systems.<br />
            <br />
            Please see below for configuration details.
        </div>
    {elseif not $rsEnabled}
        <div class="message message-error">
	        You are not using SIX's robust route server cluster. Please <a href="{genUrl controller="dashboard" action="enable-route-server"}">click here to have our provisioning system create sessions</a> for you.
	    </div>
    {else}
	    <div class="message message-success">
	        You are enabled to use SIX's robust route server cluster.
	    </div>
    {/if}
</div>



<h3>Overview</h3>

<p>
Normally on a peering exchange, all connected parties will establish bilateral peering relationships
with each other member port connected to the exchange. As the number of connected parties increases,
it becomes increasingly more difficult to manage peering relationships with members of the exchange.
A typical peering exchange full-mesh eBGP configuration might look something similar to the diagram
on the left hand side.
</p>

<table border="0" align="center">
<tr>
    <td width="354">
        <img src="{genUrl}/images/route-server-peering-fullmesh.png" title=" IXP full mesh peering relationships" alt="[ IXP full mesh peering relationships ]" width="345" height="317" />
    </td>
    <td width="25"></td>
    <td width="354">
        <img src="{genUrl}/images/route-server-peering-rsonly.png" title=" IXP route server peering relationships" alt="[  IXP route server peering relationships ]" width="345" height="317" />
    </td>
</tr>
<tr>
    <td align="center">
        <em> IXP full mesh peering relationships </em>
    </td>
    <td></td>
    <td align="center">
        <em> IXP route server peering relationships</em>
    </td>
</tr>
</table>

<p>
<br />
The full-mesh BGP session relationship scenario requires that each BGP speaker configure and manage
BGP sessions to every other BGP speaker on the exchange. In this example, a full-mesh setup requires
7 BGP sessions per member router, and this increases every time a new member connects to the exchange.
</p>

<p>
However, by using a route server for all peering relationships, the number of BGP sessions per router
stays at two: one for each route server. Clearly this is a more sustainable way of maintaining IXP
peering relationships with a large number of participants.
</p>


<h3>Should I use this service?</h3>

<p>
The SIX route server cluster is aimed at:
</p>

<ul>
    <li> small to medium sized members of the exchange who don't have the time or resources to
         aggressively manage their peering relationships
    </li>
    <li> larger members of the exchange who have an open peering policy, but where it may not
         be worth their while managing peering relationships with smaller members of the exchange.
    </li>
</ul>

<p>
As a rule of thumb: <strong>If you don't have any good reasons not to use the route server cluster, you should probably use it.</strong>
</p>

<p>
The service is designed to be reliable. It operates on two physical servers, each located in a
different data centre. The service is available on both IPv4 and IPv6. Each server runs a separate 
routing daemon per L3 protocol. Should a single BGP server die for some unlikely reason, no other BGP
server is likely to be affected. If one of the physical servers becomes unavailable, the second server
will continue to provide BGP connectivity.
</p>

<p>
SIX has also implemented inbound prefix filtering on its route-server cluster. This uses internet
routing registry data from the RIPE IRR database to allow connected members announce only the address
prefixes which they have registered publicly.
</p>

<p>
SIX uses BIRD running on Linux for its route server cluster. BIRD is increasingly used at Internet
exchanges for route server clusters, and has been found to be reliable in production.
</p>


<h3>How do I use the service?</h3>

<p>
In order to use the service, you should first instruct the route servers to create sessions for you:
</p>

<div id="overviewMessage">
	{if $user.privs eq 3}
    {elseif not $rsEnabled}
        <div class="message message-error">
            You are not enabled to use SIX's route server cluster.
            Please <a href="{genUrl controller="dashboard" action="enable-route-server"}">click here to have our provisioning system create sessions</a> for you.
        </div>
    {else}
        <div class="message message-success">
            You are enabled to use SIX's robust route server cluster.
        </div>
    {/if}
</div>

<p>
If enabled, the route servers are set up to accept BGP connections from your router. Note that it 
may take up to 24-hours for route servers to set up new peerings. Once this has
been done, you will need to configure a BGP peering session to the correct internet address. The
IP addresses of the route servers are listed as follows:
</p>

<center>

<table class="ltbr2" cellspacing="0" border="0">
<tbody>
    <tr>
        <th>Route Server #1</th>
        <th>IPv4 Address</th>
        <td>91.220.194.1</td>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>IPv6 Address</th>
        <td>2001:7f8:46:0:1::1</td>
    </tr>
    <tr>
        <th>Route Server #2</th>
        <th>IPv4 Address</th>
        <td>91.220.194.101</td>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th>IPv6 Address</th>
        <td>2001:7f8:46::1</td>
    </tr>
</tbody>
</table>

</center>

<p>
<br /><br />
For Cisco routers, you will need something like the following bgp configuration:
</p>

<pre>
    router bgp 99999
     no bgp enforce-first-as

     ! Route server #1

     neighbor 91.220.194.1 remote-as 51988
     neighbor 91.220.194.1 description SIX Route Server
     address-family ipv4
      neighbor 91.220.194.1 password s00persekr1t
      neighbor 91.220.194.1 activate
      neighbor 91.220.194.1 filter-list 100 out
     exit

     ! Route server #2

     neighbor 91.220.194.101 remote-as 51988
     neighbor 91.220.194.101 description SIX Route Server
     address-family ipv4
      neighbor 91.220.194.101 password s00persekr1t
      neighbor 91.220.194.101 activate
      neighbor 91.220.194.101 filter-list 100 out
     exit
</pre>

<p>
You should also use <code>route-maps</code> (or <code>distribute-lists</code>) to control
outgoing prefix announcements to allow only the prefixes which you intend to announce.
</p>

<p>
Note that the route server system depends on information in the RIPE IRR database. If you
have not published correct <code>as-set:</code>, <code>route:</code> and <code>route6:</code> objects in this database,
your prefix announcements will be ignored by the route server and your peers will not route their
traffic to you via the exchange.
</p>

<h3>Community based prefix filtering</h3>

<p>
The SIX route server system also provides well known communities to allow members to
control the distribution of their prefixes. These communities are defined as follows:
</p>

<table class="ltbr2" cellspacing="0" border="0" width="600px">
    <thead>
    <tr>
        <th>Description</th>
        <th>Community</th>
        <th>Extended Community</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Prevent announcement of a prefix to a peer</td>
        <td><code>0:peer-as</code></td>
        <td><code>soo:0:peer-as</code></td>
    </tr>
    <tr>
        <td>Announce a route to a certain peer</td>
        <td><code>51988:peer-as</code></td>
        <td><code>soo:51988:peer-as</code></td>
    </tr>
    <tr>
        <td>Prevent announcement of a prefix to all peers</td>
        <td><code>0:51988</code></td>
        <td><code>soo:0:51988</code></td>
    </tr>
    <tr>
        <td>Announce a route to all peers</td>
        <td><code>51988:51988</code></td>
        <td><code>soo:51988:51988</code></td>
    </tr>
    </tbody>
</table>


<p>
<br /><br />
So, for example, to instruct the route server to distribute a particular prefix only to
AS64111 and AS64222, the prefix should be tagged with communities: 0:51988, 51988:64111
and 51988:64222.
</p>

<p>
Alternatively, to announce a prefix to all SIX members, excluding AS64333, the prefix
should be tagged with community 0:64333.
</p>

<p>
To control anouncements to a peer with a 32-bit AS number use extended BGP communities.
These communities are of type Route origin. On various router platforms also known as Site
of origin, <code>soo</code>, <code>origin</code> or <code>ro</code>.
</p>

</div>
</div>

{tmplinclude file="footer.tpl"}

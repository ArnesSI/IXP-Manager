{tmplinclude file="header.tpl" pageTitle="IXP Manager :: Member Dashboard"}

<div class="yui-g">

<div id="content">

<table class="adminheading" border="0">
	<tr>
		<th class="Document">SIX Port Security Policies</th>
	</tr>
</table>

<p>For the purposes of ensuring layer 2 stability, SIX implements 
these port security policies:</p>

<ul>

    <li>
       <strong>Broadcast Traffic Storm Control</strong> — SIX restricts
        broadcast traffic received on any particular port to be no more than
        1% of the total traffic received on that port.<br />
        <br />
        While it is normal to see a small amount of Layer 2 broadcast traffic
        for certain types of traffic (ARP), large amounts of broadcast traffic
        typically indicate a problem with the connecting router or switch,
        caused by incorrect configuration, failed hardware or
        hardware/microcode bugs. Because broadcast traffic frames are forwarded
        to all ports on a flat layer 2 LAN, this sort of traffic could
        potentially disrupt service for other connections into the SIX switch
        fabric. If inbound broadcast traffic exceeds the 1% threshold the port is
        shut down and will be re-enabled after 10 minutes.
        <br />
        <br />
    </li>

    <li>
        <strong>One MAC Address per Port</strong> — SIX expects that all traffic
        coming in from a particular port will all
        be configured with the same source MAC address, which SIX switches
        will then dynamically associate with that port.<br />
        <br />
        If frames are seen on a
        port with a source MAC address which differs from the dynamically
        learned address, then the port is shut down and will be re-enabled after 
        10 minutes.<br />
        <br />
        When multiple MAC addresses are seen on a particular
        port, it generally means one of the following things:

        <ul>
           <li> the connected router or switch has been misconfigured to forward link-local frames to
                the SIX peering
           </li>
           <li> LAN member has accidentally set up a traffic loop
                between two SIX switch ports
           </li>
           <li> bogus ethernet frames have accidentally leaked into a member's connection link
           </li>
           <li> the member is using faulty hardware
           </li>
        </ul>

        Because several of these possibilities
        could cause catastrophic layer 2 network instability affecting all SIX
        members on the peering LAN, and because all of them can be
        obviated by using a one MAC-address per port policy, Arnes aggressively
        implements and polices this policy.

    </li>
</ul>


</div>
</div>

{tmplinclude file="footer.tpl"}
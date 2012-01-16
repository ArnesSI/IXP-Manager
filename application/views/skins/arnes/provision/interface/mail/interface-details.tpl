
Dear SIX Member,

Please take some time to read this email -- it contains important information concerning your newly provisioned SIX port.


Interface Details
==================

We have assigned the following IP addresses and switch-ports for your exclusive use:

Switch Port: {$progress.Physicalinterface.Switchport.SwitchTable.name}.arnes.si, {$progress.Physicalinterface.Switchport.name}
Speed:       {$progress.Physicalinterface.speed}Mbps
Duplex:      {$progress.Physicalinterface.duplex}
Location:    {$progress.Physicalinterface.Switchport.SwitchTable.Cabinet.Location.name}
Cabinet ID:  {$progress.Physicalinterface.Switchport.SwitchTable.Cabinet.name}


{assign var='vlanid' value=$progress.Vlaninterface.vlanid}
{$progress.Vlaninterface.Vlan.name}:

IPv4 Address:  {$progress.Vlaninterface.Ipv4address.address}/{$networkInfo.$vlanid.4.masklen}
IPv4 Hostname: {$progress.Vlaninterface.ipv4hostname}
IPv6 Address:  {if $progress.Vlaninterface.Ipv6address.address}{$progress.Vlaninterface.Ipv6address.address}/{$networkInfo.$vlanid.6.masklen}{else}(please contact us to enable IPv6){/if}

IPv6 Hostname: {$progress.Vlaninterface.ipv6hostname}



Your Input
----------

Should you require your reverse DNS hostnames changed for either IPv4 or IPv6, please contact {$config.identity.email}


Route Servers
=============

SIX operates a Route Server cluster; this facility allows all members who connect to the cluster to see all routing prefixes sent to the cluster by any other member.  I.e. it provides an quick, safe and easy way to peer with any other route server user. 

The SIX route server cluster is aimed at:

o  small to medium sized members of the exchange who don't have the time or resources to aggressively manage their peering relationships.

o  larger members of the exchange who have an open peering policy, but where it may not be worth their while managing peering relationships with smaller members of the exchange.

If you don't have any good reasons not to use the route server cluster, you should probably use it.

The service is designed to be reliable. It operates on two physical servers, each located in a different data centre. The service is available on both ipv4 and ipv6. The route servers also filter inbound routing prefixes based on published RIPE IRR policies, which means that using the route servers for peering is generally much safer than peering directly with other members. 


Your Input
----------

If you wish to use the SIX route server system, please contact {$config.identity.email}


Peering
=======

Arnes facilitates peering between SIX members, but does not mandate peering with any particular member. Users are encouraged to peer with route servers (see above), however bilateral peerings are also permitted.

You will find a full list of members on the SIX members web page, along with the correct email addresses to use for peering requests.

When emailing other SIX members about peering requests, please include all technical details relevant to the peering session, including your IP address, your AS number, and an estimate of the number of prefixes you intend to announce to that candidate peer.

Arnes requires that all new members peer and share routes with the SIX route collectors for administrative purposes. We would be obliged if you could set up your router(s) and make the necessary arrangements for this as soon as possible. 


NOC Details
===========

For the convenience of SIX members, Arnes maintains a list of NOC and peering contact details for SIX members. These details are held on a private SIX database, and are available only from the following URL:

        {$config.identity.ixp.url}dashboard/members-details-list

This area of the SIX website is password protected and SSL secured. Passwords are only provided to current SIX members. This information is considered private and will not be passed on to other third parties by SIX. 

We would appreciate if you could take the time to ensure that the following details we hold on file are correct:

Your Input
----------

Member name:                    {$progress.Cust.name}
Primary corporate web page:     {$progress.Cust.corpwww}
Peering Email Address:          {$progress.Cust.peeringemail}
NOC Phone number:               {$progress.Cust.nocphone}
NOC Fax number:                 {$progress.Cust.nocfax}
General NOC email address:      {$progress.Cust.nocemail}
NOC Hours:                      {$progress.Cust.nochours}
Dedicated NOC web page:         {$progress.Cust.nocwww}
AS Number:                      {$progress.Cust.autsys}

----------


Router Configuration
====================

If you are new to internet exchanges, we would ask you to note that all members are expected to adhere to the technical requirements on the SIX website. In particular, we would draw your attention to section of these requirements which outline what types of traffic may and may not be forwarded to the SIX peering LAN. 

For Cisco IOS based routers, we recommend the following interface configuration commands:

 no ip redirects
 no ip proxy-arp
 no ip directed-broadcast
 no mop enabled 
 no cdp enable 
 udld port disable 

If you intend to use IPv6 with a Cisco IOS based router, please also consider the following interface commands:

 no ipv6 redirects
 ipv6 nd suppress-ra

For further details please see the following URL:

        http://www.arnes.si/en/infrastructure/six-internet-exchange/technical-and-administrative-requirements.html


Connecting Switches to SIX
==========================

Many members choose to connect their SIX port to a layer 2 switch and then forward their peering traffic to a router virtual interface hosted elsewhere on their network. While connecting layer 2 switches to the SIX peering LAN is not actively discouraged, incorrect configuration can cause serious and unexpected connectivity problems. 

The primary concern is to ensure that only traffic from the router subinterface is presented to the SIX port. SIX implements per port mac address counting: if more than 1 mac address is seen on any switch port at any time, that port will automatically be disabled for a cooling off period, and your connectivity to SIX will temporarily be lost. 

This policy prevents two potential problems: firstly, it ensures that layer 2 traffic loops are prevented and secondly, it ensures that no other traffic escapes to the SIX peering LAN which shouldn't be seen there. 

If you choose to connect your SIX port or ports to a switch, it is critically important to assign one unique vlan for each SIX connection.  If you share an SIX facing VLAN between multiple SIX ports or share a SIX-facing VLAN with any other network, your connection will automatically be shut down due to the security mechanisms implemented by SIX.

Please also note that by default, several switch models send link-local traffic to all ports.  On Cisco switches, this can be disabled using the following interface commands:

interface GigabitEthernetx/x
 spanning-tree bpdufilter enable
 no keepalive                   
 no cdp enable                  
 udld port disable              


Monitoring
==========

By default, SIX actively monitors all ports on its peering LANs using ICMP PING for both connectivity and host latency.  This monitoring causes about 25 PING packets to be sent to each IP address on the peering LAN every 5 minutes.  If you do not wish for your router to be actively monitored, please mail {$config.identity.email} and we can disable this facility. 


PeeringDB
=========

PeeringDB ( http://www.peeringdb.com/ ) facilitates the exchange of information related to peering. Specifically, what networks are peering, where they are peering, and if they are likely to peer with you.

More and more organisations are using PeeringDB to make decisions on where they should open POPs, provision new links, etc.

We would very much appreciate it if you could mark your new SIX peering under the "Public Peering Locations" section of your PeeringDB page. We are listed as 'SIX SI'. If you do not yet have a PeeringDB account, we would suggest that you register for one on their site.


Welcome to SIX, Slovenian Internet Exchange.


SIX Operations



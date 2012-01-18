<html>
<head>
    <title>Welcome to {$config.identity.orgname}'s IXP Manager</title>

    <style>
        {literal}
        h1,h2,h3 {
        	color: #4FA500;
        }
        {/literal}
    </style>

</head>

<body>

<center>
<table border="0" width="90%" align="center">
    <tr>
        <td align="left" valign="middle">
            <h1>Welcome to {$config.identity.orgname}'s IXP Manager</h1>
        </td>
        <td align="right" valign="top">
            <img src="cid:ixp_logo" alt="[IXP Logo]" />
        </td>
    </tr>
</table>
</center>

<p>
A new user account has been created for you on the {$config.identity.orgname} IXP Management system.
</p>

<p>
You can login to it using the following details:
</p>

<table border="0">
<tr>
    <td width="50"></td>
    <td align="right"><strong>URL:</strong></td>
    <td width="20"></td>
    <td align="left"><a href="{$config.identity.ixp.url}">{$config.identity.ixp.url}</a></td>
</tr>
<tr>
    <td></td>
    <td align="right"><strong>Username:</strong></td>
    <td></td>
    <td align="left"><code>{$u->username}</code></td>
</tr>
<tr>
    <td></td>
    <td align="right"><strong>Password:</strong></td>
    <td></td>
    <td align="left"><em>(see below)</em></td>
</tr>
</table>

<p>
Once logged in, you will have access to a number of features including:
</p>

<ul>
    <li>list of IXP members and peering contact details;</li>
    <li>your traffic graphs;</li>
    <li>ability to view and edit your company details;</li>
    <li>your {$config.identity.orgname} port configuration details;</li>
    <li>peering matrix;</li>
    <li>route server, AS112 and other service information.</li>
</ul>

<p>
If you require any assistance, please contact {$config.identity.name} on <a href="mailto:{$config.identity.email}">{$config.identity.email}</a>.
</p>


<h2>Getting Your Password</h2>

<p>
To get your new password, please use the forgotten password procedure by visiting
the following link and entering your username:
</p>

<blockquote>
<a href="{$config.identity.ixp.url}auth/forgotten-password">{$config.identity.ixp.url}auth/forgotten-password</a>
</blockquote>


<h2>Additional/Miscellaneous Benefits</h2>

<h3>Route Collector</h3>

<p>
INEX runs a route collector, whose purpose is to allow exchange members to debug routing issues.
While there is public access to the route collector available on the INEX looking glass, INEX
members have CLI access to the route-collector.
</p>

<p>
It can be accessed via SSH to <code>route-collector.inex.ie</code> using your new username and password.
</p>


<h3>IRC Channel</h3>

<p>
Members of the INEX operations team, along with many NOC personnel from INEX member
organisations can often be found on the <code>#inex-ops</code> IRC channel. This facility
has proved itself to be a useful communications medium for operational matters. The
<code>#inex-ops</code> IRC channel is password protected and access to the server is
encrypted using SSL.
</p>

<table border="0">
<tr>
    <td width="50"></td>
    <td align="right"><strong>Server name:</strong></td>
    <td width="20"></td>
    <td align="left"><code>irc.inex.ie</code>, port 6697, SSL enabled</td>
</tr>
<tr>
    <td></td>
    <td align="right"><strong>Channel:</strong></td>
    <td></td>
    <td align="left"><code>#inex-ops</code></td>
</tr>
<tr>
    <td></td>
    <td align="right"><strong>Password:</strong></td>
    <td></td>
    <td align="left"><code>pixiedust</code></td>
</tr>
</table>



<p>
Thanks and kind reagrds,<br />
{$config.identity.name}<br />
<a href="mailto:{$config.identity.email}">{$config.identity.email}</a>.
</p>

</body>
</html>

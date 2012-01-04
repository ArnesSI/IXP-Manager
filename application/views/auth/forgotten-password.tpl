{tmplinclude file="auth/header.tpl"}

{tmplinclude file="message.tpl"}


<div class="login">
    <div class="login-form">
        <h1>Forgotten Password</h1>
        <br /><br />
        <form action="{genUrl controller="auth" action="forgotten-password"}" method="post" name="loginForm" id="loginForm">
        <div class="form-block">
            <div class="inputlabel">Username</div>
            <div><input name="loginusername" autocomplete="off" type="text" class="inputbox" size="15" value="{if isset($username)}{$username}{/if}" /></div>
            <div align="left">
                <input type="hidden" name="fpsubmitted" value="1" />
                <input type="submit" name="submit" class="button" value="Submit" />
                <a href="{genUrl controller="auth" action="forgotten-username"}">Forgotten Username?</a>
            </div>
        </div>
        </form>
    </div>
    <div class="login-text">

        <div class="ctr"><img src="images/joomla-admin/security.png" width="64" height="64" alt="security" /></div>
        <p>
            Please enter your username and we will send you a password reset token by email.
        </p>
        <p>
            For help please contact <br />{mailto address=$config.identity.email encode='javascript' note='the operations team'}.
        </p>
        <p>
        	<a href="{genUrl controller="auth"}">Return to Login Page</a>.
    	</p>
    </div>
    <div class="clr"></div>
</div>


{tmplinclude file="footer.tpl"}

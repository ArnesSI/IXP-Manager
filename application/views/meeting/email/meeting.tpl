<html>

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />

	<style>
	{literal}

		body {
		    margin:10px;
		}

		h1 {
		    font-size: 138.5%;
		}

		h2 {
		    font-size: 123.1%;
		}

		h3 {
		    font-size: 108%;
		}

		h1,h2,h3 {
		    margin: 1em 0;
		}


		.meetings {
		    margin-left: 20px;
		    margin-right: 20px;
		    width: 80%;
		}

		.meetings_index_container {
		    display: block;
		}

		.meetings_index {
		    display: block;
		    text-align: right;
		}

		.meeting h1 {
		    color: #4fa500;
		    font-size: 146.5%;
		    font-weight: bold;
		    padding-bottom: 2px;
		    margin-bottom: 0px;
		}

		.meeting h4 {
		    color: #4fa500;
		    font-size: 100%;
		    font-weight: normal;
		    font-style: italic;
		    padding-bottom: 0px;
		    margin-bottom: 0px;
		    padding-top: 0px;
		    margin-top: 0px;
		}

		.meeting h4 a {
		    border-bottom: 1px dotted #000000;
		    color: #4fa500;
		}


		.meeting.title {
		    padding-bottom: 2px;
		    border-bottom: 2px solid #4fa500;
		    margin-bottom: 10px;
		}

		.meetingitem h1 {
		    color: #000000;
		    font-size: 116%;
		    font-weight: bold;
		    padding-bottom: 0px;
		    margin-bottom: 0px;
		}

		.meetingitem a, .meetingitem a:link, .meetingitem a:visited {
		    color: #000000;
		    text-decoration: none;
		    border-bottom: 1px dotted #000000;
		}


		.meetingitem h4 {
		    color: #000000;
		    font-size: 100%;
		    font-weight: normal;
		    font-style: italic;
		}

		.meetingitem.title {
		    margin-bottom: 10px;
		}

		.meetingitem.title.icons {
		    float: right;
		}

		.meetingitem.title.icons img {
		    float: right;
		    padding-left: 10px;
		}


		.meetingitem dd {
		    color: #000000;
		    font-size: 100%;
		    font-weight: normal;
		    font-style: none;
		    margin-bottom: 10px;
		    padding-left: 20px;
		    padding-bottom: 10px;
		}

		.meeting.buttons {
		    text-align: center;
		}

	{/literal}
	</style>


</head>

<body>

<div class="meetings">

<div class="meeting">

<div class="meeting content">{$body}<br /></div>

<div class="meeting title">
    <h1>{$meeting.title} &ndash; {$meeting.date|date_format:"%A, %B %e, %Y"}</h1>
    <h4>
        In <a href="{$meeting.venue_url}" target="_blank">{$meeting.venue}</a> at {$meeting.time|date_format:"%H:%M"}
    </h4>
</div>

<div class="meeting content">{$meeting.before_text}</div>

<div class="meetingitem">

<dl>

    {assign var='inOtherContent' value=0}

    {foreach from=$meeting.MeetingItem key=id item=mi}

    {if $mi.other_content and not $inOtherContent}
        </dl>

        <p>
        Other meeting content also includes:
        </p>

        <dl>

        {assign var='inOtherContent' value=1}
    {/if}

    <dt>

		<div class="meetingitem title">

		    <div class="meetingitem title icons">
		    </div>

		    <h1>
		        {$mi.title} &ndash;

		        {if $mi.email neq ''}
		            {mailto address=$mi.email encode='none' text=$mi.name}
		        {else}
		            {$mi.name}
		        {/if}
		    </h1>

		    <h4>
		        {if $mi.role neq ''}{$mi.role}, {/if}
		        {if $mi.company_url neq ''}
		            <a href="{$mi.company_url}">{$mi.company}</a>
		        {else}
    		        {$mi.company}
    		    {/if}
		    </h4>
		</div>

    </dt>

    <dd>
        {$mi.summary}
    </dd>

    {/foreach}

</dl>

</div>

<div class="meeting content">{$meeting.after_text}</div>


</div>
</div>

</body>
</html>

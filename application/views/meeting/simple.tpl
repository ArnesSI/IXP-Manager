
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

        .meeting h4 a, .meeting h4 a:link, .meeting h4 a:visited {
            color: #4fa500;
            border-bottom: 1px dotted #000000;
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

<p>
    <em>
        This is public list of {$config.identity.orgname} Members' Meetings. {$config.identity.orgname} members should log into the IXP Manager
        where they can download presentations, view recorded presentations and access speaker contact
        details.
    </em>
</p>

{tmplinclude file='meeting/core.tpl'}


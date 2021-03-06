/**
* A nice little tooltip using JQuery.
* 
* @author Roland Huszti <roland _at_ opensolutions.ie>
* @version 1.1
* @copyright (c) 2010 Open Source Solutions Limited
* @license MIT License <http://en.wikipedia.org/wiki/MIT_License>
* 
* 
* Copyright (c) 2010 Open Source Solutions Limited
* 
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
*
*
*
*
* When loaded and the document is ready, it appends a div to the document body 
* with the id 'OSSTooltipContainer'.
*
* It automatically binds itself to every element on the page which has a class 
* 'OSSTooltip', using the mouseover and mouseout events (but does not hijack 
* and monopolize them). The styling of the popup div can be easily done in CSS 
* by having a #OSSTooltipContainer { [whatever] } entry. The content of the 
* tooltip comes from the item's title attribute by default (Note that it can 
* contain HTML code, but take care of the double quotes!) It automatically 
* empties the title attribute, so the browser's own built-in tooltip won't show up.
*
* The tooltip itself can be configured through appending strings to the 
* end of the 'OSSTooltip' class name, separated by a dash (minus, "-"). The 
* first parameter is the anchor point on the tooltip, the second is the 
* anchor point on the caller element (usually an "i" or "?" icon or a text 
* field). These anchor points will be matched. For example if the class says 
* "OSSTooltip-lc-rc", then the vertical center point of the tooltip on the 
* left will be set (exactly above) to the vertical center point of the caller 
* element on the right. The valid values for these parameters are 'tl', 'tc', 
* 'tr', 'rc', 'br', 'bc', 'bl', 'lc', where 't' is 'top', 'l' is left, 'r' 
* is right, 'c' is center and 'b' is bottom. The default setting is 
* "OSSTooltip-lc-rc".
*
* There is a fifth optional parameter, an ID of an element which contains 
* the contents of the tooltip. This is usually an id of a hidden div, 
* paragraph or span, but it can be pretty much anything. This ID cannot 
* contain the dash (minus, "-") character, as that separates the parameters 
* from each other. An example: "OSSTooltip-bl-tr---thecontentdivid123"
* If this parameter is set then it will be used as the content source and 
* not the title attribute, even if that has content too.
*
* By default the size of the tooltip is automatic, it stretches with the 
* content as needed. You can limit that in CSS by using the width, min-width, 
* max-width, height, min-height and max-height.
*
* The third and fourth optional parameters set the width and height of the 
* tooltip, like '200px' or '9.5em'. These overwrite the width and height CSS 
* properites.
*
* The tooltip automatically detects if it stretches out of the document borders 
* and tries to re-position itself around the caller element to be inside and 
* fully visible. So even if it was set up to appear on the top right side of 
* the caller element, it might appear on the bottom left if it is needed.
*
* Any of these parameters can be skipped, but you still have to present the 
* separator dash ("-"), like 
* "OSSTooltip-----thecontentdiv" or "OSSTooltip--br---thecontentdiv" 
* or even "OSSTooltip------".
*
* OSSTooltip-[TooltipAnchor]-[CallerAnchor]-[Width]-[Height]-[TooltipContentID]
*
* Examples:
*
* <img class="OSSTooltip" alt="" src="help.png" title="This is a tooltip." />
* <img class="OSSTooltip" alt="" src="help.png" title="Line1<br />Line2<br />Line3" />
* <img class="OSSTooltip-tl-br" alt="" src="help.png" title="This is a tooltip." />
* <img class="OSSTooltip-tl--200px-10em" alt="" src="help.png" title="This is a tooltip." />
* <img class="OSSTooltip-bl-tr---thecontentdiv" alt="" src="help.png" title="does not matter" />
* <img class="OSSTooltip-----thecontentdiv" alt="" src="help.png" /> <!-- this is how you can skip parameters -->
*
* <head>
* <link rel="stylesheet" type="text/css" href="path/to/the/style.css" />
* <script type="text/javascript" src="path/to/the/jquery.js"></script>
* <script type="text/javascript" src="path/to/the/oss_tooltip.js"></script>
* </head>
*
*/

    $(document).ready(function()
    {
        $('body').append('<div id="OSSTooltipContainer"></div>');

        $("*[class*='OSSTooltip']").bind('mouseover', function()
        {
            vContainerObject = $('#OSSTooltipContainer');

            vClasses = $(this).attr('class').split(' ');
            vClass = 'OSSTooltip';
            for(vIndex in vClasses) if (vClasses[vIndex].indexOf('OSSTooltip') != -1) vClass = vClasses[vIndex];

            // [0] = 'OSSTooltip'
            // [1] = anchor point on the tooltip div with [2], ['tl', 'tc', 'tr', 'rc', 'br', 'bc', 'bl', 'lc'], default 'lc'
            // [2] = anchor point on the caller element (usually an '?' icon), ['tl', 'tc', 'tr', 'rc', 'br', 'bc', 'bl', 'lc'], default 'rc'
            // [3] = width
            // [4] = height
            // [5] = an id of an element containing the contents of the tooltip, usually the id of a hidden div, span or paragraph
            vParams = vClass.split('-');

            // [0] = 'OSSTooltip'
            if (vParams[1] == undefined) vParams[1] = 'lc';
            if (vParams[2] == undefined) vParams[2] = 'rc';
            if (vParams[3] != undefined) vParams[3] = jQuery.trim(vParams[3]); else vParams[3] = 'auto';
            if (vParams[4] != undefined) vParams[4] = jQuery.trim(vParams[4]); else vParams[4] = 'auto';
            if (vParams[5] != undefined) vParams[5] = jQuery.trim(vParams[5]); else vParams[5] = '';

            // move the content to our tooltip div and remove the contents of the 'title' attribute so the browser's own tooltip won't show up
            // this must happen before getting the height and width of the div, because this provides the content for it

            // only run this piece of code if the contents of the tooltip for this item is not already set
            if ($(this).data('OSSTooltipContent') == undefined)
            {
                if (vParams[5] != '')
                {
                    $(this).data('OSSTooltipContent', $('#' + vParams[5]).html() );
                }
                else
                {
                    $(this).data('OSSTooltipContent', $(this).attr('title') );
                }
            }

            vContainerObject.html( $(this).data('OSSTooltipContent') );
            $(this).attr('title', '');

            vCallerPos = $(this).offset();
            vCallerHeight = $(this).outerHeight(true);
            vCallerWidth = $(this).outerWidth(true);
            vTooltipHeight = vContainerObject.outerHeight(true);
            vTooltipWidth = vContainerObject.outerWidth(true);

            // anchor on caller
            switch(vParams[2])
            {
                case 'tl':
                            vTargetX = vCallerPos.left;
                            vTargetY = vCallerPos.top;
                            break;
                case 'tc':
                            vTargetX = vCallerPos.left + (vCallerWidth / 2);
                            vTargetY = vCallerPos.top;
                            break;
                case 'tr':
                            vTargetX = vCallerPos.left + vCallerWidth;
                            vTargetY = vCallerPos.top;
                            break;
                case 'br':
                            vTargetX = vCallerPos.left + vCallerWidth;
                            vTargetY = vCallerPos.top + vCallerHeight;
                            break;
                case 'bc':
                            vTargetX = vCallerPos.left + (vCallerWidth / 2);
                            vTargetY = vCallerPos.top + vCallerHeight;
                            break;
                case 'bl':
                            vTargetX = vCallerPos.left;
                            vTargetY = vCallerPos.top + vCallerHeight;
                            break;
                case 'lc':
                            vTargetX = vCallerPos.left;
                            vTargetY = vCallerPos.top + (vCallerHeight / 2);
                            break;
                case 'rc':
                default:
                            vTargetX = vCallerPos.left + vCallerWidth;
                            vTargetY = vCallerPos.top + (vCallerHeight / 2);
                            break;
            }

            // anchor on tooltip
            switch(vParams[1])
            {
                case 'tl':
                        vTooltipX = vTargetX;
                        vTooltipY = vTargetY;
                        break;
                case 'tc':
                        vTooltipX = vTargetX - (vTooltipWidth / 2);
                        vTooltipY = vTargetY;
                        break;
                case 'tr':
                        vTooltipX = vTargetX - vTooltipWidth;
                        vTooltipY = vTargetY;
                        break;
                case 'rc':
                        vTooltipX = vTargetX - vTooltipWidth;
                        vTooltipY = vTargetY - (vTooltipHeight / 2);
                        break;
                case 'br':
                        vTooltipX = vTargetX - vTooltipWidth;
                        vTooltipY = vTargetY - vTooltipHeight;
                        break;
                case 'bc':
                        vTooltipX = vTargetX - (vTooltipWidth / 2);
                        vTooltipY = vTargetY - vTooltipHeight;
                        break;
                case 'bl':
                        vTooltipX = vTargetX;
                        vTooltipY = vTargetY - vTooltipHeight;
                        break;
                case 'lc':
                default:
                        vTooltipX = vTargetX;
                        vTooltipY = vTargetY - (vTooltipHeight / 2);
                        break;
            }

            if (vTooltipX + vTooltipWidth > $(document).width()) vTooltipX = vCallerPos.left - vTooltipWidth;
            if (vTooltipY + vTooltipHeight > $(document).height()) vTooltipY = vCallerPos.top - vTooltipHeight;
            if (vTooltipX < 0) vTooltipX = vCallerPos.left + vCallerWidth;
            if (vTooltipY < 0) vTooltipY = vCallerPos.top;

            vContainerObject.css('top', vTooltipY);
            vContainerObject.css('left', vTooltipX );
            vContainerObject.css('width', vParams[3]);
            vContainerObject.css('height', vParams[4]);
            vContainerObject.fadeIn('fast');
        });

        $("*[class*='OSSTooltip']").bind('mouseout', function()
        {
            $('#OSSTooltipContainer').hide();
        });
    });

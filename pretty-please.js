prettyPleasePopUp(pretty_please_title,pretty_please_message,pretty_please_powered);

var date = new Date();
date.setTime(date.getTime()+(timebetween*60*1000));
var expires = "; expires="+date.toGMTString();
document.cookie = "popuptimer=true"+expires+"; path=/";

        
function popUp(text)
{
    
    var learn_more=document.getElementById("pretty-please-popup");
    learn_more.className="pretty_please_popup";
    learn_more.style.visibility="visible";
    
    var scrOfY=0;

    if(typeof(window.pageYOffset)=='number')
    {
        scrOfY=window.pageYOffset;
    }
    else if(document.body&&document.body.scrollTop)
    {
        scrOfY=document.body.scrollTop;
    }
    else if(document.documentElement&&document.documentElement.scrollTop)
    {
        scrOfY = document.documentElement.scrollTop;
    }
    var learn_text=document.getElementById("pretty-please-popup-text");
    learn_text.className="pretty_please_popup_text";
    learn_text.style.margin=(scrOfY+50)+"px auto";

    learn_text.innerHTML=text;
    var docHeight = (document.height !== undefined) ? document.height : document.body.offsetHeight;
    var popUpHeight = learn_text.offsetHeight;

    if(docHeight>popUpHeight)
    {
        learn_more.style.height=(docHeight+53)+"px";
    }
    else
    {
        learn_more.style.height=(popUpHeight+103)+"px";
    }
    
   
 
    
}

function prettyPleaseClickTarget(e,h) 
{
    if(h=='yes')
    { 
        prettyPleaseClose();
    }
    if (!e) 
    {
        var e = window.event;
    }    
    e.cancelBubble = true;
    if (e.stopPropagation) 
    {
        e.stopPropagation();
    }
   
    
}
function prettyPleaseClose(neveragain)
{
    if(neveragain)
    {
        var date = new Date();
	date.setTime(date.getTime()+(365*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();

        document.cookie = "no_popup=true"+expires+"; path=/";
    }
    var learn_more=document.getElementById("pretty-please-popup");
    learn_more.style.height="";
    learn_more.style.visibility="hidden";
    var learn_text=document.getElementById("pretty-please-popup-text");
    learn_text.className="";
    learn_text.style.margin="0px";
    learn_text.innerHTML="";    
}

function prettyPleasePopUp(title,text,pretty_please_powered)
{
    
    var popHTML;
   
    if(title!="")
    {
            popHTML="<div style='float:right; cursor:pointer;'><span class='pretty_please_close_topleft' onclick='prettyPleaseClose();'>&#9746; Close</span></div><h3>"+title+"</h3><br /><div style='text-align:left;line-height:normal;'>"+text+"</div><br />";
    }
    else
    {
            popHTML="<div style='float:right; cursor:pointer;'><span class='pretty_please_close_topleft' onclick='prettyPleaseClose();'>&#9746; Close</span></div><br /><div style='text-align:left;line-height:normal;'>"+text+"</div><br />";
    }

    
    popHTML+="<div class='pretty_please_button' onclick='prettyPleaseClose();'>Close</div><br /><br />";

    if(pretty_please_powered)
    {
        popHTML+="<br /><a style='font-size:80%;line-height:15px;text-decoration:none;float:left;text-align:left;' href='http://it.language101.com/flash-pretty-please/'>Powered by:<br /> Flash Pretty Please</a>";
    }
    popHTML+="<div onclick='prettyPleaseClose(true);' style='float:right;cursor:pointer;'>Don't Show This Again <input id='dontshow' type='checkbox' /></div>";
    popHTML+="<br /><br style='line-height:10px;'/>";
    popUp(popHTML);
}

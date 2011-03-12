<?php
/*
Plugin Name: Flash Pretty Please
Plugin URI: http://it.language101.com/flash-pretty-please/
Description: This plug in detects the iPhone and iPad user agent.  It then pops up a message that asks users to write or fax Steve Jobs and very politely ask him to make Flash available as an option for the iPhone, iPad or iPod. &nbsp;&nbsp;&nbsp; <a href="/wp-admin/options-general.php?page=FlashPrettyPlease">Settings</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=E8N9D537FB8WN">Donate</a>
Version: 1.1
Author: Language101.com
Author URI: http://Language101.com
*/

//This
add_action('admin_menu', 'prettyPleaseMenu');
add_action('wp_footer','prettyPleasePopUp');

$pretty_please_directory = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));


if(prettyPleaseIsIPhoneOrIPad())
{
    wp_enqueue_style('pretty-please-style', "$pretty_please_directory/pretty-please.css");
}

$pretty_please_description="This plug in detects the iPhone and iPad user agent.  It then pops up a message that asks users to write or fax Steve Jobs and very politely ask him to make Flash available as an option for the iPhone, iPad or iPod.";

$pretty_please_webmaster_notice=
"Fellow IT Professional: You know how good it feels when someone says, “You did a great job!” That’s how good we want Steve Jobs … and Scott Forstall to feel when we are asking for Flash.<br /><br />

It’s okay to customize the text of this plug in, but make sure you are only encouraging people to call with love and support for Steve Jobs, not complaints.<br /><br />

<b>If you are going to complain, please do NOT use this plugin</b>.<br /><br />

<hr />

Language101.com will support this plugin for Wordpress.  <br /><br />

Hopefully some of you will port it to Drupal, Joomla, and all the other popular open source platforms.  <br /><br />

Also it’s very likely that some of you personally know the <a href='http://www.apple.com/pr/bios/'>Apple executives</a>.  If you do, please call the ones you know and try to explain why they would be helped by adding Flash support for iDevices.<br /><br />";

$pretty_please_other=
"The Flash Pretty Please plugin can also be used for marketing to iPhone, iPad, or iPod customers. To do that simply put a custom iDevice web page in place of the pre-loaded text and select the pages you want this to appear on.
iDevice users will then see the custom page while other users will get the regular page.";

$default_pretty_please_headline= "";

$pretty_please_default_message_text=

"<div class=\"pretty_please_center\">
    To all iPhone, iPad and iPod users...

    <h2 class=\"pretty_please_title\">We Need Your Help to
    Improve Your Browsing Experience</h2>

    Please ask Steve Jobs to enable Flash—
    Otherwise, you're missing out on viewing
    75% of all online video and audio content
    including this page!
 </div>
 
<div style=\"width:100%;text-align:center\"><a style=\"font-size:250%\" href=\"#PrettyPleaseMessage\">Ask Steve Jobs for Flash.</a></div>

<hr /> 

<div class=\"pretty_please_message\" id=\"PrettyPleaseMessage\">Dear iPhone, iPad and iPod User:

We know you love your “iDevice.” However this page requires Flash and your “iPhone, iPad or iPod doesn’t support Flash.  The result is that you’re missing out on a lot of great web content, including this page!

Would you please do yourself and everyone who loves their iPhones, iPads and iPods a simple and important favor?

As you know, Steve Jobs has had some serious health challenges.  In fact, he's once again had to take medical leave from Apple. While we don't know the extent of his current situation, he is in our prayers.

Would you consider writing him a letter or sending him a fax right now to wish him well, and thank him for creating the Apple products you love?

While you are at it, let's all ask him to allow Flash to work on the iPhone, iPad and iPod devices. This page wouldn't show up without it . . . and you're missing out on thousands of pages of video and audio content as well.

We're told that he only wants old fashioned letters and faxes, so here's where to send or fax your letter:

<div style=\"padding-left:30px;\">Steve Jobs Fax # (408) 974-2483

Steve Jobs
Apple
1 Infinite Loop
Cupertino, CA 95014</div>

If you're out of stamps you can e-mail your letter to us at: <a href=\"mailto:steve@language101.com\">steve@language101.com</a> and we'll print it out and mail it to Steve Jobs on your behalf.

You may also want to call Scott Forstall, Apple Senior Vice President for iPhone Software, and ask him to make Flash work on all iPhones, iPads and iPods.  Please be nice when you call. 

Apple’s phone number is: 408-996-1010</div>";

$pretty_please_friends="Using this plugin is like going to a good party.  It’s more fun with your friends.<br /><br />Please invite your friends to the “Flash Pretty Please” party, by e-mailing them this URL.<br /><br /><a href='http://it.language101.com/flash-pretty-please/'>http://it.language101.com/flash-pretty-please/</a>";


$plugin = plugin_basename(__FILE__);

function prettyPleaseActlinks( $links )
{
     // Add a link to this plugin's settings page
     $settings_link = '<a href="/wp-admin/options-general.php?page=FlashPrettyPlease">Settings</a>';
     array_unshift( $links, $settings_link );
     return $links;
}

add_filter("plugin_action_links_$plugin", 'prettyPleaseActlinks' );


function prettyPleaseMenu()
{
  add_options_page('Flash Pretty Please Settings', 'Flash Pretty Please', 'manage_options', 'FlashPrettyPlease', 'prettyPleaseControlPanel');
}

function prettyPleaseControlPanel()
{
    
    //check permissions
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    global $pretty_please_default_message_text;
    global $pretty_please_description;
    global $pretty_please_webmaster_notice;
    global $pretty_please_friends;
    global $default_pretty_please_headline;
    global $pretty_please_other;
   

    //check to see if the plugin data is being changed
    if(isset($_POST['flashprettypleaseupdate'])&&$_POST['flashprettypleaseupdate']=="true")
    {
          if(isset($_POST['pretty_please_display_pages']))
          {
              update_option("pretty_please_display_pages", htmlentities($_POST['pretty_please_display_pages']));
          }

          if(isset($_POST['pretty_please_page_filter']))
          {
             update_option("pretty_please_page_filter", htmlentities($_POST['pretty_please_page_filter']));
          }

          if(isset($_POST['pretty_please_not_display_pages']))
          {
             update_option("pretty_please_not_display_pages", htmlentities($_POST['pretty_please_not_display_pages']));
          }

          if(isset($_POST['pretty_please_display_link']))
          {
              update_option("pretty_please_display_link", htmlentities($_POST['pretty_please_display_link']));
          }
          else
          {
              update_option("pretty_please_display_link", "0");
          }

          if(isset($_POST['pretty_please_popup_message']))
          {
              if($_POST['pretty_please_popup_message']!="")
              {
                    update_option("pretty_please_popup_message", str_ireplace(array("\'",'\"'),array("'",'"'),$_POST['pretty_please_popup_message']));
              }
              else
              {
                  update_option("pretty_please_popup_message", str_ireplace(array("\'",'\"'),array("'",'"'),$pretty_please_default_message_text));
              }
          }
          if(isset($_POST['pretty_please_headline']))
          {
              if($_POST['pretty_please_headline']!="")
              {
                    update_option("pretty_please_headline", str_ireplace(array("\'",'\"'),array("'",'"'),$_POST['pretty_please_headline']));
              }
              else
              {
                    update_option("pretty_please_headline", str_ireplace(array("\'",'\"'),array("'",'"'),$default_pretty_please_headline));
              }
          }
          if(isset($_POST['pretty_please_popupmintime']))
          {
              if(is_numeric($_POST['pretty_please_popupmintime']))
              {
                  if($_POST['pretty_please_popupmintime']!="")
                  {
                        update_option("pretty_please_popupmintime", str_ireplace(array("\'",'\"'),array("'",'"'),$_POST['pretty_please_popupmintime']));
                  }
                  else
                  {
                        update_option("pretty_please_popupmintime", str_ireplace(array("\'",'\"'),array("'",'"'),"0"));
                  }
              }
          }
          
      }
    
    

    //get the current values of plugin data
    $display_pages = get_option("pretty_please_display_pages");
    $page_filter = get_option("pretty_please_page_filter");
    $not_display_pages = get_option("pretty_please_not_display_pages");
    $display_link = get_option("pretty_please_display_link");
    $popup_message = get_option("pretty_please_popup_message");
    $headline = get_option("pretty_please_headline");
    $minpopuptime = get_option("pretty_please_popupmintime");

    //if they are not in the database create them
    if($display_pages === false)
    {
        update_option("pretty_please_display_pages", "");
    }
    if($page_filter === false)
    {
        update_option("pretty_please_page_filter", "1");
    }
    if($not_display_pages === false)
    {
        update_option("pretty_please_not_display_pages", "");
    }
    if($display_link === false)
    {
        update_option("pretty_please_display_link", "on");
    }
    if($popup_message === false)
    {
        update_option("pretty_please_popup_message", $pretty_please_default_message_text);
    }
    if($headline === false)
    {
        update_option("pretty_please_headline", $default_pretty_please_headline);
        
    }
    if($minpopuptime === false)
    {
        update_option("pretty_please_popupmintime", "0");        
    }
    

    //spit out the admin settings html
    echo "<br /><div class='hmmm' style='width:800px;'>
        <h1 style='font-family: Georgia,Times,serif;display:inline'><i>Flash Pretty Please</i></h1> <span style='font-size:115%;margin-left:75px;'><a href='http://it.language101.com/flash-pretty-please/'>Visit Plugin Website</a></span><br /><br />";
    echo $pretty_please_description."<br /><br />";
    echo ' <table>
        <tr>
            <td style="vertical-align:top;">
                <div style="float: left; background-color: white; padding: 10px; margin-right: 15px; border: 1px solid rgb(221, 221, 221);">
                    <div style="width: 350px; height: 220px;">
                        <h3>Donate</h3>
                        <em>
                            If Steve Jobs actually does allow Flash on the iPhone, iPad, and iPod it will save a lot of websites a huge amount of money.<br /><br />

                             Please donate a few dollars now to encourage us.<br /><br />

                            If Steve Jobs does add Flash support later, please come back and make a generous donation based on the amount of money it saved you.
                        </em>
                     </div>
                     <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="E8N9D537FB8WN">
                        <input type="image"
                        src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif"
                        border="0" name="submit" alt="PayPal - The safer, easier way to pay
                        online!">
                        <img alt="" border="0"
                        src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1"
                        height="1">
                    </form>
                </div>
            </td>
            <td style="vertical-align:top;">
                <div style="float: right; background-color: white; padding: 10px; margin-right: 15px; border: 1px solid rgb(221, 221, 221);">
                    <div style="width: 350px; height: 220px;">
                        <h2>Learn <a href="http://learn-spanish.language101.com">Spanish</a>, <a href="http://learn-french.language101.com">French</a>, <a href="http://learn-german.language101.com">German</a> or <a href="http://learn-russian.language101.com">Russian</a></h2>
                        <em>
                            Some of you have always wanted to learn a foreign language.  At Language101.com we want to help.<br /><br />
                            Everything about our system for learning a foreign language is intended to have you enjoy learning it and enjoy using it.<br /><br />
                            Visit, <a href="http://language101.com">Language101.com</a> to check it out.
                        </em>
                     </div>
                </div>
            </td>
        </tr>
        </table>
        <br /><br />
        <form method="post" action="">
            <input type="hidden" value="true" name="flashprettypleaseupdate">
            <br />'.$pretty_please_friends.'<br /><br /><br />
            <h3>Popup Headline (You can put a custom headline here)</h3>
            <hr />
            <input name="pretty_please_headline" style="width:100%" value="'.$headline.'" type="text" /><br />
            <h3> Message that will be displayed on iPhones, iPads and iPods.</h3>
            <hr />
            <textarea name="pretty_please_popup_message" style="width:100%;height:150px;">';
            
            if($popup_message === false)
            {
                echo $pretty_please_default_message_text;
            }
            else
            {
                echo $popup_message;
            }
            echo
           '</textarea><br /><br />
            <h3>Select Option 1 or Option 2 Below</h3>
            <hr />
            <div id="apple-flash-only">
            <input type="radio" value="1" name="pretty_please_page_filter" ';
            if($page_filter!="2")
            {
                echo 'checked="checked"';
            }
            echo
            ' />
                <b>Option 1: Display this only on the following pages</b><br />
                <div  style="margin-left:15px">
                    <input name="pretty_please_display_pages" style="width:100%" value="'.$display_pages.'" type="text" /><br />
                    For example, to make the popup display ONLY on the pages yourwebsite.com/flash-movie/ and yourwebsite.com/flash-game/?game=5 put <b>"/flash-movie/, /flash-game/?game=5"</b> into the box above. Wildcard * input is accepted.
                    <br /><br />
                </div>
            </div>
            <br />
            <div id="apple-flash-except">
            <input type="radio" value="2" name="pretty_please_page_filter" ';
            if($page_filter=="2")
            {
                echo 'checked="checked"';
            }
            echo
            ' />
                <b>Option 2: Display this on every page except the ones listed below.</b><br />
                <div style="margin-left:15px">
                    <input name="pretty_please_not_display_pages" value="'.$not_display_pages.'" style="width:100%" type="text" /><br />
                    For example, if you don’t want to display this popup on the pages yourwebsite.com/products/ and yourwebsite.com/buy/?plan=1 put <b>"/products/, /buy/?plan=1"</b> into the box above. Wildcard * input is accepted.

                </div>
                <br /><br />
            </div>
            <br /><br />
            <input type="checkbox"';
            if($display_link=="on")
            {
                echo 'checked="checked"';
            }
            echo
            'name="pretty_please_display_link" /> &nbsp;<b>Display the link that says:  “Powered by Flash Pretty Please”</b><br />
                <div style="margin-left:25px">
                    If you decide to turn this off, please blog about Flash Pretty Please, e-mail your friends or <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=E8N9D537FB8WN">donate</a>.
                </div>
            <br /><br />
            <b>Minimum Time Between Popups in Minutes</b>: ';
            
            if($minpopuptime)
            {
                echo
                '<input style="width:40px;" type="text" name="pretty_please_popupmintime" value="'.$minpopuptime.'" />';
            }
            else
            {
                echo
                '<input style="width:40px;" type="text" name="pretty_please_popupmintime" value="0" />';
            }
            echo 
            '<br /> If you do not want a vistor to see a popup everytime a page loads you can set a delay.
            <br /><br />
            <input type="submit" style="font-size:180%;" value="Update"/>
         </form><br /><br /><br /><br /><br />'.$pretty_please_webmaster_notice.'<br /><b>Other Uses For This Plugin</b><hr /><br />'.$pretty_please_other.'<br /><br />
             
    </div>';
        
        
}

function prettyPleasePopUp()
{
    if(pageNeedsFlash())
    {
       
        if(prettyPleaseisIPhoneOrIPad())
        {
            if(!isset($_COOKIE['popuptimer']))
            {
                prettyPleaseFooterHtml();
                echo "<!--IStuff-->";
                echo "<script type='text/javascript'>
                    var pretty_please_message='".str_ireplace(array("\r\n", "\n", "\r","'"),array("<br />","<br />","<br />","&#39;"), get_option("pretty_please_popup_message"))."';
                    var pretty_please_title='".str_ireplace(array("\r\n", "\n", "\r","'"),array("","","","&#39;"), get_option("pretty_please_headline"))."';";
                if(get_option("pretty_please_display_link")=="on")
                {
                    echo "var pretty_please_powered=true;";
                }
                else
                {
                    echo "var pretty_please_powered=false;";
                }
                echo "var timebetween=".get_option("pretty_please_popupmintime").";";

                global $pretty_please_directory;
                echo "</script>";
                echo "<script type='text/javascript' src='$pretty_please_directory/pretty-please.js'></script>";
            }
            
        }
    }
}

function prettyPleaseIsIPhoneOrIPad()
{
    if(strstr($_SERVER['REQUEST_URI'],"flash-pretty-please-demo-page"))
    {
        return true;//&&!isset($_COOKIE['no_popup']);
    }
    else
    {
        return (strstr($_SERVER['HTTP_USER_AGENT'],"iPod")||strstr($_SERVER['HTTP_USER_AGENT'],"iPad")||strstr($_SERVER['HTTP_USER_AGENT'],"iPhone"))&&!isset($_COOKIE['no_popup']);
    }
}
function pageNeedsFlash()
{
    $page_filter = get_option("pretty_please_page_filter");
    $not_display_pages = get_option("pretty_please_not_display_pages");
    $display_pages = get_option("pretty_please_display_pages");
    $current_page=$_SERVER['REQUEST_URI'];


    $pages_array;
    //display only on pages
    if($page_filter!=2)
    {
        $pages_array=explode(",",$display_pages);
    }
    //display on all pages except
    else
    {
        $pages_array=explode(",",$not_display_pages);
    }
    

    //check
    foreach($pages_array as $page)
    {
        if(prettyPleaseMatch($page,$current_page))
        {
            //display only on pages
            if($page_filter!=2)
            {
                return true;
            }
            //display on all pages except
            else
            {
                return false;
            }
        }        
    }

    //display only on pages
    if($page_filter!=2)
    {
        return false;
    }
    //display on all pages except
    else
    {
        return true;
    }
}

function prettyPleaseMatch($page,$current_page)
{
    $page=trim($page);

    if($page=="")
    {
        return false;
    }
    $page_character_count=strlen($page);

    if($page_character_count>1&&$page{0}=="*"&&$page{$page_character_count-1}=="*")
    {
        $page=trim($page,"*");

        if(strstr($current_page,$page))
        {
            return true;
        }
    }
    else if($page{0}=="*")
    {
        $page=trim($page,"*");

        $current_page_character_count=strlen($current_page);
        $starting_index=$current_page_character_count-$page_character_count;

        if($starting_index>=0&&substr($current_page,$starting_index-1)==$page)
        {
            return true;
        }
    }
    else if($page{$page_character_count-1}=="*")
    {
        
        $page=trim($page,"*");

        

        if(substr($current_page,0,$page_character_count-1)==$page)
        {
            return true;
        }
    }
    else
    {
        if($current_page==$page)
        {
            return true;
        }
    }
    return false;
}
function prettyPleaseFooterHtml()
{
    echo
    '<div id="pretty-please-close-area" style="position:absolute;width:100%;left:0px;top:0px;text-align:center;z-index:2;" onclick="prettyPleaseClickTarget(event,\'yes\');">
        <div id="pretty-please-popup-text" onclick="prettyPleaseClickTarget(event,\'no\');"></div>
    </div>
    <div id="pretty-please-popup"></div>';

}
?>

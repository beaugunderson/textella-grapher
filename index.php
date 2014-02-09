<?
   if (!$form_ip) {
      $form_ip = "216.66.57.66";
   }

   if ($form_ip_text) {
      $form_ip = $form_ip_text;
   }

   if (!$form_port) {
      $form_port = "1134";
   }

   if ($form_port_text) {
      $form_port = $form_port_text;
   }

   if (!$form_ratio) {
      $form_ratio = "fill";
   }

   $random = md5(rand());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
 <head>
  <title>Textella: Network Status & Graph</title>

  <link rel="stylesheet" type="text/css" href="/~remorse/common.css" />
 </head>
 <body style="font-family: Terminal; font-size: 6pt;">
  <div class="outer" style="width: 802px; margin-left: auto; margin-right: auto;">
   <div class="inner">
    <h2 style="margin-top: -5px; margin-bottom: 6px;">Textella: Network Status & Graph</h2>

    <div style="background-color: #DDDDDD; margin-bottom: 10px; border: 1px solid black; padding: 10px;">
     Connecting to <?=$form_ip?>:<?=$form_port?>. Please wait for the image below to load.
    </div>

    <div style="background-color: #DDDDDD; margin-bottom: 10px; border: 1px solid black; padding: 5px;">
     <form action="<?=$PHP_SELF?>" method="post" style="margin: 0px;">
      <table>
       <tr>
        <td style="width: 33%;">
         <input type="radio" name="form_ratio" value="compress" <?=($form_ratio == "compress") ? "checked " : ""?>/>Compress.

         <br />

         <input type="radio" name="form_ratio" value="fill" <?=($form_ratio == "fill") ? "checked " : ""?>/>Fill.
        </td>
        <td style="width: 33%; border-left: 1px solid white; padding-left: 10px;">
         <input type="checkbox" name="form_hide" value="true" <?=($form_hide) ? "checked " : ""?>/> Hide non-original routes.

         <br />

         <input type="checkbox" name="form_debug" value="true" <?=($form_debug) ? "checked " : ""?>/> Show debug data.

         <br />

         <input type="checkbox" name="form_channel_links" value="true" <?=($form_channel_links) ? "checked " : ""?>/> Show only channel links.
        </td>
        <td style="width: 33%; border-left: 1px solid white; padding-left: 10px;">
         <select name="form_ip" style="width: 116px;">
          <option value="216.66.57.66"<?=($form_ip == "216.66.57.66") ? " selected" : ""?>>216.66.57.66</option>
          <option value="111.111.111.111"<?=($form_ip == "111.111.111.111") ? " selected" : ""?>>111.111.111.111</option>
         </select>

         <select name="form_port" style="width: 56px;">
          <option value="1134"<?=($form_port == "1134") ? " selected" : ""?>>1134</option>
          <option value="1111"<?=($form_port == "1111") ? " selected" : ""?>>1111</option>
         </select>

         <br />

         <input type="text" name="form_ip_text" value="<?=$form_ip_text?>" style="margin-right: 2px; width: 110px;" class="text" />

         <input type="text" name="form_port_text" value="<?=$form_port_text?>" style="width: 50px;" class="text" />

         <br />
         <br />

         <a href="http://www.countercultured.net/~remorse/index.php?form_ratio=<?=$form_ratio?>&form_hide=<?=$form_hide?>&form_ip=<?=$form_ip?>&form_ip_text=<?=$form_ip_text?>&form_port=<?=$form_port?>&form_port_text=<?=$form_port_text?>">Here's a link to these options.</a>
        </td>
        <td>
         <input type="submit" value="Change options." class="submit" />
        </td>
       </tr>
      </table>
     </form>
    </div>

    <embed src="http://www.countercultured.net/~remorse/svg.php?form_ratio=<?=$form_ratio?>&form_hide=<?=$form_hide?>&form_ip=<?=$form_ip?>&form_ip_text=<?=$form_ip_text?>&form_port=<?=$form_port?>&form_port_text=<?=$form_port_text?>&form_debug=<?=$form_debug?>&form_random=<?=$random?>&form_channel_links=<?=$form_channel_links?>" style="border: 1px solid black; margin-bottom: 10px;" width="800" height="600" />
<?
   if ($form_debug) {
      flush();

      sleep(10);
?>

    <h2><?=$random?> debug data:</h2>

    <iframe frameborder="0" style="margin-bottom: 10px; border: 1px solid black; width: 798px; height: 600px;" src="http://www.countercultured.net/~remorse/debug.txt"></iframe>
<?
   }
?>

    <div style="background-color: #DDDDDD; border: 1px solid black; padding: 10px; margin-bottom: 10px;">
     Changelog:

     <br />
     <br />

     <span style="color: red;">09/11/03</span>: Recoded the graph-parsing algorithm to use PFDPINGMAP. The graph will now show users and links for the channel "#havok".

     <br />
     <br />

     <span style="color: red;">06/08/03</span>: Added "hide non-original routes" mode, which shows only the first unique route to each server.

     <br />
     <br />

     <span style="color: red;">05/07/03</span>: Made svg.php return pure SVG now, with headers.

     <br />

     <span style="color: red;">05/07/03</span>: Added nifty animated "T" logo to error & graph pages.

     <br />
     <br />

     <span style="color: red;">05/01/03</span>: Modified all code from original version, added an improved interface, options, and updated the code quite a bit.
    </div>

    <div style="background-color: #DDDDDD; border: 1px solid black; padding: 10px;">
     This app coded by <a href="http://www.fakepope.com/contact.php">Beau Gunderson</a>, aka blodulv.
    </div>
   </div>
  </div>
 </body>
</html>

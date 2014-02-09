<?
   function safe($s) {
      return str_replace("^", "_", $s);
   }

   header("Content-type: image/svg-xml");

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

   $sock = @fsockopen($form_ip, $form_port, &$errno, &$errstr);

   if (!$sock) {
      include("error.php");

      exit;
   }

   fputs($sock, "TEXTELLA RED 0.0.4\r\n");

   fputs($sock, "NICK TestingBot\r\n");
   sleep(5);


   fputs($sock, "PFDPINGMAP\r\n");

   flush();

   sleep(7);

   fputs($sock, "QUIT\r\n");

   while (!feof($sock)) {
      $string .= fgets($sock, 1024);
   }

   fclose($sock);

   $sock = @fsockopen($form_ip, $form_port, &$errno, &$errstr);

   if (!$sock) {
      include("error.php");

      exit;
   }

   fputs($sock, "TEXTELLA RED 0.0.4\r\n");

   fputs($sock, "NICK TravestyBot\r\n");


   fputs($sock, "LINKS #havok\r\n");

   flush();

   sleep(10);

   fputs($sock, "QUIT\r\n");

   while (!feof($sock)) {
      $links_string .= fgets($sock, 1024);
   }

   fclose($sock);

   if ($form_debug) {
      $handle   = fopen("./debug.txt", "w");

      fwrite($handle, $form_random ."\n\n". $string ."\n". $links_string);
      fclose($handle);
   }

   $array       = split("\r\n", $string);
   $links_array = split("\r\n", $links_string);

   // sort($array);

   for ($i = 0; $i < count($array) - 1; $i++) {
      $blocked = "0";

      if (strstr($array[$i], "PFDPONGMAP")) {
         $new_string = $array[$i];

         if (strstr($new_string, "#BLOCKED")) {
            $new_string = str_replace("#BLOCKED", "", $new_string);
            $blocked = "1";
         }

         $new_string = split(" ", $new_string);

         for ($k = 0; $k < count($new_string); $k++) {
            list($connection_j, $fd_to_k)   = split("!", $new_string[3]);
            list($fd_from_j, $connection_k) = split("!", $new_string[4]);

            if ($connection_j != NULL) {
               if (!@in_array("$connection_j!$fd_to_k $fd_from_j!$connection_k", $link_array) && !@in_array("$connection_k!$fd_from_j $fd_to_k!$connection_j", $link_array)) {
                  $network[$connection_k][count($network[$connection_k])] = $connection_j;

                  $blocked_array[$connection_k][count($blocked_array[$connection_k])] = $blocked;

                  $link_array[count($link_array)] = "$connection_j!$fd_to_k $fd_from_j!$connection_k";
               }
            }
         }
      }
   }

   $keys = @array_keys($network);

   for ($i = 0; $i < count($keys); $i++) {
      if (!@in_array($keys[$i], $nodes)) {
         $nodes[count($nodes)] = $keys[$i];
         $nodes_transform[$keys[$i]] = count($nodes_transform);

         if ($nodes[count($nodes) - 1] == $form_ip .":". $form_port) {
            $nodes_text .= "  n". (count($nodes_transform) - 1) ." [label = \\\"". $nodes[count($nodes) - 1] ."\\\", shape = box, color = black, fillcolor = azure3, style = filled];\n";
         } else {
            $nodes_text .= "  n". (count($nodes_transform) - 1) ." [label = \\\"". $nodes[count($nodes) - 1] ."\\\", shape = box];\n";
         }
      }

      for ($j = 0; $j < count($network[$keys[$i]]); $j++) {
         if (!@in_array($network[$keys[$i]][$j], $nodes)) {
            $nodes[count($nodes)] = $network[$keys[$i]][$j];
            $nodes_transform[$network[$keys[$i]][$j]] = count($nodes_transform);

            if ($nodes[count($nodes) - 1] == $form_ip .":". $form_port) {
               $nodes_text .= "  n". (count($nodes_transform) - 1) ." [label = \\\"". $nodes[count($nodes) - 1] ."\\\", shape = box, color = black, fillcolor = azure3, style = filled];\n";
            } else {
               $nodes_text .= "  n". (count($nodes_transform) - 1) ." [label = \\\"". $nodes[count($nodes) - 1] ."\\\", shape = box];\n";
            }
         }
      }
   }

   for ($i = 0; $i < count($keys); $i++) {
      for ($j = 0; $j < count($network[$keys[$i]]); $j++) {
         if (!$form_channel_links) {
            if ($blocked_array[$keys[$i]][$j] == "1") {
               if (!$form_hide) {
                  $edges_text .= "  n". $nodes_transform[$keys[$i]] ." -- n". $nodes_transform[$network[$keys[$i]][$j]] ." [dir = none, color = red];\n";
               }
            } else {
               $edges_text .= "  n". $nodes_transform[$keys[$i]] ." -- n". $nodes_transform[$network[$keys[$i]][$j]] ." [dir = none];\n";
            }
         }
      }
   }

   for ($i = 0; $i < count($links_array); $i++) {
      if (strstr($links_array[$i], "SERVLINK")) {
         list($type, $channel, $from, $to) = split(" ", $links_array[$i]);

         if ($from != $to) {
            $edges_text .= "  n". $nodes_transform[$from] ." -- n". $nodes_transform[$to] ." [dir = none, color = blue, style = dashed];\n";
         }
      } else if (strstr($links_array[$i], "USERLINK")) {
         list($type, $channel, $nick, $server) = split(" ", $links_array[$i]);

         $channel = str_replace("#", "", $channel);

         $nodes_text .= "  ". safe($nick) ." [label = \\\"User: ". $nick ."\\\", shape = ellipse, style = filled, fillcolor = lightblue];\n";

         $edges_text .= "  n". $nodes_transform[$from] ." -- ". safe($nick) ." [dir = none, color = green, style = dashed];\n";
      }
   }

   $header  = "graph textella {\n";
   $header .= "  dim = 1;\n";
   $header .= "  mclimit = 250;\n";
   $header .= "  nslimit = 2500;\n";
   $header .= "  margin = \\\"0.25\\\";\n";
   $header .= "  size = \\\"10.625, 7.75\\\";\n";
   $header .= "  ratio = \\\"". $form_ratio ."\\\";\n\n";

   $footer = "}";

   exec("echo \"". $header . $nodes_text . $edges_text . $footer ."\" > temp.txt");

   $pipe = popen("/usr/bin/dot -Tsvg < temp.txt 2>&1", "r");

   while ($s = fread($pipe, 1024)) {
      $svg .= $s;
   }

   $new_svg  = " <text transform=\"matrix(1 0 0 1 30 582)\" style=\"text-anchor: middle;\">";
   $new_svg .= "  <tspan x=\"0\" y=\"0\" fill=\"#000000\" stroke=\"none\" font-family=\"'Arial-dashedMT'\" font-size=\"32\">T</tspan>";
   $new_svg .= " </text>";

   $new_svg .= " <g transform=\"translate(30 570) rotate(-25)\" style=\"stroke: black; stroke-width: 0.5; fill: none\">";
   $new_svg .= "  <ellipse id=\"ellipse1\" cx=\"0\" cy=\"0\" rx=\"20\" ry=\"20\"/>";
   $new_svg .= "  <ellipse id=\"ellipse2\" cx=\"0\" cy=\"0\" rx=\"20\" ry=\"20\"/>";
   $new_svg .= " </g>";

   $new_svg .= " <g transform=\"translate(30 570) rotate(65)\" style=\"stroke: black; stroke-width: 0.5; fill: none\">";
   $new_svg .= "  <ellipse id=\"ellipse3\" cx=\"0\" cy=\"0\" rx=\"20\" ry=\"20\"/>";
   $new_svg .= "  <ellipse id=\"ellipse4\" cx=\"0\" cy=\"0\" rx=\"20\" ry=\"20\"/>";
   $new_svg .= " </g>";

   $new_svg .= " <animate xlink:href=\"#ellipse1\" attributeName=\"rx\" values=\"20;0;20\" begin=\"1s\" dur=\"10s\" repeatCount=\"indefinite\"/>";
   $new_svg .= " <animate xlink:href=\"#ellipse2\" attributeName=\"rx\" values=\"20;0;20\" begin=\"2s\" dur=\"12s\" repeatCount=\"indefinite\"/>";
   $new_svg .= " <animate xlink:href=\"#ellipse3\" attributeName=\"rx\" values=\"20;0;20\" begin=\"3s\" dur=\"10s\" repeatCount=\"indefinite\"/>";
   $new_svg .= " <animate xlink:href=\"#ellipse4\" attributeName=\"rx\" values=\"20;0;20\" begin=\"4s\" dur=\"12s\" repeatCount=\"indefinite\"/>";
   $new_svg .= "</svg>";

   $svg = str_replace("</svg>", $new_svg, $svg);

   echo $svg;
?>

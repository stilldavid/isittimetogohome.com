<?

/**
 * 17 is 5 o'clock in 24 hour time.
 *
 * Other than that, you're on your own trying to figure this out.
 */

function get_t_zone($hour) {
  $diff = abs(17 - $hour);

  if (17 < $hour)
    $diff = -$diff;

  if ($diff > 12)
    $diff -= 24;

  if ($diff < 10 && $diff > -10)
    $diff = preg_replace('/([0-9])/', '0$1', $diff);
  return $diff;
}

function get_city($offset) {
  $cities = array();
  $handle = fopen("cities.txt", "r");
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $num = count($data);
    if (preg_match("/$offset/", $data[1])) {
       $cities[] = $data;
    }
  }
  // fclose($handle);
  $city = array_rand($cities);
  $to_ret = $cities[$city][0].', '.$cities[$city][2];
  return $to_ret;
}

$now_utc = gmdate("H");
$diff = get_t_zone($now_utc);
$to_print = get_city($diff);

$text = isset($_GET['t']) ? htmlspecialchars($_GET['t']) : "Yes.";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<!--
                 _                          _
                | |                        | |
    __ _  ___   | |__   ___  _ __ ___   ___| |
   / _` |/ _ \  | '_ \ / _ \| '_ ` _ \ / _ \ |
  | (_| | (_) | | | | | (_) | | | | | |  __/_|
   \__, |\___/  |_| |_|\___/|_| |_| |_|\___(_)
    __/ |
   |___/

  But seriously, stop reading the source and GTFO
  of work. It's five o'clock somewhere...

  My name is David Stillman, by the way. I like
  the Internet.

  http://stilldavid.com

-->

    <script type="text/javascript">
      var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
      document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
      try {
        var pageTracker = _gat._getTracker("UA-8612424-1");
        pageTracker._trackPageview();
      } catch(err) {}
    </script>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>is it time to go home?</title>
    <style type="text/css">
      body {
        text-align: center;
        font-family: helvetica, sans-serif;
      }
      .big {
        font-size: 120pt;
        font-weight: bold;
      }
      .small {
        font-size: 20pt;
        position: absolute;
        bottom: 0;
        margin: 1em;
        color: #AAA;
      }
    </style>
  </head>
  <body>
    <p class="big"><?= $text ?></p>
    <p class="small">At least it is in <?= $to_print ?></p>
  </body>
  <?
   /*
   for($i=0; $i<24; $i++) {
     echo "  <!-- if GMT is $i, diff is ".get_t_zone($i)." and  it's 5 in ".get_city(get_t_zone($i))." -->\n";
   }
   */
  ?>
</html>

<?php
  // $debug = basename(__FILE__) . ":: L:" . __LINE__;
  
  function set_debug($file){
    //https: //www.quackit.com/css/css_color_codes.cfm

    $debug_color = array(
      'archive-market' => 'blue',
      'archive-community' => 'Navy',
      'single-community' => 'green',
      'content-2Level-metabox' => 'purple',
      'content-single-community' => 'olive',
      'content-market-stats' => 'brown',
      'chartData' => 'orange',
      'neighborhood-metabox' => 'OrangeRed'
    );
    // print_r(pathinfo($file)['filename']);
    // echo $debug_color['archive-market'];
    // print_r($debug_color);
    $debug = (object)array(
      "c" => $debug_color[pathinfo($file)['filename']], //for debug color
      "f" => pathinfo($file)['filename'], //for debug file name
      "l" => "::" //Line prefix
    );
    return $debug;
  }

  /*
  @color
  @various messages
  print the messages by color
*/
  function print_x($x, $line, ...$msgs)
  {
    if(!$x){
      $x->c = 'red';
      $x->f = pathinfo($file)['filename'];
      $x->l = '::';
    }
    $color = $x->c;
    $file = $x->f;
    $line = $x->l . $line . ' // ';

    echo '<div >';
      echo '<hr height="1" style="padding-top: 3px; border-bottom: 1px solid; color: lightblue">';

      $msgString = '<p style ="text-align: left; color:' . $color . '">';
      $msgString .= $file . $line;
      foreach($msgs as $msg){
        if (!(is_object($msg) or is_array($msg))) {
            $msg = trim($msg);
            if(file_exists($msg)){
              $msg=basename($msg);
            }
            $msgString .=  ( $msg ? $msg : 'null') . (substr($msg, -2) == "::" ? "" : " // ");
        } elseif (is_array($msg)) {
            $msgString .= "^ARRAY " . "[ " . count($msg) . " ] // ";
            echo '<div style ="text-align: left!important; color:' . $color . '">';
            //print_r($msg);
            var_dump($msg);
            echo ' </div>';
        }elseif (is_object($msg)){
            $msgString .= "^OBJECT " . $msg->name. "{ " . count(array($msg)) . " } // ";
            echo '<div style ="text-align: left!important; color:' . $color . '">';
            var_dump($msg);
            //print_r($msg);
            echo ' </div>';
        }
      }
      $msgString = rtrim($msgString, " // ");
      $msgString .= '</p>';
      echo $msgString; //prints the debug message

      echo '<hr height="1" style="border: 1px solid; color: darkblue">';
    echo '</div>';
  }
?>
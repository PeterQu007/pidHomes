<?php
  $debug = basename(__FILE__) . ":: L:" . __LINE__;
  
  function get_color($file){
    $debug_color = array(
      'archive-market' => 'blue',
      'single-community' => 'green',
      'chartData' => 'orange',
      'content-2Level-metabox' => 'purple',
      'content-single-community' => 'olive',
      'content-market-stats' => 'brown'
    );
    // print_r(pathinfo($file)['filename']);
    // echo $debug_color['archive-market'];
    // print_r($debug_color);
    return $debug_color[pathinfo($file)['filename']];
  }

  /*
  @color
  @various messages
  print the messages by color
*/
  function print_x($color = 'red', ...$msgs)
  {
    if(!$color){
      $color = 'red';
    }
    echo '<div >';
      echo '<hr height="1" style="padding-top: 3px; border-bottom: 1px solid; color: lightblue">';
      $msgString = '<p style ="text-align: left; color:' . $color . '">';
      foreach($msgs as $msg){
        
        if (!(is_object($msg) or is_array($msg))) {
            if(file_exists($msg)){
              $msg=basename($msg);
            }
            $msgString .=  $msg . " // ";
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
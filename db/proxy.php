
<?php
/********************
 *    lang: "E",
      dguid: "2016A00055915004",
      topic: 5,
      notes: 0,
      stat: 0
    0 = All topics
    1 = Aboriginal peoples
    2 = Education
    3 = Ethnic origin
    4 = Families, households and marital status
    5 = Housing
    6 = Immigration and citizenship
    7 = Income
    8 = Journey to work
    9 = Labour
    10 = Language
    11 = Language of work
    12 = Mobility
    13 = Population
    14 = Visible minority

 */
$url = (isset($_GET['url'])) ? $_GET['url'] : false;
$lang = (isset($_GET['lang'])) ? $_GET['lang'] : 'E';
$dguid = (isset($_GET['dguid'])) ? $_GET['dguid'] : '2016A00055915015' /* Richmond */ ; //'2016A00055915004' /* Surrey */;
$topic = (isset($_GET['topic'])) ? $_GET['topic'] : 0;
$notes = (isset($_GET['notes'])) ? $_GET['notes'] : 0;
$stat = (isset($_GET['stat'])) ? $_GET['stat'] : 0;
$referer_test = true;
// $url = "https://www12.statcan.gc.ca/rest/census-recensement/CPR2016.json?lang=E&dguid=2016A00055915004&topic=5&notes=0&stat=0";
$url = "https://www12.statcan.gc.ca/rest/census-recensement/CPR2016.json?";
//$url_query = lang=E&dguid=2016A00055915004&topic=5&notes=0&stat=0
$url_query = 'lang=' . $lang . '&dguid=' . $dguid . '&topic=' . $topic . '&notes=' . $notes . '&stat=' . $stat;
$url .= $url_query;
// echo $url;

if (!$url) {
    exit;
}
// https://pidrealty.local/wp-content/themes/realhomes-child/db/proxy.php


$referer = (isset($_SERVER['HTTP_REFERER'])) ? strtolower($_SERVER['HTTP_REFERER']) : false;
// echo $referer;
$is_allowed = $referer && strpos($referer, strtolower($_SERVER['SERVER_NAME'])) !== false; //deny abuse of your proxy from outside your site
// echo strpos($referer, strtolower($_SERVER['SERVER_NAME']));
// echo $_SERVER['SERVER_NAME'];
// echo $_SERVER['HTTP_REFERER'];
// var_dump($_SERVER);

$string = ($is_allowed or $referer_test) ? utf8_encode(file_get_contents($url)) : 'You are not allowed to use this proxy!';
$string = ltrim($string, '//');
// var_dump($string->columns);
$demographics = json_decode($string);
// var_dump($demographics);
// var_dump($demographics->COLUMNS);
?>
    <div>
        <table>
            <tr>
            <?php
                foreach($demographics->COLUMNS as $field){
                    echo '<th>' . $field . '</th> <th> | </th>' ;
                }
            ?>
            </tr>
<?php
$indent_id = array_search('INDENT_ID', $demographics->COLUMNS);
$topic_theme_id = array_search('TOPIC_THEME', $demographics->COLUMNS);
$text_id = array_search('TEXT_ID', $demographics->COLUMNS);
var_dump($topic_theme_id);
// $json = json_encode($string);
$json = $string;
$level =1 ;
foreach($demographics->DATA as $data){
    $output = false;
    $text_id_value = $data[$text_id];
    switch ($data[$topic_theme_id]) {
        case 'Aboriginal peoples' : //1
            continue 2;
        break;
        case 'Education' : //2
            $level =1;
            if(!(strval($data[$text_id])<=28014)){
                continue 2;
            }
        break;
        case 'Families, households and marital status' : // 4
            if(!(strval($data[$text_id])<=3009)){
                continue 2;
            }
        break;

        case 'Housing' : // 5: 
            switch(true){
                case $text_id_value >=27000 and $text_id_value <=27006 :
                break;
                case $text_id_value >=27054 and $text_id_value <=27065 :
                break;
                default: 
                continue 3;
            }
        break;

        case 'Immigration and citizenship' : // 6: 
            switch(true){
                case $text_id_value >=17000 and $text_id_value <=18999 :
                break;
                case $text_id_value >=23000 and $text_id_value <=23100 :
                break;
                default: 
                continue 3;
            }
        break;

        case 'Income' : //7
            $level = 1;
            if(!(strval($data[$text_id]) >= 13000 AND strval($data[$text_id]) < 13018)){
                // echo 'yes';
                continue 2;
            }
        break;


        case 'Population': // 13: //
            switch(true){
                case $text_id_value >=1000 and $text_id_value <=1999 :
                break;
                case $text_id_value >=2027 and $text_id_value <=2033 :
                break;
                default: 
                continue 3;
            }
        break;

        case 'Visible minority': // 14: // 
            $level = 2;
        break;

        default :

        continue 2;

    }

    if($data[$indent_id]<=$level){
        echo '<tr>';
        foreach($data as $cell){
            // echo '$cell';
            echo '<td>' . strval($cell) . '</td> <td> | </td>';
        }
        echo '</tr><tr>';
        foreach ($data as $cell) {
            // echo '$cell';
            echo '<td>-------</td> <td> | </td>';
        }
        echo '</tr>';
    }
    // var_dump($data);
}
?>

        </table>
    </div>
<?php

$callback = (isset($_GET['callback'])) ? $_GET['callback'] : false;
if ($callback) {
    $jsonp = "$callback($json)";
    header('Content-Type: application/javascript');
    echo $jsonp;
    exit;
}
echo $json;

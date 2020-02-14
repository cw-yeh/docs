<?php
include_once('/home/sl/public_html/sl_init.php');
sl_open('docs');

$query = "SELECT eb01 as screen_name, 
                 eb05 as title, 
                 CONCAT( SUBSTRING( eb02, 1, 4 ) , '-', SUBSTRING( eb02, 5, 2 ) , '-', SUBSTRING( eb02, 7, 2 ) , ' ', SUBSTRING( eb03, 1, 2 ) , ':', SUBSTRING( eb03, 3, 2 ) , ':00' ) as show_startime, 
                 CONCAT( SUBSTRING( eb06, 1, 4 ) , '-', SUBSTRING( eb06, 5, 2 ) , '-', SUBSTRING( eb06, 7, 2 ) , ' ', SUBSTRING( eb07, 1, 2 ) , ':', SUBSTRING( eb07, 3, 2 ) , ':00' ) as show_endtime 
          FROM  docs.ewb01
          WHERE b_dept_id like 'S1%' 
             and eb06 = '20191105'
        ";
$qresult = mysql_query($query);
$rows = array();
$table = array();
$table['cols'] = array (
    array('id' => 'Screen', 'type' => 'string'),
    array('id' => 'Movie', 'type' => 'string'),
    array('id' => 'Start time', 'type' => 'date'),
    array('id' => 'End time', 'type' => 'date'),
    array('type'=>'string', 'p' => array('role' => 'style'))
  );
  
  while($res = mysql_fetch_assoc($qresult)){
    $vres[] = $res;
  }
  foreach ($vres as $r) {
    $temp = array();
    $temp[] = array('v' => mb_convert_encoding($r['screen_name'],"utf-8","big5"));
    $temp[] = array('v' => mb_convert_encoding($r['title'],"utf-8","big5"));
    //$temp[] = array('v' => $r['show_startime']);
    //$temp[] = array('v' => $r['show_endtime']);
    
    //$temp[] = array('v' => 'Date(0,0,0,'.date('H',strtotime($r['show_startime'])).','.date('i',strtotime($r['show_startime'])).','.date('s',strtotime($r['show_startime'])).')');
    //$temp[] = array('v' => 'Date(0,0,0,'.date('H',strtotime($r['show_endtime'])).','.date('i',strtotime($r['show_endtime'])).','.date('s',strtotime($r['show_endtime'])).')');
    
    
    $temp[] = array('v' => 'Date('.date('Y',strtotime($r['show_startime'])).','.date('m',strtotime($r['show_startime'])).','.date('d',strtotime($r['show_startime'])).','.date('H',strtotime($r['show_startime'])).','.date('i',strtotime($r['show_startime'])).','.date('s',strtotime($r['show_startime'])).')');
    $temp[] = array('v' => 'Date('.date('Y',strtotime($r['show_endtime'])).','.date('m',strtotime($r['show_endtime'])).','.date('d',strtotime($r['show_endtime'])).','.date('H',strtotime($r['show_endtime'])).','.date('i',strtotime($r['show_endtime'])).','.date('s',strtotime($r['show_endtime'])).')');
    $temp[] = array('v' => 'color: #000000');
    $rows[] = array('c' => $temp);
  }
  $table['rows'] = $rows;
  $jsonTable = json_encode($table);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {
  callback: drawVisualization,
  packages: ['corechart']
});
function drawVisualization() {
  var container = document.getElementById('example');
  var chart = new google.visualization.Timeline(container);
  var dataTable = new google.visualization.ComboChart(<?php echo $jsonTable; ?>);
  var colors2 = [];
    var colorMap2 = {
        GA: '#FF9797',
        GB: '#3271C3',
        GC: '#FFFFFF'
    }
	for (var i = 0; i < dataTable.getNumberOfRows(); i++) {
        /*alert(dataTable.getValue(i, 1));*/
        colors2.push(colorMap2['GC']);
    }
    var options = {
        backgroundColor: '#daf3f3',   // ­I´ºÃC¦â
        colors: colors2
    }
  chart.draw(dataTable,options);
}
</script>
<div id="example" style="height: 800px;"></div>
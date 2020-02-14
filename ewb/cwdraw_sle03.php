<?php
include_once('/home/sl/public_html/sl_init.php');
sl_open('docs');

$query = "SELECT sle09.E09_2 as screen_name, 
                 essf03.theme as title, 
                 CONCAT( SUBSTRING( essf03.date_s, 1, 4 ) , '-', SUBSTRING( essf03.date_s, 5, 2 ) , '-', SUBSTRING( essf03.date_s, 7, 2 ) , ' ', SUBSTRING( essf03.time_s, 1, 2 ) , ':', SUBSTRING( essf03.time_s, 3, 2 ) , ':00' ) as show_startime, 
                 CONCAT( SUBSTRING( essf03.date_e, 1, 4 ) , '-', SUBSTRING( essf03.date_e, 5, 2 ) , '-', SUBSTRING( essf03.date_e, 7, 2 ) , ' ', SUBSTRING( essf03.time_e, 1, 2 ) , ':', SUBSTRING( essf03.time_e, 3, 2 ) , ':00' ) as show_endtime 
          FROM  sle.essf03
                 left join sle.sle09 on essf03.empno = sle09.E09_1
          WHERE essf03.b_dept_id in ('S121','S122')
                and essf03.date_s >= '20190701'
                AND ( essf03.flwres = '¦P·N' or essf03.flwres = '' )
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
  callback: drawChart,
  packages: ['timeline']
});
function drawChart() {
  var container = document.getElementById('example');
  var chart = new google.visualization.Timeline(container);
  var dataTable = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
  var colors2 = [];
    var colorMap2 = {
        GA: '#FF9797',
        GB: '#3271C3',
        GC: '#7092BE'
    }
	for (var i = 0; i < dataTable.getNumberOfRows(); i++) {
        /*alert(dataTable.getValue(i, 1));*/
        colors2.push(colorMap2['GC']);
    }
    var options = {
        backgroundColor: '#FFFFFF',   // ­I´ºÃC¦â
        colors: colors2
    }
  chart.draw(dataTable,options);
}
</script>
<div id="example" style="height: 800px;"></div>
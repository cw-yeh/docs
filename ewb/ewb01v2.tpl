<!-- START IGNORE -->
<script type="text/javascript" src="jquery.autocomplete.js"></script>
<script type="text/javascript" src="/~sl/clockTime/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/~sl/clockTime/js/jquery-clock-timepicker.min.js"></script>
<script type="text/javascript">
$(function(){   
  $('.time').clockTimePicker({});
});
</script>
<style type="text/css">
.time { display:inline-block; font-size:13px; padding:5px; text-align:center; width:40px; }
table.inscr {
  width: 98%;
  margin-left:auto; 
  margin-right:auto;
  /*margin-top:100px;*/
  margin-bottom :10px;
  border: 1px solid black;
  /*background-color: #FFF4C6;*/
  border-color: #FFFFFF;
  /*font-family:Microsoft JhengHei;*/
  font-size: 10pt;
}
table.inscr th{
  background-color: #CDDDED;
  text-align:right;
}
table.inscr td{
  background-color: #E9E9E9;
}
</style>
<!-- END IGNORE -->

<!-- START BLOCK : tb_inscr -->
 <form action="{tv_action}" method="POST" enctype="multipart/form-data" name="input_form"
                                                      onsubmit="
                                                                {tv_js_rule}
                                                                return(submitonce(this));
                                                                ">
<table class='inscr'>

  <!-- START BLOCK : tb_inscr_tr -->
  <!-- START BLOCK : tb_inscr_sep -->
  <tr>
    <th colspan='4' style='background-color:#7092BE;text-align:left;color:#FFF;'>{tv_title}</th>
  </tr>
  <!-- END BLOCK : tb_inscr_sep -->

  <!-- START BLOCK : tb_inscr_single -->
  <tr>
    <th width='16%'>{tv_field_name}¡G</th>
    <td width='35%' colspan='3' style='background-color:{tv_color};'>
    <!-- START BLOCK : tb_inscr_single_text -->
        <input name="{tv_name}" id="{tv_name}" type="{tv_type}" value="{tv_value}" size="{tv_size}" maxlength="{tv_max}" {tv_readonly} required class="{tv_class}" onchange="{tv_onchange}">
    <!-- END BLOCK : tb_inscr_single_text -->
	<!-- START BLOCK : tb_inscr_single_radio -->
	    <input type="radio" name="{tv_name}" value="N" CHECKED>§_ 
	    <input type="radio" name="{tv_name}" value="Y">¬O
    <!-- END BLOCK : tb_inscr_single_radio -->
    <!-- START BLOCK : tb_inscr_single_select -->
	    <select name="{tv_name}" size="{tv_size}" {tv_multiple} {tv_readonly}>
	    <!-- START BLOCK : tb_inscr_single_option -->
	        <option value="{tv_value}" {tv_selected}>{tv_show}</option>
	    <!-- END BLOCK : tb_inscr_single_option -->
	    </select>
    <!-- END BLOCK : tb_inscr_single_select -->
    &emsp;<font color=green>{tv_memo}</font>
    </td>
  </tr>
  <!-- END BLOCK : tb_inscr_single -->
  



  <!-- START BLOCK : tb_inscr_double -->
  <tr>
    <!-- START BLOCK : tb_inscr_double_td -->
	  <!-- START BLOCK : tb_inscr_double_text -->
        <th width='16%'>{tv_field_name}¡G</th>
        <td width='35%' style='background-color:{tv_color};'>
            <input name="{tv_name}" id="{tv_name}" type="{tv_type}" value="{tv_value}" size="{tv_size}" maxlength="{tv_max}" {tv_readonly} required class="{tv_class}"  onchange="{tv_onchange}">
            &nbsp;<font color=green>{tv_memo}</font>
        </td>
      <!-- END BLOCK : tb_inscr_double_text -->
	  <!-- START BLOCK : tb_inscr_double_date -->
        <th width='16%'>{tv_field_name}¡G</th>
        <td width='35%' style='background-color:{tv_color};'>
            <script type="text/javascript">$(document).ready(function(){$('#{tv_name}').calendar({dateFormat: 'YMD'});});</script>
            <input name="{tv_name}" id="{tv_name}" type="text" value="{tv_value}" size="{tv_size}" maxlength="{tv_max}" {tv_readonly} class="{tv_class}"  onchange="{tv_onchange}">
            &nbsp;<font color=green>{tv_memo}</font>
        </td>
      <!-- END BLOCK : tb_inscr_double_date -->
	  <!-- START BLOCK : tb_inscr_double_time -->
        <th width='16%'>{tv_field_name}¡G</th>
        <td width='35%' style='background-color:{tv_color};'>
            <input name="{tv_name}" id="{tv_name}" type="text" value="{tv_value}" size="{tv_size}" maxlength="{tv_max}" {tv_readonly} class="time" onchange="console.log('Time changed')">
            &nbsp;<font color=green>{tv_memo}</font>
        </td>
      <!-- END BLOCK : tb_inscr_double_time -->
      <!-- START BLOCK : tb_inscr_double_select -->
        <th width='16%'>{tv_field_name}¡G</th>
        <td width='35%' style='background-color:{tv_color};'>
	      <select name="{tv_name}" size="{tv_size}" {tv_multiple} {tv_readonly}>
	      <!-- START BLOCK : tb_inscr_double_option -->
	          <option value="{tv_value}" {tv_selected}>{tv_show}</option>
	      <!-- END BLOCK : tb_inscr_double_option -->
	      </select>
        </td>
      <!-- END BLOCK : tb_inscr_double_select -->
	<!-- END BLOCK : tb_inscr_double_td -->
  </tr>
  <!-- END BLOCK : tb_inscr_double -->
  
  <!-- END BLOCK : tb_inscr_tr -->
  <tr>
    <td colspan=4>
      <input type="submit" class="buttonprint" value="½T©w" name="B1">
    </td>
  </tr>
</table>
 
</form>
<!-- END BLOCK : tb_inscr -->
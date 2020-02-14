<!-- START BLOCK : fd_script_showmsg -->
<input type="button" id="ShowButton" name="ShowButton" class="groovybutton" value="顯示注意事項"><br style="margin:0;height:0;clear:both;" />
<div name="ShowDiv" id="ShowDiv"  style="display:none;">
<table class="div_tb">
  <tr>                                               
    <td>外出白板自動轉成<font color=blue>外出簽核單</font>及<font color=blue>哩程簽核單</font>,自100/11/07起已於全區使用.<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;1. 待<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，即可修改哩程，並轉<font color=red>哩程簽核單</font>。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;2. 待<font color=blue>哩程簽核單</font>簽核<font color=red>同意</font>後，才會計算於私車公用統計表。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;3. <b>輸入回程哩程並轉哩程簽核單，需於調車單簽核結案後翌日起算<font color=red>三日內</font>(不含例假日)登打完畢。</b><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>如超過登打期限，欲開放請洽各區<font color=red>管理課課長</font>。</b><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ex: 調車單簽核同意結案日期 -> 2012-06-14(四)<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 出入廠哩程期限至 2012-06-19(二) 止需填寫完哩程<br>
        &nbsp;&nbsp;&nbsp;&nbsp;4. 同仁截止期限規定請參閱申請依【<a href=/~docs/ewb/ewb_file/20130418_ha310029.pdf target='_blank'>同仁車輛供公務使用管理實施辦法HA-310029<img src='/~sl/img/link_go.png' border='0' name='filepic' ></a>】及【<a href=/~docs/ewb/ewb_file/96019.pdf target='_blank'>九十六山隆字第019號通報<img src='/~sl/img/link_go.png' border='0' name='filepic' ></a>】<br>
        &nbsp;&nbsp;&nbsp;&nbsp;5. 經由總公司管理課統一規定關帳日為<font color=red>隔月6日</font><br>
        &nbsp;&nbsp;&nbsp;&nbsp;6. <b>群簽</b>簽核的外出資料，轉檔時間為<b>整點</b>，請於轉檔結束後再進行修改<br>
        &nbsp;&nbsp;&nbsp;&nbsp;7. 若有疑問，請洽<font color=red>各區管理課</font>詢問。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;8. 如簽核單沒有直屬主管，請聯絡<font color=red>總公司人事部</font>。<br>
        <!-- 
        &nbsp;&nbsp;&nbsp;&nbsp;6. 經由總公司管理課統一規定關帳日為<font color=red>隔月6日</font>。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ex:  201205(2012.04.26 ~ 2012.05.25)外出資料，關帳日為2012.06.05 23:59:59<br>
        <font color=red>＊</font>7. 關帳後，哩程簽核中外出資料油貼<font color=red>下月補發</font>。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;8. 如簽核單沒有直屬主管，請聯絡<font color=red>總公司人事部</font>。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;9. 如哩程 登打錯誤，或是已超過登打期限，欲開放請洽各區<font color=red>管理課課長</font>。<br>
        -->
    </td>
    <!--  
    <td>外出白板自動轉成<font color=blue>外出簽核單</font>及<font color=blue>里程簽核單</font>,自11/07起已於全區使用.<br><br>
        &nbsp;&nbsp;&nbsp;&nbsp;1. 待<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，即可修改里程，並轉<font color=blue>里程簽核單</font>。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;2. 待<font color=blue>里程簽核單</font>簽核<font color=red>同意</font>後，才會計算於私車公用統計表。<br>
        &nbsp;&nbsp;&nbsp;&nbsp;3. 11/07後，由於<font color=blue>多筆里程輸入</font>不會跑簽核，所以此功能移除，請<font color=blue>單筆</font>修改外出里程。<br>
        <font color=red>＊</font>4. <font size='3'><b>依總公司規定自11/26起，輸入回程里程並轉里程簽核單，需於<font color=red>簽核結案(預計回程日)後三日內</font>登打完畢。</b></font><br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ex: 日期 2011-12-21(三)，其往後算三日為 2011-12-23(五)(含)前要填寫完里程！當日也包含於三日內！<br>
        <font color=red>＊</font>5. <font color=red>若有疑問請詢問總公司總務組。</font><br>
        <font color=red>＊</font>6. <b>群簽</b>簽核的外出資料，轉檔時間為<font color=red>整點</font>，請於轉檔結束後再進行修改<br>
        <font color=red>＊</font>7. <b>填寫里程</b>，請於<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，再進行修改填寫。<br>
        <font color=red>＊</font>8. 經由2/7日與總務部做討論後，統一關帳日為<font color=blue>6日</font>。<br>
        <font color=red>＊</font>9. 關帳後，里程簽核中的外出資料不予理會，且<font color=red>不算入油貼發放</font>中。<br>
        <font color=red>＊</font>10.如簽核單沒有直屬主管，請聯絡總公司人事部。
    </td>
    -->
  </tr>
</table>
</div>
<script type="text/javascript">
//動畫顯示
$(function(){
  $("#ShowDiv").show();
  $("#ShowButton").val("隱藏注意事項");
  //speed(1000);
  //slidediv();
  //setTimeout($("#ShowDiv").show(),1000);    
  //setTimeout("slidediv()",2000); //mark by 佳玟 2016.10.03 經理說,不要收起來   
  $("#ShowButton").click(function(){
     if($("#ShowDiv").css("display")=='none'){
       $("#ShowDiv").slideDown();
       $("#ShowDiv").show();
       //$("#ShowDiv").html("slideDown()<br>slideUp()");
       $("#ShowButton").val("隱藏注意事項");
     }
     else{
       $("#ShowDiv").slideUp();
       $("#ShowButton").val("顯示注意事項");
     }
  });
});  
function slidediv(){
  $("#ShowDiv").slideUp();
  $("#ShowButton").val("顯示注意事項");
}
    
</script>
<style type="text/css">
table.div_tb {
border-top : 1px dotted #004EA0; /*上框線 粗細1px 實線 水藍色*/
border-bottom : 1px dotted #004EA0; /*下框線*/
border-left : 1px dotted #004EA0; /*左框線*/
border-right : 1px dotted #004EA0; /*右框線#6699cc*/ 
background-color: #EBF5FF;
}
input.groovybutton
{
   font-size:12px;
   text-align:left;
   color:#FFFFFF;
   width:96px;
   height:26px;
   background-color:#2878C0;
   border-top-style:solid;
   border-top-color:#2878C0;
   border-top-width:1px;
   border-bottom-style:solid;
   border-bottom-color:#2878C0;
   border-bottom-width:1px;
   border-left-style:solid;
   border-left-color:#1858B8;
   border-left-width:6px;
   border-right-style:solid;
   border-right-color:#508CC0;
   border-right-width:6px;
}
</style>
<!-- END BLOCK : fd_script_showmsg -->

<!-- START BLOCK : tb_memo1 -->

<pre style="margin:0">

 ＊ 申請油貼外出資料作業流程說明:
    (申請油貼車種：「私車公用」、「受公司補助購車」)
　+--------------+    +--------------+    +--------------+    +--------------+    +--------------+    +--------------+    +------------+
　|              |    | 轉外出調車單 |    | 主管簽核同意 |    | 修改外出資料 |    | 轉里程簽核單 |    | 主管簽核同意 |    |            |
　| 新增外出資料 |--->|   電子簽核   |--->|              |--->|  填寫里程數  |--->|   電子簽核   |--->|              |--->| 外出統計表 |
　|              |    |   (簽核中)   |    |    (同意)    |    |              |    |   (簽核中)   |    |    (同意)    |    |            |
　+--------------+    +--------------+    +--------------+    +--------------+    +--------------+    +--------------+    +------------+
</pre>

<br>
<!-- END BLOCK : tb_memo1 -->

<!-- START BLOCK : tb_memo2 -->
<br>外出資料不能修改的原因：
<pre style="margin:0">
+------------------------------------------------------------+
|(1) 外出單簽核狀態為簽核中、不同意、已抽單者。              |
|(2) 里程單簽核狀態為簽核中、同意。                          |
|(3) 已超過三日，起始日如下:                                 |
|    a. 外出調車單簽核日。                                   |
|    b. 如預計回程日 > 外出調車單簽核日，依預計回程日為主。  |
|    c. 里程簽核單不同意時，抓取簽核單結案日。               |
|(4) 經辦已將外出資料轉私車耗油統計表。                      |
+------------------------------------------------------------+ 
</pre>
<!-- END BLOCK : tb_memo2 -->

<!-- START BLOCK : fd_script_msel3 -->
  <input name="f_btn" type="hidden" value="{tv_btn}">
  <input name="f_msgbox_1" type="hidden" value="{tv_msgbox_1}">
  <input name="f_msgbox_2" type="hidden" value="{tv_msgbox_2}">
  <input name="f_msgbox_3" type="hidden" value="{tv_msgbox_3}">
  <script type="text/javascript">
  $(function(){
    $("#f_ok").after("<input type='button' onmouseout='this.style.backgroundColor=&quot;&quot;' onmouseover='this.style.backgroundColor=&quot;#228B22&quot;' onblur='this.style.backgroundColor=&quot;&quot;' onfocus='this.style.backgroundColor=&quot;#228B22&quot;' value='確定"+$("input[name='f_btn']").val()+"' class='btn_submit' id='f_ok_n' name='f_ok_n' style=''>");
    $("#f_ok").remove();       
    $("input[name='f_ok_n']").click(function(){  
      alert($("input[name='f_msgbox_1']").val()+"\n"+$("input[name='f_msgbox_2']").val()+"\n\n"+$("input[name='f_msgbox_3']").val()+"\n\n執行後無法回復，請小心選擇");
      setTimeout("submitform()",100);       
    });
  });
  function submitform(){
    //if(confirm("是否確定送出？")){   	//mmark by 佳玟 2017.03.13 將送出後的選項移除,部份人員電腦會把跳窗關閉
    	 document.del_form.submit();
	  //}
	  //else{                                                             
    //  return false;
    //}                                      
  }    
  </script>
<!-- START BLOCK : fd_script_msel3 -->  


<!-- START BLOCK : fd_script_msel72 -->
  <!-- START IGNORE -->
  <script type="text/javascript" src="jquery.autocomplete.js"></script>
  <script type="text/javascript">
  $(function(){
    /*找出姓名或員編*/
    //$("[name='f_eb01']").autocomplete("ewb01.php",{extraParams:{msel:'ajax_get_emp'},delay:10,width:250,minChars:1,maxItemsToShow:100,selectFirst:true,cacheLength:0,onItemSelect:u_empno1});
    $("[name='f_empno']").autocomplete("ewb01.php",{extraParams:{msel:'ajax_get_emp2'},delay:10,width:250,minChars:1,maxItemsToShow:100,selectFirst:true,cacheLength:0,onItemSelect:u_empno2});
    /*
    ,onItemSelect:u_empno
    delay:60, 停頓幾毫秒後開始搜尋
    width:400, 顯示清單時的外框寬度
    minChars:2, 最少輸入幾位數時開始送出查詢
    maxItemsToShow:30, 最大顯示個數
    onItemSelect:u_empno 選取時執行哪個function
    */  
    $("[name='f_empno']").change(function(){  //upd by 佳玟 2011.12.30  判斷預計回程日期是否大於外出日期
      str = this.value;
      if(str==''){
        $("input[name='f_car']").val('');
        $("input[name='f_card']").val('');      
      }
    });          
  });
  
  function u_empno1() {
    str1 = $("[name='f_eb01']").val();
    str2 = $("[name='f_eb01']").val().split('-');
    $("input[name='f_eb18']").val(str2[0]);
    $("input[name='f_eb01']").val(str2[1]);
//    if(str2[2]=='Y'){
//      $("select[name='f_eb17']").val(str2[2]);
//      document.input_form.f_eb17.disabled = true;  //upd by 佳玟 2011.10.17 如例外人員有設定扣除里程為 Y 者，則鎖住欄位不能修改 
//    }else{
//      $("select[name='f_eb17']").val(str2[2]);
//      document.input_form.f_eb17.disabled = false;
//    }
  }
  
  function u_empno2() {
    str1 = $("[name='f_empno']").val();
    str2 = $("[name='f_empno']").val().split(';');
    $("input[name='f_empno']").val(str2[0]);
    $("input[name='f_car']").val(str2[2]);
    $("input[name='f_card']").val(str2[3]);
  } 
  

  </script>
    <!-- END IGNORE -->
<!-- END BLOCK : fd_script_msel72 -->

<!-- START BLOCK : fd_script_close_eb12 -->
  <script type="text/javascript">
  $(function(){
    document.input_form.f_eb12.disabled = true;
    document.input_form.f_eb12.className = 'field_color';
  });
  </script>
<!-- END BLOCK : fd_script_close_eb12 -->

<!-- START BLOCK : fd_script_eb01 -->
  <!-- START IGNORE -->
  <script type="text/javascript" src="jquery.autocomplete.js"></script>
  <script type="text/javascript">
  $(function(){     
    /*找出姓名或員編*/
    $("[name='f_eb01']").autocomplete("ewb01.php",{extraParams:{msel:'ajax_get_emp'},delay:10,width:250,minChars:1,maxItemsToShow:100,selectFirst:true,cacheLength:0,onItemSelect:u_empno1});
    $("[name='f_empno']").autocomplete("ewb01.php",{extraParams:{msel:'ajax_get_emp2'},delay:10,width:250,minChars:1,maxItemsToShow:100,selectFirst:true,cacheLength:0,onItemSelect:u_empno2});
    /*
    ,onItemSelect:u_empno
    delay:60, 停頓幾毫秒後開始搜尋
    width:400, 顯示清單時的外框寬度
    minChars:2, 最少輸入幾位數時開始送出查詢
    maxItemsToShow:30, 最大顯示個數
    onItemSelect:u_empno 選取時執行哪個function
    */

    //add by 朝鈞 2019.03.14 代辦-15285 判斷同仁姓名是否存在slcar.slcar01_09，存在的話是公司補助購車，不能使用公務車和私車公用
    var Today = new Date();
    var Year = Today.getFullYear();
    var Month = Today.getMonth()+1;
    var Day = Today.getDate();
    //alert(Day);
    //if( Year=='2019' && Month=='5' && Day=='1' ){ //  2019.05.01開始實施
      f_eb01 = $( "[name='f_eb01']" ).val();
      $.ajax({
        url: "ewb01.php",
        dataType: "text",
        data: {
          msel : "ajax_chk_slcar01_09",
             q : f_eb01
        },
        success: function( data ) {
          if ( data == 'Y' ) { //有資料
            $( "[name='f_eb09'] option" ).eq( 1 ).attr( "disabled" , "disabled" );
            $( "[name='f_eb09'] option" ).eq( 2 ).attr( "disabled" , "disabled" );
            //$( "[name='f_eb09'] option" ).eq( 0 ).attr( "selected" , "selected" );
          }
        }
      });
    //}
    
    //判斷預計回程時間是否大於外出時間-----------------------------------------------//   	
    $("[name='f_eb02']").change(function(){  //upd by 佳玟 2011.12.30  判斷預計回程日期是否大於外出日期
      fd_eb02 = $('[name="f_eb02"]').val();
      fd_eb06 = $('[name="f_eb06"]').val();
      if(isNaN(fd_eb02) || fd_eb02.length<8 ){
        alert('『外出日期』請輸入日期格式!!') ; 
        $("input[name='f_eb02']").val('');    
        $("input[name='f_eb02']").focus();
      }else if(fd_eb06!='' && fd_eb02>fd_eb06){ //外出日期>預計回程日期
        alert("「預計回程日期」不能小於「外出日期」！");
        $("input[name='f_eb06']").val('');     
        $("[name='f_eb06']").focus(); 
      }
      check_data(fd_eb02,'f_eb02');   
    });         
    $("[name='f_eb06']").change(function(){ //upd by 佳玟 2011.12.30  判斷預計回程日期是否大於外出日期 
      fd_eb02 = $('[name="f_eb02"]').val();
      fd_eb06 = $('[name="f_eb06"]').val();
      if(isNaN(fd_eb06) || fd_eb06.length<8 ){
        alert('『預計回程日期』請輸入日期格式!!') ; 
        $("input[name='f_eb06']").val('');    
        $("input[name='f_eb06']").focus();
      }else if(fd_eb02!='' && fd_eb02>fd_eb06){ //外出日期>預計回程日期
        alert("「預計回程日期」不能小於「外出日期」！");
        $("input[name='f_eb06']").val('');     
        $("[name='f_eb06']").focus(); 
      }
      check_data(fd_eb06,'f_eb06');   
    });    
    $("[name='f_eb03']").change(function(){  //upd by 佳玟 2011.12.30  判斷預計回程時間是否大於外出時間
      fd_eb02 = $('[name="f_eb02"]').val();
      fd_eb06 = $('[name="f_eb06"]').val();    
      fd_eb03 = $('[name="f_eb03"]').val();
      fd_eb07 = $('[name="f_eb07"]').val();
      if(isNaN(fd_eb03) || fd_eb03.length<4){
        alert('『外出時間』請輸入四碼時間格式!!') ; 
        $("input[name='f_eb03']").val('');    
        $("input[name='f_eb03']").focus();
      }      
      if(fd_eb02==fd_eb06){ //外出日期=預計回程日期
        if(fd_eb07!='' && fd_eb03>fd_eb07){ //外出時間>預計回程時間
          alert("「預計回程時間」不能小於「外出時間」！");
          $("input[name='f_eb07']").val('');     
          $("[name='f_eb07']").focus(); 
        }  
      } 
      check_time(fd_eb07,'f_eb03');   
    });       
    $("[name='f_eb07']").change(function(){  //upd by 佳玟 2011.12.30  判斷預計回程時間是否大於外出時間
      fd_eb02 = $('[name="f_eb02"]').val();
      fd_eb06 = $('[name="f_eb06"]').val();    
      fd_eb03 = $('[name="f_eb03"]').val();
      fd_eb07 = $('[name="f_eb07"]').val();
      if(isNaN(fd_eb07) || fd_eb07.length<4){
        alert('『預計回程時間』請輸入四碼時間格式!!') ; 
        $("input[name='f_eb07']").val('');    
        $("input[name='f_eb07']").focus();
      }      
      if(fd_eb02==fd_eb06){ //外出日期=預計回程日期
        if(fd_eb03!='' && fd_eb03>fd_eb07){ //外出時間>預計回程時間
          alert("「預計回程時間」不能小於「外出時間」！");
          $("input[name='f_eb07']").val('');     
          $("[name='f_eb07']").focus(); 
        }  
      } 
      check_time(fd_eb07,'f_eb07');   
    });   
    //判斷預計回程時間是否大於外出時間 END ------------------------------------------//   	


    $("[name='f_eb11']").change(function(){  
      fd_eb11 = $('[name="f_eb11"]').val();  //出廠公里數
      if(isNaN(fd_eb11)){ //判斷是否為非數值
        $("input[name='f_eb11']").val('0');
      }else{
        fd_eb11 = parseInt(fd_eb11,10);
        $("input[name='f_eb11']").val(fd_eb11);      
      }
      chk_eb11(); //檢查出廠公里數
      cal_mile(); //計算里程數 
    });       
    
    $("[name='f_eb12']").change(function(){ 
      fd_eb12 = $('[name="f_eb12"]').val();  //入廠公里數  
      if(isNaN(fd_eb12)){
        $("input[name='f_eb12']").val('0');
      }else{       
        fd_eb12 = parseInt(fd_eb12,10);
        $("input[name='f_eb12']").val(fd_eb12);  
      }
      chk_eb12(); 
      cal_mile(); //計算里程數 
    }); 
    
    $("[name='f_eb14']").change(function(){ //add by 佳玟 2016.04.11 報修28769-單筆最高輸入上限為1000
      fd_eb14 = $('[name="f_eb14"]').val();  //入廠公里數  
      if(isNaN(fd_eb14)){
        $("input[name='f_eb14']").val('0');
      }else{  
        fd_eb14 = parseInt(fd_eb14,10);
        if( fd_eb14>1000 ){                    
          alert('依報修28769修改, 通行費不得大於1000!') ;
          $("input[name='f_eb14']").val('0');
        } 
        else{
          $("input[name='f_eb14']").val(fd_eb14);  
        }    
      }
    });     

    $("select[name='f_eb09']").change(function(){  //add by 佳玟 2018.10.15 陳冠威來電,蔡文鴻調車單寫錯車種要修改, 公里數不能改的問題
      fv_val = $(this).val();
      ex_val = fv_val.toString().split('.');
      switch(ex_val[0]){
        case '02':
        case '03':
        case '04':
             $("input[name='f_eb11']").attr("readonly", "");
             $("input[name='f_eb12']").attr("readonly", "");
             $("input[name='f_eb11']").attr("class", "");
             $("input[name='f_eb12']").attr("class", "");
             break;
        default:      
             $("input[name='f_eb11']").attr("readonly", "readonly");
             $("input[name='f_eb12']").attr("readonly", "readonly");
             $("input[name='f_eb11']").attr("class", "field_color");
             $("input[name='f_eb12']").attr("class", "field_color");
             $("input[name='f_eb11']").val(0);
             $("input[name='f_eb12']").val(0);
             $("input[name='f_eb13']").val(0);
             break;
      }
    }); 
    $("select[name='f_tohrm']").change(function(){
      fv_val = $("input[name='f_hrmctrl']").val();
      if( fv_val!='' ){
        alert(fv_val) ;
        $("select[name='f_tohrm']").val('N');
      }
    });
    
    //document.input_form.f_ok.style.visibility="hidden";   //隱藏原本的submit按鈕
    $("#f_ok").after("<input type='button' onmouseout='this.style.backgroundColor=&quot;&quot;' onmouseover='this.style.backgroundColor=&quot;#228B22&quot;' onblur='this.style.backgroundColor=&quot;&quot;' onfocus='this.style.backgroundColor=&quot;#228B22&quot;' value='確定"+$("#f_ok").val().substring(2,4)+"' class='btn_submit' id='f_ok_n' name='f_ok_n' style=''>");
    $("#f_ok").remove();       
    $("input[name='f_ok_n']").click(function(){     
      var url = location.href;
      var ary1 = url.split('?');
      var ary2 = ary1[1].split('&');
      var ary3 = ary2[0].split('=');
      var fv_msel = ary3[1];
      //alert(fv_msel);
      if($("input[name='f_eb01']").val()==''){
        alert('『同仁姓名』輸入有誤!!') ;
        $("input[name='f_eb01']").focus();
        return false;
      }    
      if($("input[name='f_eb18']").val()==''){
        alert('『同仁員編』輸入有誤!!') ;
        $("input[name='f_eb18']").focus();
        return false;
      }        
      if($("input[name='f_eb02']").val()==''){                   
        alert('『外出日期』輸入有誤!!') ;
        $("input[name='f_eb02']").focus();
        return false;
      }  

      if($("input[name='f_eb03']").val()==''){
        alert('『外出時間』輸入有誤!!') ;
        $("input[name='f_eb03']").focus();
        return false;
      }    
      if($("input[name='f_eb04']").val()==''){
        alert('『前往地點』輸入有誤!!') ;
        $("input[name='f_eb04']").focus();
        return false;
      }           
      if($("input[name='f_eb05']").val()==''){
        alert('『前往事由』輸入有誤!!') ;
        $("input[name='f_eb05']").focus();
        return false;
      }    
      if($("input[name='f_eb06']").val()==''){
        alert('『預計回程日期』輸入有誤!!') ;
        $("input[name='f_eb06']").focus();
        return false;
      }
      if($("input[name='f_eb07']").val()==''){
        alert('『預計回程時間』輸入有誤!!') ;
        $("input[name='f_eb07']").focus();
        return false;
      }   
      if($("input[name='f_eb16']").val()==''){
        alert('『預計回程地點』輸入有誤!!') ;
        $("input[name='f_eb16']").focus();
        return false;
      } 

      if($("select[name='f_tohrm']").val()=='-'){  //add by 佳玟 2018.03.27 報修33599-外出白板新增選項  -> 出退勤紀錄轉入HR(鼎新)
        alert('請選擇是否『出退勤紀錄轉入HR(鼎新)』!!') ;
        return false;
      }

      if($("select[name='f_eb09']").val()=='--'){
        alert('『車種』選擇有誤!!') ;
        return false;
      }
      if($("select[name='f_eb24']").val()=='--'){  
        alert('請選擇是否『往返調任地扣除30公里』!!') ;
        return false;
      }
      if($("select[name='f_eb10']").val()=='--'){
        //01.公務車 . 05.大眾交通工具 . 99.其他 . 06.公務車(併車搭乘-不借車) . 07.私車公用(併車搭乘-不請領油貼)   
        chk01 = $("select[name='f_eb09']").val().search('01.');
        chk05 = $("select[name='f_eb09']").val().search('05.');
        chk06 = $("select[name='f_eb09']").val().search('06.');
        chk07 = $("select[name='f_eb09']").val().search('07.');
        chk99 = $("select[name='f_eb09']").val().search('99.');
        if(chk01 != 0 && chk05 != 0 && chk06 != 0 && chk07 != 0 && chk99 != 0){
          alert('『排氣量』輸入有誤!!') ;
          //$("input[name='f_eb16']").focus();
          return false;  
        }
      }     
      //摩托車限定車種 
      if($("select[name='f_eb10']").val()=='06.摩托車'){
        vchk02 = $("select[name='f_eb09']").val().search('02.'); //私車公用
        vchk07 = $("select[name='f_eb09']").val().search('07.'); //私車公用
        if(vchk02 != 0 && vchk07 != 0){
          alert('『摩托車』僅能為私車公用!!') ;
          return false;
        }
      }      
      //if($("select[name='f_eb17']").val()=='--'){  mark by 佳玟 2016.04.08 報修28783 -公司以廢除120公哩程
      //  alert('請選擇『扣除標準里程』!!') ;
      //  return false;
      //}
      
      chk_eb11(); //出廠里程是否有異常 
      chk_eb12(); //入廠里程是否有異常 
      cal_mile(); //計算里程數
      if( '1'==fv_msel ){
        fv_eb04 = $("input[name='f_eb04']").val();
        fv_eb02 = $("input[name='f_eb02']").val();
        fv_eb03 = $("input[name='f_eb03']").val();
        fv_eb06 = $("input[name='f_eb06']").val();
        fv_eb07 = $("input[name='f_eb07']").val();
        fv_tohrm = $("select[name='f_tohrm']").val();
        //fv_eb08 = $("input[name='f_eb08']").val();
        if( 'Y'==fv_tohrm ){  //出退勤紀錄轉入HR(鼎新) 才需CALL 出差登記
          $.getJSON("ewb01.php", {f_eb04:fv_eb04,f_eb02:fv_eb02,f_eb03:fv_eb03,f_eb06:fv_eb06,f_eb07:fv_eb07,f_tohrm:fv_tohrm,msel:"ajax_chkhrm"},
          function(json){
            fd_json = json.toString();
            ex_json = fd_json.split(';');
            if( '0'!=ex_json[0] ){
              //alert('HRM發單驗證錯誤! 請洽各區人事。(錯誤訊息: '+ex_json[1]+')') ;
              alert('HRM發單驗證錯誤! 請確認是否與其他請假或外出時間重覆或洽各區人事。(錯誤訊息: '+ex_json[1]+')') ;
              return false;
            }else{
              setTimeout("submitform()",1000); 
            }
          });  
        }else{
          setTimeout("submitform()",1000); 
        }
      }else{
        setTimeout("submitform()",1000); 
      }
 
    });

    //$("[name='f_eb12']").change(function(){  //upd by 佳玟 2011.11.24  11/26起，輸入回程里程並轉里程簽核單，需於三日內登打完畢 
    //  fd_snum = $("[name='f_s_num']").val();
    //  u_sign3flw(fd_snum);       
    //});          
  });
  
  function submitform(){
    if(confirm("是否確定送出？")){   
      $("select[name='f_tohrm']").attr("disabled",false);
	    document.input_form.submit();
	  }
	  else{
      return false;
    }    
    //document.input_form.submit();
  }  


  function cal_mile(){ //計算里程數
    fd_eb18 = $('[name="f_eb18"]').val();  //員編
    fd_eb02 = $('[name="f_eb02"]').val();  //外出日期
    fd_eb11 = $('[name="f_eb11"]').val();  //出廠公里數
    fd_eb12 = $('[name="f_eb12"]').val();  //入廠公里數  
    if( fd_eb11!='' && fd_eb12!='' && fd_eb12!='0' ){ //出入廠公里數都有填寫
      if(isNaN(fd_eb11)){ //判斷是否為非數值
        $("input[name='f_eb11']").val('0');
      }
      if(isNaN(fd_eb12)){
        $("input[name='f_eb12']").val('0');
      }      
      
      fd_eb13 = parseInt(fd_eb12,10) - parseInt(fd_eb11,10); //add by 2012.02.14  佳玟 計算里程數
      if(isNaN(fd_eb13)){
        $("input[name='f_eb13']").val('0');
      }
      if(parseInt(fd_eb13,10)<0){
        alert("「哩程數」計算為： "+fd_eb13+" 異常，不得為負數！");
        $("input[name='f_eb12']").val('0'); //入廠公里數
        $("input[name='f_eb13']").val('0'); //哩程數        
      }else{
        $("input[name='f_eb13']").val(fd_eb13);
      }
    }else{
      $("input[name='f_eb13']").val('0'); //哩程數
    }   
  }
  function chk_eb11(){  //檢查出廠公里數
    fd_eb18 = $('[name="f_eb18"]').val();  //員編
    fd_eb11 = $('[name="f_eb11"]').val();  //出廠公里數
    fd_eb12 = $('[name="f_eb12"]').val();  //入廠公里數
    fd_eb02 = $('[name="f_eb02"]').val(); //外出日期
    fd_eb03 = $('[name="f_eb03"]').val(); //外出時間  
    //add by 佳玟  2012.05.29 重簽資料起迄是否還是為異常
    if(fd_eb11 != ''){  //不得為空值
      //外出日期, 出廠公里數, 員編 -> msel:"ajax_chk_eb11"
      $.getJSON("ewb01.php", {f_eb02:fd_eb02,f_eb11:fd_eb11,f_eb18:fd_eb18,msel:"ajax_error01_eb11"},
      function(json){
        fd_json = json.toString();
        if(fd_json!='0'){
          ex_json = fd_json.split(';');   
    	    mile1 = parseInt(ex_json[1], 10);
    	    mile2 = parseInt(fd_eb11, 10);
          if(mile2 < mile1){
          	alert("「出廠公里數」異常，需大於前筆 "+ex_json[0]+" 外出迄: "+mile1+"\n如因『換車』緣故，請忽略此訊息！"); 
            $("[name='f_eb11']").focus();
          }
        }
      });       
      //員編,出廠公里數,外出日期,外出時間 -> ajax_get_eb11
      $.getJSON("ewb01.php", {f_eb18:fd_eb18,f_eb11:fd_eb11,f_eb02:fd_eb02,f_eb03:fd_eb03,msel:"ajax_error02_eb11"},
      function(json){
        fd_json = json.toString();
        if(fd_json!='y'){
          ex_json = fd_json.split(';');   
        	alert("「出廠公里數」與前筆 "+ex_json[0]+" 外出資料出廠公里數有重覆！");
          $("input[name='f_eb11']").val('0'); 
          $("input[name='f_eb12']").val('0');
          $("input[name='f_eb13']").val('0');    
          $("[name='f_eb11']").focus();
        }
      });  
    }      
  }
  function chk_eb12(){  //檢查出廠公里數
    fd_eb18 = $('[name="f_eb18"]').val();  //員編
    fd_eb11 = $('[name="f_eb11"]').val();  //出廠公里數
    fd_eb12 = $('[name="f_eb12"]').val();  //入廠公里數
    fd_eb02 = $('[name="f_eb02"]').val(); //外出日期
    fd_eb03 = $('[name="f_eb03"]').val(); //外出時間  
    if(fd_eb12 != ''){  //不得為空值
      $.getJSON("ewb01.php", {f_eb02:fd_eb02,f_eb12:fd_eb12,f_eb18:fd_eb18,msel:"ajax_chk_eb12"},
      function(json){
        fd_json = json.toString();
        if(fd_json != '0'){
          ex_json = fd_json.split(';');  
      	  mile1 = parseInt(ex_json[1], 10);
      	  mile2 = parseInt(fd_eb12, 10);
          if(mile2 > mile1){
           	alert("「入廠公里數」異常，需小於後筆 "+ex_json[0]+" 外出起: "+mile1);
            $("input[name='f_eb12']").val('0');
            $("input[name='f_eb12']").val('0');     
            $("[name='f_eb12']").focus();
          }
        }
      });
    } 
  }


  function check_time(fd_time,fd_key){  //檢查時間格式
    if(fd_time.length == 4){  //是否為4碼
      var str = fd_time.toString();
      var h = str.slice(0,2);  //時
      var m = str.slice(2,4);  //分 
      if(h<'00' || h>'23'){
        alert("時間格式不符!!");
        $('input[name="'+fd_key+'"]').val('');
        $('[name="'+fd_key+'"]').focus(); 
              
      }
      if(m<'0' || m>'59'){
        alert("時間格式不符!!");
        $('input[name="'+fd_key+'"]').val('');
        $('[name="'+fd_key+'"]').focus();         
      } 
    }  
  }
  
  function check_data(fd_date,fd_key){  //檢查日期格式
	  if(fd_date.length == 8){  //是否為8碼
      var str = fd_date.toString();
      var big_month = new Array("01", "03", "05", "07", "08", "10", "12");   // 大月 d <32
      var small_month = new Array("02", "04", "06", "09", "11");             // 小月 d <31
      //alert(big_month[1]);
      var y = str.slice(0,4);  //年
      var m = str.slice(4,6);  //月 
      var d = str.slice(6,8);  //日
      if(!(parseInt(y, 10) > 0) || !(parseInt(m, 10) > 0 && parseInt(m, 10) < 13)){    //年、月判斷
        alert("日期格式不符!!");
        $('input[name="'+fd_key+'"]').val('');
        $('[name="'+fd_key+'"]').focus();     
      }
      else{    //日、判斷
        for(var i = 0; i < big_month.length; i++){   //大月
          if(m == big_month[i]){
            if(!(parseInt(d, 10) > 0 && parseInt(d, 10) < 32)){
              alert("日期格式不符!!");
              $('input[name="'+fd_key+'"]').val('');
              $('[name="'+fd_key+'"]').focus();              
            }
          }
        }
        for(var i = 0; i < small_month.length; i++){  //小月
          if(m == small_month[i]){
            if(m == small_month[0]){  //2月，判斷是否為閏年
              
              if((parseInt(y, 10)%4==0 && parseInt(y, 10)%100!=0) || (parseInt(y, 10)%400==0)){
                if(!(parseInt(d, 10) > 0 && parseInt(d, 10) < 30)){   //閏年
                  alert("日期格式不符!!");
                  $('input[name="'+fd_key+'"]').val('');
                  $('[name="'+fd_key+'"]').focus(); 
                }
              }
              else{   //非閏年
                if(!(parseInt(d, 10) > 0 && parseInt(d, 10) < 29)){
                  alert("日期格式不符!!");
                  $('input[name="'+fd_key+'"]').val('');
                  $('[name="'+fd_key+'"]').focus(); 
                }
              }             
            }
            else{  //非2月份(其他小月)               
              if(!(parseInt(d, 10) > 0 && parseInt(d, 10) < 31)){
                alert("日期格式不符!!"); 
                $('input[name="'+fd_key+'"]').val('');
                $('[name="'+fd_key+'"]').focus();           
              }
            }
          }
        }        
      }
    }else{
      alert("日期格式不符!!"); 
      $('input[name="'+fd_key+'"]').val('');
      $('[name="'+fd_key+'"]').focus();       
    }
  }
      
  function u_empno1() {
    str1 = $("[name='f_eb01']").val();
    str2 = $("[name='f_eb01']").val().split('-');
    $("input[name='f_eb18']").val(str2[0]);
    $("input[name='f_eb01']").val(str2[1]);
//    if(str2[2]=='Y'){
//      $("select[name='f_eb17']").val(str2[2]);
//      document.input_form.f_eb17.disabled = true;  //upd by 佳玟 2011.10.17 如例外人員有設定扣除里程為 Y 者，則鎖住欄位不能修改 
//    }else{
//      $("select[name='f_eb17']").val(str2[2]);
//      document.input_form.f_eb17.disabled = false;
//    }
  }
  function u_empno2() {
    str1 = $("[name='f_empno']").val();
    str2 = $("[name='f_empno']").val().split(';');
    $("input[name='f_empno']").val(str2[0]);
    $("input[name='f_car']").val(str2[2]);
    $("input[name='f_card']").val(str2[3]);
  }  
  
//  function u_sign3flw(fd_snum){  //搜尋區別部門  
//    fd_eb02 = $("[name='f_eb02']").val();  
//    //alert(fd_eb02);  
//    if(fd_eb02>='20111126'){
//      $.getJSON("ewb01.php",
//        {f_snum:fd_snum,msel:"ajax_get_eb12"},
//        function(json){
//          //var fd_ndate = new Date(); 
//          //var fd_now = u_date(fd_ndate);        
//          fd_str = $("[name='f_ndate']").val(); //現在日期
//          var ar_ndate = fd_str.split('-');
//          var fd_ndate = new Date(parseInt(ar_ndate[0], 10),
//                                  parseInt(ar_ndate[1], 10) - 1,
//                                  parseInt(ar_ndate[2], 10)); 
//          var fd_ndate2 = u_date(fd_ndate);               
//          //alert("現在日期: "+fd_ndate2);   
//
//          qa = json.toString();  //upd by 佳玟 2011.12.12 (報修-15683)開放高永民 7966431 修改里程  11/28.11/29.12/2
//          qa2 = qa.split(';');
//          str_date = qa2[0].substring(0,10);  
//          //str_date = json.substring(0,10);
//          var ar_sdate = str_date.split('-');
//          var fd_sdate = new Date(parseInt(ar_sdate[0], 10),
//                                  parseInt(ar_sdate[1], 10) - 1,
//                                  parseInt(ar_sdate[2], 10));  
//          var fd_sdate2 = u_date(fd_sdate);  
//
//          str_eb06 = qa2[2];  //add by 佳玟 2011.12.22 如預計回程日期大於簽核日期，則以預計回程日期為主
//          var ar_eb06 = str_eb06.split('-');
//          var fd_eb06 = new Date(parseInt(ar_eb06[0], 10),
//                                  parseInt(ar_eb06[1], 10) - 1,
//                                  parseInt(ar_eb06[2], 10));  
//          var fd_eb062 = u_date(fd_eb06);  
//        
//          
//          //alert("簽核: "+fd_ndate2+"****"+qa2[1]);
//          if((qa2[1]=='119093' || qa2[1]=='119206' || qa2[1]=='119566') && fd_ndate2<'20111214'){ //upd by 佳玟 2011.12.12 (報修-15683)開放高永民 7966431 修改里程  11/28.11/29.12/2
//            qa_upd = "Y";
//          }else{
//            qa_upd = "N";
//          }
//          //upd by 佳玟 2011.12.16 (報修-15743)開放江宗樺 0883168 修改里程  11/28,11/29,12/05,12/07,12/08,12/12
//          //'119167','119198','119771','119935','120146','120390' <- ewb01.s_num
//          if((qa2[1]=='119167' || qa2[1]=='119198' || qa2[1]=='119771' || qa2[1]=='119935' || qa2[1]=='120146' || qa2[1]=='120390') && fd_ndate2<'20111221'){ 
//            qa_upd = "Y";
//          }else{
//            qa_upd = "N";
//          }       
//          //alert("簽核: "+fd_sdate2);
//          if(fd_eb062>fd_sdate2){ //add by 佳玟 2011.12.22 如預計回程日期大於簽核日期，則以預計回程日期為主
//            fd_sdate2 = fd_eb062; 
//          }
//          $.getJSON("ewb01.php",
//            {f_sd:fd_sdate2,msel:"ajax_get_day"},   //f_sd 簽核日期
//            function(json2){
//              //alert(json2);
//              dd = json2.toString();
//              msg = dd.substring(0,4)+'-'+dd.substring(4,6)+'-'+dd.substring(6);                 
//              //alert("三天後: "+json2);     
//              //if(fd_ndate2>=json2 && qa_upd=='N'){  //如現在日期大於建檔以及修改日期，則不能輸入哩程
//              //  $("input[name='f_eb12']").val(0);
//              //  $("input[name='f_eb13']").val(0);
//              //  alert("已於12/26實施，輸入回程里程並轉里程簽核單，需於三日內登打完畢。\n本外出應於"+msg+"前登打完成！");
//              //}                                
//            }               
//          );         
//        }        
//      );  
//    }              
//  }
  function u_date(fd_date) {
    var fd_y = fd_date.getFullYear().toString();                        
    var fd_m = fd_date.getMonth()+1;
    var fd_d = fd_date.getDate();
    //var fd_day = fd_date.getDay(); //星期
    
    if(fd_m<10){
      fd_m="0"+fd_m.toString();
    }           
    if(fd_d<10){
      fd_d="0"+fd_d.toString();
    }    
    var fd_cdate = fd_y + fd_m + fd_d; 
    return fd_cdate;
  }       
  </script>
  <!-- END IGNORE -->
<!-- END BLOCK : fd_script_eb01 -->

<style type="text/css">
/* autocomlate-style */
.ac_results {
  padding: 0px;
  border: 1px solid WindowFrame;
  background-color: Window;
  overflow: hidden;
}
.ac_results ul {
  width: 100%;
  list-style-position: outside;
  list-style: none;
  padding: 0;
  margin: 0;
}
.ac_results iframe {
  display:none;/*sorry for IE5*/
  display/**/:block;/*sorry for IE5*/
  position:absolute;
  top:0;
  left:0;
  z-index:-1;
  filter:mask();
  width:3000px;
  height:3000px;
}
.ac_results li {
  margin: 0px;
  padding: 2px 5px;
  cursor: pointer;
  display: block;
  width: 100%;
  font-family: "細明體", "Courier New", Arial;
  font-size: 12px;
  overflow: hidden;
}
.ac_loading {
  background : Window url('indicator.gif') right center no-repeat;
}
.ac_over {
  background-color: Highlight;
  color: HighlightText;
}


/*列印的button按鈕*/
.css_btn_class {
	font-size:16px;
	font-family:Arial Black;
	font-weight:normal;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
	border:1px solid #d02718;
	padding:9px 18px;
	text-decoration:none;
	background:-moz-linear-gradient( center top, #f24537 5%, #c62d1f 100% );
	background:-ms-linear-gradient( top, #f24537 5%, #c62d1f 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f24537', endColorstr='#c62d1f');
	background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #f24537), color-stop(100%, #c62d1f) );
	background-color:#f24537;
	color:#ffffff;
	display:inline-block;
	text-shadow:1px 1px 0px #810e05;
 	-webkit-box-shadow:inset 1px 1px 0px 0px #f5978e;
 	-moz-box-shadow:inset 1px 1px 0px 0px #f5978e;
 	box-shadow:inset 1px 1px 0px 0px #f5978e;
}.css_btn_class:hover {
	background:-moz-linear-gradient( center top, #c62d1f 5%, #f24537 100% );
	background:-ms-linear-gradient( top, #c62d1f 5%, #f24537 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#c62d1f', endColorstr='#f24537');
	background:-webkit-gradient( linear, left top, left bottom, color-stop(5%, #c62d1f), color-stop(100%, #f24537) );
	background-color:#c62d1f;
}.css_btn_class:active {
	position:relative;
	top:1px;
}
table.talbeprn{
	font-family: Times New Roman,arial;
	border-collapse:collapse;
	margin-left:auto; 
  margin-right:auto;
	border-spacing:1px;
	color:#000;
	width:100%;
}
table.talbeprn th{ 
	border:1px solid #CCC;
	/*border:1px solid #523A0B;    */
	/*border-width:1px 0;*/
	background:#A5BED7;  /*8DBDD8*/
}
table.talbeprn td{ 
	border:1px solid #CCC;
	border-width:1px;
}
table.talbeprn tr.odd td {
	background:#F7F4EE;
	border-color:#8A8A8A;
}
table.talbeprn tr:hover td{
	background:#FEF6CE;
  border-color:#8A8A8A; 
  border-style:dotted;
}
</style>
<!-- START BLOCK : tb_sel_link -->
   <table width="100%" border="0" cellpadding="1" cellspacing="1" class="font">
     <tr>
       <td>
         <div align="left">
           <a href="{tv_add}"  >新增</a>&nbsp;|&nbsp;
           <a href="{tv_list}" >瀏覽</a>&nbsp;|&nbsp;
           <a href="{tv_que}"  >查詢</a>&nbsp;|&nbsp;
           <a href="/~docs/ewb/ewb01.php?msel=9">今日外出</a>&nbsp;|&nbsp;
           <a href="{tv_prn}">列印</a>&nbsp;|&nbsp;
           <!--<a href="/~docs/ewb/ewb02.php">多筆哩程輸入</a>&nbsp;&nbsp;-->
           <a href="/~docs/ewb/ewb01.php?msel=7&num=2">私車公用明細</a>&nbsp;|&nbsp;
           <a href="/~docs/ewb/ewb_rpt03.php">部門同仁外出明細表</a>&nbsp;|&nbsp;
           <a href="/~docs/ewb/ewb_rpt09v2.php">部屬外出明細表</a>&nbsp;|&nbsp;  
           <a href="/~docs/ewb/ewb_rpt04.php">查詢重簽外出資料</a>&nbsp;|&nbsp;   
           <a href="/~docs/ewb/ewb_rpt07.php">外出簽核狀態明細表</a>        
           
           <!--
           <span style="cursor:hand" onClick="p1.style.display=p1.style.display=='none'?'':'none'">
             <a href="#"> 管理</a></font><br> 
             <div id="p1" style="display:none; background-color: #CDDDED;  width: 280;" align="center">&nbsp;&nbsp;&nbsp;
               <a href="{tv_prn}">列印</a>&nbsp;&nbsp;|&nbsp;&nbsp;
               <a href="/~docs/ewb/ewb01.php?msel=7&num=2">私車公用統計</a>&nbsp;&nbsp;|&nbsp;&nbsp;
               <a href="/~docs/ewb/ewb_rpt03.php">部門同仁外出明細表</a>
             </div> 
           </span>
           -->                      
           </div></td>
           <!--br-->
       <td><div align="right">
           <a href="/~docs/ewb/ewb01.php?msel=4&f_eb01={tv_vname}&f_dateb={tv_dateb}&f_datee={tv_datee}&f_sname={tv_dept_id}" ><img src='/~sl/img/user.png' border='0' title='查詢一個月內個人外出資料'></a>
           <a>廠部別：</a>
           <!-- START BLOCK : tb_select_statu -->
            <select name="f_change1" onchange="location.href = '{tv_change1}'+this.value"> 
               <!-- START BLOCK : tv_option1 -->
                <option value="{tv_value}">{tv_show}</option>
               <!-- END BLOCK : tv_option1 --> 
            </select>
            <script language="JavaScript">
                f_change1.value="{tv_f_change}";
            </script>
          <!-- END BLOCK : tb_select_statu -->
          &nbsp;&nbsp;
           <a href="{tv_up_page}">上頁</a>&nbsp;|&nbsp;
           <a href="{tv_dn_page}">下頁</a>&nbsp;|&nbsp;
           <a href="{tv_del_n}" title="列出未作廢的資料...">未廢</a>&nbsp;|&nbsp;
           <a href="{tv_del_y}" title="列出已作廢的資料...">已廢</a>&nbsp;|&nbsp;
           <a href="{tv_del_a}" title="列出所有的資料..."  >全部</a>
         </div>
       </td>
     </tr>
   </table>
<!-- END BLOCK : tb_sel_link -->


<!-- START BLOCK : tb_btn -->
  
  <a href={tv_link} ><img src='./img/ewb01.gif' border='0' height="45" width="120" ></a>
   <!--  name='exitpic' 
  <a href="{tv_link}" class="css_btn_class">列印-調車單</a>
  -->
<!-- END BLOCK : tb_btn -->

<!-- INCLUDE BLOCK : tb_sl_tpl_1 -->

<!-- START BLOCK : tb_text_ndate -->
  <!--add by 佳玟 2011.11.24 11/26起，輸入回程里程並轉里程簽核單，需於三日內登打完畢-->
  <input name="f_ndate" type="hidden" value="{tv_value}">  <!--現在伺服器時間-->
<!-- END BLOCK : tb_text_ndate -->


<!-- START BLOCK : tp_in_prn_7 -->
<br><br>
    <table border="1" width="550" " align="center" border="1" cellpadding="1" cellspacing="0" class="font" bordercolorlight="#111111" bordercolordark="#111111" style="border-collapse: collapse" height="112">
     <form action="{tv_action}" method="POST" enctype="multipart/form-data" name="input_form"
                                                      onsubmit="
                                                                {tv_js_rule}
                                                                return(submitonce(this));
                                                                ">
        <tr> 
      <td  colspan=2 height="50" align="center" valign="middle" width="60%"> <div align=center><font size="2" color="#333333">{tv_title}</font></div></td>
    </tr>
    <!-- START BLOCK : tb_in_que_hr_tr -->
    <tr > 
      <td width="100" height="30" align="center" valign="middle" >
        <p align="right"><font size="2" color="#333333">{tv_cname}：</font></p>
      </td>
      <td width="450" height="30" align="center" valign="middle" >
      <p align="left">&nbsp;        
        <font size="2" color="#333333">
          <!-- START BLOCK : tb_select_hr -->
            <select name="{tv_sname}" id="{tv_sname}" {tv_readonly}> 
               <!-- START BLOCK : tv_option_hr -->
                <option value="{tv_value}" {tv_selected}>{tv_show}</option>
               <!-- END BLOCK : tv_option_hr --> 
            </select>
          <!-- END BLOCK : tb_select_hr -->
                      
          <!-- START BLOCK : tb_text_hr -->
             <input name="{tv_ename}" type="text" value="{tv_value}" size="{tv_size}" maxlength="{tv_maxlength}" {tv_readonly} class="{tv_class}">
          <!-- END BLOCK : tb_text_hr -->
          
          <!-- START BLOCK : tb_date_hr -->
            <script type="text/javascript">$(document).ready(function(){$('#f_dateb').calendar({dateFormat: 'YMD'});});</script>
            <input name="f_dateb" type="text" value="{tp_dateb}" size="8" maxlength="8" {tv_readonly} id="f_dateb" class="{tv_class}">
              </font>～<font color="#0000FF">
            <script type="text/javascript">$(document).ready(function(){$('#f_datee').calendar({dateFormat: 'YMD'});});</script>
            <input name="f_datee" type="text" value="{tp_datee}" size="8" maxlength="8" {tv_readonly} id="f_datee" class="{tv_class}">
          <!-- END BLOCK : tb_date_hr -->

          
          <font size="2" color="#0000ff">{tv_memo}</font></p>
        </font>
      </td>
    </tr>
    <!-- END BLOCK : tb_in_que_hr_tr -->
    <tr >
      <td colspan=2 height="30" align="center" valign="middle" width="60%"> 
      <input type="submit" class="buttonprint" value="確定" name="B1"> 
      </td>
    </tr>
     </form>
   </table>
   <!-- START BLOCK : tb_memo -->
   <p align="center">  　
   <table class="font" style="BORDER-COLLAPSE: collapse" height="32" cellSpacing="0" borderColorDark="#FF9966" cellPadding="1" width="600" align="center" borderColorLight="#FF9966" border="1" >     
     <tr>
       <td width="100%" height="28" bordercolor="#FF9966" bgcolor="#FFFF99">
         <p align="center"><font size="4"><font color="#FF0000"><b>注意!!</b></font>本統計表僅列出車種為【私車公用】、【受公司補助購車】<br>外出簽核單狀態為【<font color=red>簽核中</font>】、【已抽單】或【不同意】者，將不會顯示！<br>【里程簽核單】同意後，才算簽核結束！</font></p>
       </td>
     </tr>
   </table>
   <!-- END BLOCK : tb_memo -->
   
   <br>
<!-- END BLOCK : tp_in_prn_7 -->

<!-- START BLOCK : tp_prn -->

	<!-- START BLOCK : tp_prn_head -->
	<h2>{tp_title}</h2>
<font size="3">          日期起訖:{tp_dateb}～{tp_datee}
	<hr width="640" align="left">
	<!-- END BLOCK : tp_prn_head -->
	<!-- START BLOCK : tp_prn_body -->
		<table width="630" border="0">
		<tr>
		  <td >{tp_b_date}</td>
		</tr>
		
		<tr>
		  <td colspan="9"><pre>{tp_qah_5}</pre></td>
		</tr>
		</table>
			<!-- START BLOCK : tp_prn_body_jump -->
				-[接下頁]-----------------------------------------------------------------------------------------------------
				<br class="pageBreak">
			<!-- END BLOCK : tp_prn_body_jump --> 
	<!-- END BLOCK : tp_prn_body -->
	
</font>                  
<!-- END BLOCK : tp_prn -->

<!-- START BLOCK : tb_list_prn -->
  <!-- START BLOCK : tb_title -->
  <table border="0" width="100%">
    <tr>
      <td width="55%">
        <p align="right">　<font face="標楷體" size="5"><b>山隆公司-私車公用耗油明細表</b></font></p>
      </td>
      <td width="35%">
        <p align="right"><font face="標楷體" size="3"><b>卡號：{tv_card}</b></font></p>
      </td>
    </tr>  </table>
  <table border="0" width="100%">
   <tr>
    <td width="15%" align="left">申請人：{tv_name}</td>
    <td width="15%" align="left">車號：{tv_car}</td>
    <td width="18%" align="left">排氣量：{tv_eb10}</td>
    <td width="13%" align="left">固定油貼：{tv_set}</td> 
    <td width="40%" align="right">起迄日期：{tv_date1}～{tv_date2}</td>
    </tr>
  </table>
  <!-- START BLOCK : tb_body -->
    <table border="1"  align="center" border="1" cellpadding="1" cellspacing="0" class="font" bordercolorlight="#111111" bordercolordark="#111111" style="border-collapse: collapse" width="100%">
      <tr>
        <td width="7%" rowspan="2" align="center">日期</td>
        <td width="16%" colspan="2" align="center">出差行區間</td>
        <td width="7%" rowspan="2" align="center">行駛<br>哩程<br>(A)</td>
        <td width="6%" rowspan="2" align="center">車輛<br>耗油<br>(B)</td>
        <td width="8%" rowspan="2" align="center">應申領<br>油料<br>(C)</td>
        <td width="6%" rowspan="2" align="center">九五<br>單價<br>(D)</td>
        <td width="8%" rowspan="2" align="center">應申請<br>金額<br>(E)</td>
        <!-- <width="3%" rowspan="2" align="center">路票</td> -->
        <td width="4%" rowspan="2" align="center">申報加班時數</td>  <!-- upd by 2014.12.01 報修25124 -->
        <td width="3%" rowspan="2" align="center">通行費</td>   <!-- add by 2014.01.03 (報修22108)計程通行費-->
        <td width="9%" rowspan="2" align="center">前往地點</td>
        <td width="22%" rowspan="2" align="center">事由</td>
      </tr>
      <tr>
        <td width="8%" align="center">起</td>
        <td width="8%" align="center">迄</td>
      </tr>
      <!-- START BLOCK : tb_body_tr -->
      <tr>
        <td  align="center"style="{tv_style}">{tv_eb02}</td>
        <td  align="right" style="{tv_style}">{tv_eb11}</td>
        <td  align="right" style="{tv_style}">{tv_eb12}</td>
        <td  align="right" style="{tv_style}">{tv_eb13}</td>
        <td  align="right" style="{tv_style}">{tv_litre}</td>
        <td  align="right" style="{tv_style}">{tv_gast}</td>
        <td  align="right" style="{tv_style}">{tv_cost}</td>
        <td  align="right" style="{tv_style}">{tv_lpsum}</td>
        <!-- <td  align="right" style="{tv_style}">{tv_eb14}&nbsp;</td> -->
        <td  align="right" style="{tv_style}">{tv_eb141}&nbsp;</td>
        <td  align="right" style="{tv_style}">{tv_eb142}&nbsp;</td> <!-- add by 2014.01.03 (報修22108)計程通行費-->        
        <td  align="left"  style="{tv_style}"><font size='1'>&nbsp;{tv_eb04}</font></td>
        <td  align="left"  style="{tv_style}"><font size='1'>&nbsp;{tv_eb05}</font></td>
      </tr>
      <!-- END BLOCK : tb_body_tr -->
      <!-- START BLOCK : tb_body_addcut -->
      <tr>
        <td  align="center" style="{tv_style}">加減金額</td>
        <td  align="right" style="{tv_style}" colspan='6'>{tv_ac06}</td>
        <td  align="right" style="{tv_style}">{tv_ac05}</td>
        <td  align="right" style="{tv_style}" colspan='4'></td>
      </tr>
      <!-- END BLOCK : tb_body_addcut -->      
      <!-- START BLOCK : tb_body_tol -->
      <tr bgcolor="#000000" height="2"><td colspan="99"></td></tr>
      <tr>
        <td  colspan="2">{tv_count}</td>
        <td  align="right">總計</td>
        <td  align="right">{tv_eb13}</td>
        <td  align="right">{tv_litre}&nbsp;</td>
        <td  align="right">{tv_gast}</td>
        <td  align="right">{tv_cost}&nbsp;</td>
        <td  align="right">{tv_lpsum}</td>
        <!-- <td  align="right">{tv_eb14}&nbsp;</td> -->
        <td  align="right">{tv_eb141}&nbsp;</td>
        <td  align="right">{tv_eb142}&nbsp;</td> <!-- add by 2014.01.03 (報修22108)計程通行費-->        
        <td colspan="2" >　</td>
      </tr>
      <!-- END BLOCK : tb_body_tol -->
    </table>
    <!-- START BLOCK : tb_jump_page -->  
    <pre>----接下頁-----------------------------------------------------------------------------------------------------------------------------------</pre>
    <br><div STYLE='page-break-after: always;'>  </div>
    <!-- END BLOCK : tb_jump_page -->
  <!-- END BLOCK : tb_body -->
  <!-- END BLOCK : tb_title -->

  <!-- START BLOCK : tb_body_final -->
   <table  border="1"  align="center" border="1" cellpadding="1" cellspacing="0" class="font" bordercolorlight="#111111" bordercolordark="#111111" style="border-collapse: collapse" width="100%">
    <tr bgcolor="#000000" height="3"><td colspan="99"></td></tr>
    <tr><td colspan="99"><font color='#0000ff'>
                         ＊ <font color='#ff0000'>＠</font>=受公司補助購車維修費【<font color='#ff0000'>自行支付</font>】行駛里程數超過1200公里之部份概以<font color='#ff0000'>4 KM/L</font>計算其油量。 <br>
                         ＊ <font color='#ff0000'>＃</font>= 該筆有扣除標準里程120公里。<br>
                         ＊ <font style="text-decoration: line-through; color: #C0C0C0; background-color: #FF0000">紅底灰字</font>= 該筆油價尚未轉入。<br>
                         ＊ 應申領油料(C) = 行駛哩程((A) ÷ 車輛耗油(B)<br>
                         ＊ 應申請金額(E) = 應申領油料(C) × 九五單價(D)【當日】<br>
                         ＊ 如車輛耗油顯示為<font color='#ff0000'>空值</font>，表示此筆排氣量未設定無法計算。<br>
                         <font color='#ff0000'>＊</font> 出差行區間，在『起』的地方有<font color='#ff0000'>*</font>，表示外出日『起』小於上一個外出日的『迄』，如資料為第一筆，表示上個月的迄有誤。<br>
                         <font color='#ff0000'>＊</font> 出差行區間，在『起』的地方有<font color='#4F8917'>&nbsp;x&nbsp;</font>，表示油貼尚未核准(未轉檔)。
                         <!-- (<u><b>核準後，於次月10~15日之間給點</b></u>) upd by 佳玟 2013.07.08 陳誌煌來電，此提示移除，因為他說無公告說10~15之間會給點 --><br>
                         <!--＊ <font style="color: #000000;background-color: #CCEEFF">藍底黑字</font>，表示此筆外出<font color='#ff0000'>簽核中</font>(<font color='#ff0000'>里程簽核單</font>同意者，才算簽核結束！)。<br></font>--></td></tr>
    <tr bgcolor="#000000" height="3"><td colspan="99"></td></tr>
    <tr>                                                               
      <td width="15%" rowspan="4"><p align="center">油 料 補 助 標 準</td>
      <td width="24%" colspan="2" align="center">車種</td>
      <td width="10%" align="center">摩托車</td>
      <td width="10%" align="center">1300CC以下</td>
      <td width="10%" align="center">1300-1500CC</td>
      <td width="10%" align="center">1501-1800CC</td>
      <td width="10%" align="center">1801-2000CC</td>
      <td width="10%" align="center">2001CC以上</td>
    </tr>
    <tr>
      <td width="24%" colspan="2" align="center"><p align="center">私車公用</td>
      <!--  <td width="10%" align="center">20KM/L</td> -->
      <td width="10%" align="center">10KM/L</td>   <!-- upd by 佳玟 2016.01.12 報修28170-原級距摩托車: 20KM, 元月一日起更改為 10KM -->
      <td width="10%" align="center">4&nbsp; KM/L</td>
      <td width="10%" align="center">4&nbsp; KM/L</td>
      <td width="10%" align="center">4&nbsp; KM/L</td>
      <td width="10%" align="center">4&nbsp; KM/L</td>
      <td width="10%" align="center">4&nbsp; KM/L</td>
    </tr>
    <tr>
      <td width="24%" colspan="2" align="center">受公司補助購車<br>維修費<font color="#0000ff">公司支付</font></td>
      <td width="10%" align="center"></td>
      <td width="10%" align="center">13 KM/L</td>
      <td width="10%" align="center">12 KM/L</td>
      <td width="10%" align="center">11 KM/L</td>
      <td width="10%" align="center">10 KM/L</td>
      <td width="10%" align="center">9&nbsp; KM/L</td>
    </tr>  
    <tr>
      <td width="24%" colspan="2" align="center">受公司補助購車<br>維修費<font color="#0000ff">自行支付</font></td>
      <td width="10%" align="center"></td>
      <td width="10%" align="center">10 KM/L</td>
      <td width="10%" align="center">9&nbsp; KM/L</td>
      <td width="10%" align="center">8&nbsp; KM/L</td>
      <td width="10%" align="center">7&nbsp; KM/L</td>
      <td width="10%" align="center">6&nbsp; KM/L</td>
    </tr>  
  </table>
  <br>
  <table border="0" width="100%" height="19">
    <tr>
      <td width="20%" height="15">駐廠稽核：</td>
      <td width="20%" height="15">單位主管：</td>
      <td width="20%" height="15">直屬主管：</td>
      <td width="20%" height="15">
        <p align="right">申請人：{tv_wman}</td>
      <td width="20%" height="15">
        <p align="right">製表人：{tv_man}</td>
    </tr>
  </table>
  <!-- END BLOCK : tb_body_final -->
<!-- END BLOCK : tb_list_prn -->


<!-- START BLOCK : tb_list_prn2 -->
<table border="0" width="100%" height="70" align="center">
  <tr>
    <td width="100%" colspan="2" valign="middle" align="center" height="41"><font face="標楷體" size="6">調　　　車　　　單</font></td>
  </tr>
  <tr>
    <td width="65%" height="21">
      <p align="left">申請單位：<b><font face="標楷體" size="3">{tv_dept_name}</font></b></p>
    </td>
    <td width="35%" height="21">
      <p align="right"><b><font face="標楷體" size="3">&nbsp;{tv_b_date}</font></b></td>
  </tr>
</table>

<table  border="1"  align="center" border="1" cellpadding="1" cellspacing="0" class="font" bordercolorlight="#111111" bordercolordark="#111111" style="border-collapse: collapse" width="100%" height="68"> 
  <tr>
    <td width="11%" height="39" align="center">預定時間</td>
    <td width="89%" colspan="3" height="39">
    
    　　出：　<b><font face="標楷體" size="3">{tv_eb02}　{tv_eb03}</font></b>　<br>
    　　　　　　　　　　　　　　　　　共：<b><font face="標楷體" size="3">{tv_dif}</font></b>　　<br>
    　　入：　<b><font face="標楷體" size="3">{tv_eb06}　{tv_eb07}</font></b>
    
    </td>
  </tr>
  <tr>
    <td width="11%" height="35" align="center">事　　由</td>
    <td width="54%" height="35">　　<b><font face="標楷體" size="3">{tv_eb05}</font></b>&nbsp;</td>
    <td width="10%" height="35" align="center">乘車人數</td>
    <td width="25%" height="35">　　<b><font face="標楷體" size="3">{tv_eb15}</font></b>&nbsp;</td>
  </tr>
  <tr>
    <td width="11%" height="36" align="center">擬往地點</td>
    <td width="54%" height="36">　　<b><font face="標楷體" size="3">{tv_eb04}</font></b>&nbsp;</td>
    <td width="10%" height="36" align="center">
      <p align="center">駕駛簽章</p>
    </td>
    <td width="25%" height="36">　</td>
  </tr>
</table>
<table border="0" width="100%" height="76" align="center">
  <tr>
    <td width="60%" height="70">單位主管核准：</td>
    <td width="40%" height="70">
      <p>申請人：<b><font face="標楷體" size="3">{tv_eb01}</font></b></td>
  </tr>
</table>


<table  border="1"  align="center" border="1" cellpadding="1" cellspacing="0" class="font" bordercolorlight="#111111" bordercolordark="#111111" style="border-collapse: collapse" width="100%" height="122">
  <tr>
    <td width="66%" height="65" colspan="4">
      <p align="left"><b><font face="標楷體" size="3">{tv_eb09_1}</font></b>公車 
      No.<br>  
      <br><b><font face="標楷體" size="3">{tv_eb09_2}</font></b>私車車號：{tv_car_id}　　　　　　　　　　　排氣量：<b><font face="標楷體" size="3">{tv_eb10}</font></b></p>
    </td>
    <td width="9%" height="65">
      <p align="center">庶<br>務<br>簽<br>派</p>
    </td>
    <td width="25%" height="65">　</td>
  </tr>
  <tr>
    <td width="4%" height="49">
      <p align="center">出<br>廠</p>
    </td>
    <td width="29%" height="49">時　間：<br>
      <br>
      公里數：<b><font face="標楷體" size="3">{tv_eb11}</font></b></td>
    <td width="4%" height="49">
      <p align="center">入<br>廠</p>
    </td>
    <td width="29%" height="49">時　間：<br>
      <br>
      公里數：<b><font face="標楷體" size="3">{tv_eb12}</font></b></td>
    <td width="9%" height="49">
      <p align="center">守<br>衛</p>
    </td>
    <td width="25%" height="49">　</td>
  </tr>
</table>
<p align="right">製表日期:{tv_prn_date}　　SL-B013　　50P　　</p>
<!-- END BLOCK : tb_list_prn2 -->




<!-- START BLOCK : tb_list_today_prn -->
  <!-- START BLOCK : tb_title_today_prn -->
  <table border="0" width="100%">
    <tr>
      <td>
        <p align="left"><font face="標楷體" size="5"><b>今日外出 <font face="標楷體" size="3">({tv_today})</font></b></font></p>
      </td>
    </tr>
    <tr>
      <td>
        <A HREF='ewb01.php?msel=9&fd_area=0'>全部</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S1'>總管理處</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S25'>北區管理課</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S26'>中區管理課</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S28'>南區管理課</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S35'>北區油品</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S36'>中區油品</A> |
        <A HREF='ewb01.php?msel=9&fd_area=S38'>南區油品</A> |
        <A HREF='ewb01.php?msel=9&fd_area=E1'>船務報關</A> |
        <A HREF='ewb01.php?msel=9&fd_area=T1'>山隆生技</A><br><br>
      </td>
    </tr>  
  </table>
  <!-- END BLOCK : tb_title_today_prn -->
  <table class="talbeprn">
    <tr>
      <th align="center" width="2%">序</th>
      <th align="center" width="6%">廠部別</th>
      <th align="center" width="6%">部門別</th>
      <th align="center" width="6%">同仁姓名</th>
      <th align="center" width="8%"><A HREF='ewb01.php?msel=9&fd_area={tv_area}&fd_ord={tv_ord}'>外出時數<A></th>
      <th align="center" width="6%">外出日期</th>
      <th align="center" width="6%">外出時間</th>
      <th align="center" width="12%">前往地點</th>
      <th align="center" width="17%">外出事由</th>
      <th align="center" width="6%">回程日期</th>
      <th align="center" width="6%">回程時間</th>
      <th align="center" width="8%">回程地點</th>
      <th align="center">備註</th>
    </tr>                                                   
    <tbody>
      <!-- START BLOCK : tb_body_today_prn -->
      <tr>
        <td align="right"><font color='{tv_fcolor}'>{tv_num}</font></td>    <!-- 序 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_dept1}</font></td>  <!-- 廠部別 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_dept2}</font></td>  <!-- 部門別 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_name}</font></td>   <!-- 同仁姓名 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_hr}</font></td>     <!-- 外出時數 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_godate}</font></td> <!-- 外出日期 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_time}</font></td>   <!-- 外出時間 --> 
        <td align="left"><font color='{tv_fcolor}'>{tv_place}</font></td>  <!-- 前往地點 -->
        <td align="left"><font color='{tv_fcolor}'>{tv_content}</font></td><!-- 外出事由 -->
        <td align="center"><font color='{tv_fcolor}'>{tv_redate}</font></td> <!-- 回程日期 -->  
        <td align="center"><font color='{tv_fcolor}'>{tv_retime}</font></td> <!-- 回程時間 -->
        <td align="left"><font color='{tv_fcolor}'>{tv_replace}</font></td> <!-- 回程地點 -->
        <td align="left"><font color='{tv_fcolor}'>{tv_memo}</font></td> <!-- 備註 -->
      </tr>
      <!-- END BLOCK : tb_body_today_prn -->
    </tbody>
  </table>
  <br>
<!-- END BLOCK : tb_list_today_prn -->

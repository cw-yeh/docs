<?
  //┌──────────┬──────────────────────────────────────────────────────────────┐
  //│系統名稱: │EWB01   外出電子白板程式檔                                    │
  //│程式名稱: │ewb01_init.php     自訂函數與變數設定                         │
  //│程式說明: │自行開發的函數，以及變數設定                                  │
  //│          │                                                              │
  //│程式設計: │呂若瑄                                                        │
  //│設計日期: │2008.01.30                                                    │
  //│程式修改: │                                                              │
  //│修改日期: │                                                              │
  //└──────────┴──────────────────────────────────────────────────────────────┘
  //┌──────────┬──────────────────────────────────────────────────────────────┐
  //│函數名稱  │函數功能                                                      │
  //├──────────┼──────────────────────────────────────────────────────────────┤
  //│u_setvar()│變數設定                                                      │
  //│u_fd_var()│設定欄位變數                                                  │
  //└──────────┴──────────────────────────────────────────────────────────────┘





  // **************************************************************************
  //  函數名稱: u_setvar()
  //  函數功能: 變數設定
  //  使用方式: u_setvar(&$f_var)
  //  程式設計: Tony
  //  設計日期: 2006.09.27
  // **************************************************************************
  function u_setvar($f_var) {
    // post or get data Begin ............................................//
       //echo $_REQUEST.'---------';
       if(is_array($_REQUEST)) { // 有資料才處理
          while (list($f_fd_name,$f_fd_value) = each($_REQUEST)) {
                 //echo "$f_fd_name=$f_fd_value----";
                 $f_var[$f_fd_name] = $f_fd_value;
          }
       }
    // post or get data End ..............................................//

    // 未傳入值之預設值設定 Begin.................................................//
       if(NULL==$f_var['msel']) {
          $f_var['msel']=4;
       }

       if(NULL==$f_var['f_page']) {
          $f_var['f_page']  = 1;         // 頁次
       }

       if(NULL==$f_var['f_del']) { // 條件為未作廢
          $f_var['f_del']='N';
       }
       sl_open('sl');
       $query1      = "SELECT sl.dept.*
                              FROM sl.dept
                              WHERE sl.dept.dept_id = '{$_SESSION['login_dept_id']}'
                            ";
       //echo $query1."<BR>";//exit;
       $result1 = mysql_query($query1); 
       $row1 = mysql_fetch_array($result1);
       if(NULL==$f_var["f_change1"]) { // 條件為廠部別$fd_dept = substr($row1['p_gid'],0,2); 
          $fd_dept=substr($row1['p_gid'],0,2);
          switch ($fd_dept) {
            case "S1":  
            case "E1":  
            case "T1":  
                  $f_var["f_change1"] = $fd_dept;
                break;
            case "S2":  
            case "S3":  
                $vfd_dept = substr($row1['p_gid'],0,3); 
                      $f_var["f_change1"] = $vfd_dept;
                break;
            default:
              break;
          }   
       }
    // 未傳入值之預設值設定 End ..................................................//

    

    $mphp_name = u_showproc();
    //$f_var['ap_id']        = 'sl';       // sl.ap.ap_id
    $f_var['show_year']    = '2'; //  '4'表示秀西元年 2007, '2'表示秀民國年 95
    $f_var['msel_name']    = array('1'=>'新增','2'=>'修改','3'=>'刪除','4'=>'瀏覽','5'=>'查詢','6'=>'未定義','7'=>'列印'); // msel 中文
    $f_var['ie_h_title']   = '外出白板';  //upd by 佳玟 2012.06.20  經理告知，由外出電子白板 -> 外出白板
    $f_var['msub_title']   = '外出白板';                 // 程式副標題 山隆EIP-$f_var['msub_title']
    $f_var['mmaxline']     = 20;                             // 每頁最大筆數
    $f_var['break_pg_num'] = 8;                              // 列印跳頁筆數
    $f_var['mdb']          = 'docs';                         // db name
    $f_var['mtable']       = array('head'=>'ewb01','dept'=>'sl.dept','pass'=>'sl.pass');    // 使用 table 名稱 h=檔頭 ; b=檔身
    $f_var['tpl']          = 'ewb01.tpl';                    // 樣版畫面檔
    $f_var['mque_color']   = 'background-color: #FFFF00; color: #000000; font-weight: bold'; // 查詢字串顏色
    $f_var["mwidth1"]      = '15%'; // 輸入畫面的中文欄位部份
    $f_var["mwidth2"]      = '85%'; // 輸入畫面的input部份
    $f_var["upd_ct"]       = 'empno';
    //$f_var['job_id']="5041/5042/5043/5001/5002/5003/5019/5020/5021";
    $f_var['job_id']="5001/5002/5003/5019/5020";   //upd by  佳玟  2011.09.29 (報修-15017)   稽核人員外出白板查看權限改為經理級以上
    $f_var['domain']= strstr($f_var['job_id'],$_SESSION['login_job_id']);
    
    $f_var['domain_S181'] = strstr("S112",$_SESSION['login_dept_id']);  //ADD BY 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位  
    if( date("Ymd")<'20160101' AND '8200092'==$_SESSION['login_empno'] ){ //add by 佳玟 2015.12.15 開放甘不理
      $f_var['domain_S181'] = TRUE; 
    }
    
    //$f_var['domain1']= strstr('S122',$_SESSION['login_dept_id']);   //add by 佳玟 2011.08.11 增加設計組觀看稽核權限
    //$f_var['domain2']= strstr('8702080',$_SESSION['login_empno']);   //add by 佳玟 2011.08.11 增加陳誌煌觀看稽核權限
    //echo $f_var['domain'].'=======<br>';
    $f_var["mfd_show"]  = array("dept_id","sname");   //部門
    $f_var["mfd_value"] = array("dept_id","sname");
    $f_var['fmdb']          = 'sl';           
    $f_var['fmtable']       = array('head'=>'sl.dept');
    $f_var['fwhere'] = "{$f_var['fmtable']['head']}.d_date='0000-00-00' and {$f_var['fmtable']['head']}.stop='N'";
    $f_var['forder'] = "{$f_var['fmtable']['head']}.dept_id";
    list($f_var['dept_id_show'],$f_var['dept_id_value']) = sl_add_select3($f_var['fmdb'],$f_var['fmtable']['head'],$f_var['fwhere'],$f_var['forder'],$f_var["mfd_show"],$f_var["mfd_value"]); //由資料庫列出select
    //$f_var['deptid'] = array('value'=> $f_var['dept_id_value']  ,'show'=> $f_var['dept_id_show'] );
    $f_var['deptid']['value'][]='00';
    $f_var['deptid']['show'][] ='全部';
    while(list($hvalue)=each($f_var['dept_id_value'])){
      if("--"!=$f_var['dept_id_value'][$hvalue] ){
        $f_var['deptid']['value'][]=$f_var['dept_id_value'][$hvalue];
        $f_var['deptid']['show'][]=$f_var['dept_id_show'][$hvalue];
      }
    }
    $f_var['area_value'] = array('00','S1','S25','S26','S28','S35','S36','S38','E1','T1');
    $f_var['area_show']  = array('全部','總管理處','北區管理課','中區管理課','南區管理課','北區油品','中區油品','南區油品','船務報關','山隆生技');
    $f_var['area'] = array('value'=> $f_var['area_value']  ,'show'=> $f_var['area_show'] );

    //$f_var['order_value'] = array('eb02'    ,'eb01','sname'    ,'eb06'        );
    //$f_var['order_show']  = array('外出日期','同仁','部門名稱' ,'預計回程日期');    
    $f_var['order_value'] = array('eb02,eb18,eb02,eb03'    ,'eb01,eb02','sname'    ,'eb06'        );
    $f_var['order_show']  = array('外出日期'          ,'同仁'     ,'部門名稱' ,'預計回程日期');
    $f_var['order'] = array('value'=> $f_var['order_value']  ,'show'=> $f_var['order_show'] );
    
    //$f_var['eb09_value'] = array('--'        ,'01.公務車','02.私車公用','03.受公司補助購車-維修-公司支付','04.受公司補助購車-維修-自行支付','05.大眾交通工具','06.公務車(併車搭乘-不借車)','07.私車公用(併車搭乘-不請領油貼)','99.其他'); //upd by 佳玟 2012.02.06 (報修-16232) 增加06.07選項
    //$f_var['eb09_show']  = array('--請選擇--','01.公務車','02.私車公用','03.受公司補助購車-維修-公司支付','04.受公司補助購車-維修-自行支付','05.大眾交通工具','06.公務車(併車搭乘-不借車)','07.私車公用(併車搭乘-不請領油貼)','99.其他');
    //$f_var['eb09_value'] = array('--'        ,'01.公務車','02.私車公用','03.受公司補助購車-維修-公司支付','05.大眾交通工具','06.公務車(併車搭乘-不借車)','07.私車公用(併車搭乘-不請領油貼)','99.其他'); //upd by 佳玟 2012.02.06 (報修-16232) 增加06.07選項
    //$f_var['eb09_show']  = array('--請選擇--','公務車','私車公用','受公司補助購車-維修-公司支付','大眾交通工具','公務車(併車搭乘-不借車)','私車公用(併車搭乘-不請領油貼)','其他');  //upd by 佳玟 2012.02.24  (報修-16408)取消04.受公司補助購車-維修-自行支付
    $f_var['eb09_value'] = array('--'        ,'01.公務車','02.私車公用','03.受公司補助購車-維修-公司支付','04.受公司補助購車-維修-自行支付','05.大眾交通工具','06.公務車(併車搭乘-不借車)','07.私車公用(併車搭乘-不請領油貼)','99.其他');
    $f_var['eb09_show']  = array('--請選擇--','公務車'   ,'私車公用'   ,'受公司補助購車-維修-公司支付'   ,'受公司補助購車-維修-自行支付'   ,'大眾交通工具','公務車(併車搭乘-不借車)','私車公用(併車搭乘-不請領油貼)','其他');  //upd by 佳玟 2014.07.16  (報修-24009)增加04.受公司補助購車-維修-自行支付
    $f_var['eb09'] = array('value'=> $f_var['eb09_value']  ,'show'=> $f_var['eb09_show'] );

    
    $f_var['eb10_value'] = array('--'        ,'01.1300 CC以下','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC以上','06.摩托車');
    $f_var['eb10_show']  = array('--請選擇--','01.1300 CC以下','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC以上','06.摩托車');
    $f_var['eb10'] = array('value'=> $f_var['eb10_value']  ,'show'=> $f_var['eb10_show']);
    
    $f_var['else_calc_value'] = array('--'        ,'00'      ,'N'                           ,'Y');
    $f_var['else_calc_show']  = array('--請選擇--','私車公用',"受公司補助購車維修費公司支付","受公司補助購車維修費自行支付");
    $f_var['else_calc'] = array('value'=> $f_var['else_calc_value']  ,'show'=> $f_var['else_calc_show'] );
    
    
    //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
    sl_open($f_var['mdb']);
    $query = "select group_concat( dept_id ORDER BY dept_id SEPARATOR '/' )  as dept_id
              from sl.dept
              where (dept_name LIKE '%物流%') AND stop = 'N' AND d_date='0000-00-00 00:00:00'
           ";
    //echo $query."<BR>";
    $result = mysql_query($query);
    $row =mysql_fetch_array($result);
    $f_var['domain1']=strstr($row['dept_id'],$_SESSION['login_dept_id']);//add by mimi 2011.06.02 轉至簽核表判斷只要物流
    $f_var['domain2']=strstr('S121,S122',$_SESSION['login_dept_id']);//add by mimi 2011.06.03 轉至簽核表判斷只要資訊
    
    //add by mimi 2011.09.28 增加中區轉簽核表
    $query2 = "select group_concat( dept_id ORDER BY dept_id SEPARATOR '/' )  as dept_id
              from sl.dept
              where (dept_id like 'S6%') AND stop = 'N' AND d_date='0000-00-00 00:00:00'
           ";
    //echo $query2."<BR>";
    $result2 = mysql_query($query2);
    $row2 =mysql_fetch_array($result2);
    $f_var['domain3']=strstr($row2['dept_id'],$_SESSION['login_dept_id']);//add by mimi 2011.06.02 轉至簽核表判斷只要中區

    //add by 佳玟 2012.01.12 待辦-14426 給予設定檔(ewb_set01)設定有哪些人員只簽核一層
    sl_open('docs');
    $sql2 = "select  group_concat( es01 ORDER BY es01 SEPARATOR '/' )  as empno
              from   ewb_set1
              where  d_date='0000-00-00 00:00:00'
           ";
    $res2 = mysql_query($sql2);
    $ar2 =mysql_fetch_array($res2);
    $f_var['domain4']=strstr($ar2['empno'],$_SESSION['login_empno']); //add by 佳玟 2012.01.12 待辦-14426 給予設定檔(ewb_set01)設定有哪些人員只簽核一層
    //$f_var['domain4']=strstr("/5003/5019/5020",$_SESSION['login_job_id']);//add by mimi 2012.01.12 報修-16058 經理級以上只要簽核一層
    //echo 'domain4: '.$f_var['domain4'];
    
    //add by 佳玟 2018.12.04 依資訊網頁/權限管理/鼎新版更時間控制設定 控制開放始用時間
    $vb_date = date("Y-m-d H:i:s");
    $f_var['hrmctrl'] = "";
    $f_var['hrmctrl_ing'] = "";
    $f_var['hrmctrl_ing2'] = "";
    $sql_tr = "select startime, endtime, reason
                from  hrm.hrmupdatectrl
                where '{$vb_date}' >= startime
                      and chk = 'Y'
                      and d_date = '0000-00-00 00:00:00'
               ";
    //echo $sql_tr."<br>";           
    $res_tr = mysql_query($sql_tr);
    $qty_tr = mysql_num_rows($res_tr);
    if($qty_tr > 0){
      while($row_tr = mysql_fetch_array($res_tr)){
        $f_var['hrmctrl_ing'] = "注意!! 鼎新人事系統版更維護中。\r\n版更時間: {$row_tr['startime']} ~ {$row_tr['endtime']} (版更期間,【出退勤紀錄轉入HR(鼎新)】選擇「是」將無法送單)\n";
        //$f_var['hrmctrl_ing'] = "注意!! 鼎新人事系統版更維護中。\n
        //                     版更時間: {$row_tr['startime']} ~ {$row_tr['endtime']}\n
        //                     版更原因: {$row_tr['reason']}\n
        //                     請等版更結束後, 再使用。\n
        //                     (鼎新給予的預計結束時間,會有延後的可能)\n
        //                     (版更期間,【出退勤紀錄轉入HR(鼎新)】選擇「是」將無法送單)\n";
        $f_var['hrmctrl_ing2'] = "<font size='+1' style='font-family:Microsoft JhengHei;'>注意!! 鼎新人事系統版更維護中。<br>
                             版更時間: <font style='font-weight:bold;color:blue;'>{$row_tr['startime']} ~ {$row_tr['endtime']}</font> <br>
                             版更原因: <font style='font-weight:bold;color:blue;'>{$row_tr['reason']}</font><br>
                             請等版更結束後, 再使用。<br>
                             <font style='font-weight:bold;color:green;'>(鼎新給予的預計結束時間,會有延後的可能)</font><br>";
      }                                                   
    }
    $sql_tr2 = "select startime, endtime, reason
                from  hrm.hrmupdatectrl
                where startime > '{$vb_date}'
                      and chk = 'Y'
                      and d_date = '0000-00-00 00:00:00'
               ";
    $res_tr2 = mysql_query($sql_tr2);
    $qty_tr2 = mysql_num_rows($res_tr2);
    if($qty_tr2 > 0){
      while($row_tr2 = mysql_fetch_array($res_tr2)){
        $f_var['hrmctrl'] = "<font size='+1' style='font-family:Microsoft JhengHei;'>近期鼎新人事系統版更維護時間: <br>
                             版更時間: <font style='font-weight:bold;color:blue;'>{$row_tr2['startime']} ~ {$row_tr2['endtime']}</font> <br>
                             版更原因: <font style='font-weight:bold;color:blue;'>{$row_tr2['reason']}</font><br>
                             <font style='font-weight:bold;color:green;'>(注意! 版更期間,<font style='font-weight:bold;color:red;'>【出退勤紀錄轉入HR(鼎新)】選擇「是」</font>將無法送單,請提前申請)</font></font>";
      }                                                   
    }
    
    
    
    $f_var['fd']        = u_fd_var($f_var); // 設定欄位變數，一定要放在 $f_var['area']與$f_var['kind']之後，因為會使用到此陣列內容。
 
 // 宣告List瀏覽表格畫面設定 Begin.................................................//
    // th_width = 欄位大小百分比, 但總合需<=100)
    // th_name  = 抬頭欄位名稱
    // fd_align = 資料秀出位置 left=左,right=右,center=中央
    // fd_name  = table 中的欄位名稱

    $f_var["list"]=array('th_width' => array(7         ,6         ,7         ,5         ,10        ,18        ,7             ,6          ,8             ,8      ,10                       ,2       ,2        ), 
                         'th_name'  => array('部門名稱','同仁'    ,'外出日'  ,'時間'    ,'前往地點','外出事由','預計回程'    ,'預計<br>時間' ,'預計回程<br>地點','備註'  ,'調車單/里程單/里程<br><b>開放期限</b>'               ,'修'    ,'廢'     ), 
                         'fd_align' => array('left'    ,'left'    ,'center'  ,'center'  ,'left'    ,'left'    ,'center'      ,'center'   ,'left'        ,'left'  ,'left'                ,'center','center' ), 
                         'fd_name'  => array('sname'   ,'eb01'    ,'eb02'    ,'eb03'    ,'eb04'    ,'eb05'    ,'eb06'        ,'eb07'     ,'eb16'        ,'eb08'  ,'u_chksign(s_num)'        ,'u_upd' ,'u_del'  ),
                         'fd_type'  => array(''        ,''        ,''        ,'time'    ,''        ,''        ,''            ,'time'     ,''            ,''      ,''                      ,''      ,''       )
                                   );                                                                                                    
    // 瀏覽表格畫面設定 End ..................................................//



    // 查詢條件設定 Begin ................................................//
       $f_var['que']['memo']  = '查詢欄位為:【';
       $mnum = 0;
       reset($f_var['fd']); // 將陣列的指標指到陣列第一個元素
       while(list($mfd_id)=each($f_var['fd'])) {
             if('Y'==$f_var['fd'][$mfd_id]['que']) { // 可查詢欄位
                if($mnum>=1) {
                   $f_var['que']['memo'] .= '、';
                }
                $f_var['que']['fd'][]  = $mfd_id;
                $f_var['que']['memo'] .= $f_var['fd'][$mfd_id]['cname'];
                $mnum++;
             }
       }
       $f_var['que']['memo']  .= '】輸入條件後請點選確定。';
    // 查詢條件設定 End ..................................................//
    $f_var['today'] = date("Ymd");
     
    //$f_var['mwhere'] = "{$f_var['mtable']['head']}.b_date>'0000-00-00' and (({$f_var['mtable']['head']}.b_empno = '{$_SESSION['login_empno']}' and  {$f_var['mtable']['head']}.dc05 = 'N' ) or ({$f_var['mtable']['head']}.b_empno = '{$_SESSION['login_empno']}' and {$f_var['mtable']['head']}.dc05 = 'Y') or {$f_var['mtable']['head']}.dc05 = 'N') and ";
    switch ($f_var['f_del']) {
         case "N": // N.未作廢                        
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or '1130091'==$_SESSION["login_empno"] or ''!=$f_var['domain_S181'] ){  //add by 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date='0000-00-00 00:00:00' "; //js_h.date='0000-
              }
              else{
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date='0000-00-00 00:00:00' and {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
              }
              break;
         case "Y": // Y.已作廢
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181']){   //add by 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date<>'0000-00-00 00:00:00' ";
               }
              else{
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date<>'0000-00-00 00:00:00' and {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
              }
              break;
         default: // 全部
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181']){  //add by 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位
                $f_var['mwhere'] .= "1=1";
              }
              else{
                $f_var['mwhere'] .= "1=1 and {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
              }
              break;
    }

    if(NULL==$f_var['f_order_fd']) {
       $f_var['f_order_fd'] = 'b_date';
    }

    if(NULL==$f_var['f_order_md']) {
       $f_var['f_order_md'] = 'desc';
    }

    //if('8966389'==$_SESSION["login_empno"]) {
    //   echo $f_var['f_order_fd'].'--------'.$f_var['f_order_md'];
    //}
    //if('sname' == $f_var['f_order_fd']){
    //  $f_var['morder'] = "{$f_var['mtable']['dept']}.{$f_var['f_order_fd']} {$f_var['f_order_md']}";
    //}
    //else{
      $f_var['morder'] = "{$f_var['f_order_fd']} {$f_var['f_order_md']} ";
    //}

    return;
  }




  // **************************************************************************
  //  函數名稱: u_fd_var()
  //  函數功能: 設定欄位變數
  //  使用方式: u_fd_var($f_var)
  //  程式設計: Tony
  //  設計日期: 2006.09.25
  // **************************************************************************
  function u_fd_var($f_var) {
    //$_SESSION['login_car_id'];         // 車號
    //$_SESSION['login_car_kind'];       // 車種
    //$_SESSION['login_exhaust'];        // 排氣量
    //$_SESSION['login_vip_card'];       // 山隆VIP卡號
    sl_open($f_var['mdb']); // 開啟資料庫  
    
    

    $f_var['mwhere'] = "{$f_var['mtable']['head']}.b_date>'0000-00-00 00:00:00' and {$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
    $f_var['morder'] = "{$f_var['mtable']['head']}.s_num DESC";

    
    $query1      = "select {$f_var['mtable']['head']}.*  /*,{$f_var['mtable']['dept']}.sname*/
                    from {$f_var['mtable']['head']} 
                          /*left join {$f_var['mtable']['dept']}
                           on   {$f_var['mtable']['head']}.b_dept_id = {$f_var['mtable']['dept']}.dept_id  */
                   where {$f_var['mwhere']}
                   order by {$f_var['morder']}
                   ";
    //echo "<pre>".$query1."</pre><BR>";
    $result1  = mysql_query($query1);
    $row1 = mysql_fetch_array($result1); //add by 佳玟  2011.10.05 (待辦-14426 回應29) 有設定例外人員設定檔才扣除

    $fd_disabled  = iif($f_var['msel']=='2','disabled',''); //select使用    
    $fd_readonly  = iif($f_var['msel']=='2','readonly','');
    $fd_class     = iif($f_var['msel']=='2','field_color','');     
    $fd_inputtype = iif($f_var['msel']=='2','text','date'); //日期不給選
    
    $fd_eb09 = strstr("01/05/06/07/99",substr($row1['eb09'],0,2));
    $fd_readonly_msel= iif($fd_eb09<>'' and $f_var['msel']=='2','readonly','');
    $fd_class_msel   = iif($fd_eb09<>'' and $f_var['msel']=='2','field_color','');         
    
    //--搜尋例外人員設定檔，是否扣除標準里程---------------------// 
    $sql = "select *
            from   docs.ewb_pay_emp_set 
            where  es02 = '{$_SESSION["login_empno"]}'  
                   and d_date = '0000-00-00 00:00:00'                   
                   /*and es03 = 'Y'*/
                   and es15 = 'Y'            
           ";   
    $rs = mysql_query($sql);
    $count = mysql_num_rows($rs);
    if($count>0){
      //$fd_eb17 = "Y"; //有資料則扣除標準里程
      $fd_eb24 = "Y"; //有資料則扣除標準里程
    }
    //if( $row1['b_date']<>'' ){  //修改
    //  $fd_eb17 = $row1['eb17']; 
    //} 
    //-----------------------------------------------------------//
    mysql_close(); // 關閉資料庫
        
    
    //if($fd_eb17=='Y' AND $f_var['msel']=='2'){  //add by 佳玟  2011.10.17 修改，例外人員資料表設定是 Y 者
    //  $fd_eb17s = $fd_eb17;
    //}
    //else if($f_var['msel']!='2'){  //新增， 依據例外人員資料表設定給值
    //  $fd_eb17s = $fd_eb17;
    //}
    //else{  //修改，給予原資料庫內儲存的值
    //  $fd_eb17s ='';
    //}
    
    //$fd_resda019 = u_chksign($f_var['f_s_num']); //搜尋里程開放期限
    //$ar_key = explode("<br>",$fd_resda019);
    //$fd_resda0192 = strip_tags($ar_key[1]); //去除所有html標籤
    //echo $fd_resda0192;
    $fd_var['s_num'] = array(  //add by 佳玟 2011.11.24  取得s_num，查詢外出單簽核結案日期 (檢查里程三日內登打)
                              'ename'     => 'f_s_num',
                              'cname'     => 's_num',
                              'type'      => 'hidden',
                              'save'      => 'N',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 20,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // 是否開放查詢
                              'js_rule'   => '',
                              'memo'      => '' ,         
                            );      
                                
    $fd_var['sname'] = array(
                              'ename'     => 'f_sname',
                              'cname'     => '部門名稱',
                              'type'      => 'text',
                              'value'     => $_SESSION['login_sname'],
                              'size'      => 10,
                              'maxlength' => 10,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'save'      => 'N',
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => '',   
                              'memo'      => ''                           
                            );
    $fd_var['eb01'] = array(
                              'ename'     => 'f_eb01',
                              'cname'     => '同仁姓名',
                              'type'      => 'text',
                              'value'     => $_SESSION["login_name"],
                              'size'      => 10,
                              'maxlength' => 12,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                               
                              //'readonly'  => "{$fd_readonly}",
                              //'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),   // 一定要輸入值，也就是檢查是否為空白
                              'pkey'      => 'Y',
                              'memo'      => ''
                            );
    $fd_var['eb18'] = array(
                              'ename'     => 'f_eb18',
                              'cname'     => '同仁員編',
                              'type'      => 'text',
                              'value'     => $_SESSION["login_empno"],
                              'size'      => 7,
                              'maxlength' => 7,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),   // 一定要輸入值，也就是檢查是否為空白
                              'pkey'      => 'Y',
                              'memo'      => ''
                            );        
    $fd_var['eb02'] = array(
                              'ename'     => 'f_eb02',
                              'cname'     => '外出日期',
                              'type'      => $fd_inputtype,        // 網頁form的input_type,資料型態仍為 char(),為的是要叫用 BLOCK:tb_date
                              'value'     => date("Ymd"),   // 網頁form的input_value
                              'size'      => 10,            // 網頁form的input_size
                              'maxlength' => 8,
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'chkdate','chk_len'=>'8'),   // 一定要輸入值，也就是檢查是否為日期
                              'pkey'      => 'Y',  
                              'memo'      => '請輸入西元年月日，範例：20071005'
                            );
    $fd_var['eb03'] = array(
                              'ename'     => 'f_eb03',
                              'cname'     => '外出時間',
                              'type'      => 'time',
                              'value'     => date("Hi"),
                              'size'      => 10,
                              'maxlength' => 4,       //字的長度
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'time','chk_len'=>'4'),    // 一定要輸入值，也就是檢查是否為數字
                              'pkey'      => 'Y',  
                              'memo'      => '請輸入時分，範例：0930'   
                            );
    $fd_var['eb04'] = array(
                              'ename'     => 'f_eb04',
                              'cname'     => '前往地點',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 40,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // 一定要輸入值，也就是檢查是否為數字
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );

    $fd_var['eb05'] = array(
                              'ename'     => 'f_eb05',
                              'cname'     => '前往事由',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 60,
                              'maxlength' => 60,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // 一定要輸入值，也就是檢查是否為數字
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );
    $fd_var['eb06'] = array(
                              'ename'     => 'f_eb06',
                              'cname'     => '預計回程日期',
                              'type'      => $fd_inputtype,        // 網頁form的input_type,資料型態仍為 char(),為的是要叫用 BLOCK:tb_date
                              'value'     => date("Ymd"),   // 網頁form的input_value
                              'size'      => 10,            // 網頁form的input_size
                              'maxlength' => 8,
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢                              
                              'js_rule'   => array('kind'=>'chkdate','chk_len'=>'8'),   // 一定要輸入值，也就是檢查是否為日期
                              'pkey'      => 'Y',  
                              'memo'      => '請輸入西元年月日，範例：20071005'
                            );
    $fd_var['eb07'] = array(
                              'ename'     => 'f_eb07',
                              'cname'     => '預計回程時間',
                              'type'      => 'time',
                              'value'     => '',
                              'size'      => 10,
                              'maxlength' => 4,            //字的長度
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'time','chk_len'=>'4'),    // 一定要輸入值，也就是檢查是否為數字
                              'pkey'      => 'Y',  
                              'memo'      => '請輸入時分，範例：0930'   
                            );
    $fd_var['eb16'] = array(
                              'ename'     => 'f_eb16',
                              'cname'     => '預計回程地點',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 40,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // 一定要輸入值，也就是檢查是否為數字
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );
      //add by 佳玟 2018.03.27 報修33599-外出白板新增選項  -> 出退勤紀錄轉入HR(鼎新)
      $fd_var['tohrm'] = array(
                                'ename'     => 'f_tohrm',
                                'cname'     => '出退勤紀錄轉入HR(鼎新)',
                                'type'      => 'select2',
                                'show'      => array('--請選擇--','否','是'),
                                'value'     => array('-','N','Y'), 
                                'selected'  => $fd_eb24,
                                'size'      => 0,
                                'maxlength' => 0,   
                                //'readonly'  => '',
                                'class'     => '',
                                'multiple'  => $fd_disabled,
                                'show_scr'  => 'Y',  
                                //'js_rule'   => '',      
                                'js_rule'   => array('kind'=>'required','chk_value'=>'-'),   // 一定要輸入值，也就是檢查是否為空白
                                'pkey'      => 'Y',                                
                                'memo'      => '若選擇為『是』，外出白板取代出勤紀錄'
                                
                            );    
      $fd_var['eb09'] = array(
                                'ename'     => 'f_eb09',
                                'cname'     => '車種',
                                'type'      => 'select2',
                                'selected'  => $_SESSION['login_car_kind'],
                                'show'      => $f_var['eb09']['show'],
                                'value'     => $f_var['eb09']['value'], 
                                'size'      => 0,
                                'maxlength' => 0,
                                'show_scr'  => 'Y',
                                'que'       => 'Y',          // 是否開放查詢
                                //'multiple'  => "{$fd_disabled}",  //mark by 佳玟 2012.12.21 (報18956)                        
                                'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // 一定要輸入值，也就是檢查是否為空白
                                'pkey'      => 'Y',
                                'memo'      => '車種為私車公用、受公司補助購車，排氣量為必填'     
                              );      
      $fd_var['eb10'] = array(
                                'ename'     => 'f_eb10',
                                'cname'     => '排氣量',
                                'type'      => 'select2',
                                'show'      => $f_var['eb10']['show'],
                                'value'     => $f_var['eb10']['value'], 
                                'selected'  => $_SESSION['login_exhaust'],
                                'size'      => 0,
                                'maxlength' => 0,
                                'show_scr'  => 'Y',
                                'que'       => 'Y',          // 是否開放查詢
                                //'multiple'  => "{$fd_disabled}",  //mark by 佳玟 2012.12.21 (報18956)                           
                                //'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   //add by 佳玟 2011.08.10 如未設定，耗油計算會有錯誤
                                                                                                
                                //'pkey'      => 'Y',
                                'memo'      => '請輸入行照上之確實排氣量'     
                              );
    /*                          
     $fd_var['eb17'] = array(
                              'ename'     => 'f_eb17',
                              'cname'     => '扣除標準里程',
                              'type'      => 'text',
                              'show'      => '',
                              'value'     => $fd_eb17, 
                              'size'      => 1,
                              'maxlength' => 1,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'show_scr'  => 'Y',          // 是否再回應的時可輸入資料
                              'js_rule'   => '',
                              'memo'      => '值為Y, 於列印私車公用耗油統計表時會將哩程數扣除120公里'
                            );  */ 
    //mark by 佳玟 2016.04.08 報修28783 -公司以廢除120公哩程                        
    //if( $row1['b_date']=='' and $fd_eb17<>'Y' ){ //新增                       
    //  $fd_var['eb17'] = array(
    //                            'ename'     => 'f_eb17',
    //                            'cname'     => '扣除標準里程',
    //                            'type'      => 'select2',
    //                            'show'      => array('--請選擇--','N','Y'),
    //                            'value'     => array('--','N','Y'), 
    //                            //'selected'  => '',
    //                            'size'      => 0,
    //                            'maxlength' => 0,
    //                            'readonly'  => '',
    //                            'class'     => '',
    //                            'show_scr'  => 'Y',          // 是否再回應的時可輸入資料
    //                            //'js_rule'   => '',      
    //                            'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // 一定要輸入值，也就是檢查是否為空白
    //                            'pkey'      => 'Y',                                
    //                            'memo'      => '選擇Y,於列印私車公用耗油統計表時會將哩程數扣除120公里'
    //                            
    //                          ); //upd by 佳玟 2011.10.11 (報修-15148) 陳誌煌說，目前派任沒有解決方法，所以改回先前自行輸入      
    //}else{ //修改
    //  $fd_var['eb17'] = array(
    //                            'ename'     => 'f_eb17',
    //                            'cname'     => '扣除標準里程',
    //                            'type'      => 'text',
    //                            'value'     => $fd_eb17,
    //                            'readonly'  => 'readonly',
    //                            'class'     => 'field_color',
    //                            'size'      => 1,
    //                            'maxlength' => 1,            //字的長度
    //                            'show_scr'  => 'Y',
    //                            'que'       => 'N',          // 是否開放查詢
    //                            //'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // 一定要輸入值，也就是檢查是否為數字
    //                            'memo'      => '' ,         
    //                          );  
    //}
    $fd_var['eb24'] = array(
                                'ename'     => 'f_eb24',
                                'cname'     => '往返調任地扣除30公里',
                                'type'      => 'select2',
                                'show'      => array('--請選擇--','N','Y'),
                                'value'     => array('--','N','Y'), 
                                'selected'  => $fd_eb24,
                                'size'      => 0,
                                'maxlength' => 0,   
                                'readonly'  => '',
                                'class'     => '',
                                'show_scr'  => 'Y',          // 是否再回應的時可輸入資料
                                //'js_rule'   => '',      
                                'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // 一定要輸入值，也就是檢查是否為空白
                                'pkey'      => 'Y',                                
                                'memo'      => '依公告16033通勤往返調任地油費補助:依實際往返里程減30公里加計通行費'
                                
                            );     
    $fd_var['eb11'] = array(
                              'ename'     => 'f_eb11',
                              'cname'     => '出廠公里數',
                              'type'      => 'text',
                              //'readonly'  => 'onBlur=\'javascript:document.input_form.f_eb13.value=eval(parseInt(document.input_form.f_eb12.value)-parseInt(this.value));if(document.input_form.f_eb13.value<=0){alert("哩程數不可小於0");}if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb13.value=0;}\'',
                              'readonly'  => 'onBlur=\'javascript:if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb11.value="";document.input_form.f_eb13.value=0;}\'',
                              'value'     => '',
                              'size'      => 7,
                              'maxlength' => 7,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'readonly'  => "{$fd_readonly_msel}",
                              'class'     => "{$fd_class_msel}",                              
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // 一定要輸入值，也就是檢查是否為數字
                              'memo'      => '' ,         
                            ); 
    $fd_var['eb12'] = array(
                              'ename'     => 'f_eb12',
                              'cname'     => '入廠公里數',
                              'type'      => 'text',
                              'value'     => '',
                              'readonly'  => 'onBlur=\'javascript:input_form.f_eb13.value=eval(parseInt(this.value)-parseInt(input_form.f_eb11.value));if(input_form.f_eb13.value<=0){alert("哩程數不可以小於零");}if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb13.value=0;}\'',
                              'size'      => 7,
                              'maxlength' => 7,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'readonly'  => "{$fd_readonly_msel}",
                              'class'     => "{$fd_class_msel}",                              
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // 一定要輸入值，也就是檢查是否為數字
                              'memo'      => '' ,         
                            );         
    $fd_var['eb13'] = array(
                              'ename'     => 'f_eb13',
                              'cname'     => '哩程數',
                              'type'      => 'text',
                              'value'     => '',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'size'      => 4,
                              'maxlength' => 4,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // 一定要輸入值，也就是檢查是否為數字
                              'memo'      => '' ,         
                            );          
    $fd_var['eb14'] = array(
                              'ename'     => 'f_eb14',
                              'cname'     => '回數票(高速公路通行費)',   //upd by 佳玟 2013.12.27(報修22108)外出白板國道通行費   ALTER TABLE  `ewb01` CHANGE  `eb14`  `eb14` INT( 8 ) NOT NULL COMMENT  '回數票(高速公路通路費)'
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 6,
                              'maxlength' => 8,            //字的長度
                              'show_scr'  => 'Y',                                     
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => '',    
                              'memo'      => '<a href="http://fare.fetc.net.tw/Custom.aspx" target="_blank">計程通行費試算</a>' ,         
                            );                   
    $fd_var['eb15'] = array(
                              'ename'     => 'f_eb15',
                              'cname'     => '乘車人數',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 1,
                              'maxlength' => 1,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => '',    
                              'memo'      => '' ,         
                            );            
    $fd_var['eb08'] = array(
                              'ename'     => 'f_eb08',
                              'cname'     => '備註',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 60,
                              'maxlength' => 60,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // 是否開放查詢
                              'js_rule'   => '',
                              'memo'      => '可輸入聯絡電話' ,         
                            );
    $fd_var['resda019'] = array(  //add by 佳玟 2011.11.24  取得s_num，查詢外出單簽核結案日期 (檢查里程三日內登打)
                              'ename'     => 'f_resda019',
                              'cname'     => '調車單簽核日期',
                              'type'      => 'text',
                              'save'      => 'N',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                              
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 20,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // 是否開放查詢
                              'js_rule'   => '',
                              'memo'      => '' , 
                                      
                            );      
    $fd_var['resda0192'] = array(  //add by 2012.03.02 佳玟  副理告知增加里程開放期限顯示
                              'ename'     => 'f_resda0192',
                              'cname'     => '里程開放修改期限',
                              'type'      => 'text',
                              'save'      => 'N',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                              
                              'value'     => "",
                              'size'      => 20,
                              'maxlength' => 20,            //字的長度
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // 是否開放查詢
                              'js_rule'   => '',
                              'memo'      => '' , 
                                      
                            );  
    //if( '1130091'==$_SESSION["login_empno"] ){                          
    $fd_var['hrmctrl'] = array(  //add by 佳玟 2018.12.04 依資訊網頁/權限管理/鼎新版更時間控制設定 控制開放始用時間
                              'ename'     => 'f_hrmctrl',
                              'cname'     => 'text',
                              'type'      => 'text',
                              'save'      => 'N',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                              
                              'value'     => $f_var['hrmctrl_ing'],   
                              'show_scr'  => 'Y',
                              'que'       => 'N',       
                              'js_rule'   => '',
                              'memo'      => '' , 
                                      
                            );                                                                                                   
    //}
    return($fd_var);
  }
  
  
  
  // **************************************************************************
  //  函數名稱: u_chksign()
  //  函數功能: 檢查簽核單簽核結果是否為同意
  //  使用方式: u_chksign($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.12.23
  // **************************************************************************
  function u_chksign($vsnum) {
    sl_open('docs');
    $query = "SELECT docs.sleip2flw.sleip2flw006,
                     docs.sleip2flw.sleip2flw008,
                     docs.sleip2flw.sleip2flw011, 
                     docs.sleip2flw.resda019,
                     docs.sleip2flw.resda020,
                     docs.ewb01.eb13,
                     docs.ewb01.eb18,
                     docs.ewb01.eb02,
                     docs.ewb01.eb09,
                     docs.ewb01.eb20
              FROM   docs.sleip2flw 
                     left join docs.ewb01 
                          on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 
              WHERE  docs.sleip2flw.sleip2flw010 = '{$vsnum}' and
                     docs.sleip2flw.sleip2flw003 = 'docs' and
                     docs.sleip2flw.sleip2flw004 = 'ewb01' and
                     docs.sleip2flw.sleip2flw008 in ('1','3','4','11','12') and
                     /*docs.sleip2flw.resda021 = '2' and*/
                     docs.sleip2flw.d_date = '0000-00-00 00:00:00' 
                      
              order by docs.sleip2flw.sleip2flw008       
             ";    
           
    $result = mysql_query($query); 
    $num = mysql_num_rows($result); 
    //$fd_resda19='';  
    if($num>0){  //2011.10.04 以前是沒跑簽核者，則會顯示
      while($row = mysql_fetch_array($result)){
        $fd_eb09 = substr($row['eb09'],0,2);  //車種
        $fd_carkey = strstr('02/03/04',$fd_eb09); //add by 佳玟 2012.03.07 車種為私車公用、受公司補助購車
        if($row['sleip2flw008']=='1' or $row['sleip2flw008']=='3' or $row['sleip2flw008']=='11'){
          $fd_flw13 = iif($row['resda019']=='0000-00-00 00:00:00',"簽核中","<font color=#693837>".substr($row['resda019'],5,5)."</font>");
          //add by 2012.03.02 佳玟  副理告知增加里程開放期限顯示
          $fd_resda19 = iif($row['resda019']=='0000-00-00 00:00:00',$fd_resda19,str_replace('-','',substr($row['resda019'],0,10))); //簽核日
        }else if($row['sleip2flw008']=='4' or $row['sleip2flw008']=='12'){
          $fd_flw4 = iif($row['resda019']=='0000-00-00 00:00:00',"/簽核中","/<font color=#693837>".substr($row['resda019'],5,5)."</font>");
        }
        
        if( '1'==$row['sleip2flw011'] ){
          switch( $row['resda020'] ){
            case '4':
                 return "已抽單";
                 echo $row['s_num'];
                 break;
            default:
                 break;
          }
        }

        $fd_eb13 = $row['eb13'];
        
        $fd_eb18 = $row['eb18']; //員編
        $fd_eb02 = $row['eb02']; //外出日期
        $fd_eb20 = $row['eb20']; //是否給油貼 -> 是否為重簽資料
      }
      $fd_str .= $fd_flw13;
      //$fd_str .= iif($fd_flw4==null and $fd_eb13<>'0'," / {$fd_eb13}Km",$fd_flw4);
      $fd_str .= iif($fd_flw4==null,'',$fd_flw4);
      $fd_str .= iif($fd_eb13=='0' or $fd_eb13=='','',"/{$fd_eb13}");
      
      //return "外出單:".$fd_resda0191."/里程單:".$fd_resda0192."/".$fd_eb13;
      
      
      //如為重簽資料，則開放三個月 add by 佳玟 2012.05.31 (待辦14426)
      $y2 = substr($fd_eb02, 0, 4); //取前四碼 (年)        
      $m2 = substr($fd_eb02, 4, 2); //取最後二碥(月)  
      $d2 = substr($fd_eb02, 6, 2); //日
      if($fd_eb02>substr($fd_eb02,0,6).'25'){
        $fd_sday3 = mktime(0, 0, 0, $m2+2, $d2, $y2);  //超過25，算下個月
      }else{
        $fd_sday3 = mktime(0, 0, 0, $m2+1, $d2, $y2);  //25內，本月
      }
      $fd_sday3 = substr(date('Ymd', $fd_sday3),0,6);
      $fd_close = $fd_sday3."06";  //預設關帳日  upd by 佳玟 2012.02.10 (待辦-14426)回應95.3 統一限定5日 23:59:59          
      $y3 = substr($fd_close, 0, 4); //取前四碼 (年)        
      $m3 = substr($fd_close, 4, 2); //取最後二碥(月)  
      $d3 = substr($fd_close, 6, 2); //日            	   	
      $fd_vdate  = date('Ym',mktime(0, 0, 0, $m3+1, $d3, $y3))."05";      
      if($fd_eb20 == 'N'){  //重簽資料
        $fd_str .= "<br><b><font color=#693837>".substr(sl_4ymd($fd_vdate),5,5)."</font></b>";
        return $fd_str;   
      }
      
      
      
      
      //add by 2012.03.02 佳玟  副理告知增加里程開放期限顯示
      //搜尋外出白板開放修改設定檔是否有資料---------------------------------------------// 
      $query_es = "select case 
                             when ewb_set03.b_date>ewb_set03.m_date then
                                  ewb_set03.b_date
                             else ewb_set03.m_date end as date                                
                   from   ewb_set03
                   where  ewb_set03.d_date = '0000-00-00 00:00:00' and
                          ewb_set03.es02 = '{$fd_eb18}' and
                          (ewb_set03.es03 <= '{$fd_eb02}' and ewb_set03.es04 >= '{$fd_eb02}')
                   order by date desc
                   limit 1
                ";  //搜尋 ewb_set03 是否有設定開放外出
       //echo '<pre>'.$query_es.'</pre>';
      $result_es  = mysql_query($query_es);
      $num_es = mysql_num_rows($result_es);  //筆數
      if($num_es>0){             
        $row_es = mysql_fetch_array($result_es);
        $fd_setdate = str_replace('-','',substr($row_es['date'],0,10));
        //$fd_resda19 = $fd_setdate;  //紀錄最大建檔或異動日期  
        
        //upd by 佳玟 2013.11.22 課長來能，林經理11/18不得修改哩程，因為有人至設定檔內設定人員開放修改里程，程式會判斷建立日b_date 來做為依據開放截止日
        if( $fd_resda19<$fd_setdate ){ //簽核完成日 < 設定開放日 ，才以設定檔內開放日為主
          $fd_resda19 = $fd_setdate;  //紀錄最大建檔或異動日期  
        }
      }     
      //計算三天內排除國定假日-----------------------------------------------------------// 
      $cal_cnt=0;
      for($fd_cnt=0;$fd_cnt<='3';$fd_cnt++){ //三天內跳脫國定假日  
        $y = substr($fd_resda19, 0, 4); //年          
        $m = substr($fd_resda19, 4, 2); //月  
        $d = substr($fd_resda19, 6, 2); //日          
        $fd_resda192_mk = mktime(0, 0, 0, $m, $d+$cal_cnt, $y);  //upd by 佳玟 2012.04.14 列出日期有誤
        $fd_resda192    = date('Ymd', $fd_resda192_mk);
        $ch_resda192    = $fd_resda192 - 19110000;      
      
        //$fd_resda192 = date('Ymd',strtotime("{$fd_resda19} +{$cal_cnt} day"));
        //$ch_resda192 = (date('Ymd',strtotime("{$fd_resda19} +{$cal_cnt} day"))-19110000);
        sl_open('sle');    //國定假日
        $sql99 = "select sle.sle0a.E0A_1 as date
                  from   sle.sle0a 
                  where  sle.sle0a.E0A_1 = '{$ch_resda192}'
                  order by sle.sle0a.E0A_1
                 ";
        //echo "<pre>".$sql99."</pre>";
        $rs99 = mysql_query($sql99);
        $rows99 = mysql_num_rows($rs99);
        //echo $cal_cnt."----".$rows99."----"."<br>";
        if($rows99 <> '0'){
          $fd_cnt-=1;
        }else{
           //add by 佳玟 2013.01.02 人事國定六日設定檔未轉入 sle0a ，先暫時加上國定判斷
           if( strstr("1020101/1020105/1020106/1020112/1020113/1020119/1020120/1020126/1020127","{$ch_resda192}") ){
             $fd_cnt-=1;
           }
           if( strstr("1020202/1020203/1020209/1020210/1020211/1020212/1020213/1020214/1020215/1020216/1020217/1020224/1020228","{$ch_resda192}") ){
             $fd_cnt-=1;
           }            
         }
        //echo $rows99.'--'.$fd_resda192.'---'.$fd_cnt.'<br>';
        $cal_cnt++;
      }
      if($fd_carkey<>''){ //add by 佳玟 2012.03.07 限定車種才顯示里程開放期限
        $fd_str .= iif($fd_resda19<>'',"<br><b><font color=#693837>".substr(sl_4ymd($fd_resda192),5,5)."</font></b>",'');    
      }   
      return $fd_str;
    }                                     
    else{
      return "<font color=#693837>外出單送出簽核異常</font>";
    }
  }               
  
?>

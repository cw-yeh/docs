<?
  //┌──────────┬──────────────────────────────────────────────────────────────┐
  //│系統名稱: │EWB01   外出電子白板程式檔                                    │
  //│          │                                                              │
  //│程式名稱: │ewb01.php  EWB01   外出電子白板                               │
  //│程式說明: │                                                              │
  //│樣板名稱: │ewb01.tpl                                                     │
  //│          │/home/sl/public_html/sl_tpl_1.tpl 共用樣板檔                  │
  //│          │                                                              │
  //│資料庫  : │eip :docs                                                     │
  //│資料表  : │ewb01     問題收集-檔頭                                       │
  //│          │                                                              │
  //│相關程式: │/home/sl/public_html/sl_init.php 共用函數                     │
  //│          │/home/sl/public_html/tp/*.*      樣板套件                     │
  //│          │ewb01_init.php                   外出電子白板自訂函數         │
  //│          │                                                              │
  //│          │/home/sl/public_html/sl.css      css 檔                       │
  //│          │/home/sl/public_html/sl.js        javascript 自訂函數         │
  //│          │/home/sl/public_html/sl_header.inc.php  頁首                  │
  //│          │/home/sl/public_html/sl_footer.inc.php  頁尾                  │
  //│          │                                                              │
  //│相關文件: │/home/docs/public_html/doc/ewb01.txt          目的            │
  //│          │                                                              │
  //│注意事項: │有關於 select 的下拉式選單規則，前面一定要保留三碼當作判斷碼，│
  //│          │不然共用函數會抓錯。                                          │
  //│          │例如: <select name="f_dept">                                  │
  //│          │        <option value="01.總公司">總公司</option>             │
  //│          │                       ^^^--->就是這三碼喔！                  │
  //│          │      </select>                                               │
  //│          │                                                              │
  //│          │                                                              │
  //│程式設計: │呂若瑄                                                        │
  //│設計日期: │2008.01.30                                                    │
  //│          │                                                              │
  //│程式修改: │                                                              │
  //│修改日期: │                                                              │
  //│修改內容: │                                                              │
  //│          │                                                              │
  //│          │                                                              │
  //│          │                                                              │
  //│          │                                                              │
  //│          │                                                              │
  //└──────────┴──────────────────────────────────────────────────────────────┘

  // -----  session 啟動 Begin ------------ //
     //session_cache_limiter("private");      // 按上頁後,之前的值可保留,若被強迫登出後,則無法再登入,且若程式更新後,仍抓舊版,除非按Ctrl+F5,或除非將IE暫存檔清空
     //session_cache_limiter("nocache");    //
     //session_start();            
  // ------ session 啟動 End -------------- //
  if ($_COOKIE['alertewb01'] != 1 and date('Ymd') <= '20111126') {  //add by 佳玟　2011.11.24
    setcookie('alertewb01', 1, time()+10800);  //3600(1hr)*3  3hr後，才會再提示一次
    echo "<script type='text/javascript'>";
    echo "alert('總公司總務組公告:\\n\\n11/26起，輸入回程里程並轉里程簽核單，需於三日內登打完畢。');";
    echo "</script>";  
  }

  include_once('/home/sl/public_html/sl_init.php');  // 共用自訂函數與變數設定
  /* ajax start */
  if ($_REQUEST['msel']=='ajax_get_emp') {
    $q = mb_convert_encoding($_REQUEST["q"],'big5','utf-8');
    /*
    big5支援有問題!中文字碼容易搜尋不到資料
    */
    if ($q==null) return;
    sl_open('sle');
    $sql = "select sle.sle09.E09_1 as empno,
                   sle.sle09.E09_2 as name,
                   docs.ewb_pay_emp_set.es03
            from sle.sle09 
                 left join docs.ewb_pay_emp_set on sle.sle09.E09_1 = docs.ewb_pay_emp_set.es02 
            where (sle.sle09.E09_1 like '{$q}%' or
                   sle.sle09.E09_2 like '{$q}%'
                  ) and sle.sle09.E09_26 = ''
            order by sle.sle09.E09_1 desc
           ";
    //echo $sql;
    $rs = mysql_query($sql);
    $rows = mysql_num_rows($rs);
    while ($ar = mysql_fetch_assoc($rs)) {
      //$items[] = $q.'-'.$ar['empno'];
      if($ar['es03']=='Y'){
        $fd_ny = "Y";
      }else{
        $fd_ny = "N";
      }
      $value = mb_convert_encoding($ar['empno'].'-'.$ar['name'].'-'.$fd_ny,'UTF-8','big5');
      echo "$value\n";
    }
    exit;
  }
  /* ajax end */
  
  /* ajax start */
  if ($_REQUEST['msel']=='ajax_get_emp2') {
    $q = mb_convert_encoding($_REQUEST["q"],'big5','utf-8');
    /*
    big5支援有問題!中文字碼容易搜尋不到資料
    */
    if ($q==null) return;
    
    sl_openef2k('EF2KWeb');  //搜尋管理的部門
    $sql_dept =  "SELECT case  
                         when (resan004=5030 ) then rl1.resal001
                         when (resan004=5029 ) then rl1.resal001
                         else rl2.resal001
                       end as resal001,
                       case  
                         when (resan004=5030) then rl1.resal002
                         when (resan004=5029) then rl1.resal002
                       else rl2.resal002
                       end as resal002,rl2.resal004,resan001,resan003,resak002,resan004
                  FROM  resan
                        LEFT JOIN resak ON resan003 = resak001
                        LEFT JOIN resal rl1 ON resan001 = rl1.resal001
                        LEFT JOIN resal rl2 ON resan001 = rl2.resal004
                  WHERE resan003 = '{$_SESSION['login_empno']}' 
                        AND resan003 <> '18'
                        AND rl2.resal898 IS NULL
                 ";						 
    $rs_dept = mssql_query($sql_dept);
    while($row_dept = mssql_fetch_array($rs_dept)){
      if( '' == $row_dept['resal004']){//沒管部門的+站長
        $sql_qq = "select resal001 , resal002 ,resal007 from resal where resal001 = '{$row_dept['resan001']}'";
        $rs_qq = mssql_query($sql_qq);
        while($row_qq = mssql_fetch_array($rs_qq)){
          $a[$row_qq['resal001']] = $row_qq['resal002'];
        }
      } 
  		else {
  		  $a[$row_dept['resal001']] = $row_dept['resal002'];
  		}
    }   
    foreach($a as $key => $val){ //管理的人員
      if( '' != $key ){
		    $jobid = $_SESSION['login_job_id'];  
        if('5'==substr($jobid,0,1)){//管理階層
          $fd_dept = substr($key,0,4);
      	  $where = "resan001 like '{$fd_dept}%' AND (resan004 <'5000' OR resan004 > '{$jobid}')";
      	}                
      	else{
      	  $where = "resak.resak001 = '{$_SESSION['login_empno']}'";
      	}
        $sql  =  "SELECT rl2.resal001,
                             rl2.resal002,
                             rl2.resal004,
                             resan001,
                             resan003,
                             resak001,
                             resak002,
                             resan004
                      FROM  resan
                            LEFT JOIN resak ON resan003 = resak001
                            LEFT JOIN resal rl1 ON resan001 = rl1.resal001
                            LEFT JOIN resal rl2 ON resan001 = rl2.resal004
                      WHERE {$where} 
                            and len(resan003) in ('7')
                      ORDER BY rl2.resal001      
                     "; 							 
        //echo "<pre>".$sql.'</pre>';
        $rs = mssql_query($sql);
        while($row = mssql_fetch_array($rs)){
          $fd_empno .= ",'{$row['resak001']}'";
        }        	
	    }
    }
    $fd_empno = substr($fd_empno,1);
    sl_open('sl');
    $sql = "select sle.sle09.E09_1 as empno,
                   sle.sle09.E09_2 as name,
                   sl.person_set.ps03 as car,
                   sl.person_set.ps06 as card
            from   sle.sle09
                   left join sl.person_set on sle.sle09.E09_1 = sl.person_set.ps01  
            where (sle.sle09.E09_1 like '{$q}%' or
                   sle.sle09.E09_2 like '{$q}%'
                  ) and sle.sle09.E09_26 = ''
                  and sle.sle09.E09_1 in ({$fd_empno})
            order by sl.person_set.ps01 desc    
           ";
    //echo $sql;
    $rs = mysql_query($sql);
    $rows = mysql_num_rows($rs);
    while ($ar = mysql_fetch_assoc($rs)) {
      //$items[] = $q.'-'.$ar['empno'];
      $value = mb_convert_encoding($ar['empno'].';'.$ar['name'].';'.$ar['car'].';'.$ar['card'],'UTF-8','big5');
      echo "$value\n";
    }
    exit;
  }
  /* ajax end */ 

  /* ajax start */
  if ($_REQUEST['msel']=='ajax_get_eb11') {
  	
    $fd_eb18 = mb_convert_encoding($_REQUEST["f_eb18"],'big5','utf-8'); 
    $fd_eb11 = mb_convert_encoding($_REQUEST["f_eb11"],'big5','utf-8'); 
    $fd_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8'); 
    $fd_eb03 = mb_convert_encoding($_REQUEST["f_eb03"],'big5','utf-8'); 
    //big5支援有問題!中文字碼容易搜尋不到資料

    $y = date('Y'); //年        
    $m = date('m'); //月
    $d = date('d'); //日      
    $fd_date = date('Ymd', mktime(0, 0, 0, $m-2, $d, $y));   //前二個月      

    if ($fd_eb18==null) return;
    sl_open('docs');
    $sql = "select docs.ewb01.*
            from   docs.ewb01 
            where  docs.ewb01.eb18 = '{$fd_eb18}' and
                   docs.ewb01.eb11 = '{$fd_eb11}' and
                   (docs.ewb01.eb02 >= '{$fd_date}' and docs.ewb01.eb03 <> '{$fd_eb03}') and
                   docs.ewb01.d_date = '0000-00-00 00:00:00'
           ";
    //echo "<pre>".$sql."</pre>";       
    $rs = mysql_query($sql);
    $count = mysql_num_rows($rs);
    if($count>0){
    	$value = mb_convert_encoding('n','UTF-8','big5');
    }else{
    	$value = mb_convert_encoding('y','UTF-8','big5');
    }
    $value = json_encode($value);
    echo "$value\n";
    exit;
  }
  /* ajax end */

  /* ajax start */
  //---------------------------------------------------------------
  // 如資料不是當月，而是先前月份重簽資料，則需判斷是否還是為異常
  //---------------------------------------------------------------
  if ($_REQUEST['msel']=='ajax_chk_eb11') {
    $fd_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8'); //外出日期
    $fd_eb18 = mb_convert_encoding($_REQUEST["f_eb18"],'big5','utf-8'); //員編
    $fd_eb11 = mb_convert_encoding($_REQUEST["f_eb11"],'big5','utf-8'); //入廠公里數
    //big5支援有問題!中文字碼容易搜尋不到資料

    $fd_ndate = date("Ymd");  //現在日期
    $y = substr($fd_eb02, 0, 4); //年         
    $m = substr($fd_eb02, 4, 2); //月  
    $d = substr($fd_eb02, 6, 2); //日
    $fd_eday = substr(date('Ymd',mktime(0, 0, 0, $m-2, $d, $y)),0,6)."01";  //前二個月
    
    if($fd_eb02 > substr($fd_eb02,0,6).'25'){
      $fd_cday = mktime(0, 0, 0, $m+2, $d, $y);  //超過25，算下個月
    }else{
      $fd_cday = mktime(0, 0, 0, $m+1, $d, $y);  //25內，本月
    }
    $fd_cday = substr(date('Ymd', $fd_cday),0,6);
    $fd_close = $fd_cday."06";  //關帳日  upd by 佳玟 2012.02.10 (待辦-14426)回應95.3 統一限定5日 23:59:59   
    //echo $fd_ndate."-----".$fd_close."...";
    if($fd_ndate > $fd_close){  //當月過期，算至下個月  (重簽資料)
    	// 外出資料與前後二筆做比對
    	$sql = "select docs.ewb01.eb02, '' as eb11, docs.ewb01.eb12 as eb12
    	        from   docs.ewb01
    	               left join docs.sleip2flw on docs.ewb01.s_num = docs.sleip2flw.sleip2flw010
                                                   and docs.sleip2flw.sleip2flw001 = 'SL-EIP2FLW'
                                                   and docs.sleip2flw.sleip2flw003 = 'docs'
                                                   and docs.sleip2flw.sleip2flw001 = 'ewb01'
                                                   and docs.sleip2flw.sleip2flw008 in ('4','12')
                                                   and docs.sleip2flw.resda021 = '2' 
    	        where  docs.ewb01.eb18 = '{$fd_eb18}'
    	               and substring(docs.ewb01.eb09,2,1) in('2','3','4')
    	               and (docs.ewb01.eb02 < '{$fd_eb02}' or (docs.ewb01.eb02 = '{$fd_eb02}' and docs.ewb01.eb12 < '{$fd_eb11}') ) 
    	               and docs.ewb01.eb02 > '{$fd_eday}'
    	               and docs.ewb01.d_date = '0000-00-00 00:00:00'
    	        order by docs.ewb01.eb02 desc,docs.ewb01.eb12 desc
    	        limit  1
    	       ";
    	//echo "<pre>".$sql."</pre>";
    	sl_open('docs');
      $rs = mysql_query($sql);
      $count = mysql_num_rows($rs);
      if($count > 0){
      	$ar = mysql_fetch_assoc($rs);
      	$value = mb_convert_encoding($ar['eb12'],'UTF-8','big5');
      }
    }else{
      $value = mb_convert_encoding('n','UTF-8','big5');
    }
    $value = json_encode($value);
    echo "$value\n";
    exit;
  }
  /* ajax end */
  
  
  /* ajax start */
  if ($_REQUEST['msel']=='ajax_chk_eb12') {
    $fd_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8'); //外出日期
    $fd_eb12 = mb_convert_encoding($_REQUEST["f_eb12"],'big5','utf-8'); //入廠公里數
    $fd_eb18 = mb_convert_encoding($_REQUEST["f_eb18"],'big5','utf-8'); //員編
    //big5支援有問題!中文字碼容易搜尋不到資料

    $fd_ndate = date("Ymd");  //現在日期
    $y = substr($fd_eb02, 0, 4); //年        
    $m = substr($fd_eb02, 4, 2); //月  
    $d = substr($fd_eb02, 6, 2); //日
    //$fd_eday = substr(date('Ymd',mktime(0, 0, 0, $m-2, $d, $y)),0,6)."";  //前二個月 
    
    if($fd_eb02 > substr($fd_eb02,0,6).'25'){
      $fd_cday = mktime(0, 0, 0, $m+2, $d, $y);  //超過25，算下個月     
    }else{
      $fd_cday = mktime(0, 0, 0, $m+1, $d, $y);  //25內，本月
    }
    $fd_cday = substr(date('Ymd', $fd_cday),0,6);
    $fd_close = $fd_cday."06";  //關帳日  upd by 佳玟 2012.02.10 (待辦-14426)回應95.3 統一限定5日 23:59:59   
    //echo $fd_ndate."-----".$fd_close."...";
    if($fd_ndate > $fd_close){  //當月過期，算至下個月
    	// 1. 外出資料與前後二筆做比對
    	$sql = "select docs.ewb01.eb02, docs.ewb01.eb11 as eb11, '' as eb12
    	        from   docs.ewb01
    	               left join docs.sleip2flw on docs.ewb01.s_num = docs.sleip2flw.sleip2flw010
                                                   and docs.sleip2flw.sleip2flw001 = 'SL-EIP2FLW'
                                                   and docs.sleip2flw.sleip2flw003 = 'docs'
                                                   and docs.sleip2flw.sleip2flw001 = 'ewb01'
                                                   and docs.sleip2flw.sleip2flw008 in ('4','12')
                                                   and docs.sleip2flw.resda021 = '2' 
    	        where  docs.ewb01.eb18 = '{$fd_eb18}'
    	               and substring(docs.ewb01.eb09,2,1) in('2','3','4')
    	               and (docs.ewb01.eb02 > '{$fd_eb02}' or (docs.ewb01.eb02 = '{$fd_eb02}' and docs.ewb01.eb12 > '{$fd_eb12}') )
    	               and docs.ewb01.eb02 < '{$fd_close}'
    	               and docs.ewb01.d_date = '0000-00-00 00:00:00'
    	        order by docs.ewb01.eb02 asc, docs.ewb01.eb12 asc
    	        limit  1
    	       ";
    	//echo "<pre>".$sql."</pre>";       
    	sl_open('docs');       
      $rs = mysql_query($sql);
      $count = mysql_num_rows($rs);
      if($count > 0){
      	$ar = mysql_fetch_assoc($rs);
      	$value = mb_convert_encoding($ar['eb11'],'UTF-8','big5');
      }
    }else{
      $value = mb_convert_encoding('n','UTF-8','big5');
    }
    $value = json_encode($value);
    echo "$value\n";
    exit;
  }
  if ($_REQUEST['msel']=='ajax_chkhrm') {        
    $f_eb04 = mb_convert_encoding($_REQUEST["f_eb04"],'big5','utf-8');
    $f_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8');
    $f_eb03 = mb_convert_encoding($_REQUEST["f_eb03"],'big5','utf-8');
    $f_eb06 = mb_convert_encoding($_REQUEST["f_eb06"],'big5','utf-8');
    $f_eb07 = mb_convert_encoding($_REQUEST["f_eb07"],'big5','utf-8');
    $f_tohrm = mb_convert_encoding($_REQUEST["f_tohrm"],'big5','utf-8');
    //$f_eb08 = mb_convert_encoding($_REQUEST["f_eb04"],'big5','utf-8');
    if ($f_tohrm=='N') return;
    if ($f_eb04==null) return;                  
    if ($f_eb02==null) return;
    if ($f_eb03==null) return;
    if ($f_eb06==null) return;
    if ($f_eb07==null) return;
    //if ($f_eb08==null) return;
    $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
    $f_var['hrmws']['method'] = "CheckForESS";
    $f_var['hrmws']['parameterType'] = "";
    $f_var['hrmws']['parm'][1]['String'] = "SL-EIP2FLW"; //單別
    $f_var['hrmws']['parm'][2]['String'] = "00000000"; //單號
    $f_var['hrmws']['parm'][3]['Int32'] = 2; //登記類型(1.按申請登記、2.直接登記)
    $f_var['hrmws']['parm'][4]['String'] = ""; //出差申請id (如果直接登記為空值)
    $f_var['hrmws']['parm'][5]['String'] = $_SESSION["login_hrm_empid"]; //員工ID
    $f_var['hrmws']['parm'][6]['String'] = "701"; //出差類型id  A1136|出差(無伙食)   A1136|出差(無伙食)
    $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($f_eb04,'UTF-8','big5'); //出差地點
    $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($f_eb02); //開始日期
    $f_var['hrmws']['parm'][9]['String'] = substr($f_eb03,0,2).":".substr($f_eb03,2,2); //開始時間
    $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($f_eb06); //結束日期
    $f_var['hrmws']['parm'][11]['String'] = substr($f_eb07,0,2).":".substr($f_eb07,2,2); //結束時間
    $f_var['hrmws']['parm'][12]['Int32'] = "0"; //扣除休息班次
    //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //備註
    $f_var['hrmws']['parm'][13]['String'] = "-ajax_chkhrm"; //備註
    $f_var['hrmws']['parm'][14]['Int32'] = "0"; //扣除非在公司時間
    $f_var['hrmws']['parm'][15]['Int32'] = "0"; //扣除休息班次?加班就餐段（0否，1是）
    sl_hrmws($f_var); 
    //if( '1530693'==$_SESSION["login_empno"] ){
    //  echo "<pre>";
    //  print_r($f_var['hrmws']);
    //  echo "</pre>";
    //  echo "<font color=red>";
    //  echo htmlspecialchars($f_var['hrmws']['pxml'],ENT_QUOTES)."<br>";
    //  echo "</font>";
    //}
    if( '0'==$f_var['hrmws']['status'] ){  //驗證成功  非0為失敗
      $value = mb_convert_encoding("0; ",'UTF-8','big5');
    }else{
      $val  = "1;"; //非0為失敗        
      //if( ''==trim($f_var['hrmws']['status']) and ''==trim($f_var['hrmws']['error']) and strstr($f_eb04,"&")!=null ){
        //$val .= "請確認「前往地點」不得存在「&」符號"; //錯誤訊息
      //}else{
        $val .= $f_var['hrmws']['error']; //錯誤訊息
      //}
      $val .= "\n其它異常可能: 請確認「前往地點」不得存在「&」符號"; //錯誤訊息
      $value = mb_convert_encoding($val,'UTF-8','big5');      
    }
    $value = json_encode($value);
    echo "$value\n";
    exit;
  }
  /* ajax end */  
  
  /* ajax start */
  if ($_REQUEST['msel']=='ajax_chk_slcar01_09') {
    $q = mb_convert_encoding($_REQUEST["q"],'big5','utf-8');
    /*
    big5支援有問題!中文字碼容易搜尋不到資料
    */
    if ($q==null) return;
    sl_open('slcar');
    $sql = "select car01_09
            from sl_car01
            where d_date = '0000-00-00 00:00:00'
                  and car01_01 like '01%'
                  and car01_03 like '02%'
                  and car01_09 like '%{$q}%'
           ";
    //echo $sql;
    $rs = mysql_query($sql);
    $rows = mysql_num_rows($rs);
    if($rows > 0){ //有資料
      $fd_ny = "Y";
    }else{
      $fd_ny = "N";
    }
    $value = $fd_ny;
    echo $value;
    exit;
  }
  /* ajax end */





  /* ajax start */
  //if ($_REQUEST['msel']=='ajax_get_eb12') {
  //  $fd_snum = mb_convert_encoding($_REQUEST["f_snum"],'big5','utf-8');
    /*
    big5支援有問題!中文字碼容易搜尋不到資料
    */
  //  if ($fd_snum==null) return;
  //  sl_open('docs');
  // $sql = "select docs.sleip2flw.resda019,
  //                 docs.sleip2flw.sleip2flw010,
  //                 docs.ewb01.eb06
  //          from   docs.sleip2flw 
  //                 left join docs.ewb01 on docs.sleip2flw.sleip2flw010 = docs.ewb01.s_num
  //          where docs.sleip2flw.sleip2flw008 in ('1','3') and
  //                docs.sleip2flw.resda020 = '3' and
  //                docs.sleip2flw.resda021 = '2' and 
  //                docs.sleip2flw.d_date = '0000-00-00 00:00:00' and
  //                docs.sleip2flw.sleip2flw010 = '{$fd_snum}'
  //         ";
  //  $rs = mysql_query($sql);
  //  $rows = mysql_num_rows($rs);
  //  while ($ar = mysql_fetch_assoc($rs)) {
  //    $fd_eb06 = substr($ar['eb06'],0,4)."-".substr($ar['eb06'],4,2)."-".substr($ar['eb06'],6,2);
  //    $value = mb_convert_encoding($ar['resda019'].';'.$ar['sleip2flw010'].';'.$fd_eb06,'UTF-8','big5'); //upd by 佳玟 2011.12.12 (報修-15683)開放高永民 7966431 修改里程  11/28.11/29.12/2
  //  }
    //$value2 .= mb_convert_encoding($value.";".sl_4ymd($value),'UTF-8','big5');  //upd by 佳玟 2011.12.12 (報修-15683)開放高永民 7966431 修改里程  11/28.11/29.12/2
  //  $value = json_encode($value);
  //  echo "$value\n";
  //  exit;
  //}
  /* ajax end */    

  /* ajax start */
  //if ($_REQUEST['msel']=='ajax_get_day') {
  //  $fd_sd = mb_convert_encoding($_REQUEST["f_sd"],'big5','utf-8');
    /*
    big5支援有問題!中文字碼容易搜尋不到資料
    */
  //  if ($fd_sd==null) return;
  //  $y = substr($fd_sd, 0, 4); //取前四碼 (年)        
  //  $m = substr($fd_sd, 4, 2); //取最後二碥(月)
  //  $d = substr($fd_sd, 6, 2); //取最後二碥(日)
  //  $fd_sday = mktime(0, 0, 0, $m, $d, $y);      
  //  $add2day  = mktime(0, 0, 0, $m, $d+20, $y);   //日加20天
    //$lastmonth = mktime(0, 0, 0, $m, "01", $y);   //插尋月份第一天 
    //$nowmonth = strtotime('+1 month -1 days', $lastmonth);   //插尋月份最後一天      
  //  $fd_sd2 = date('Ymd', $add2day);
  //  $fd_sde = $fd_sd2 - 19110000;  //轉民國年
  //  $fd_sds = $fd_sd - 19110000; //轉民國年
  //  sl_open('sle');
  //  $sql = "select sle.sle0a.E0A_1 as date
  //          from   sle.sle0a 
  //          where  sle.sle0a.E0A_1 between '{$fd_sds}' and '{$fd_sde}'
  //          order by sle.sle0a.E0A_1
  //         ";
  //  $rs = mysql_query($sql);
  //  $rows = mysql_num_rows($rs);
    
  //  $ar_date[0]=$fd_sd;
  //  for($i=1;$i<20;$i++){
  //    $fd_date1  = mktime(0, 0, 0, $m, $d+$i, $y);   
  //    $fd_date2  = date('Ymd', $fd_date1);       
  //    $ar_date[$i] = $fd_date2-19110000;
  //  }    
    
  //  $adday = -1;
  //  while ($ar = mysql_fetch_assoc($rs)) {
  //    for($j=0;$j<20;$j++){
  //      if($ar_date[$j]<>$ar['date'] and $adday<>4){
  //       $value=$ar_date[$j]+19110000; //轉西元年
  //        $adday++;          
  //      }
  //    }
  //  } 
    
    //$value = mb_convert_encoding($value.";".sl_4ymd($value),'UTF-8','big5'); 
    
  
    //$value = json_encode($value);
  //  echo "$value\n";
  //  exit;
  //}
  /* ajax end */ 

  session_start();  //upd by mimi 2009.04.23 記錄外出白板查詢條件
  include_once('ewb01_init.php');  // 提善改善共用自訂函數與變數設定
  include_once(  "ewb_pay_init.php"  );
  u_setvar(&$f_var);            // 程式變數設定,全部改用陣列變數,不再用 global u_setvar(&$f_var),需要用&,傳值,可以將值回傳,後面繼續用值
  u_domain(&$f_var);  //權限 ewb_pay_init.php
  include_once($sl_header_php); // header

  include_once(  $mtp_url."class.TemplatePower.inc.php"  ); //qq: $sl_tp_url ?
  $f_var["tp"] = new  TemplatePower (  $f_var['tpl']  );//'pa01.tpl';  // 樣版畫面檔
  $f_var["tp"]-> assignInclude ("tb_sl_tpl_1","/home/sl/public_html/sl_tpl_1.tpl"      ); // 共用樣板檔
  $f_var["tp"]-> prepare ();

  sl_open($f_var['mdb']); // 開啟資料庫
  $f_var['f_b_empno']=$_SESSION['login_empno'];
  $f_var['f_db']=$f_var['mdb'];
  $f_var['f_table']=$f_var['mtable']['head'];
  $f_var['f_file_path']='';
  $f_var['f_b_date']=date('Ymd');
  $f_var['f_file1']='';
  $f_var['f_file2']='';
  $f_var['f_file3']='';
//  $msg_title = "外出白板自動轉成<font color=blue>外出簽核單</font>及<font color=blue>里程簽核單</font>,自11/07起已於全區使用.<br><br>
//                1. 待<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，即可修改里程，並自動轉<font color=blue>里程簽核單</font>。<br>
//                2. 待<font color=blue>里程簽核單</font>簽核<font color=red>同意</font>後，才會計算於私車公用統計表。<br>
//                3. 11/07後，由於<font color=blue>多筆里程輸入</font>不會跑簽核，所以此功能移除，請<font color=blue>單筆</font>修改外出里程。<br>
//                4. 若有疑問請詢問總公司總務組。";
  $msg_title = "外出白板自動轉成<font color=blue>外出簽核單</font>及<font color=blue>里程簽核單</font>,自11/07起已於全區使用.<br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;1. 待<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，即可修改里程，並轉<font color=blue>里程簽核單</font>。<br>
                &nbsp;&nbsp;&nbsp;&nbsp;2. 待<font color=blue>里程簽核單</font>簽核<font color=red>同意</font>後，才會計算於私車公用統計表。<br>
                &nbsp;&nbsp;&nbsp;&nbsp;3. 11/07後，由於<font color=blue>多筆里程輸入</font>不會跑簽核，所以此功能移除，請<font color=blue>單筆</font>修改外出里程。<br>
                <font color=red>＊</font>4. <font size='3'><b>依總公司規定自11/26起，輸入回程里程並轉里程簽核單，需於<font color=red>簽核結案(預計回程日)後三日內</font>登打完畢。</b></font><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ex: 基準日 2011-12-21(三)，其往後算三日為 2011-12-23(五)(含)前要填寫完里程！當日也包含於三日內！<br>
                <font color=red>＊</font>5. <font color=red>若有疑問請詢問總公司總務組。</font><br>
                <font color=red>＊</font>6. <b>群簽</b>簽核的外出資料，轉檔時間為<font color=red>整點</font>，請於轉檔結束後再進行修改<br>
                <font color=red>＊</font>7. <b>填寫里程</b>，請於<font color=blue>調車簽核單</font>簽核<font color=red>同意</font>後，再進行修改填寫。<br>
                <font color=red>＊</font>8. 如里程填錯，將<font color=blue>里程簽核單</font><font color=red>抽單</font>後，可再次修改里程重傳里程簽核單(於規定三日內)。<br>
                <font color=red>＊</font>9. 如哩程登打錯誤或是已超過登打期限，欲開放請洽各區<font color=red>管理課課長</font>。
                ";

  //u_eip2del();  //add by 佳玟  2011.11.23  課長指示簽核單如為抽單者，回壓d_date作廢   upd by 佳玟 2011.12.28 改到瀏覽畫面才執行
  $f_var["tp"]-> newBlock ("tb_text_ndate");    //add by 佳玟 2011.11.24  防止使用者自行變更系統日期，所以判斷日期採用servertime.html的伺服器時間
  $f_var["tp"]-> assign   ("tv_value" ,date("Y-m-d"));       
  switch ($f_var['msel']) {
       case "1": // 新增-畫面  
         if( ''!=trim($f_var['hrmctrl']) ){ //add by 佳玟 2018.12.04 依資訊網頁/權限管理/鼎新版更時間控制設定 控制開放始用時間
           sl_errmsg($f_var['hrmctrl']);
         }   
         sl_chk_rak013(&$f_var);//add by mimi 2011.11.28 報修-15581 確認是否有直屬主管
         //$f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by 佳玟 2011.12.28  經理指示，將上方注意事項隱藏摺疊
         //sl_errmsg($msg_title);
         $f_var["tp"]->newBlock('tb_memo1');
         u_in_scr($f_var);
         $f_var["tp"]->newBlock('fd_script_eb13');
         $f_var["tp"]->newBlock('fd_script_eb01');
         $f_var["tp"]->newBlock('fd_script_close_eb12');  //add by 佳玟 2011.12.23  新增外出時，入廠里程不得輸入（鎖住） (待辦-14426回應61)
         break;
       case "11": // 新增-儲存
         if( 'Y'==$f_var['f_tohrm']){  //不確定為什麼有人闖過json驗證, 在save前再驗證一次                                          
           $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
           $f_var['hrmws']['method'] = "CheckForESS";
           $f_var['hrmws']['parameterType'] = "";
           $f_var['hrmws']['parm'][1]['String'] = ''; //單別
           $f_var['hrmws']['parm'][2]['String'] = ''; //單號
           $f_var['hrmws']['parm'][3]['Int32'] = 2; //登記類型(1.按申請登記、2.直接登記)
           $f_var['hrmws']['parm'][4]['String'] = ""; //出差申請id (如果直接登記為空值)
           $f_var['hrmws']['parm'][5]['String'] = $_SESSION["login_hrm_empid"]; //員工ID
           $f_var['hrmws']['parm'][6]['String'] = "701"; //出差類型id  A1136|出差(無伙食)   A1136|出差(無伙食)
           $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($f_var['f_eb04'],'UTF-8','big5'); //出差地點
           $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($f_var['f_eb02']); //開始日期
           $f_var['hrmws']['parm'][9]['String'] = substr($f_var['f_eb03'],0,2).":".substr($f_var['f_eb03'],2,2); //開始時間
           $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($f_var['f_eb06']); //結束日期
           $f_var['hrmws']['parm'][11]['String'] = substr($f_var['f_eb07'],0,2).":".substr($f_var['f_eb07'],2,2); //結束時間
           $f_var['hrmws']['parm'][12]['Int32'] = "1"; //扣除休息班次
           //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //備註
           $f_var['hrmws']['parm'][13]['String'] = "-msel=11"; //備註
           $f_var['hrmws']['parm'][14]['Int32'] = "1"; //扣除非在公司時間
           $f_var['hrmws']['parm'][15]['Int32'] = "1"; //扣除休息班次?加班就餐段（0否，1是）
           sl_hrmws($f_var);                            
           //echo "<pre>";
           //print_r($f_var['hrmws']);
           //echo "</pre>";      
           if( '0'!=$f_var['hrmws']['status'] ){ //驗證成功  非0為失敗
             $fd_inLog  = "<font style='font-weight:bold;color:red;font-size:24px;'>注意!! 外出資料至HRM驗證失敗, 外出申請異常</font><br>";
             $fd_inLog .= "status: ".$f_var['hrmws']['status']." (非0為失敗)<br>";
             $fd_inLog .= "error: <font style='font-weight:bold;color:blue;font-size:16px;'>".$f_var['hrmws']['error']."</font><br><br>";
             $fd_inLog .= "出差地點: ".$f_var['f_eb04']."<br>";
             $fd_inLog .= "外出日期: ".sl_4ymd($f_var['f_eb02'])." ".substr($f_var['f_eb03'],0,2).":".substr($f_var['f_eb03'],2,2)."<br>";
             $fd_inLog .= "回程日期: ".sl_4ymd($f_var['f_eb06'])." ".substr($f_var['f_eb07'],0,2).":".substr($f_var['f_eb07'],2,2)."<br>";
             $fd_inLog .= "<br><br><font style='font-weight:bold;color:red;'>「出退勤紀錄轉入HR(鼎新)」</font>您選擇為 <font style='font-weight:bold;color:red;'>Y</font> , HRM騎證後有異常, 資料無法轉入, <br>請先確認輸入的資料格式無誤, 或與各區人事了解問題後重新登打。<br><br>";
             $fd_inLog .= "【<a href='/~docs/ewb/ewb01.php?msel=1'>回外出新增畫面</a>】<br>";
             sl_errmsg($fd_inLog);
             exit;
           }
         }                                
         $sql_set = "select es02
                     from   docs.ewb_pay_emp_set 
                     where  es02 = '{$_SESSION["login_empno"]}' and 
                            d_date = '0000-00-00 00:00:00' and
                            es03 = 'Y'
                    ";
         $rs_set = mysql_query($sql_set);
         $count_set = mysql_num_rows($rs_set);
         if($count_set>0){
           $f_var['f_eb17'] = "Y"; //有資料則扣除標準里程
         }        
         //echo "eb17: ".$f_var['f_eb17']."<br>";
         //exit;
         $f_var['f_cnt']='1';//upd by mimi 2011.06.13 增加轉檔次數
         //echo $_SESSION['login_job_id'].'****'.$f_var['domain'].'****'.$f_var['domain4'].'----'.$_SESSION['login_dept_id'].'******'.$f_var['domain2'];exit;
         if($f_var['domain4']<>''){//add by mimi 2012.01.12 報修-16058 經理級以上只要簽核一層 type=11.調車單(經理)
           $f_var['f_type']='11';
         }
         else{
           $f_var['f_type']=iif($f_var['domain1']<>'','3','1');//type=3.物流調車單 type=1.一般調車單
         }
         $to_date=date("Ymd");
         
         //add by 佳玟 2012.01.18 (報修-16099)黃冠中 7665865 12/26起至1/13外出新增
         $fd_opensave = 'N';
         $f_var['qa16099'] = strstr('7665865',$_SESSION["login_empno"]);
         if($f_var['qa16099']<>null and ($f_var['f_eb02']>='20111226' and $f_var['f_eb02']<='20120113')){
           $fd_opensave = 'Y';
         }
         //add by 佳玟 2014.11.11 (報修24995)徐志文調車單簽核有誤
         $f_var['qa24995'] = strstr('1430451',$_SESSION["login_empno"]);
         if($f_var['qa24995']<>null and ($f_var['f_eb02']>='20141104' and $f_var['f_eb02']<='20141104')){
           $fd_opensave = 'Y';
         }         
         //$f_var['qa0515'] = strstr('0883608/1070263/8166480/1330776/7968256/1330011',$_SESSION["login_empno"]);
         //if($f_var['qa0515']<>null and ($f_var['f_eb02']>='20140509' and $f_var['f_eb02']<='20140515')){
         //  $fd_opensave = 'Y';  
         //}        
         if($f_var['f_eb02']>=$to_date or $fd_opensave=='Y'){  //只能新增 >= 今天日期的外出資料           
           $fd_eb023 =$f_var['f_eb02'].$f_var['f_eb03']; 
           $fd_eb067 =$f_var['f_eb06'].$f_var['f_eb07']; 
           if($fd_eb023<=$fd_eb067){
             //sl_save(&$f_var);
             //if('' <> $f_var['domain1'] or '' <> $f_var['domain2'] or '' <> $f_var['domain3']){//add by mimi 2011.06.02 判斷物流和資料的,才要轉簽核表
               //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
               $query = "select *
                         from information_schema.TABLES 
                         where TABLE_SCHEMA = '{$f_var['mdb']}' and TABLE_NAME = '{$f_var['mtable']['head']}'
                      ";
               //echo $query."<BR>";
               //echo $row['AUTO_INCREMENT'];
               $result = mysql_query($query);
               $row =mysql_fetch_array($result);
               $f_var['f_s_num']=$row['AUTO_INCREMENT'];
               $f_var['f_title']=substr($f_var['f_eb09'],3)."外出調車單 {$f_var['f_eb01']} ".date('m/d',strtotime($f_var['f_eb02']));
               if( 'Y'==$f_var['f_tohrm']){ 
                 $f_var['f_title']= "*".substr($f_var['f_eb09'],3)."外出調車單 {$f_var['f_eb01']} ".date('m/d',strtotime($f_var['f_eb02']));
               }
               $f_var['f_content']="
　　　　　　外出日期：".date('m/d',strtotime($f_var['f_eb02']))." ".date('H:i',strtotime($f_var['f_eb03']))." ~ ".date('m/d',strtotime($f_var['f_eb06']))." ".date('H:i',strtotime($f_var['f_eb07']))."
　　　　　　行駛區間：{$f_var['f_eb16']} ~ {$f_var['f_eb04']}   

　　　　　　外出事由：{$f_var['f_eb05']}  
　　　　　　　　車種：".substr($f_var['f_eb09'],3)." ".substr($f_var['f_eb10'],3)."
往返調任地扣除30公里：{$f_var['f_eb24']}　回數票：{$f_var['f_eb14']}　乘車人數：{$f_var['f_eb15']}   
　　　　　　　　備註：{$f_var['f_eb08']}
　　　　　　填單日期：".date('Y/m/d H:i')."
　　　　";
//扣除標準里程：{$f_var['f_eb17']}　回數票：{$f_var['f_eb14']}　乘車人數：{$f_var['f_eb15']}
//   upd by 佳玟 2011.10.05 (待辦-14426 回應30)  
//               $f_var['f_title']="{$f_var['f_eb01']} 外出調車單";           
//               $f_var['f_content']="
//　　同仁姓名：{$f_var['f_sname']}-{$f_var['f_eb01']}
//
//　　外出日期：".date('Y/m/d',strtotime($f_var['f_eb02']))." ".date('H:i',strtotime($f_var['f_eb03']))."
//　　前往地點：{$f_var['f_eb04']}   
//  
//　　回程日期：".date('Y/m/d',strtotime($f_var['f_eb06']))." ".date('H:i',strtotime($f_var['f_eb07']))."
//　　回程地點：{$f_var['f_eb16']}
//  
//　　前往事由：{$f_var['f_eb05']}  
//　　　　車種：{$f_var['f_eb09']}
//　　　排氣量：{$f_var['f_eb10']} 
//扣除標準里程：{$f_var['f_eb17']} 
//　　　回數票：{$f_var['f_eb14']}   
//　　乘車人數：{$f_var['f_eb15']}   
//　　　　備註：{$f_var['f_eb08']}
//　　建檔日期：".date('Y/m/d H:i:s')."
//　　　　";

             if(u_chk_ewb01($f_var)){ //add by 佳玟 2011.11.23  查閱是否重覆新增
               $f_var['chkewb'] = "y";   
               /*if( 'S181'==$_SESSION["login_dept_id"] ){  //add by 佳玟 報修32441-簽核至稽核最高主管
                 ul_eip2flw(&$f_var);
               }else mark by 小樵20191022報修37078 將稽核外出白板更改為依照原設定 二關*/ 
               if( strstr('1730055/1130091',$_SESSION["login_empno"])!=NULL ){
                 sl_eip2flwV2(&$f_var);       
               }else{
                 sl_eip2flw(&$f_var);//add by mimi 2011.06.02 轉簽核表
               }
                 
               //}  //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
               sl_open('docs');
               sl_save(&$f_var);//upd by mimi 2011.11.18 改為先寫入簽核表後再回入EIP    

                 
                 
             }else{
               $f_var['chkewb'] = "n";
               sl_errmsg("外出/預計回程日期時間已有重覆資料存在,請確認資料是否有誤!");//add by mimi 2012.01.06 增加錯誤的提示訊息~ 
             }
           }
           else{
             sl_errmsg("請確認外出/預計回程日期時間,是否有誤!"); 
           }
         }
         else{
           sl_errmsg("外出日期有誤!"); 
         }
         break;
       case "2": // 修改
         
         sl_chk_rak013(&$f_var);//add by mimi 2011.11.28 報修-15581 確認是否有直屬主管
         //add by 佳玟  2011.10.17 判斷es03欄位是否設定為y，如是則設定為扣除里程120
         $sql_set = "select docs.ewb_pay_emp_set.es02
                 from   docs.ewb_pay_emp_set 
                 where  docs.ewb_pay_emp_set.es02 = '{$_SESSION["login_empno"]}' and 
                        docs.ewb_pay_emp_set.es03 = 'Y'
                ";
         $rs_set = mysql_query($sql_set);
         $count_set = mysql_num_rows($rs_set);
         if($count_set>0){
           $fd_eb17 = "Y"; //有資料則扣除標準里程
         }else{
           $fd_eb17 = "N";
         }         
         echo "<input name='fdny' type='hidden' value='{$fd_eb17}'>";  //add by 佳玟  2011.10.17 作為javascript是否鎖定「扣除標準里程」的依據        
         $f_var["tp"]->newBlock('tb_memo2');
         //sl_errmsg("外車白板連結電子簽核系統,自6/7起於物流處先行使用,依高協理指示,應於前一天填寫.");
         //20110411 佳玟 (增加轉油貼統計表的判斷 ewb_pay01.php)
         $f_var['check_mwhere']="{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
         $sql = "select {$f_var['mtable']['head']}.*
                 from   {$f_var['mtable']['head']}
                 where  {$f_var['check_mwhere']}
                ";     //20110607-(報修13954)- 將where條件and ewb01.eb19<>''移除
         $rs = mysql_query($sql);
         //$check_total = mysql_num_rows($rs);
         $ar = mysql_fetch_assoc($rs);
         //if($ar['eb19'] != ''){  //已轉檔產生統計表(ewb_pay01.php)
         if($ar['eb22'] != ''){  // upd by 佳玟 2012.05.29 作帳年月不為空白，表示已作帳發油貼
           sl_errmsg("已轉私車公用耗油統計表! 無法修改資料! ");
         }       
         else{         
           //echo $_SESSION["login_empno"];
           if($ar['eb18'] == $_SESSION["login_empno"]){
             $fd_empno = $ar['eb18']; 
             $fd_upd_chk="Y";
             sl_open('docs');
             $count_table= substr_count($f_var['mtable']['head'],'.');
             $ex_table   = explode('.',$f_var['mtable']['head']);
             $fd_table   = iif($count_table==0,$f_var['mtable']['head'],$ex_table[1]);
             $query      = "select sleip2flw.* ,
                               CASE 
                                 WHEN resda021 = '' THEN '<font color=blue>簽核進行中</font>'
                                 WHEN resda021 = '1' THEN '<font color=blue>簽核進行中</font>'
                                 WHEN resda021 = '2' THEN '<font color=#006600>已同意</font>'
                                 WHEN resda021 = '3' THEN '<font color=red>不同意</font>'
                                 WHEN resda021 = '4' THEN '<font color=red>已抽單</font>'
                               END AS resda021_list
                            from docs.sleip2flw
                            where sleip2flw003='{$f_var['mdb']}'
                                  and sleip2flw004='{$fd_table}'
                                  and sleip2flw010='{$f_var['f_s_num']}'
                                  and d_date='0000-00-00 00:00:00'
                            order by s_num
                               "; 
             //echo $query;              
             $result = mysql_query($query);
             $num = mysql_num_rows($result);  //筆數
             if($num > 0){
              while($row = mysql_fetch_array($result)){
                if('1'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'])){ //調車單 未完成,不同意,已抽單都不可再修改
                  $fd_upd_chk="N";
                  $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 調車簽核單目前顯示{$row['resda021_list']},因此不可進行修改。";
                }else if( '1'==$row['sleip2flw011'] and '2'==$row['resda021'] ){
                  $fd_upd_chk="Y"; //upd by 7/21簽核單有問題處理
                }
                if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '2'==$row['resda021'])){ //調車單 未完成,不同意,已抽單都不可再修改
                  //if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'])){ //調車單 未完成,不同意,已抽單都不可再修改
                  $fd_upd_chk="N";
                  $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 里程簽核單 目前顯示{$row['resda021_list']},因此不可進行修改。";
                }
                
                if(('1'==$row['sleip2flw008'] or '3'==$row['sleip2flw008'] or '11'==$row['sleip2flw008']) and '2'==$row['resda021']){ //調車單為同意者
                  $fd_resda19 = $row['resda019'];
                }
                if('4'==$row['sleip2flw008'] and '3'==$row['resda021']){  //里程簽核單不同意者
                  $fd_resda194 = $row['resda019'];
                }                
                //if('4'==$row['sleip2flw008'] and '2'==$row['resda021']){  //里程簽核單同意者
                //  $fd_qa1223_2 = 'Y';
                //}                                        
              }
             }
             
             $fd_sign = substr($ar['eb06'], 0, 4)."-".substr($ar['eb06'], 4, 2)."-".substr($ar['eb06'], 6, 2); //預計回程日期八碼         
             if($fd_resda19<$fd_sign){  //add by 佳玟 2011.12.22   當預計回程日期大於簽核日期時 
               $fd_resda19 = $fd_sign;       
             }
             if($fd_resda194>$fd_resda19 and $fd_resda194>$fd_sign){  //當里程簽核單不同意者，日期延常，抓不同意單的結案日期
               $fd_resda19 = $fd_resda194;
             }
             $fd_setdate = str_replace('-','',substr($fd_resda19,0,10)); //原 2012-05-31  -> 21020531
             $fd_resda19 = $fd_setdate;  //紀錄最大建檔或異動日期           
             
             //if( '8365628'==$_SESSION["login_empno"] ){
             //    echo $fd_resda19.'<br>';
             //  }
                                
             //ECHO $fd_resda19;
             //搜尋外出白板開放修改設定檔是否有資料---------------------------------------------// 
             sl_open('docs');
             $query_es = "select ewb_set03.es01,
                                 ewb_set03.es02,
                                 ewb_set03.es03,
                                 ewb_set03.es04,
                                 case 
                                    when ewb_set03.b_date>ewb_set03.m_date then
                                         ewb_set03.b_date
                                    else ewb_set03.m_date end as date                                
                          from   ewb_set03
                          where  ewb_set03.d_date = '0000-00-00 00:00:00' and
                                 ewb_set03.es02 = '{$ar['eb18']}' and
                                /*'{$ar['eb02']}' between ewb_set03.es03 and ewb_set03.es04   */
                                 (ewb_set03.es03 <= '{$ar['eb02']}' and ewb_set03.es04 >= '{$ar['eb02']}')
                          order by date desc
                          limit 1
                       ";  //搜尋 ewb_set03 是否有設定開放外出
             //echo '<pre>'.$query_es.'</pre>';
             $result_es  = mysql_query($query_es);
             $num_es = mysql_num_rows($result_es);  //筆數
             if($num_es>0){             
               $row_es = mysql_fetch_array($result_es);
               $fd_start_eb02 = $row_es['es03'];  //紀錄最小外出日起
               $fd_end_eb02   = $row_es['es04'];  //紀錄最大外出日迄
               $fd_setdate = str_replace('-','',substr($row_es['date'],0,10)); //原 2012-05-31  -> 21020531
               //$fd_resda19 = $fd_setdate;  //紀錄最大建檔或異動日期  
               
               //upd by 佳玟 2013.11.22 課長來能，林經理11/18不得修改哩程，因為有人至設定檔內設定人員開放修改里程，程式會判斷建立日b_date 來做為依據開放截止日
               if( $fd_resda19<$fd_setdate ){ //簽核完成日 < 設定開放日 ，才以設定檔內開放日為主
                 $fd_resda19 = $fd_setdate;  //紀錄最大建檔或異動日期  
               }
             
             }    

             //計算三天內排除國定假日-----------------------------------------------------------// 
             $cal_cnt=0;
             $y = substr($fd_resda19, 0, 4); //年          
             $m = substr($fd_resda19, 4, 2); //月  
             $d = substr($fd_resda19, 6, 2); //日        
             for($fd_cnt=0;$fd_cnt<='3';$fd_cnt++){ //三天內跳脫國定假日       
               $fd_resda192_mk = mktime(0, 0, 0, $m, $d+$cal_cnt, $y);  //upd by 佳玟 2012.04.14 列出日期有誤
             	 $fd_resda192    = date('Ymd', $fd_resda192_mk);
             	 $ch_resda192    = $fd_resda192 - 19110000;
             	 
             	 //echo $y."---".$m."---".$d."---".$fd_resda192."---".$ch_resda192."<br>"; 
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


               //echo $ch_resda192."---".$rows99."<br>";
               //$date_n = date("Ymd");
               //if( strstr("1020101",$ch_resda192) ){
               //  $rows99 = 1;
               //}
               
               //echo $cal_cnt."----".$rows99."----"."<br>";
               if($rows99 <> '0'){
                 $fd_cnt-=1;
               }
               //else{
                 //add by 佳玟 2013.01.02 人事國定六日設定檔未轉入 sle0a ，先暫時加上國定判斷
                 //if( strstr("1020101/1020105/1020106/1020112/1020113/1020119/1020120/1020126/1020127","{$ch_resda192}") ){
                 //  $fd_cnt-=1;
                 //}
                 //if( strstr("1020202/1020203/1020209/1020210/1020211/1020212/1020213/1020214/1020215/1020216/1020217/1020224/1020228","{$ch_resda192}") ){
                 //  $fd_cnt-=1;
                 //}                 
               //}
               $cal_cnt++;
               
               
               
            }
            
            //設定關帳日------------------------------------------------------------------------// 
            $fd_ndate = date("Ymd");  //現在日期
            //add by 佳玟 2012.01.03 關帳日日期
            $y2 = substr($ar['eb02'], 0, 4); //取前四碼 (年)        
            $m2 = substr($ar['eb02'], 4, 2); //取最後二碥(月)  
            $d2 = substr($ar['eb02'], 6, 2); //日
            if($ar['eb02']>substr($ar['eb02'],0,6).'25'){
              $fd_sday3 = mktime(0, 0, 0, $m2+2, $d2, $y2);  //超過25，算下個月
            }else{
              $fd_sday3 = mktime(0, 0, 0, $m2+1, $d2, $y2);  //25內，本月
            }
            $fd_sday3 = substr(date('Ymd', $fd_sday3),0,6);
            $fd_close = $fd_sday3."06";  //預設關帳日  upd by 佳玟 2012.02.10 (待辦-14426)回應95.3 統一限定5日 23:59:59            
            
            //開放三日後貼報修修改里程----------------------------------------------------------//
            //被設定重簽的外出資料，保留三個月，超過期限視同放棄  (待辦14426 回應137) 
            if($num_es>0 AND 'N'!=$fd_upd_chk ){ //如set03 設定開放修改有值的話，查看是否開放   upd by 佳玟 2016.06.24 報修29315-增加$fd_upd_chk判斷
              $y3 = substr($fd_close, 0, 4); //取前四碼 (年)        
              $m3 = substr($fd_close, 4, 2); //取最後二碥(月)  
              $d3 = substr($fd_close, 6, 2); //日            	   	
              $fd_vdate  = date('Ym',mktime(0, 0, 0, $m3+3, $d3, $y3))."05";
              //echo $ar['eb20']."---".$fd_ndate."---".$fd_vdate."---".$fd_resda192."<br>";
              if($ar['eb02']>=$fd_start_eb02 and $ar['eb02']<=$fd_end_eb02){  //開放外出日期區間 
                 //if($fd_ndate<=$fd_resda192 and $fd_ndate<$fd_close){ //於關帳日內
                 if($ar['eb20']=='N'){ //重簽資料
                   if($fd_ndate<=$fd_vdate){  //upd by 2012.05.30 (待辦14426 137)開放三個月
                     u_in_scr($f_var);
                     $f_var["tp"]->newBlock('fd_script_eb01');   
                     $fd_openkey='Y'; //已開啟  
                   }else{
                     sl_errmsg("已超過開放日(".sl_4ymd($fd_vdate).")！");
                   }
                 }else{
                   if($fd_ndate<=$fd_resda192){  //非重簽資料，開放日到期者開放三天
                     u_in_scr($f_var);
                     $f_var["tp"]->newBlock('fd_script_eb01');   
                     $fd_openkey='Y'; //已開啟  
                   }else{
                     sl_errmsg("已超過開放日(".sl_4ymd($fd_resda192).")！");
                   }
                 }
                 //if($fd_ndate<=$fd_vdate){  //upd by 2012.05.30 (待辦14426 137)開放三個月
                 //  u_in_scr($f_var);
                 //  $f_var["tp"]->newBlock('fd_script_eb01');   
                 //  $fd_openkey='Y'; //已開啟  
                 //}else{
                 //  sl_errmsg("已超過開放日(".sl_4ymd($fd_resda192).")，或已關帳(".sl_4ymd($fd_close).")！");
                 //}                 
              }             
            } 
            //ECHO $fd_resda192;
             sl_open('docs');
             if('N'==$fd_upd_chk and $fd_openkey<>'Y'){
               sl_errmsg($fd_noupd_msg);
             }
             else if($fd_openkey<>'Y'){  // $fd_openkey 已開放過(防止出現二次 IN_SCR)
               //echo $fd_ndate."-----".$fd_resda192."<br>";
               if($fd_ndate<=$fd_resda192){
                 if($fd_ndate<$fd_close){
                   u_in_scr($f_var);
                   $f_var["tp"]->newBlock('fd_script_eb01');
                 }else{   //add by 佳玟 2012.01.03 如日期已關帳日，則不能修改
                   sl_errmsg("已關帳！(".sl_4ymd($fd_close)."), 各區總務經辦人員已彙整資料!");
                 }
               }else{
                 sl_errmsg("需於調車單簽核結案後三日內，".sl_4ymd($fd_resda192)." (含)內，填寫完里程簽核單! <br>如欲開放, 請聯絡<font color=blue>各區管理課課長</font>申請開放!");
               } 
             }
           }
           else{
             sl_errmsg("非本人，無法修改資料! ");
           }
         }
         break;
       case "21": // 修改-儲存
         $sql = "select *
                 from   ewb01
                 where  s_num='{$f_var['f_s_num']}' ";
         $result = mysql_query($sql);
         $row = mysql_fetch_array($result);
         //echo $row['eb09']."<br>".$row['eb10'];
         
         //$f_var['f_eb09'] = $row['eb09'];   //修改時，車種、排氣量不修改 mark by 佳玟 2012.12.21 (報18956)
         //$f_var['f_eb10'] = $row['eb10'];          
         $f_var['f_eb17'] = $row['eb17']; //扣除標準里程不修改
              
         //echo "eb17: ".$f_var['f_eb17']."<br>";       
         //exit;
         //echo $f_var['f_eb13']."----".$f_var['f_eb12']."-----".$f_var['f_eb11']."<br>";
         //exit;   
         if($f_var['f_eb12']<>'' and $f_var['f_eb12']<>'0' ){  //add by 佳玟 2012.02.14  防止javascript失效，儲存時再計算一次里程數
           $f_var['f_eb13'] = $f_var['f_eb12']-$f_var['f_eb11'];
         }
         
     
         //echo $f_var['f_eb13'];
         //exit;   
         sl_open('docs');
         sl_save(&$f_var);
         break;
       case "3": // 作廢     
         //sl_errmsg("外車白板連結電子簽核系統,自6/7起於物流處先行使用,依高協理指示,應於前一天填寫.");
         $fd_upd_chk="N";
         $count_table= substr_count($f_var['mtable']['head'],'.');
         $ex_table   = explode('.',$f_var['mtable']['head']);
         $fd_table   = iif($count_table==0,$f_var['mtable']['head'],$ex_table[1]);
         sl_openef2k('EF2KWeb');  // 開啟資料庫
         $sql_flw = "select sleip2flw.*,
                            resda.resda019,
                            resda.resda020,
                            resda.resda021,
                            CASE 
                              WHEN resda.resda021 = '' THEN '<font color=blue>簽核進行中</font>'
                              WHEN resda.resda021 = '1' THEN '<font color=blue>簽核進行中</font>'
                              WHEN resda.resda021 = '2' THEN '<font color=#006600>已同意</font>'
                              WHEN resda.resda021 = '3' THEN '<font color=red>不同意</font>'
                              WHEN resda.resda021 = '4' THEN '<font color=red>已抽單</font>'
                            END AS resda021_list,
                            CASE 
                              WHEN resda.resda021 = '' THEN '簽核進行中'
                              WHEN resda.resda021 = '1' THEN '簽核進行中'
                              WHEN resda.resda021 = '2' THEN '已同意'
                              WHEN resda.resda021 = '3' THEN '不同意'
                              WHEN resda.resda021 = '4' THEN '已抽單'
                            END AS resda021_msg                            
                     from   sleip2flw
                            left join resda on sleip2flw.sleip2flw001 = resda.resda001
                                               and sleip2flw.sleip2flw002 = resda.resda002
                     where  sleip2flw.sleip2flw003='{$f_var['mdb']}'
                            and sleip2flw.sleip2flw004='{$fd_table}'
                            and sleip2flw.sleip2flw010='{$f_var['f_s_num']}'
                            and sleip2flw.sleip2flw900='{$_SESSION["login_empno"]}'
                     ";
         //echo "<pre>".$sql_flw."</pre>";            
         $result_flw = mssql_query($sql_flw);
         $num        = mssql_num_rows($result_flw);  //筆數
         if( $num>0 ){
           while($row = mssql_fetch_array($result_flw)){
             // sleip2flw011 轉呈次數  ;  resda021 簽核結果 1=未完成,2=同意,3=不同意,4=已抽單
             if('1'==$row['sleip2flw011'] and ( ''==$row['resda021'] or '1'==$row['resda021'] ) ){ //調車單 未完成
               $fd_btn_txt = "抽單作廢";
               $fd_upd_chk = "Y";                                
               //$fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 調車簽核單目前顯示{$row['resda021_list']},因此不可進行作廢。";
               $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 調車簽核單目前顯示{$row['resda021_list']}。";
               $fd_msgbox_1 ="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']}";
               $fd_msgbox_2 ="調車簽核單目前顯示『{$row['resda021_msg']}』";
               $fd_msgbox_3 ="調車簽核單( 單號：{$row['sleip2flw002']} )【抽單】；外出白板該外出資料【作廢】";
             }
             if('2'==$row['sleip2flw011'] and ( ''==$row['resda021'] or '1'==$row['resda021'] ) ){ //哩簽單 未完成 
               $fd_btn_txt = "抽單";
               $fd_upd_chk="Y";
               //$fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 里程簽核單 目前顯示{$row['resda021_list']},因此不可進行作廢。";
               $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 里程簽核單 目前顯示{$row['resda021_list']}。";
               $fd_msgbox_1 ="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']}";
               $fd_msgbox_2 ="哩程簽核單目前顯示『{$row['resda021_msg']}』";
               $fd_msgbox_3 ="哩程簽核單( 單號：{$row['sleip2flw002']} )【抽單】";               
             }
             if( '2'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'] ){
               $fd_btn_txt = "作廢";
               $fd_upd_chk="Y";
               $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 里程簽核單 目前顯示{$row['resda021_list']}。";
               $fd_msgbox_1 ="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']}";
               $fd_msgbox_2 ="調車簽核單目前顯示『{$row['resda021_msg']}』";
               $fd_msgbox_3 ="外出白板該外出資料【作廢】";               
             }              
           }   
         }
         //echo $fd_upd_chk;
         sl_errmsg($fd_noupd_msg);
         if('N' <> $fd_upd_chk){
           $f_var["tp"]-> newBlock ("fd_script_msel3");
           $f_var["tp"]-> assign   ('tv_btn'    , $fd_btn_txt);         
           $f_var["tp"]-> assign   ('tv_msgbox_1' , $fd_msgbox_1);  
           $f_var["tp"]-> assign   ('tv_msgbox_2' , $fd_msgbox_2);  
           $f_var["tp"]-> assign   ('tv_msgbox_3' , $fd_msgbox_3);                                 
           u_disp($f_var);
         }                            
         
         
         
         /*
         $fd_upd_chk="Y";
         sl_open('docs');
         $count_table= substr_count($f_var['mtable']['head'],'.');
         $ex_table   = explode('.',$f_var['mtable']['head']);
         $fd_table   = iif($count_table==0,$f_var['mtable']['head'],$ex_table[1]);
         $query      = "select sleip2flw.* ,
                           CASE 
                             WHEN resda021 = '' THEN '<font color=blue>簽核進行中</font>'
                             WHEN resda021 = '1' THEN '<font color=blue>簽核進行中</font>'
                             WHEN resda021 = '2' THEN '<font color=#006600>已同意</font>'
                             WHEN resda021 = '3' THEN '<font color=red>不同意</font>'
                             WHEN resda021 = '4' THEN '<font color=red>已抽單</font>'
                           END AS resda021_list
                        from docs.sleip2flw
                        where sleip2flw003='{$f_var['mdb']}'
                              and sleip2flw004='{$fd_table}'
                              and sleip2flw010='{$f_var['f_s_num']}'
                              and d_date='0000-00-00 00:00:00'
                        order by s_num
                           "; 
         //echo $query;
         $result = mysql_query($query);
         $num = mysql_num_rows($result);  //筆數
         if($num > 0){
          while($row = mysql_fetch_array($result)){
            if('1'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'])){ //調車單 未完成,不同意,已抽單都不可再修改
              $fd_upd_chk="N";
              $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 調車簽核單目前顯示{$row['resda021_list']},因此不可進行作廢。";
            }
            if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '2'==$row['resda021'])){ //調車單 未完成,不同意,已抽單都不可再修改
              $fd_upd_chk="N";
              $fd_noupd_msg="單別：{$row['sleip2flw001']}　單號：{$row['sleip2flw002']} 里程簽核單 目前顯示{$row['resda021_list']},因此不可進行作廢。";
            }
          }
         }
         if('N'==$fd_upd_chk){
          sl_errmsg($fd_noupd_msg);
         }
         else{
           u_disp($f_var);
          }
          */
         break;
       case "31": // 作廢-儲存
         $sql_tr = "select tohrm
                    from   docs.ewb01
                    where  s_num = '{$f_var['f_s_num']}'
                           and d_date = '0000-00-00 00:00:00'
                           and tohrm = 'Y'
                   ";
         $res_tr = mysql_query($sql_tr);
         $qty_tr = mysql_num_rows($res_tr);
         if($qty_tr > 0){
           if( ''!=trim($f_var['hrmctrl_ing2']) ){ //add by 佳玟 2018.12.04 依資訊網頁/權限管理/鼎新版更時間控制設定 控制開放始用時間
             sl_errmsg($f_var['hrmctrl_ing2']."<br><a href='/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}' target=_blank><font color=red>回瀏覽畫面</font></a>");
             exit;
           }
         }
         //upd by 佳玟 2013.12.27 報修22017 增加作廢功能
         // 調車單(簽核中)   -> 調車單抽單、 外出資料作廢
         // 調車單(簽核完畢) -> 外出資料作廢
         // 哩程單(簽核中)   -> 哩程單抽單
         // 哩程單(簽核完畢) -> 外出資料作廢        
         sl_openef2k('EF2KWeb');  // 開啟資料庫
         $sql_flw = "select sleip2flw.*,
                           resda.resda019,
                           resda.resda020,
                           resda.resda021,
                           CASE 
                             WHEN resda.resda021 = '' THEN '<font color=blue>簽核進行中</font>'
                             WHEN resda.resda021 = '1' THEN '<font color=blue>簽核進行中</font>'
                             WHEN resda.resda021 = '2' THEN '<font color=#006600>已同意</font>'
                             WHEN resda.resda021 = '3' THEN '<font color=red>不同意</font>'
                             WHEN resda.resda021 = '4' THEN '<font color=red>已抽單</font>'
                           END AS resda021_list
                    from   sleip2flw
                           left join resda on sleip2flw.sleip2flw001 = resda.resda001
                                              and sleip2flw.sleip2flw002 = resda.resda002
                    where  sleip2flw.sleip2flw003='docs'
                           and sleip2flw.sleip2flw004='ewb01'
                           and sleip2flw.sleip2flw010='{$f_var['f_s_num']}'
                           and sleip2flw.sleip2flw900='{$_SESSION["login_empno"]}'
                           and ( resda.resda020 <> '3' AND resda.resda020 <> '4' )
                   ";
         $result_flw = mssql_query($sql_flw);
         $ar_flw = mssql_fetch_assoc($result_flw);
         $fd_sla015002 = $ar_flw['sleip2flw002']; //單號       
         
         if('2'==$ar_flw['sleip2flw011'] and ( ''==$ar_flw['resda021'] or '1'==$ar_flw['resda021'] ) ){ //哩簽單 未完成(不作廢外出白板) 
           u_del_flw($fd_sla015002); //抽單              
         }else if( '1'==$ar_flw['sleip2flw011'] and (''==$ar_flw['resda021'] or '1'==$ar_flw['resda021']) ){ //調車單簽核中，抽單and作廢外出資料
           u_del_flw($fd_sla015002); //抽單 
           u_del_ewb($f_var); //作廢外出資料
         }else{
           u_del_ewb($f_var); //作廢外出資料
         }
         if( date("Ymd")>='20180701' ){
           ul_essf21($f_var['f_s_num'],"3",$_SESSION["login_hrm_empid"]); 
           //mark by 佳玟 2018.09.05 popen 出現 Resource temporarily unavailable 找不到原因,目前把塞入背景的,拿出來fucntion
           //$t_path = "/home/docs/public_html/ewb/t_essf21.php {$f_var['f_s_num']} 3 {$_SESSION["login_hrm_empid"]} &";
           //$t_popen = popen($t_path,"r");
           //while ($t_popen and !feof($t_popen)) {      //?通道里面取得?西
           //  $out = fgets($t_popen, 4096);
           //  //echo $out;         //打印出?
           //}
           //pclose($t_popen);
         }    
         echo sl_jreplace("/~docs/ewb/ewb01.php");	
                  
         
         //sl_save(&$f_var);
         break;
       case "4": // 瀏覽        
         //sl_errmsg($msg_title);
         //u_eip2del();  //add by 佳玟  2011.11.23  課長指示簽核單如為抽單者，回壓d_date作廢
         $f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by 佳玟 2011.12.28  經理指示，將上方注意事項隱藏摺疊
         $_SESSION['f_b_dept_id']= $f_var['f_b_dept_id'];
         $_SESSION['f_sname']    = $f_var['f_sname'];    
         $_SESSION['f_eb01']     = $f_var['f_eb01'];           
         $_SESSION['f_order']    = $f_var['f_order'];          
         $_SESSION['f_dateb']    = $f_var['f_dateb'];          
         $_SESSION['f_datee']    = $f_var['f_datee']; 
         //echo $_SESSION['f_eb01'];
         u_list(&$f_var);
         break;
       case "41": // 瀏覽
         //sl_errmsg("外車白板連結電子簽核系統,自6/7起於物流處先行使用,依高協理指示,應於前一天填寫.");
         u_disp($f_var);
         break;
       case "5": // 查詢-showform
         //sl_errmsg("外車白板連結電子簽核系統,自6/7起於物流處先行使用,依高協理指示,應於前一天填寫.");
         $f_var["tp"]->newBlock('tp_in_prn_7');
         $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=4&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}");
         $f_var["tp"]->assign('tv_title' , "請輸入查詢條件");
         list_disp($f_var);
         break;
       case "7": // 列印輸入畫面
         if('1'==$f_var['num']){
           $f_var["tp"]->newBlock('tp_in_prn_7');
           $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=71&num=1");
           $f_var["tp"]->assign('tv_title' , "請輸入列印條件");
           list_disp($f_var);
         }
         if('2'==$f_var['num']){
           $f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by 佳玟 2011.12.28  經理指示，將上方注意事項隱藏摺疊
           $f_var["tp"]->newBlock('fd_script_msel72');
           prn_que($f_var);
         }
         break;
       case "71":  // 列印畫面
          if('1'==$f_var['num']){
           list_prn1($f_var);//列印畫面-選擇列印
          }
          if('2'==$f_var['num']){
           list_prn2($f_var);//列印畫面-私車公用
          }
          if('3'==$f_var['num']){
           list_prn3($f_var);//列印畫面-調車單
          }
          break;
       case "8": // 轉里程簽核單
         $f_var['f_cnt'] ='2';//upd by mimi 2011.06.13 增加轉檔次數 
         $f_var['f_type']=iif($f_var['domain4']<>'','12','4');//upd by mimi 2012.01.12 報修-16058 經理級以上只要簽核一層 type=4.哩程簽核單 type=12.哩程簽核單(經理)
         $query = "select *, docs.ewb01.s_num as fs_num
                    from docs.ewb01  
                      left join sl.dept on dept.dept_id = ewb01.b_dept_id and dept.stop='N'
                    where ewb01.s_num='{$f_var['f_s_num']}'
                   ";
         //echo $query."<BR>";
         $result = mysql_query($query);
         $row =mysql_fetch_array($result);
         $f_var['f_title']=substr($row['eb09'],3)."實際里程簽核單 {$row['eb01']} ".date('m/d',strtotime($row['eb02']));
         //echo $f_var['f_title'];exit;
         $f_var['f_content']="
　　外出日期：".date('m/d',strtotime($row['eb02']))." ".date('H:i',strtotime($row['eb03']))." ~ ".date('m/d',strtotime($row['eb06']))." ".date('H:i',strtotime($row['eb07']))."
　　行駛區間：{$row['eb16']} ~ {$row['eb04']}   
　　行駛里程：{$row['eb13']} km ({$row['eb12']}-{$row['eb11']})
  
　　外出事由：{$row['eb05']}
　　私車排氣：".substr($row['eb10'],3)."　往返調任地扣除30公里：{$row['eb24']}　回數票：{$row['eb14']}　乘車人數：{$row['eb15']}
　　填單日期：".date('Y/m/d H:i:s')."
　　　　";
//私車排氣：".substr($row['eb10'],3)."　扣除標準里程：{$row['eb17']}　回數票：{$row['eb14']}　乘車人數：{$row['eb15']}        
/*    upd by 佳玟 2011.10.05 (待辦-14426 回應29)       
         $f_var['f_title']="{$row['eb01']} 哩程簽核單";
         //echo $f_var['f_title'];exit;
         $f_var['f_content']="
      哩程數：{$row['eb13']}({$row['eb12']}-{$row['eb11']})
        
    同仁姓名：{$row['sname']}-{$row['eb01']}
    
　　外出日期：".date('Y/m/d',strtotime($row['eb02']))." ".date('H:i',strtotime($row['eb03']))."
　　前往地點：{$row['eb04']}   

　　回程日期：".date('Y/m/d',strtotime($row['eb06']))." ".date('H:i',strtotime($row['eb07']))."
　　回程地點：{$row['eb16']}  
  
　　前往事由：{$row['eb05']}  
　　　　車種：{$row['eb09']}
　　　排氣量：{$row['eb10']} 
扣除標準里程：{$row['eb17']} 
　　　回數票：{$row['eb14']}   
　　乘車人數：{$row['eb15']}   
　　　　備註：{$row['eb08']}
　　建檔日期：".date('Y/m/d H:i:s')."
　　　　";
*/
         if(u_chk_sign2flw4($row)){ // add by 佳玟 2011.12.06 防止重覆發送哩程簽核單
           //echo "無重覆";
           //exit;
           u_save_log($row); //add by 佳玟 2012.02.13 增加紀錄於行駛區間table   ewb01_adr
           /*if( 'S181'==$_SESSION["login_dept_id"] ){ //add by 佳玟 報修32441-簽核至稽核最高主管
             ul_eip2flw(&$f_var);
           }else mark by 小樵20191022報修37078 將稽核外出白板更改為依照原設定 二關*/ 
           if( strstr('1730055/1130091',$_SESSION["login_empno"])!=NULL ){
             sl_eip2flwV2(&$f_var);     
           }else{
             sl_eip2flw(&$f_var);//add by mimi 2011.06.02 轉簽核表
           }    
           //sl_eip2flw(&$f_var);//add by mimi 2011.06.02 轉簽核表
           echo "<script language='JavaScript'>";
           echo "alert('已轉至哩程簽核單 {$f_var['f_resdz001']}-{$f_var['f_resdz002']} 請前往查看。');";
           echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           echo "</script>";
         }else{
           //if($row['eb18']=='8266174' and $row['eb02']=='20111227'){  //add by 佳玟 2012.01.11 (報修-16047)由於何發盛12/27已里程簽核過，所以需額外增加判斷跑簽核
           //  sl_eip2flw(&$f_var);//add by mimi 2011.06.02 轉簽核表
           //  echo "<script language='JavaScript'>";
           //  echo "alert('已轉至哩程簽核單 {$f_var['f_resdz001']}-{$f_var['f_resdz002']} 請前往查看。');";
           //  echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           //  echo "</script>";           
           //}             
           //echo "重覆新增";
           echo "<script language='JavaScript'>";
           echo "alert('里程簽核單已傳送！');";
           echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           echo "</script>";
         }
         break;
       default:
         break;
  }

  u_sel_link(&$f_var);      // 右上角點選選單設定
  if(!empty($f_var['query_data'])) { //如果query_data有資料,就執行mysql_query(),only for新增儲存,修改儲存,作廢儲存,
     u_log($f_var);
     if(!mysql_query($f_var['query_data'])) { // 寫入失敗
        sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$f_var['query_data'].'!!'); //qq:para只丟str不丟font
        exit;
     }
     switch ($f_var['msel']) {                            
       case "11": // 新增儲存
            if($f_var['chkewb']=="y"){  // add by 佳玟  2011.11.23  無重覆新增
              $f_var['autoindex']  = mysql_insert_id();  //新增的s_num
              //if( strstr("1130091/0883430/1300282/1330075",$_SESSION["login_empno"])!=NULL ){
              if( date("Ymd")>='20180701' AND 'Y'==$f_var['f_tohrm'] ){
                //$mgo_url = "/~docs/ewb/t_essf21v2.php?f_snum={$f_var['autoindex']}&f_msel=1&f_empid={$_SESSION["login_hrm_empid"]}";
                ul_essf21($f_var['autoindex'],"1",$_SESSION["login_hrm_empid"]); 
              }
              //mark by 佳玟 2018.09.05 popen 出現 Resource temporarily unavailable 找不到原因,目前把塞入背景的,拿出來fucntion
              //else if( date("Ymd")>='20180701' AND 'Y'==$f_var['f_tohrm'] ){
              //  $t_path = "/home/docs/public_html/ewb/t_essf21.php {$f_var['autoindex']} 1 {$_SESSION["login_hrm_empid"]} &";
              //  $t_popen = popen($t_path,"r");
              //  while ($t_popen and !feof($t_popen)) {      //?通道里面取得?西
              //    $out = fgets($t_popen, 4096);
              //    //echo $out;         //打印出?
              //  }
              //  pclose($t_popen);
              //}        
              u_send($f_var);
              //if('' <> $f_var['domain2'] or '' <> $f_var['domain3']){
              //upd by 佳玟 2012.01.31 mimi接獲來電，列印調車單移除
              //if('' <> $f_var['domain2']){  //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
              //  echo "<script language=\"javascript\">";
              //  echo "  if (confirm('已將調車單轉至電子簽核 {$f_var['f_resdz001']}-{$f_var['f_resdz002']}，是否列印調車單？')){";
              //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=71&num=3&f_s_num={$f_var['autoindex']}\");";
              //  echo "  }";
              //  echo "  else {";
              //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['autoindex']}\");";
              //  echo "  }";
              //  echo "</script>";
              //}
              //else{   //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
                //if('' <> $f_var['domain1']){
                //if( '1130091'!=$_SESSION["login_empno"] ){
                echo "<script language='JavaScript'>";
                echo "alert('已將調車單轉至電子簽核 {$f_var['f_resdz001']}-{$f_var['f_resdz002']} 請前往查看。');";
                echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['autoindex']}\");";
                echo "</script>";
                //}else{
                //  exit;
                //}
              //}
            }  
            break;
       case "21": // 回應儲存

            u_send($f_var);
            if(u_chkeb12($f_var['f_s_num'])){ //upd by 佳玟 2011.12.26 暐昕反應，有很多人沒點選轉里程簽核單，導致油貼不計算，改為如里程有key，強制轉里程簽核單            
              echo "<script language=\"javascript\">";            
              echo "location.replace(\"/~docs/ewb/ewb01.php?msel=8&f_s_num={$f_var['f_s_num']}\");";
              echo "</script>";              
            }else{       
              echo "<script language=\"javascript\">";            
              echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
              echo "</script>";                    
            }
            
            //upd by 佳玟 2011.11.04  劉經理指示，全區新增外出都轉電子簽核
            //if('' <> $f_var['domain1'] or '' <> $f_var['domain2'] or '' <> $f_var['domain3']){
            //  echo "<script language=\"javascript\">";
            //  echo "  if (confirm('是否轉至里程簽核單？')){";
            //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=8&f_s_num={$f_var['f_s_num']}\");";
            //  echo "  }";
            //  echo "  else {";
            //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
            //  echo "  }";
            //  echo "</script>";
            //}
            
            break;
    
       default:
            break;
     }
     echo sl_jreplace($f_var['mgo_url']);
  }
  
  if("9" == $f_var['msel']){// 今日外出畫面 
    if(null == $f_var['fd_area']){
      $query = "select {$f_var['mtable']['dept']}.*
                  from {$f_var['mtable']['dept']}
                  where sl.dept.dept_id = '{$_SESSION['login_dept_id']}'
             ";
      //echo $query."<BR>";
      $result = mysql_query($query);
      $row =mysql_fetch_array($result);
      $lnk_area = substr($row['p_gid'],0,2);
      if($lnk_area=='S1' or $lnk_area=='E1' or $lnk_area=='T1'){
        $f_var['fd_area']=$lnk_area;
      }
      else{
        $f_var['fd_area']=substr($row['p_gid'],0,3);
      }
    }
    list_today($f_var);//列印畫面-今日外出
  }
  $f_var["tp"]-> printToScreen ();
  //mysql_close(); // 關閉資料庫

  include_once($sl_footer_php); // footer
?>
<?
  // **************************************************************************
  //  函數名稱: u_list()
  //  函數功能: 瀏覽
  //  使用方式: u_list($f_var)
  //  程式設計: Mimi
  //  設計日期: 2007.08.15
  // **************************************************************************
  function u_list($f_var) {
    $f_var['msnum']  = ($f_var['f_page']*$f_var['mmaxline'])-$f_var['mmaxline'];   // 起始比數
    
    if(NULL<>$f_var["f_sname"] or NULL<>$f_var["f_b_dept_id"] or NULL<>$f_var["f_eb01"] or NULL<>$f_var["f_dateb"] or NULL<>$f_var["f_datee"]) { // List,取得$f_var['mwhere'] qq:是否將此段用func代替?
      $fd_dept_sn = substr($f_var['f_sname'],0,4); 
      $f_var['where_dept'] = iif($f_var['f_sname'] == '00',""," and ewb01.b_dept_id = '{$fd_dept_sn}' "); 
      //$f_var['mwhere']  .= iif($f_var['f_b_dept_id'] == '00',""," and substring(ewb01.b_dept_id,1,2) = '{$f_var['f_b_dept_id']}'"); 
      //upd by 佳玟 2011.09.22 原等於更改為like
      switch ($f_var['f_b_dept_id']) {
        case "S1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S1%' ";
            break;
        case "S25":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S25%' ";
            break;  
        case "S26":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S26%' ";
            break;  
        case "S28":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S28%' ";
            break;  
        case "S35":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S35%' ";
            break;  
        case "S36":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S36%' ";
            break;  
        case "S38":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S38%' ";
            break;  
        case "E1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'E1%' ";
            break;  
        case "T1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'T1%' ";
            break;  
        default:
          break;
      } 
/*
      switch ($f_var['f_b_dept_id']) {
        case "S1":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,2) = 'S1' ";
            break;
        case "S25":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S25' ";
            break;  
        case "S26":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S26' ";
            break;  
        case "S28":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S28' ";
            break;  
        case "S35":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S35' ";
            break;  
        case "S36":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S36' ";
            break;  
        case "S38":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,3) = 'S38' ";
            break;  
        case "E1":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,2) = 'E1' ";
            break;  
        case "T1":                
              $f_var['mwhere'] .= " and substring({$f_var['mtable']['dept']}.p_gid,1,2) = 'T1' ";
            break;  
        default:
          break;
      }   
*/                 
      $f_var['mwhere'] .= iif($f_var['f_eb01'] == ''      ,""," and ewb01.eb01 like '%{$f_var['f_eb01']}%' "); 
      $f_var['mwhere'] .= " and (ewb01.eb02 BETWEEN '{$f_var['f_dateb']}' AND '{$f_var['f_datee']}')  
                            and ewb01.d_date = '0000-00-00 00:00:00'   
                           {$f_var['where_dept']}";
    }
    else{
       if(NULL<>$f_var["f_change1"] ) { // 以狀態查詢
        if("00" != $f_var["f_change1"]){
          $f_var['mwhere'] .= ' and (';
          $vque             = trim($f_var["f_change1"]);
          //$f_var['mwhere'] .= "substring(docs.ewb01.b_dept_id,2,1) = '$vque'";
          switch ($vque) {
            case "S1":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S1%' ";
                break;
            case "S25":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S25%' ";
                break;  
            case "S26":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S26%' ";
                break;  
            case "S28":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S28%' ";
                break;  
            case "S35":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S35%' ";
                break;  
            case "S36":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S36%' ";
                break;  
            case "S38":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'S38%' ";
                break;  
            case "E1":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'E1%' ";
                break;  
            case "T1":                
                  $f_var['mwhere'] .= "  {$f_var['mtable']['dept']}.p_gid like 'T1%' ";
                break;  
            default:
              break;    
              //echo $f_var['mwhere'].'------------';exit;
          }
          $f_var['mwhere'] .= ')';
        }  
      }
    }
    if(NULL<>$f_var['f_order'] ) { // 以狀態查詢
      $f_var['morder']="{$f_var['f_order']} desc,b_date desc";
    }
     
     // qq: {$f_var 的作用?
     $query1      = "select {$f_var['mtable']['head']}.*,{$f_var['mtable']['dept']}.sname
                           from {$f_var['mtable']['head']} left join {$f_var['mtable']['dept']}
                           on   {$f_var['mtable']['head']}.b_dept_id = {$f_var['mtable']['dept']}.dept_id
                            where {$f_var['mwhere']}
                            order by {$f_var['morder']}
                    ";
     $query2 = $query1." limit {$f_var['msnum']},{$f_var['mmaxline']} ";
     sl_showsql($query1);
     //echo "<pre>".$query1."</pre><BR>";
     //echo $query2."<BR>";
    
     $f_var['list_result_cnt'] = mysql_query($query1);
     $f_var['list_result'] = mysql_query($query2);
     
     $f_var['mstock_qty']= mysql_num_rows($f_var['list_result_cnt']); // 目前總筆數
     $f_var['qty_cnt']= mysql_num_rows($f_var['list_result_cnt']); // 目前總筆數
     $f_var['mpagetot'] = floor(((($f_var['mmaxline']-1)+$f_var['mstock_qty'])/$f_var['mmaxline'])); // 求整數，最大頁次

     if($f_var['mstock_qty']>0) { // 有資料
        sl_list($f_var);  // 列出瀏覽的欄位抬頭與table資料內容 sl_init.php // Block=tb_list_01、 Block=tb_list_01_body...
     }
     else {
        sl_errmsg('無顯示資料！');
     }
     return;
  }

  // **************************************************************************
  //  函數名稱: u_sel_link()
  //  函數功能: 點選選單設定
  //  使用方式: u_sel_link(&$f_var)
  //  備    註: 點選選單設定
  //  程式設計: Mimi
  //  設計日期: 2007.09.04
  // **************************************************************************
  function u_sel_link($f_var) {
     if($f_var['f_page']==1) {  // 首頁，不可再往上
        $f_var['mup_page'] = $f_var['f_page'];
     }
     else {
        $f_var['mup_page'] = $f_var['f_page']-1;
     }
     if($f_var['f_page']==$f_var['mpagetot']) {  // 末頁，不可再往上
        $f_var['mdn_page'] = $f_var['f_page'];
     }
     else {
        $f_var['mdn_page'] = $f_var['f_page']+1;
     }

    $y = date('Y'); //年        
    $m = date('m'); //月  
    $d = date('d'); //日
    $fd_cday = mktime(0, 0, 0, $m-3, $d, $y);  //超過25，算下個月     
    $fd_cday = date('Ymd', $fd_cday);
     
     if('71' != $f_var['msel'] ){
       $f_var["tp"]-> newBlock ("tb_sel_link"              ); // 新增資料
       $f_var["tp"]-> assign   ("tv_vname"     ,$_SESSION["login_name"]);
       $f_var["tp"]-> assign   ("tv_dateb"     ,$fd_cday);
       $f_var["tp"]-> assign   ("tv_datee"     ,date("Ymd"));
       $f_var["tp"]-> assign   ("tv_dept_id"   ,$_SESSION["login_dept_id"]);
       
       $f_var["tp"]-> assign   ("tv_add"     , u_showproc().".php?msel=1&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}"              ); // 新增
       $f_var["tp"]-> assign   ("tv_list"    , u_showproc().".php?msel=4&f_page=1&f_del=N&f_change1={$f_var['f_change1']}"                                                                                                   ); // 瀏覽
       $f_var["tp"]-> assign   ("tv_que"     , u_showproc().".php?msel=5&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"              ); // 查詢
       $f_var["tp"]-> assign   ("tv_prn"     , u_showproc().".php?msel=7&num=1&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"              ); // 列印
            
       $f_var["tp"]-> assign   ("tv_up_page" , u_showproc().".php?msel=4&f_page={$f_var['mup_page']}&f_del={$f_var['f_del']}&f_que={$f_var['f_que']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}&f_change2={$f_var['f_change2']}&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}" ); // 上頁
       $f_var["tp"]-> assign   ("tv_dn_page" , u_showproc().".php?msel=4&f_page={$f_var['mdn_page']}&f_del={$f_var['f_del']}&f_que={$f_var['f_que']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}&f_change2={$f_var['f_change2']}&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}" ); // 下頁
       $f_var["tp"]-> assign   ("tv_del_n"   , u_showproc().".php?msel=4&f_page=1&f_del=N&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // N.未廢
       $f_var["tp"]-> assign   ("tv_del_y"   , u_showproc().".php?msel=4&f_page=1&f_del=Y&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // Y.作廢
       $f_var["tp"]-> assign   ("tv_del_a"   , u_showproc().".php?msel=4&f_page=1&f_del=A&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // A.全部
       
       $f_var['f_page'] = 1;
       if('9' != $f_var['msel'] ){
         $f_var["tp"]-> newBlock ("tb_select_statu"       );//以狀態查詢
         $f_var["tp"]-> assign   ("tv_change1"  , u_showproc().".php?msel=4&f_del=A&f_page={$f_var['f_page']}&f_change2={$f_var['f_change2']}&f_change1="               ); 
         if(NULL == $f_var['f_change1']){$f_var['f_change1'] = "00";}else{}
         $f_var["tp"]-> assign   ("tv_f_change"  , $f_var['f_change1']);     
         //$f_var["tp"]-> newBlock ("tv_option1"                  ); // option
         //$f_var["tp"]-> assign   ("tv_value"   , "--"  );
         //$f_var["tp"]-> assign   ("tv_show"    , "--請選擇--"   );
         while( list($mvalue)=each($f_var['area']['value']) ) {
          //echo $mvalue."<br>";
          //echo $f_var['area']['value'][$mvalue]."<br>";
           $f_var["tp"]-> newBlock ("tv_option1"                  ); // option
           $f_var["tp"]-> assign   ("tv_value"   , $f_var['area']['value'][$mvalue]  );
           $f_var["tp"]-> assign   ("tv_show"    , $f_var['area']['show'][$mvalue]   );
         }
       }
     }
     
     return;
  }
  // **************************************************************************
  //  函數名稱: u_disp()
  //  函數功能: 瀏覽
  //  使用方式: u_disp($f_var)
  //  程式設計: Tony
  //  設計日期: 2006.09.29
  // **************************************************************************
  function u_disp($f_var) {
     //echo $f_var['f_s_num'].'----';
     $f_var['mwhere'] = "{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
     $f_var['morder'] = "{$f_var['mtable']['head']}.s_num";


     //add by 2012.03.02 佳玟  副理告知增加里程開放期限顯示
     $fd_resda019 = u_chksign($f_var['f_s_num']); //搜尋里程開放到期日  ewb01_init.php u_chksign函數
     $ar_key = explode("<br>",$fd_resda019);
     $fd_resda0192 = strip_tags($ar_key[1]); //去除所有html標籤
     sl_open('docs');
     $query1      = "select {$f_var['mtable']['head']}.*,{$f_var['mtable']['dept']}.sname, sleip2flw.resda019, '{$fd_resda0192}' as resda0192
                     from {$f_var['mtable']['head']} 
                          left join {$f_var['mtable']['dept']} on {$f_var['mtable']['head']}.b_dept_id = {$f_var['mtable']['dept']}.dept_id
                          left join sleip2flw  on {$f_var['mtable']['head']}.s_num = sleip2flw.sleip2flw010 and 
                                                       sleip2flw.sleip2flw008 in ('1','3','11') and
                                                       sleip2flw.resda020 = '3' and
                                                       sleip2flw.resda021 = '2' and 
                                                       sleip2flw.d_date = '0000-00-00 00:00:00'
                     where {$f_var['mwhere']}
                     order by {$f_var['morder']}
                    ";
     //echo "<pre>".$query1."</pre>";
       
     $f_var['disp_result'] = mysql_query($query1);

        
     sl_disp_1($f_var); // 列出單筆資料 // Block=tb_disp_01
     $res = mysql_query($query1);
     $ar = mysql_fetch_array($res);  
     $fd_str = substr($ar['eb09'],0,2);
     if('41'==$f_var['msel'] and $fd_str<>'06'){  //upd by 佳玟 2012.02.07  (報修-16232)公務車(併車搭乘-不借車)列印"調車單"按紐,不存在
       $f_var["tp"]-> newBlock (  "tb_btn" ); 
       $f_var["tp"]-> assign   (  "tv_link" , u_showproc().".php?msel=71&num=3&f_s_num={$f_var['f_s_num']}&f_key=1"   ); //
     }
     return;
  }




  // **************************************************************************
  //  函數名稱: u_in_scr()
  //  函數功能: 輸入畫面
  //  使用方式: u_in_scr($vsel,$vno,$vbtn_str,$vque)
  //  程式設計: Tony
  //  設計日期: 2006.09.27
  // **************************************************************************
  function u_in_scr($f_var) {
     /*
     $f_var['check_mwhere']="{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}' 
                             and {$f_var['mtable']['head']}.eb19<>''";
     $check_sql = "select {$f_var['mtable']['head']}.*
                   from   {$f_var['mtable']['head']}
                   where  {$f_var['check_mwhere']}
                  ";
     $check_total = mysql_num_rows(mysql_query($check_sql));
     if($check_total != 0){  //已轉檔產生統計表(ewb_pay01.php)
       sl_errmsg("已轉私車公用耗油統計表! 無法修改資料! ");
     }
     */              
     $f_var["tp"]-> newBlock (  "tb_in_01"                 ); // 新增資料
     $f_var["tp"]-> assign   (  "tv_scrmsg"     , $f_var['msel_name'][ $f_var['msel'] ]         ); // 按鈕文字
     $f_var["tp"]-> assign   (  "tv_qah_action" , u_showproc().".php?msel={$f_var['msel']}1&f_s_num={$f_var['f_s_num']}&f_que={$f_var['f_que']}&f_page={$f_var['f_page']}"); // form action
     $f_var['mwhere'] = "{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
     $f_var['morder'] = "{$f_var['mtable']['head']}.s_num";

     //add by 佳玟 2011.08.11 增加排氣量之判斷，判斷排氣量要設定，除公務車
      reset($f_var['fd']); // 將陣列的指標指到陣列第一個元素
      while(list($mfd_id)=each($f_var['fd'])) {          
       if(NULL!=$f_var['fd'][$mfd_id]['js_rule']['kind']) {   //檢查必填欄位
           $vjs_rule .= sl_js_rule($f_var['fd'][$mfd_id]['js_rule']['kind'],
                                   $f_var['fd'][$mfd_id]['ename'],
                                   $f_var['fd'][$mfd_id]['cname'],
                                   $f_var['fd'][$mfd_id]['js_rule']['chk_value'],
                                   $f_var['fd'][$mfd_id]['js_rule']['chk_len']
                                 );       
       }
      }
     //$vjs_rule .= "if(this.f_eb10.value=='--'){
     //                if(this.f_eb09.value=='01.公務車' || this.f_eb09.value=='05.大眾交通工具' || this.f_eb09.value=='99.其他' || this.f_eb09.value=='06.公務車(併車搭乘-不借車)' || this.f_eb09.value=='07.私車公用(併車搭乘-不請領油貼)'){
     //                  return(true);
     //                }
     //                else{
     //                  alert('『排氣量』有誤!!') ;
     //                  this.f_eb10.focus();
     //                  return(false);
     //                }
     //              };                
     //            "; //upd by 佳玟 2012.02.06 (報修-16232) 增加06.07選項  
     //$vjs_rule .= "if(this.f_eb10.value=='06.摩托車'){
     //                if(this.f_eb09.value=='02.私車公用'){
     //                  return(true);
     //                }
     //                else{
     //                  alert('『摩托車』僅能為私車公用!!') ;
     //                  this.f_eb10.focus();
    //                   return(false);
     //                }
     //              };                
     //            "; //upd by 佳玟 2012.05.11 摩托車限定車種                               
     $f_var["tp"]-> assign   ( "tv_js_rule"    , $vjs_rule);

     //add by 2012.03.02 佳玟  副理告知增加里程開放期限顯示
     $fd_resda019 = u_chksign($f_var['f_s_num']); //搜尋里程開放到期日  ewb01_init.php u_chksign函數
     $ar_key = explode("<br>",$fd_resda019);
     $fd_resda0192 = strip_tags($ar_key[1]); //去除所有html標籤                    
     $query1      = "select {$f_var['mtable']['head']}.*,{$f_var['mtable']['dept']}.sname, sleip2flw.resda019, '{$fd_resda0192}' as resda0192 
                           from {$f_var['mtable']['head']} 
                               left join {$f_var['mtable']['dept']} on {$f_var['mtable']['head']}.b_dept_id = {$f_var['mtable']['dept']}.dept_id
                               left join sleip2flw  on {$f_var['mtable']['head']}.s_num = sleip2flw.sleip2flw010 and 
                                                       sleip2flw.sleip2flw008 in ('1','3','11') and
                                                       sleip2flw.resda020 = '3' and
                                                       sleip2flw.resda021 = '2' and 
                                                       sleip2flw.d_date = '0000-00-00 00:00:00'                                
                            where {$f_var['mwhere']}
                            order by {$f_var['morder']}
                    ";
     //echo "<pre>".$query1."</pre>";
     sl_open('docs');
     $f_var['in_scr_result'] = mysql_query($query1);
     $f_var['in_scr_row'] =mysql_fetch_array($f_var['in_scr_result']);
     sl_get($f_var); // sl_init.php
  }  
  
  // **************************************************************************
  //  函數名稱: list_disp()
  //  函數功能: 輸入畫面
  //  使用方式: list_disp($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.01.30
  // **************************************************************************
  function list_disp($f_var) {
    //echo $_SESSION['f_b_dept_id'];
    //upd by mimi 2009.04.23 記錄外出白板查詢條件-------------------------
    $f_b_dept_id= iif($_SESSION['f_b_dept_id']<>'',$_SESSION['f_b_dept_id'],'00');
    $f_sname    = iif($_SESSION['f_sname']<>''    ,$_SESSION['f_sname'],'00');
    $f_eb01     = iif($_SESSION['f_eb01']<>''     ,$_SESSION['f_eb01'],'');
    $f_order    = iif($_SESSION['f_order']<>''    ,$_SESSION['f_order'],'eb02');
    $f_dateb    = iif($_SESSION['f_dateb']<>''    ,$_SESSION['f_dateb'],date("Ymd"));
    $f_datee    = iif($_SESSION['f_datee']<>''    ,$_SESSION['f_datee'],date("Ymd")); 
    //--------------------------------------------------------------------
    //echo $f_b_dept_id;   
    $fd_cname     = array('廠部別'     ,'部門別' ,'姓名'        ,'外出日期起訖'                        ,'排序方式');
    $fd_ename     = array('f_b_dept_id','f_sname','f_eb01'      ,''                                    ,'f_order' );
    $fd_value     = array($f_b_dept_id ,$f_sname ,$f_eb01       ,''                                    ,$f_order  );
    $fd_tbhr      = array('select'     ,'select' ,'text'        ,'date'                                ,'select'  );
    $fd_memo      = array(''           ,''       ,'(空白：全部)','(西元年月日,範例：20080130~20080217)','');
    for($i=0;$i<count($fd_cname);$i++){
      $f_var["tp"]->newBlock('tb_in_que_hr_tr');
      $f_var["tp"]->assign('tv_cname', $fd_cname[$i]);
      switch ($fd_tbhr[$i]) {
        case "date":             
          $f_var["tp"]-> newBlock (  "tb_date_hr"                );
          $f_var["tp"]-> assign   (  "tv_ename"     , $fd_ename[$i]);
          $f_var["tp"]-> assign   ( "tp_dateb"      , $f_dateb                   ); // 日期起
          $f_var["tp"]-> assign   ( "tp_datee"      , $f_datee                   ); // 日期訖
          $f_var["tp"]-> assign   ("tb_in_que_hr_tr.tv_memo"   , $fd_memo[$i]  );
          break;
        case "select":
          $f_var["tp"]-> newBlock (  "tb_select_hr"              );
          $f_var["tp"]-> assign   (  "tv_sname"   , $fd_ename[$i]);
          //echo $fd_value[$i];
          $fd_select = iif($fd_ename[$i]== 'f_b_dept_id',$f_var['area'],$f_var['deptid']);
          $fd_select = iif($fd_ename[$i]== 'f_order',$f_var['order'],$fd_select);
          while(list($mvalue)=each($fd_select['value'])) {
            $f_var["tp"]-> newBlock ("tv_option_hr"                  ); // option
            $f_var["tp"]-> assign   ("tv_value"   , $fd_select['value'][$mvalue]  );
            $f_var["tp"]-> assign   ("tv_show"    , $fd_select['show'][$mvalue]   );
            if($fd_value[$i]==$fd_select['value'][$mvalue]){
              $f_var["tp"]-> assign ("tv_selected", "selected"   );
            }
          }  
          break;
        default:
          $f_var["tp"]-> newBlock ("tb_text_hr"                ); 
          $f_var["tp"]-> assign   ("tv_ename"  , $fd_ename[$i] );
          $f_var["tp"]-> assign   ("tv_value"  , $fd_value[$i]);
          $f_var["tp"]-> assign   ("tv_size"   , 10            );
          $f_var["tp"]-> assign   ("tb_in_que_hr_tr.tv_memo"   , $fd_memo[$i]  );
          break;
      }      
    }  
     $f_var["tp"]-> assignglobal   (  "tv_js_rule"    , $vjs_rule); // js rule            
  }
  // **************************************************************************
  //  函數名稱: prn_que()
  //  函數功能: 輸入畫面
  //  使用方式: prn_que($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.06.23
  // **************************************************************************
  function prn_que($f_var) {    
    //sl_errmsg("<font color='#FF0000'><b>注意!!</b></font>本統計表僅列出車種為【私車公用】、【受公司補助購車】"); //qq:para只丟str不丟font
    $f_var["tp"]->newBlock('tp_in_prn_7');
    $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=71&num=2");
    $f_var["tp"]->assign('tv_title' , "請輸入私車公用耗油統計表條件");
    //upd by 佳玟 2011.08.15  移除車種查詢 
    $fd_cname     = array('員工編號','車號'    ,'會員卡卡號','年月'    ,'排除里程數為零');
    $fd_ename     = array('f_empno' ,'f_car'   ,'f_card'    ,'f_date'      ,'f_eb13'            );
    $fd_value     = array($_SESSION['login_empno'],$_SESSION['login_car_id'],$_SESSION['login_vip_card'],'',''            );
    $fd_tbhr      = array('text'    ,'text'    ,'text'      ,'text','select'        );
    $fd_size      = array('7'       ,'8'       ,'8'         ,'6',''        );
    $fd_maxl      = array('7'       ,'8'       ,'8'         ,'6',''        );
    $fd_memo      = array('(請輸入員編或姓名查詢)','(請至 <a href="/~sl/sl_person.php" target=_blank><font color=red>個人基本設定</font></a> 填寫，填寫完請<font color=red>重新登入EIP</font>查詢！)','','(西元年月, 範例：201109, 抓取2011.08.26~2011.09.25)','');
    $fd_readonly  = array(''        ,'readonly','readonly'  ,'','');
    $fd_class     = array(''        ,'field_color','field_color'  ,'','');
    //$fd_readonly  = array('','onChange="javascript:this.value=this.value.toUpperCase();"','','','');
    
    /*
    $fd_cname     = array('員工編號','車號'    ,'會員卡卡號','車種','外出日期起訖','排除哩程數為零');
    $fd_ename     = array('f_eb01'  ,'f_car'   ,'f_card'    ,'f_else_calc'    ,'','f_eb13'            );
    $fd_value     = array($_SESSION['login_empno'],$_SESSION['login_car_id'],$_SESSION['login_vip_card'],'','',''            );
    $fd_tbhr      = array('text'    ,'text'    ,'text'      ,'select'      ,'date','select'        );
    $fd_size      = array('7'       ,'8'       ,'8'         ,'','',''        );
    $fd_maxl      = array('7'       ,'8'       ,'8'         ,'' ,'',''        );
    $fd_memo      = array('','','','','(西元年月日,範例：20080130~20080217)','');
    $fd_readonly  = array('','onChange="javascript:this.value=this.value.toUpperCase();"','','','');    
    */
    for($i=0;$i<count($fd_cname);$i++){
      $f_var["tp"]->newBlock('tb_in_que_hr_tr');                                          
      $f_var["tp"]->assign('tv_cname', $fd_cname[$i]);
      switch ($fd_tbhr[$i]) {
        case "date":             
           $f_var["tp"]-> newBlock (  "tb_date_hr"                );
           $f_var["tp"]-> assign   (  "tv_ename"     , $fd_ename[$i]);
           $f_var["tp"]-> assign   ( "tp_dateb"      , date("Ymd")                   ); // 日期起
           $f_var["tp"]-> assign   ( "tp_datee"      , date("Ymd")                   ); // 日期訖
           $f_var["tp"]-> assign   ("tb_in_que_hr_tr.tv_memo"   , $fd_memo[$i]  );
          break;
        case "select":
            $f_var["tp"]-> newBlock (  "tb_select_hr"              );
            $f_var["tp"]-> assign   (  "tv_sname"   , $fd_ename[$i]);
            if('f_else_calc'==$fd_ename[$i]){
              while(list($mvalue)=each($f_var['else_calc']['value'])) {
                $f_var["tp"]-> newBlock ("tv_option_hr"                  ); // option
                $f_var["tp"]-> assign   ("tv_value"   , $f_var['else_calc']['value'][$mvalue]  );
                $f_var["tp"]-> assign   ("tv_show"    , $f_var['else_calc']['show'][$mvalue]   );
              }  
            }
            else{
              $f_var["tp"]-> newBlock ("tv_option_hr"                  ); // option
              $f_var["tp"]-> assign   ("tv_value"   , 'N'  );
              $f_var["tp"]-> assign   ("tv_show"    , 'N'   );
              $f_var["tp"]-> newBlock ("tv_option_hr"                  ); // option
              $f_var["tp"]-> assign   ("tv_value"   , 'Y'  );
              $f_var["tp"]-> assign   ("tv_show"    , 'Y'   );
            }
          break;
        default:
               $f_var["tp"]-> newBlock ("tb_text_hr"                ); 
               $f_var["tp"]-> assign   ("tv_ename"     , $fd_ename[$i] );
               $f_var["tp"]-> assign   ("tv_value"     , $fd_value[$i] );
               $f_var["tp"]-> assign   ("tv_size"      , $fd_size[$i]  );
               $f_var["tp"]-> assign   ("tv_maxlength" , $fd_maxl[$i]  );
               $f_var["tp"]-> assign   ("tv_readonly" , $fd_readonly[$i]  );
               $f_var["tp"]-> assign   ("tb_in_que_hr_tr.tv_memo"   , $fd_memo[$i]  );
               $f_var["tp"]-> assign   ("tv_class"    , $fd_class[$i]  );
          break;
      }      
    }  
    $f_var["tp"]-> newBlock ("tb_memo"                ); 
    $vjs_rule .= "if(this.f_empno.value==''){
                      alert('『員工編號』不可為空白!!') ;
                      this.f_eb01.focus();
                      return(false)
                  };
                  if(this.f_car.value==''){
                    alert('『車號』不可為空白!!') ;
                    this.f_car.focus();
                    return(false)
                  }; 
                  if(this.f_date.value.length!=6 || this.f_date.value==''){
                    alert('『年月』輸入有誤!!') ;
                    this.f_date.focus();
                    return(false)
                  };                                    
                  
                 "; 
/*  upd by 佳玟 2011.09.23 發現有人沒有卡號   先移除檢查 

                  if(this.f_card.value==''){
                    alert('『會員卡卡號』不可為空白!!') ;
                    this.f_card.focus();
                    return(false)
                  };


*/
     $f_var["tp"]-> assignglobal   (  "tv_js_rule"    , $vjs_rule); // js rule            
  }
  // **************************************************************************
  //  函數名稱: list_prn1()
  //  函數功能: 列印畫面-選擇列印
  //  使用方式: list_prn1($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.01.30
  // **************************************************************************
  function list_prn1($f_var) {    
    //echo $f_var['f_b_dept_id'].'---'.$f_var['f_eb01'].'---'.$f_var['f_dateb'].'---'.$f_var['f_datee'].'<br>';  
    //印明細表部分
    $fd_date = date("Y-m-d h:i:s");
    $res=strpos($f_var['f_sname'],"-")+1;
    $len=strlen($f_var['f_sname'])-$res;
    $fd_dept_id = substr($f_var['f_sname'],$res,$len); 
    $fd_dept_sn = substr($f_var['f_sname'],0,4); 
    //$fd_dateby  = $f_var['f_dateb']-19110000;
    //$fd_dateey  = $f_var['f_datee']-19110000;
    $fd_dateb   = substr($f_var['f_dateb'],0,4).'-'.substr($f_var['f_dateb'],4,2).'-'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($f_var['f_datee'],0,4).'-'.substr($f_var['f_datee'],4,2).'-'.substr($f_var['f_datee'],6,2);
    $fd_trtitle = array('廠部別 '     ,'部門別 '  ,'同仁姓名 ','回數票 ','外出日期 ','外出時間 ','前往地點 '            ,'外出事由 '                                 ,'回程日期 ','回程時間 ','備註'                );    
    $fd_trline  = array("=========== ","======== ","======== ","====== ","======== ","======== ","==================== ","======================================== " ,"======== ","======== ","==================== ");
    $fd_width   = array(12            ,9          ,9          ,7        ,9          ,9          ,21                     ,41                                          ,9          ,9         ,21                     );
    $fd_word1   ='';
    $fd_line   ='';
    for($i=0;$i<count($fd_trtitle);$i++){
      $fd_word1 .= str_pad($fd_trtitle[$i],$fd_width[$i], " ", STR_PAD_RIGHT);
      $fd_line  .= str_pad($fd_trline[$i],$fd_width[$i], " ", STR_PAD_RIGHT);
    }
    //
    $f_var['where_dept'] = iif($f_var['f_sname'] == '00'      ,""," and ewb01.b_dept_id = '{$fd_dept_sn}' "); 
    //$f_var['mwhere']  = iif($f_var['f_b_dept_id'] == '00',""," substring(ewb01.b_dept_id,1,2) = '{$f_var['f_b_dept_id']}' and "); 
    
      switch ($f_var['f_b_dept_id']) {
        case "S1":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S1%' and ";
            break;
        case "S25":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S25%' and ";
            break;  
        case "S26":                
            $f_var['mwhere'] = "  {$f_var['mtable']['dept']}.p_gid like 'S26%' and";
            break;  
        case "S28":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S28%' and ";
            break;  
        case "S35":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S35%'  and ";
            break;  
        case "S36":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S36%'  and ";
            break;  
        case "S38":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'S38%' and";
            break;  
        case "E1":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'E1%' and";
            break;  
        case "T1":                
            $f_var['mwhere'] = " {$f_var['mtable']['dept']}.p_gid like 'T1%' and";
            break;  
        default:
          $f_var['mwhere'] = " ";
          break;
      }      
    $f_var['mwhere'] .= iif($f_var['f_eb01'] == ''      ,""," ewb01.eb01 like '%{$f_var['f_eb01']}%' and "); 
    $f_var['mwhere'] .= "(ewb01.eb02 BETWEEN '{$f_var['f_dateb']}' AND '{$f_var['f_datee']}') and 
                         ewb01.d_date = '0000-00-00 00:00:00'   
                         {$f_var['where_dept']}
                         ";
    
    if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181'] ){ //add by 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位
      $f_var['mwhere'] .= " ";
     }
    else{
      //$f_var['mwhere'] .= " and  {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
      $f_var['mwhere'] .= " and  pass.dept_id <>'S181' "; //js_h.date='0000-
    }
    if(NULL<>$f_var['f_order'] ) { // 以狀態查詢
      $f_var['morder']="{$f_var['f_order']} desc,b_date desc";
    }
    $query1      = "SELECT ewb01.*,
                           {$f_var['mtable']['dept']}.sname,{$f_var['mtable']['dept']}.p_gid
                    FROM ewb01 
                         left join {$f_var['mtable']['dept']} on ewb01.b_dept_id = {$f_var['mtable']['dept']}.dept_id
                         left join sl.pass on ewb01.eb18 = pass.empno
                    WHERE {$f_var['mwhere']}
                           ORDER BY {$f_var['morder']}
                         ";
    //echo $query1."<BR>";//exit;
    $result1 = mysql_query($query1); 
    $num1 = mysql_num_rows($result1);
    $page_sum   = ceil($num1/40);
    echo "<pre>"; 
    while($row1 = mysql_fetch_array($result1)){      
      //列印部份
      $fd_cut++;
      $fd_cut = iif($fd_cut < 10,"0{$fd_cut}",$fd_cut); 
      $fd_dept = substr($row1['p_gid'],0,2); 
      switch ($fd_dept) {
        case "S1":  
              $fd_area = "總管理處";
            break;
        case "S2":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            //echo $vfd_dept;
            switch ($vfd_dept) {
              case "S25":  
                    $fd_area = "北區管理課";
                  break;
              case "S26":  
                    $fd_area = "中區管理課";
                  break;
              default:
                    $fd_area = "南區管理課";
                break;
            }   
            break;
        case "S3":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            switch ($vfd_dept) {
              case "S35":  
                    $fd_area = "北區油品";
                  break;
              case "S36":  
                    $fd_area = "中區油品";
                  break;
              default:
                    $fd_area = "南區油品";
                break;
            }   
            break;
        case "E1":  
              $fd_area = "船務報關";
            break;
        case "T1":  
              $fd_area = "山隆生技";
            break;
        default:
          break;
      }   
      $fd_eb02  = substr($row1['eb02'],4,2).'-'.substr($row1['eb02'],6,2);
      $fd_eb03  = substr($row1['eb03'],0,2).':'.substr($row1['eb03'],2,2);
      $fd_eb06  = substr($row1['eb06'],4,2).'-'.substr($row1['eb06'],6,2);
      $fd_eb07  = substr($row1['eb07'],0,2).':'.substr($row1['eb07'],2,2);
      $fd_value = array($fd_area,$row1['sname'],$row1['eb01'],$row1['eb14'],$fd_eb02,$fd_eb03,$row1['eb04'],$row1['eb05'],$fd_eb06,$fd_eb07,$row1['eb08']);
      $fd_dept1 = $fd_area; 
      //寫到      
      $fd_word2 = '';
      for($s=0;$s<count($fd_value);$s++){
        if('6' != $s and '7' != $s and '10' !=$s and '1' !=$s and '2' !=$s and '0' !=$s){
          $fd_word2 .= str_pad($fd_value[$s],$fd_width[$s], " ", STR_PAD_BOTH);
        }
        else{          
          $fd_word2 .= str_pad($fd_value[$s],$fd_width[$s], " ", STR_PAD_RIGHT);
        }
      }
      $mjump_cnt++;
      //if('1' == substr($_SESSION['login_erp_dept_id'],0,1) or $_SESSION['login_erp_dept_id'] ==  $f_var['f_TB006']){
      if("1" == $mjump_cnt){
        $page_cnt++;
        $fd_word4 = str_pad("目前頁次：{$page_cnt}/{$page_sum}",95, " ", STR_PAD_LEFT);
        echo "<h2>外出列印查詢</h2>";
        echo "<br>外出日期起訖：{$fd_dateb}～{$fd_datee} {$fd_word4}<br><br>";
        echo "<br><br>===========================================================================================================================================================<br>{$fd_word1}<br>{$fd_line}<br>";
      }      
      if($fd_dept1 != $fd_dept2 and NULL != $fd_dept2){
        echo "----------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
      }   
      $fd_dept2 = $fd_area; 
      echo "{$fd_word2}<br>";  
      if("40" == $mjump_cnt){
        echo "------接下頁-----------------------------------------------------------------------------------------------------------------------------------------------";
        echo "<br><div STYLE='page-break-after: always;'></div>";
        $mjump_cnt=0;
      }
      //} 
    }
    $fd_totle = number_format($fd_totle);
    $fd_len   = strlen("總筆數：{$num1}");
    //echo "======================================================================================================================================== ";
    echo "{$fd_line}<br>總筆數：{$num1}<br>";
    echo "=========================================================================================================================================================== ";
    echo "<br>                                        列印日期：{$fd_date}                　　　　　　　　                   列印人員:{$_SESSION['login_name']}"; 
    echo "</pre>"; 
  }
  // **************************************************************************
  //  函數名稱: list_prn2()
  //  函數功能: 列印畫面-私車公用
  //  使用方式: list_prn2($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.06.23
  // **************************************************************************
  function list_prn2($f_var) {
    //upd by 佳玟 2011.10.05 (待辦-14426 回應32(2)) 將外出日期起訖：修正為僅可以輸入年月,系統計算為上月26至本月25
    $y = substr($f_var['f_date'], 0, 4); //取前四碼 (年)        
    $m = substr($f_var['f_date'], 4, 2); //取最後二碥(月)  
    $lastmonth = mktime(0, 0, 0, $m-1, "26", $y);   //上個月 26 日       
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //這個月 25 日止
    $f_var['f_dateb'] = date('Ymd', $lastmonth);
    $f_var['f_datee'] = date('Ymd', $nowmonth);
    $f_var['close_date'] = date('Y-m-d', mktime(0, 0, 0, $m+1, "7", $y))." 00:00:00"; //關帳日隔月7日以前
    //echo $f_var['close_date'];
    //油料計算的部分
     //02.私車公用
     //$vfd_litre['206'] = 20;
     $vfd_litre['206'] = 10; //upd by 佳玟 2016.01.12 報修28170-改以10公里/公升補助
     $vfd_litre['201'] = 4;
     $vfd_litre['202'] = 4;
     $vfd_litre['203'] = 4;
     $vfd_litre['204'] = 4;
     $vfd_litre['205'] = 4;          
     //03.受公司補助購車-維修-公司支付
     $vfd_litre['301'] = 13;
     $vfd_litre['302'] = 12;
     $vfd_litre['303'] = 11;
     $vfd_litre['304'] = 10;
     $vfd_litre['305'] = 9;                 
     //04.受公司補助購車-維修-自行支付
     $vfd_litre['401'] = 10;
     $vfd_litre['402'] = 9;
     $vfd_litre['403'] = 8;
     $vfd_litre['404'] = 7;
     $vfd_litre['405'] = 6;
    //$vfd_litre['306'] = 1;

    //-------------------------------------------------------------------------
    // add by 佳玟 2012.06.25 (報修17550)排除當月不發油貼(但非本月)
    //-------------------------------------------------------------------------      
    $month_m3 = mktime(0, 0, 0, $m-3, "26", $y);   //前三個月前 26 日       
    $fd_m3    = date('Ym', $month_m3);  
    $query4 = "SELECT *
              from   ewb_pay_emp_set2
              where  d_date = '0000-00-00 00:00:00'
                     and es01 = '{$f_var['f_empno']}'
                     and es03 > '{$fd_m3}'
              ";
    //echo "<pre>".$query4."</pre>";
    $result4 = mysql_query($query4);
    $count4  = mysql_num_rows($result4);    
    //echo $count4;
    if($count4>0){
      while($row4 = mysql_fetch_array($result4)){
        $y4 = substr($row4['es03'], 0, 4); //取前四碼 (年)        
        $m4 = substr($row4['es03'], 4, 2); //取最後二碥(月)  
        $month_m1 = mktime(0, 0, 0, $m4-1, "26", $y4);   //上個月 26 日       
        $month_m2  = mktime(0, 0, 0, $m4,   "25", $y4);   //這個月 25 日止
        $fd_mm1 = date('Ymd', $month_m1);
        $fd_mm2 = date('Ymd', $month_m2); 
        $swhere_set2 .= " and not (docs.ewb01.eb02 BETWEEN '{$fd_mm1}' AND '{$fd_mm2}') ";        
      }
    }  
    //-------------------------------------------------------------------------
    

    //印明細表部分
    $fd_date = date("Y-m-d h:i:s");
    $f_var['mwhere'].= " and docs.ewb01.eb02 between '{$f_var['f_date1']}' and '{$f_var['f_date2']}' ";
    $fd_dateb   = substr($f_var['f_dateb'],0,4).'-'.substr($f_var['f_dateb'],4,2).'-'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($f_var['f_datee'],0,4).'-'.substr($f_var['f_datee'],4,2).'-'.substr($f_var['f_datee'],6,2);
    $f_var['mwhere']  = "docs.ewb01.eb18 = '{$f_var['f_empno']}' ";
    //-------------------------------------------------------------
    // 是否已轉統計表 (轉統計表前後顯示資料不同)
    //-------------------------------------------------------------
    $query3 = "select docs.ewb_pay_ym.*
               from   docs.ewb_pay_ym
               where  docs.ewb_pay_ym.d_date = '0000-00-00 00:00:00'
                      and docs.ewb_pay_ym.ey01 = '{$f_var['f_date']}'
                      and docs.ewb_pay_ym.ey02 = '{$f_var['f_empno']}'
           ";
    $result3 = mysql_query($query3);
    $count3  = mysql_num_rows($result3);     
    if(0==$count3){  //未作帳
      $ybe = substr($f_var['f_dateb'], 0, 4); //取前四碼 (年)        
      $mbe = substr($f_var['f_dateb'], 4, 2); //取最後二碥(月)          
      $befor_month = mktime(0, 0, 0, $mbe-1, "25", $ybe);   //前一個月前 26 日  upd by 20120705  次月
      $befor_month = date('Ymd', $befor_month);    
      $f_var['mwhere'] .= " and (((docs.ewb01.eb02 BETWEEN '{$f_var['f_dateb']}' AND '{$f_var['f_datee']}')
                                   or (docs.ewb01.eb20 = 'Y' and docs.ewb01.eb19 = '' and (docs.ewb01.eb02 > '{$befor_month}' and docs.ewb01.eb02 <= '{$f_var['f_datee']}'))
                                   {$swhere_set2}
                                  )
                                 /*政杰11/26~12/25外出資料給予 */
                                 OR ( docs.ewb01.eb18 = '9166637'
                                      AND docs.ewb01.eb02 BETWEEN '20121126' AND '20121225' 
                                      AND docs.ewb01.eb20 = 'Y'
                                      AND docs.ewb01.eb19 = ''
                                  )
                                 /*add by 佳玟 2014.12.25 報修25296、25295 */
                                 OR ( docs.ewb01.eb18 in ('9325760')
                                      AND docs.ewb01.eb02 BETWEEN '20141002' AND '20141002' 
                                      AND docs.ewb01.eb20 = 'Y'
                                      AND docs.ewb01.eb19 = ''
                                      AND docs.ewb01.eb22 = ''
                                     ) 
                                 OR ( docs.ewb01.eb18 in ('8165564')
                                      AND docs.ewb01.eb02 BETWEEN '20141021' AND '20141021' 
                                      AND docs.ewb01.eb20 = 'Y'
                                      AND docs.ewb01.eb19 = ''
                                      AND docs.ewb01.eb22 = ''
                                     )   
                                  
                                ) 
                            and docs.ewb01.d_date = '0000-00-00 00:00:00'   
                          "; //$swhere_set2 ->>  upd by 佳玟 2012.06.25 (報17550) 排除當月不發油貼設定檔所設定的年月    	
    }else{  //已作帳
      //$f_var['mwhere'].= " and (docs.ewb01.eb22 = '{$f_var['f_date']}')
      //                     and docs.ewb01.d_date = '0000-00-00 00:00:00'   
      //                   ";  //upd by 佳玟 2012.05.17 (待辦14426回應125) 列出先前資料為本月份作帳
      
      //$f_var['mwhere'] .= " and ((docs.ewb01.eb02 BETWEEN '{$f_var['f_dateb']}' AND '{$f_var['f_datee']}')
      //                            or (docs.ewb01.eb22 = '{$f_var['f_date']}')
      //                          ) 
      //                      and docs.ewb01.d_date = '0000-00-00 00:00:00'   
      //                    ";    	 
      $f_var['mwhere'] .= " and docs.ewb01.eb22 = '{$f_var['f_date']}'
                            and docs.ewb01.d_date = '0000-00-00 00:00:00'   
                          ";                                                      
    }
    //-------------------------------------------------------------
                                     
    //if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain'])  or 'S122'==$_SESSION['login_dept_id'] or '8702080'==$_SESSION['login_empno']){
    if($f_var['views181'] == 'Y'){
      $f_var['mwhere'] .= " ";
    }
    else{
      $f_var['mwhere'] .= " and pass.dept_id <>'S181' "; //js_h.date='0000-
    }
    $f_var['mwhere'] .= iif($f_var['f_eb13']=='N',""," AND docs.ewb01.eb13 <>'0' ");
    
    $query1      = "SELECT sle.sle0a.E0A_1,
                           ( select sum(sle.sle01.E01_5)
                             from   sle.sle01
                             where  (sle.sle01.E01_2+19110000)  = docs.ewb01.eb02
                                    AND sle.sle01.E01_1 = docs.ewb01.eb18
                           ) as E01_5,
                           docs.ewb01.*,docs.ewb02.eb02 gas_cost,
                           pass.name as ebname,
                           sl.dept.sname,
                           (select es14
                            from   docs.ewb_pay_emp_set_log
                            where  es02=docs.ewb01.eb18
                                   and d_date='0000-00-00 00:00:00'
                                   and b_date <= '{$fd_dateb} 00:00:00'
                                   and m_date <= '{$f_var['close_date']}'
                            order by s_num desc
                            limit 1       
                           ) as es14,
                           sl.person_set.ps03 as car  # 車號
                    FROM   docs.ewb01 
                           left join sl.pass on ewb01.eb18 = pass.empno
                           left join sl.dept
                                on docs.ewb01.b_dept_id = sl.dept.dept_id
                           left join docs.ewb02
                                on docs.ewb01.eb02=docs.ewb02.eb01 
                           left join sl.person_set
                                on docs.ewb01.eb18 = sl.person_set.ps01 
	                         left join sle.sle0a
	                              on docs.ewb01.eb02=(sle.sle0a.E0A_1+19110000) 
                           /*left join sle.sle01
	                              on docs.ewb01.eb02=(sle.sle01.E01_2+19110000) 
                                   AND docs.ewb01.eb18=sle.sle01.E01_1 */                                   
                    WHERE {$f_var['mwhere']} and 
                          substring(docs.ewb01.eb09,2,1) in('2','3','4')
                    ORDER BY ewb01.eb02 asc, ewb01.eb11 asc
                   ";
    if('1330075'==$_SESSION["login_empno"]) {                      
      echo '<pre>'.$query1.'</pre>';
    }
    //echo '<pre>'.$query1.'</pre>';
    $add_eb13=0;
    //$add_eb14=0;
    $add_eb141=0;
    $add_eb142=0; //add by 2014.01.03計程通行費
    $pre_eb10 ='';
    $result1 = mysql_query($query1); 
    $num1 = mysql_num_rows($result1); 
    if($num1==0){
      sl_errmsg("無可顯示資料!!");
    }
    else{  
      $fd_cut=1;
      $fd_jump='N';
      $fd_agree = 0;
      $fd_disagree = 0;
      $fd_signin = 0;      
      while($row1 = mysql_fetch_array($result1)){
        $fd_sleip2flw = u_chk_sleip2flw($row1['s_num']);  //0 同意  1 不同意  2 未簽核

        switch($fd_sleip2flw){  //計算簽核數  0 同意  1 不同意  2 未簽核(簽核中)
          case '0':
               $fd_agree++;
               break;
          case '1':
               $fd_disagree++;  
               break;
          case '2':
               $fd_signin++;
               break;
          case '3':
               $fd_resign++;  //重簽
               break;               
          default:
               break;
        }

        //echo $row1['s_num']."-----".$fd_sleip2flw."<br>";
        if($fd_sleip2flw=="0"){ //僅顯示里程簽核同意的外出  20111107上線
        	  //-------------------------------------------------------------
        	  // add by 佳玟 2011.08.10 判斷是否eb10(排氣量) 為無效值
        	  //-------------------------------------------------------------
            $ex_error =iif(trim($row1['eb10'])=='--' or trim($row1['eb10'])=='',"E","C");
            if($f_var['f_car']==''){
              $f_car=$_REQUEST['f_car'];
            }else{
              $f_car=$f_var['f_car'];
            }        	  
        	  //-------------------------------------------------------------
        	  // 基本資料
        	  //-------------------------------------------------------------  
            if($fd_cut==1){  //第一迴圈
              $f_var["tp"]-> newBlock (  "tb_list_prn"                );
              $f_var["tp"]-> assign   ('tv_action', u_showproc().".php?msel=42&f_trn_ym={$f_var['f_trn_ym']}&f_empno={$f_var['f_empno']}&f_name={$row1['eb01']}");  //儲存
              $f_var["tp"]-> newBlock (  "tb_title"                   );          
              $f_var["tp"]-> assign   (  "tv_date1"  , sl_4ymd($f_var['f_dateb'] ));
              $f_var["tp"]-> assign   (  "tv_date2"  , sl_4ymd($f_var['f_datee'] ));
              $f_var["tp"]-> assign   (  "tv_name"   , $row1['ebname']  );  //upd by 佳玟 2018.11.06 船務珮瑜來電,員編1830083,換名字會抓到舊名
              //$f_var["tp"]-> assign   (  "tv_name"   , $row1['eb01']  );  //車號  ebname
              $f_var["tp"]-> assign   (  "tv_car"    , $f_car         );
              $f_var["tp"]-> assign   (  "tv_card"   , $f_var['f_card']);              
              $fd_setes14 = iif($row1['es14']<>NULL,$row1['es14'],0);
              $f_var["tp"]-> assign   (  "tv_set"    , number_format($fd_setes14));  //固定油貼
              $f_var["tp"]-> assign   (  "tv_car"    , $row1['car']   );  //車號
              $f_var["tp"]-> newBlock (  "tb_body"                    );
              $fd_jump='Y'; //跳頁設定
            }   
            $f_var["tp"]-> assign   (  "tb_title.tv_eb01"  , $row1['eb01']   );
            $f_var["tp"]-> assign   (  "tb_title.tv_dept"  , $row1['sname']   );
            $f_var["tp"]-> assign   (  "tb_title.tv_eb10"  , substr($row1['eb10'],3,99)   );

            $fd_eb02  = substr(sl_4ymd($row1['eb02']),5); //日期 
        
        	  //-------------------------------------------------------------
        	  // add by 2011.04.14 佳玟  受公司補助購車 無 摩托車
        	  //-------------------------------------------------------------  
            $fd_eb10  = iif(substr($row1['eb09'],1,1)=='3' and substr($row1['eb10'],0,2)=='06',$pre_eb10,$row1['eb10']);
            $fd_eb91  = substr($row1['eb09'],1,1).substr($fd_eb10,0,2); //取得油耗 KM/L
            $pre_eb10 = substr($row1['eb10'],0,2);  //紀錄先前eb10值
            $vfd_litre['206'] = 10;
            if( $row1['eb02']<'20160101' ){ //add by 佳玟 2016.01.12 報修28170-2016/1/1以前外出,摩托車以20公里/公升補助
              //echo $row1['eb02'];
              $vfd_litre['206'] = 20;
            }
            $fd_litre = $vfd_litre[$fd_eb91];   //車輛耗油    
            
        	  //-------------------------------------------------------------
        	  // 行駛哩程
        	  //-------------------------------------------------------------
            //$fd_eb17_1 = iif($row1['eb17']=='Y',"<font color='#ff0000'>＃</font>",""); //扣除標準里程 註記
            $fd_eb17_1 = iif($row1['eb24']=='Y',"<font color='#ff0000'>＃</font>",""); //扣除標準里程 註記
            $fd_veb13 = $row1['eb12']-$row1['eb11'];
            //$fd_eb17_2 = iif($row1['eb17']=='Y',"<font color='#ff0000' size='1'><b>({$fd_veb13})-120</b></font>&nbsp;<br>","");
            $fd_eb17_2 = iif($row1['eb24']=='Y',"<font color='#ff0000' size='1'><b>({$fd_veb13})-30</b></font>&nbsp;<br>","");
            //$dec_eb13  = iif($row1['eb17']=='Y',(($row1['eb12']-$row1['eb11'])-120),($row1['eb12']-$row1['eb11']));
            $dec_eb13  = iif($row1['eb24']=='Y',(($row1['eb12']-$row1['eb11'])-30),($row1['eb12']-$row1['eb11']));
            
            $fd_eb13   = iif($dec_eb13>0,$dec_eb13,0);
            $fd_eb13   = iif('N'==$row1['eb20'],0,$fd_eb13);  //是否被設定為不給油貼
            $add_eb13 += $fd_eb13; //行駛哩程累加       
            
        	  //-------------------------------------------------------------
        	  // 排氣量為有效值才計算，不然會出錯
        	  //-------------------------------------------------------------              
            if($ex_error=="C"){
              $fd_eb09   = substr($row1['eb09'],0,2); //車種
              //$fd_gast   = iif($row1['eb10']=='--' or $row1['eb10']=='',"0",$fd_eb13/$fd_litre);
              //$fd_lpsum  =  $fd_gast* $row1['gas_cost']; 
              $fd_gast   = iif($row1['eb10']=='--' or $row1['eb10']=='',"0",round(($fd_eb13/$fd_litre),2)); //upd by 佳玟 2013.01.11 先四捨五入至小數第二位後再乘95單價
              $fd_lpsum  =  round($fd_gast* $row1['gas_cost']); 
                               
              $v_litre   =  $fd_litre;  //車輛耗油
              $fd_lpsum  = iif('N'==$row1['eb20'],0,$fd_lpsum);  //是否被設定為不給油貼
              $v_lpsum   =  number_format($fd_lpsum,0); //應申請金額(E)
              $v_gast    =  number_format($fd_gast,2);  //應申請油料(C)
              $add_lpsum +=  round($fd_lpsum,0);  //應申請金額(E)累加  
              $add_gast  +=  $fd_gast;  //應申請油料(C)累加
             
              
            }else{
              $v_litre = '';
              $v_lpsum = ''; 
              $v_gast  = '';  
              $row1['eb14']='0';//當資料異常，路票設定為0     
            }  
                 
            //$add_eb14 += iif('N'==$row1['eb20'],0,$row1['eb14']); //路票累加        

        	  //-------------------------------------------------------------
        	  // 該筆油價尚未轉入 [紅底灰字]
        	  //-------------------------------------------------------------             
            $fd_strike=iif($row1['gas_cost']==NUll,"text-decoration: line-through; color: #C0C0C0; background-color: #FF0000",""); 

            //--------------------------------------------------
            // 未給予油貼的外出資料，在里程「起」旁邊顯示x
            //--------------------------------------------------
            if(''==$row1['eb19']){ //upd by 佳玟 2012.05.09 (報修14426 回應125)
            	$fd_str_eb11 = "<font color='#4F8917'>x&nbsp;</font>";
            }else{
            	$fd_str_eb11 = "";
            }

            //--------------------------------------------------
            // 起迄是否異常判斷
            //--------------------------------------------------            
            if($ar_oldeb12<>''){
              if($ar_oldeb12>$row1['eb11'] and $row1['eb23']<>'Y'){ //之前的訖 > 現在的起 (異常)
                $fd_str_eb11.= '<font color=red>＊</font>'.number_format($row1['eb11']);
              }else{
                $fd_str_eb11.= number_format($row1['eb11']);
                $ar_oldeb12 = $row1['eb12'];            
              }
            }else{
              $f_var['top_date'] = $row1['eb02'];
              u_seleb12(&$f_var);    
              if( strstr("201211/201212",substr($row1['eb02'],0,6)) and '9166637'==$row1['eb18'] ){
                $f_var['maxeb12'] = 0;
              }               
              $ar_oldeb12 = $f_var['maxeb12'];
              if($ar_oldeb12>$row1['eb11'] and $row1['eb23']<>'Y'){ //上月最大一筆訖 > 現在的起 (異常)
                $fd_str_eb11.= '<font color=red>＊</font>'.number_format($row1['eb11']);
              }else{
                $fd_str_eb11.= number_format($row1['eb11']);
                $ar_oldeb12 = $row1['eb12'];            
              }                                             
            }   
             
            if('N'<>$row1['eb20']){  // 是否給油貼
            	$fd_eb13 = $fd_eb17_2.number_format($fd_eb13);
            }
            
        	  //-------------------------------------------------------------
        	  // 列出每筆外出資料
        	  //-------------------------------------------------------------        
            $weekday  = date('w', strtotime($row1['eb02']));
            $weeklist = array('日', '一', '二', '三', '四', '五', '六');  
            if( !empty($row1['E0A_1']) ){  //國定假日
              $fd_week = "<font color=red>({$weeklist[$weekday]})</font>";          
            }else{
              $fd_week = "(".$weeklist[$weekday].")";
            }  
                            
            $f_var["tp"]-> newBlock (  "tb_body_tr"                      );
            $f_var["tp"]-> assign   (  "tv_style"  , $fd_strike          );  //底色   
            $f_var["tp"]-> assign   (  "tv_eb02"   , $fd_eb17_1.$fd_eb02."<font size=-2>".$fd_week."</font>" );  //日期  
            $f_var["tp"]-> assign   (  "tv_vchkb"  , $row1['s_num']      );  //ewb01流水號
            if($row1['eb20']=='N'){  //checkbox 是否預設勾選
              $f_var["tp"]-> assign   (  "tv_checked1"  , 'checked'); 
              $f_var["tp"]-> assign   (  "tv_disabled1"  , 'disabled'); 
              $f_var["tp"]-> assign   (  "tv_disabled2"  , 'disabled'); 
            }
            if($row1['eb23']=='Y'){ 
              $f_var["tp"]-> assign   (  "tv_checked2"  , 'checked'); 
              $f_var["tp"]-> assign   (  "tv_disabled1"  , 'disabled'); 
            }
            $f_var["tp"]-> assign   (  "tv_eb21"   , $row1['eb21']);  //重簽原因
            $f_var["tp"]-> assign   (  "tv_eb11"   , $fd_str_eb11);   //起            
            $f_var["tp"]-> assign   (  "tv_eb12"   , number_format($row1['eb12']));   //訖
            $f_var["tp"]-> assign   (  "tv_eb13"   , $fd_eb13);    //行駛哩程
            //echo $fd_eb13."<br>";
            $f_var["tp"]-> assign   (  "tv_litre"  , $v_litre);   //車輛耗油
            $f_var["tp"]-> assign   (  "tv_gast"   , $v_gast);  //應申領油料
            $f_var["tp"]-> assign   (  "tv_cost"   , $row1['gas_cost']);   //95單價
            $f_var["tp"]-> assign   (  "tv_lpsum"  , $v_lpsum);    //應申請金額
            //if($row1['eb20']=='N'){
            // 	$fd_eb14 = '0';
            //}else{
            //  $fd_eb14 = $row1['eb14'];
            //}
            //$f_var["tp"]-> assign   (  "tv_eb14"   , $fd_eb14);   //路票
            if( $row1['eb02']>"20140101" ){ //外出日期>20140101則開始累加遠通計程費
              $fd_eb141 = 0;
              $fd_eb142 = $row1['eb14'];
            }else{
              $fd_eb141 = $row1['eb14'];
              $fd_eb142 = 0;
            }
            if($row1['eb20']=='N'){
              $fd_eb141 = 0;
              $fd_eb142 = 0;
            }else{
              $fd_eb141 = $fd_eb141;
              $fd_eb142 = $fd_eb142;
            }
            //$add_eb141 += iif('N'==$row1['eb20'],0,$fd_eb141); //路票累加  
            $add_eb142 += iif('N'==$row1['eb20'],0,$fd_eb142); //計程通行費累加  
                                                  
            //$atime = sl_4ymd($row1['eb02'])." ".substr($row1['eb03'],0,2).":".substr($row1['eb03'],2,2).":00";
            //$btime = sl_4ymd($row1['eb06'])." ".substr($row1['eb07'],0,2).":".substr($row1['eb07'],2,2).":00";
            //$ar_diff = sl_timediff($atime,$btime); //2012-07-09 01:40:00 upd by 2014.12.01 報修25124
            //$fd_hr = $ar_diff['hour'] + round(($ar_diff['min']/60),2);
            
            if( empty($ar_E01_5[$row1['eb02']]) ){
              $ar_E01_5[$row1['eb02']] = $row1['E01_5'];
              $fd_E01_5 = $row1['E01_5'];
            }else{
              $fd_E01_5 = 0;
            }
            
            $add_eb141 += $fd_E01_5; //加班點                                 
            $f_var["tp"]-> assign   (  "tv_eb141"   , iif($fd_E01_5=='',0,$fd_E01_5) );   //加班點    upd by 2014.12.01 報修25124
            //$f_var["tp"]-> assign   (  "tv_eb141"   , $fd_eb141);   //路票            
            $f_var["tp"]-> assign   (  "tv_eb142"   , $fd_eb142);   //計程通行費
            
            $f_var["tp"]-> assign   (  "tv_eb04"   , $row1['eb04']);   //前往地點
            $fd_streb08 = iif($row1['eb08']=='',''," / ".$row1['eb08']);  //upd by 佳玟 2011.12.29 陳誌煌要求增加備註
            $f_var["tp"]-> assign   (  "tv_eb05"   , $row1['eb05'].$fd_streb08);   //事由  
            if($fd_cut==50 and $fd_jump=='Y'){  //50筆跳頁
              $f_var["tp"]-> newBlock (  "tb_jump_page"             );
              $fd_cut=0;
            }
            $fd_cut++; //筆數加加
            $fd_wman = $row1['eb01']; //add by 佳玟 2011.08.26  陳誌煌來電，新增顯示申請人姓名
        }    //echo $add_lpsum."<br>";
      }
      if($fd_agree==0){
        $fd_signa = $fd_signin+$fd_resign;  //簽孩中　＋　重簽
        sl_errmsg("未有外出資料簽核完成(里程簽核單同意)！<BR>簽核中筆數共: {$fd_signa} 筆");
      }

      //add by 佳玟 2011.12.15  (待辦-14426 回應52) 新增顯示加減金額  line: 1595~1613
      $query2 = "select *
                 from   docs.ewb_pay_addcut
                 where  docs.ewb_pay_addcut.ac01 = '{$f_var['f_empno']}' and
                        docs.ewb_pay_addcut.ac02 = '{$f_var['f_date']}' and 
                        docs.ewb_pay_addcut.d_date='0000-00-00 00:00:00'                       
                ";
      //echo $sql;
      $result2 = mysql_query($query2);
      $count = mysql_num_rows($result2);
      if($count>0){
        while ($row2 = mysql_fetch_assoc($result2)) {
          $f_var["tp"]-> newBlock (  "tb_body_addcut"             );
          $f_var["tp"]-> assign   (  "tv_ac06"   , $row2['ac06']);    //加減金額說明
          $f_var["tp"]-> assign   (  "tv_ac05"   , $row2['ac05']);    //加減金額
          $fd_tac05 += $row2['ac05'];
        }
      }else{
        $fd_tac05 = 0;
      } 

      //-------------------------------------------------------------
      // 總計列
      //-------------------------------------------------------------       
      $fd_signa = $fd_signin+$fd_resign;
      $f_var["tp"]-> newBlock (  "tb_body_tol"                            );
      $f_var["tp"]-> assign   (  "tv_count"   , "同意:{$fd_agree}  不同意:{$fd_disagree}  簽核中:{$fd_signa} ");
      $f_var["tp"]-> assign   (  "tv_eb13"    , number_format($add_eb13)  );
      $f_var["tp"]-> assign   (  "tv_gast"    , number_format($add_gast,2));
      $add_lpsum2 = $add_lpsum + $fd_tac05;  //upd by 佳玟 2011.12.15  (待辦-14426 回應52) 新增顯示加減金額  
      $f_var["tp"]-> assign   (  "tv_lpsum"   , number_format($add_lpsum2,0)); //$fd_tac05 -> 加減金額   
      //$f_var["tp"]-> assign   (  "tv_eb14"    , $add_eb14                 );
      $f_var["tp"]-> assign   (  "tv_eb141"    , $add_eb141                 );
      $f_var["tp"]-> assign   (  "tv_eb142"    , $add_eb142                 ); //add by 2014.01.03計程通行費     
      $f_var["tp"]-> newBlock (  "tb_body_final"                          );
      $f_var["tp"]-> assign   (  "tv_wman"    , $fd_wman                  ); //add by 佳玟 2011.08.26  陳誌煌來電，新增顯示申請人姓名
      $f_var["tp"]-> assign   (  "tv_man"     , $_SESSION['login_name']   );
    }
  }
  // **************************************************************************
  //  函數名稱: list_prn3()
  //  函數功能: 列印畫面-調車單
  //  使用方式: list_prn3($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.07.15
  // **************************************************************************
  function list_prn3($f_var) { 
    $f_var["tp"]-> newBlock (  "tb_list_prn2"                ); 
    //echo "<pre>";
    //var_dump($f_var["tp"]);
    //echo "</pre>";   
    $query1      = "select ewb01.eb01,   /*申請人*/
                           CONCAT(substring(eb02,5,2),'-',substring(eb02,7,2)) eb02,
                           CONCAT(substring(eb03,1,2),':',substring(eb03,3,2)) eb03,
                           CONCAT(substring(eb06,5,2),'-',substring(eb06,7,2)) eb06,
                           CONCAT(substring(eb07,1,2),':',substring(eb07,3,2)) eb07,
                           TIMEDIFF(CONCAT(substring(eb06,1,4),'-',substring(eb06,5,2),'-',substring(eb06,7,2),' ',substring(eb07,1,2),':',substring(eb07,3,2)) , CONCAT(substring(eb02,1,4),'-',substring(eb02,5,2),'-',substring(eb02,7,2),' ',substring(eb03,1,2),':',substring(eb03,3,2))) dif, 
                           ewb01.eb05,   /*事由*/ ewb01.eb04,   /*前往地點*/
                           substring(ewb01.eb09,1,2) eb09,   /*車種,是否為私車*/ 
                           ewb01.eb10,   /*排氣量*/
                           ewb01.eb11,   /*出廠公里數*/ ewb01.eb12,   /*入廠公里數*/
                           ewb01.eb15,   /*乘車人數*/
                           ewb01.b_date, /*建檔日期*/ sl.dept.dept_name  /*申請單位*/
                    from ewb01
                         left join sl.dept on ewb01.b_dept_id = sl.dept.dept_id
                         left join sl.pass on ewb01.eb01 = sl.pass.name
                    where ewb01.s_num = '{$f_var['f_s_num']}' and 
                          ewb01.d_date ='0000-00-00 00:00:00'
                   ";
    //echo $query1."<BR>";//exit;
    $result1 = mysql_query($query1); 
    $num1 = mysql_num_rows($result1);
    if($num1>0){
      while($row1 = mysql_fetch_array($result1)){
        $fd_b_date=substr($row1['b_date'],0,4)."年".substr($row1['b_date'],5,2)."月".substr($row1['b_date'],8,2)."日";
        switch ($row1['eb09']) {
          case "01":
            $fd_eb09_1="&#9745;";
            $fd_eb09_2="&#9744;";
            break;
          case "02":
          case "03":
            $fd_eb09_1="&#9744;";
            $fd_eb09_2="&#9745;";
            break;
          default:
            $fd_eb09_1="&#9744;";
            $fd_eb09_2="&#9744;";
            break;
        }      
        $fd_eb10  =iif($row1['eb10']=='',"",substr($row1['eb10'],3,99));
        $fd_eb11  =iif($row1['eb11']=='0',"",$row1['eb11']);
        $fd_eb12  =iif($row1['eb12']=='0',"",$row1['eb12']);
        $f_var["tp"]-> assign   (  "tv_dept_name", $row1['dept_name']  );
        $f_var["tp"]-> assign   (  "tv_b_date", $fd_b_date);    
        $f_var["tp"]-> assign   (  "tv_eb01"  , $row1['eb01']);    
        $f_var["tp"]-> assign   (  "tv_eb04"  , $row1['eb04']);  
        $f_var["tp"]-> assign   (  "tv_eb05"  , $row1['eb05']);  
        $f_var["tp"]-> assign   (  "tv_eb02"  , $row1['eb02']);
        $f_var["tp"]-> assign   (  "tv_eb03"  , $row1['eb03']);
        $f_var["tp"]-> assign   (  "tv_eb06"  , $row1['eb06']);
        $f_var["tp"]-> assign   (  "tv_eb07"  , $row1['eb07']); 
        $f_var["tp"]-> assign   (  "tv_dif"   , substr($row1['dif'],0,5)." hr");  
        $f_var["tp"]-> assign   (  "tv_eb09_1", $fd_eb09_1);   
        $f_var["tp"]-> assign   (  "tv_eb09_2", $fd_eb09_2);   
        $f_var["tp"]-> assign   (  "tv_eb10"  , $fd_eb10);   
        $f_var["tp"]-> assign   (  "tv_eb11"  , $fd_eb11);   
        $f_var["tp"]-> assign   (  "tv_eb12"  , $fd_eb12);   
        $f_var["tp"]-> assign   (  "tv_eb15"  , $row1['eb15']);   
        $f_var["tp"]-> assign   (  "tv_car_id"  ,$_SESSION['login_car_id']);    
        $f_var["tp"]-> assign   (  "tv_prn_date",date('Y-m-d H:i'));    
      }
    }
  }
  // **************************************************************************
  //  函數名稱: list_today()
  //  函數功能: 列印畫面-今日外出
  //  使用方式: list_today($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.01.30
  // **************************************************************************
  function list_today($f_var) {    
    //echo $f_var['f_b_dept_id'].'---'.$f_var['f_eb01'].'---'.$f_var['f_dateb'].'---'.$f_var['f_datee'].'<br>';  
    switch ($f_var['fd_ord']) {
      case "ASC": // 排序
        $f_var['morder'] = "sl.dept.p_gid,dftime ASC,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="DESC";
        break;
      case "DESC": // 排序
        $f_var['morder'] = "sl.dept.p_gid,dftime DESC,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="ASC";
        break;
      default:
        $f_var['morder'] = "sl.dept.p_gid,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="ASC";
        break;
    }      
    //echo $f_var['fd_ord'];
    //印明細表部分
    $fd_date = date("Ymd");
    $fd_date2= (date("Y")-1911).'-'.date("m-d");
    //$fd_dateby  = $f_var['f_dateb']-19110000;
    //$fd_dateey  = $f_var['f_datee']-19110000;
    $fd_dateb   = substr($fd_dateby,0,2).'.'.substr($f_var['f_dateb'],4,2).'.'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($fd_dateey,0,2).'.'.substr($f_var['f_datee'],4,2).'.'.substr($f_var['f_datee'],6,2);
    $fd_trtitle = array('廠部別 '     ,'部門別 '  ,'同仁姓名 ',"<A HREF='ewb01.php?msel=9&fd_area={$f_var['fd_area']}&fd_ord={$f_var['fd_ord']}'>外出時數</A> ",'外出日期 ','外出時間 ','前往地點 '            ,'外出事由 '                                 ,'回程日期 ','回程時間 ','回程地點 ','備註'                 );
    $fd_trline  = array("=========== ","======== ","======== ","======== ","======== ","======== ","==================== ","======================================== " ,"======== ","======== ","==================== ","==================== ");
    $fd_width   = array(12            ,9          ,9          ,9          ,9          ,9          ,21                     ,41                                          ,9          ,9          ,21                     ,21                      );
    $fd_word1   ='';
    $fd_line   ='';
    for($i=0;$i<count($fd_trtitle);$i++){
      $fd_word1 .= str_pad($fd_trtitle[$i],$fd_width[$i], " ", STR_PAD_RIGHT);
      $fd_line  .= str_pad($fd_trline[$i],$fd_width[$i], " ", STR_PAD_RIGHT);
    }
    //
    //$f_var['mwhere'] = iif($f_var['f_b_dept_id'] == '00',""," substring(ewb01.b_dept_id,1,2) = '{$f_var['f_b_dept_id']}' and "); 
    //$f_var['mwhere'] .= iif($f_var['f_eb01'] == ''      ,""," ewb01.eb01 like '%{$f_var['f_eb01']}%' and "); 
    
    $f_var['mwhere'] = "ewb01.eb02 <= '{$fd_date}' and ewb01.eb06 >= '{$fd_date}' and 
                         ewb01.d_date = '0000-00-00 00:00:00'  
                         ";
    if(null != $f_var['fd_area']){
      switch ($f_var['fd_area']) {
        case "S1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S1%' ";
            break;
        case "S25":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S25%' ";
            break;  
        case "S26":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S26%' ";
            break;  
        case "S28":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S28%' ";
            break;  
        case "S35":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S35%' ";
            break;  
        case "S36":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S36%' ";
            break;  
        case "S38":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'S38%' ";
            break;  
        case "E1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'E1%' ";
            break;  
        case "T1":                
              $f_var['mwhere'] .= " and {$f_var['mtable']['dept']}.p_gid like 'T1%' ";
            break;  
        default:
          break;
      }      
    }   
    if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181'] ){ //add by 佳玟 2015.01.12 報修25484-稽核人員外出白板查看權限增加人事單位
      $f_var['mwhere'] .= " ";
     }
    else{
      $f_var['mwhere'] .= " and  {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
    }
    $query1      = "SELECT CONCAT(substring(eb02,1,4),'-',substring(eb02,5,2),'-',substring(eb02,7,2),' ',substring(eb03,1,2),':',substring(eb03,3,2)) s_date,
                           CONCAT(substring(eb06,1,4),'-',substring(eb06,5,2),'-',substring(eb06,7,2),' ',substring(eb07,1,2),':',substring(eb07,3,2)) e_date,
                           TIMEDIFF(CONCAT(substring(eb06,1,4),'-',substring(eb06,5,2),'-',substring(eb06,7,2),' ',substring(eb07,1,2),':',substring(eb07,3,2)) , CONCAT(substring(eb02,1,4),'-',substring(eb02,5,2),'-',substring(eb02,7,2),' ',substring(eb03,1,2),':',substring(eb03,3,2))) dftime, 
                           ewb01.*,{$f_var['mtable']['dept']}.sname,{$f_var['mtable']['dept']}.p_gid
                           FROM ewb01 left join {$f_var['mtable']['dept']}
                           on ewb01.b_dept_id = {$f_var['mtable']['dept']}.dept_id
                           WHERE {$f_var['mwhere']}
                           ORDER BY {$f_var['morder']}
                         ";
    //if('0775711'==$_SESSION['login_empno']){echo $query1."<BR>";}//exit;
    $result1 = mysql_query($query1); 
    //$num1 = mysql_num_rows($result1);
    //$page_sum   = ceil($num1/40);
    //mark by 佳玟 2016.10.13 經理說,這樣顯示不好,所以改成table
    //echo "<pre>"; 
    //echo "<h2>今日外出($fd_date2)</h2><A HREF='ewb01.php?msel=9&fd_area=0'>全部</A>|<A HREF='ewb01.php?msel=9&fd_area=S1'>總管理處</A>|<A HREF='ewb01.php?msel=9&fd_area=S25'>北區管理課</A>|<A HREF='ewb01.php?msel=9&fd_area=S26'>中區管理課</A>|<A HREF='ewb01.php?msel=9&fd_area=S28'>南區管理課</A>|<A HREF='ewb01.php?msel=9&fd_area=S35'>北區油品</A>|<A HREF='ewb01.php?msel=9&fd_area=S36'>中區油品</A>|<A HREF='ewb01.php?msel=9&fd_area=S38'>南區油品</A>|<A HREF='ewb01.php?msel=9&fd_area=E1'>船務報關</A>|<A HREF='ewb01.php?msel=9&fd_area=T1'>山隆生技</A><br><br>";
    //echo "<br><br>==================================================================================================================================================================================<br>{$fd_word1}<br>{$fd_line}<br>";
    //mark end

    //if( '1130091'==$_SESSION["login_empno"] ){
      //echo "<pre>".$query1."</per>";
      $f_var["tp"]-> newBlock ( "tb_list_today_prn" );
      $f_var["tp"]-> assign   ( "tv_area" , $f_var['fd_area'] );
      $f_var["tp"]-> assign   ( "tv_ord"  , $f_var['fd_ord'] );      
      $f_var["tp"]-> newBlock ( "tb_title_today_prn" );
      $f_var["tp"]-> assign   ( "tv_today" , $fd_date2 );      
    //}

    $fd_num = 1;
    while($row1 = mysql_fetch_array($result1)){      
      //列印部份
      //$fd_cut++;
      //$fd_cut = iif($fd_cut < 10,"0{$fd_cut}",$fd_cut);
      $fd_dept = substr($row1['p_gid'],0,2); 
      switch ($fd_dept) {
        case "S1":  
              $fd_area = "總管理處";
            break;
        case "S2":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            //echo $vfd_dept;
            switch ($vfd_dept) {
              case "S25":  
                    $fd_area = "北區管理課";
                  break;
              case "S26":  
                    $fd_area = "中區管理課";
                  break;
              default:
                    $fd_area = "南區管理課";
                break;
            }   
            break;
        case "S3":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            switch ($vfd_dept) {
              case "S35":  
                    $fd_area = "北區油品";
                  break;
              case "S36":  
                    $fd_area = "中區油品";
                  break;
              default:
                    $fd_area = "南區油品";
                break;
            }   
            break;
        case "E1":  
              $fd_area = "船務報關";
            break;
        case "T1":  
              $fd_area = "山隆生技";
            break;
        default:
          break;
      }   
      //echo substr($row1['eb07'],0,2).substr($row1['eb07'],2,2).'00'.substr($row1['eb06'],4,2).substr($row1['eb06'],6,2).substr($row1['eb06'],0,4);   
      $fd_eff1  =mktime(substr($row1['eb07'],0,2),substr($row1['eb07'],2,2),00,substr($row1['eb06'],4,2),substr($row1['eb06'],6,2),substr($row1['eb06'],0,4));
      $fd_eff2  =mktime(substr($row1['eb03'],0,2),substr($row1['eb03'],2,2),00,substr($row1['eb02'],4,2),substr($row1['eb02'],6,2),substr($row1['eb02'],0,4));
      //$fd_eftime= number_format(round(($fd_eff1-$fd_eff2)/3600,1),1);
      $len_eftime =strlen($row1['dftime'])-3;
      $fd_eftime =substr($row1['dftime'],0,$len_eftime);
      //echo $fd_eftime.'<hr>';//exit;
      $fd_eb02  = substr($row1['eb02'],4,2).'-'.substr($row1['eb02'],6,2);
      $fd_eb03  = substr($row1['eb03'],0,2).':'.substr($row1['eb03'],2,2);
      $fd_eb06  = substr($row1['eb06'],4,2).'-'.substr($row1['eb06'],6,2);
      $fd_eb07  = substr($row1['eb07'],0,2).':'.substr($row1['eb07'],2,2);
      $fd_time  = $row1['eb06'].$row1['eb07'];
      //echo $fd_time.'===='.date("YmdHi").'<hr>';
      
      
      //if( '1130091'==$_SESSION["login_empno"] ){
        $f_var["tp"]-> newBlock ( "tb_body_today_prn" );
        if(date("YmdHi") >= $fd_time){ //目前時間已超過回程時間者姓名灰色
          $f_var["tp"]-> assign   ("tv_fcolor"     , "#A0A0A0" );
        }
        $f_var["tp"]-> assign   ("tv_num"    , $fd_num );  //序 
        $f_var["tp"]-> assign   ("tv_dept1"  , $fd_area );  //廠部別 
        $f_var["tp"]-> assign   ("tv_dept2"  , $row1['sname'] );  //部門別 
        if(date("YmdHi") >= $fd_time){ //目前時間已超過回程時間者姓名灰色
          $f_var["tp"]-> assign   ("tv_name"   , $row1['eb01'] );  //同仁姓名
        }else{ //否則姓名為藍色
          $f_var["tp"]-> assign   ("tv_name"   , "<font color='#003399'>".$row1['eb01']."</font>" );  //同仁姓名
        }                      
        $f_var["tp"]-> assign   ("tv_hr"     , $fd_eftime );  //外出時數 
        $f_var["tp"]-> assign   ("tv_godate" , $fd_eb02 );  //外出日期 
        $f_var["tp"]-> assign   ("tv_time"   , $fd_eb03 );  //外出時間 
        $f_var["tp"]-> assign   ("tv_place"  , $row1['eb04'] );  //前往地點 
        $f_var["tp"]-> assign   ("tv_content", $row1['eb05'] );  //外出事由 
        $f_var["tp"]-> assign   ("tv_redate" , $fd_eb06 );  //回程日期          
        $f_var["tp"]-> assign   ("tv_retime" , $fd_eb07 );  //回程時間
        $f_var["tp"]-> assign   ("tv_replace" , $row1['eb16'] );  //回程地點
        $f_var["tp"]-> assign   ("tv_memo"    , $row1['eb08'] );  //備註
        $fd_num++;         
      //}      


      $fd_value = array($fd_area,$row1['sname'],$row1['eb01'],$fd_eftime,$fd_eb02,$fd_eb03,$row1['eb04'],$row1['eb05'],$fd_eb06,$fd_eb07,$row1['eb16'],$row1['eb08']);
      //寫到      
      $fd_word2 = str_pad($fd_value[0],$fd_width[0], " ", STR_PAD_RIGHT);
      $fd_word2 .= str_pad($fd_value[1],$fd_width[1], " ", STR_PAD_RIGHT);
      //$fd_word2 = "<A NAME='{$fd_dept}'>{$fd_word2}</A>";
      $fd_dept1 = $fd_area;      
      if(date("YmdHi") >= $fd_time){ //目前時間已超過回程時間者姓名灰色
        $fd_name = "<font color='#A0A0A0'>".str_pad($fd_value[2],$fd_width[2], " ", STR_PAD_RIGHT)."</font>";
      }
      else{                        //否則姓名為藍色
        $fd_name = "<font color='#003399'>".str_pad($fd_value[2],$fd_width[2], " ", STR_PAD_RIGHT)."</font>";
      }
      $fd_word2 .= $fd_name;
      for($s=3;$s<count($fd_value);$s++){
        if('6' != $s and '7' != $s and '10' !=$s  and '11' !=$s ){
          $fd_word2 .= str_pad($fd_value[$s],$fd_width[$s], " ", STR_PAD_BOTH);
        }
        else{     
          $fd_word2 .= str_pad($fd_value[$s],$fd_width[$s], " ", STR_PAD_RIGHT);
        }

      }
      //mark by 佳玟 2016.10.13 經理說,這樣顯示不好,所以改成table
      //if($fd_dept1 != $fd_dept2 and NULL != $fd_dept2){
      //    echo "-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>";
      //  }       
      //  $fd_dept2 = $fd_area;
      //  if(date("YmdHi") >= $fd_time){ //目前時間已超過回程時間者灰字
      //    echo "<font color='#A0A0A0'>{$fd_word2}<br></font>";
      //  }
      //  else{
      //    echo "{$fd_word2}<br>"; 
      //  }
      //mark end  

    }
    //mark by 佳玟 2016.10.13 經理說,這樣顯示不好,所以改成table
    //echo "<br>================================================================================================================================================================================== ";
    //echo "</pre>";
    //mark end 
  }
  
  // **************************************************************************
  //  函數名稱: u_send()
  //  函數功能: 傳送訊息
  //  使用方式: u_send($f_var)
  //  程式設計: Mimi
  //  設計日期: 2007.09.11
  // **************************************************************************
  function u_send($f_var) {
     //找出所有收件者          
     $f_var['mwhere'] = "{$f_var['mtable']['head']}.s_num='{$f_var['f_h_s_num']}'";
     $query2      = "select distinct {$f_var['mtable']['head']}.dh04,{$f_var['mtable']['head']}.dh05,{$f_var['mtable']['head']}.b_empno,{$f_var['mtable']['body']}.db01,sl.pass.empno
                            from {$f_var['mtable']['head']} left join {$f_var['mtable']['body']}
                            on {$f_var['mtable']['head']}.s_num = {$f_var['mtable']['body']}.h_s_num
                            left join sl.pass 
                            on {$f_var['mtable']['body']}.db01=sl.pass.name
                            where {$f_var['mwhere']}
                    ";
     //echo $query2.'<hr>';
     $result2  = mysql_query($query2);
     
     
     switch ($f_var['msel']) {
       case "11": // 新增儲存
            $msubject  = "【{$f_var['f_eb01']}】新增一筆外出資料！";
            $f_var["subject"] = "【{$f_var['f_eb01']}】您新增一筆外出資料！";
            $f_var["message"] = "";  
            while(list($vfd_id)=each($f_var['fd'])) {
              $vins_cname = $f_var['fd'][$vfd_id]['cname'];
              $vins_ename = $f_var[$f_var['fd'][$vfd_id]['ename']];
              //$f_var["message"] .= "{$vins_cname}：{$vins_ename}"."\n";
              if($vins_cname!='s_num'){    //upd by 佳玟 2011.11.24  s_num不放入發送訊息內
                $f_var["message"] .= "{$vins_cname}：{$vins_ename}"."\n";   
              }                                    
            }     
            $f_var['to']["{$_SESSION['login_empno']}"] = $_SESSION['login_empno'];
            break;
       case "21": // 修改儲存
            $fd_eb02=(substr($f_var['f_eb02'],0,4)-1911).'.'.substr($f_var['f_eb02'],4,2).'.'.substr($f_var['f_eb02'],6,2);
            $msubject  = "【{$f_var['f_eb01']}】修改{$fd_eb02}外出資料！";
            $f_var["subject"] = "【{$f_var['f_eb01']}】您修改{$fd_eb02}外出資料！";
            $f_var["message"] = "";  
            while(list($vfd_id)=each($f_var['fd'])) {
              $vins_cname = $f_var['fd'][$vfd_id]['cname'];
              $vins_ename = $f_var[$f_var['fd'][$vfd_id]['ename']];
              //$f_var["message"] .= "{$vins_cname}：{$vins_ename}"."\n";
              if($vins_cname!='s_num'){   //upd by 佳玟 2011.11.24  s_num不放入發送訊息內
                $f_var["message"] .= "{$vins_cname}：{$vins_ename}"."\n";   
              }                              
            }     
            $f_var['to']["{$_SESSION['login_empno']}"] = $_SESSION['login_empno'];
            break;
       default:
            break;
     }
     //是否重覆
     reset ($f_var['to']);
     foreach ($f_var['to'] as $value) {
         if(''!=$value){
          $man[] =$value; 
        }
     }
     //訊息傳送
     for($i=0;$i<count($man);$i++){
        sl_send_msg('it',$man[$i],$f_var["subject"],$f_var["message"]);            
     } 
     
     
     //upd by 佳玟 2012.07.05 將副理發送訊息部分移除
     //發送郵件TO tony  
     
     //$fd_man   = "tony@slc.com.tw";
     //$fd_man   = "mimi@slc.com.tw";
     //$mcontent = "<pre>";  
     //$mexdata   = "Content-Type:text/html;charset=big5\n";
     //$mexdata  .= "X-MSMail-Priority: High\n";
     //$mexdata  .= "From:".$fd_man."\nReply-To:".$fd_man."\n";
     //$mcontent .= "{$f_var['message']}</pre>";  
     
     //if(!mail($fd_man, $msubject , $mcontent , $mexdata) ) {
     //   u_errmsg('2','left','FF99FF','FF0000','FF9966','<font color="#FFFFFF"><b>注意!!</b></font>&nbsp;&nbsp;確認郵件傳送失敗!!<br>請聯絡資訊部..');
     //} 
     
     
     
     //exit;
  return;
  }
  
  // **************************************************************************
  //  函數名稱: u_log()
  //  函數功能: 傳送訊息
  //  使用方式: u_log($f_var)
  //  程式設計: Mimi
  //  設計日期: 2008.07.07
  // **************************************************************************
  function u_log($f_var) {
    //sl_open($f_var['mdb']); // 開啟資料庫
    $vb_empno   = $_SESSION["login_empno"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vfromip    = $_SERVER["REMOTE_ADDR"];
    $vproc      = u_showproc(); // 程式代號 
    switch ($f_var['msel']) {
      case "11": // 新增儲存
        $fd_list='add  ;_;';
        ksort($f_var['fd']);
        while(list($vfd_id)=each($f_var['fd'])) {
          $cut++;
          $vins_cname = $f_var['fd'][$vfd_id]['cname'];
          $value = $f_var[$f_var['fd'][$vfd_id]['ename']];
          $fd_list.=iif($value=='',"''",$value);
          if($cut<=(count($f_var['fd']))) {
           //echo $cut.'--'.(count($row2)/2-1).'<hr>';
            $fd_list .= ";_;";
          }
        }     
        $fd_list .= "{$vb_empno};_;{$vb_dept_id};_;{$vproc};_;{$vb_date};_;'';_;'';_;'';_;'';_;'';_;'';_;'';_;'';_;{$vfromip}";
        break;
      case "21": // 修改儲存
        $fd_list='upd  ;_;';
        ksort($f_var['fd']);
        while(list($vfd_id)=each($f_var['fd'])) {
          $cut++;
          $vins_cname = $f_var['fd'][$vfd_id]['cname'];
          $value = $f_var[$f_var['fd'][$vfd_id]['ename']];
          $fd_list.=iif($value=='',"''",$value);
          if($cut<=(count($f_var['fd']))) {
           //echo $cut.'--'.(count($row2)/2-1).'<hr>';
            $fd_list .= ";_;";
          }
        }     
        $fd_list .= "'';_;'';_;'';_;'';_;{$vb_empno};_;{$vb_dept_id};_;{$vproc};_;{$vb_date};_;'';_;'';_;'';_;'';_;{$vfromip}";
        break;
      default:
        break;
    }
    $fd_list.="\r\n";
    
    $fp = fopen("./ewb01.log", "a+");
    fwrite ($fp, $fd_list);   
    fpassthru ($fp);     
  }
  
  // **************************************************************************
  //  函數名稱: u_chk_sleip2flw()
  //  函數功能: 檢查簽核單簽核結果是否為同意
  //  使用方式: u_chk_sleip2flw($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.11.03
  // **************************************************************************
  function u_chk_sleip2flw($vsnum) {
    $query = "SELECT docs.sleip2flw.sleip2flw006,
                     docs.sleip2flw.sleip2flw008, 
                     docs.sleip2flw.resda021,
                     docs.ewb01.eb13,
                     docs.sleip2flw.sleip2flw010
              FROM   docs.sleip2flw 
                     left join docs.ewb01 
                          on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 and
                             docs.sleip2flw.sleip2flw003 = 'docs' and 
                             docs.sleip2flw.sleip2flw004 = 'ewb01' and
                             docs.sleip2flw.d_date = '0000-00-00 00:00:00' 
              WHERE  docs.sleip2flw.sleip2flw010 like '{$vsnum}%'
                     /*and docs.ewb01.s_num = '{$vsnum}'*/
              ORDER BY  docs.sleip2flw.sleip2flw008,docs.sleip2flw.sleip2flw006,docs.sleip2flw.resda019
             ";  
      
    if($_SESSION['login_empno']=='1130091'){                          
      echo "<pre>".$query."</pre>";   
    }
    $result = mysql_query($query); 
    $num = mysql_num_rows($result);   
    if($num==0){  //2011.10.04 以前是沒跑簽核者，則會顯示
      return 0;
    }else{
      while($row = mysql_fetch_array($result)){
        $fd_flw008 = $row['sleip2flw008']; //類別 (1.外出調車單、3.物流調車單、4、哩程簽核單)
        $ar_flw008[$fd_flw008]   = $fd_flw008;  //1、3、4 upd by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
        $ar_resda021[$fd_flw008] = $row['resda021'];  //最新一筆簽核狀態
        $ar_flw010[$fd_flw008]   = $row['sleip2flw010'];  //EWB01.S_NUM
      }
      if($_SESSION['login_empno']=='1130091'){    
        echo "<pre>";
        var_dump($ar_resda021);
        echo "</pre>";
      }           
      foreach ($ar_flw008 as $key=>$value){      	
      	switch($value){
      		case '1':
      		case '11': 
      		case '3':
      		     if($ar_resda021[$key]=='3'){  //不同意
      		     	 return 1;	
      		     }
      		     if($ar_resda021[$key]<>'2'){
      		     	 return 2;
      		     }   		     
      		     break;
      		case '4':
      		case '12':
      		     if($ar_resda021[$key]=='2'){  //同意
      		     	 if('xx'==substr($ar_flw010[$key],-2)){  //重簽
      		     	 	 return 3;
      		     	 }
      		       return 0;	
      		     }else if($ar_resda021[$key]=='3'){  //不同意
      		     	 return 1;	
      		     }else{ //簽核中 
      		     	 return 2;	
      		     }
      		     break;
      		default:
      		     break;      		     
      	}     	
      }
    }
    return 2;  //有填寫外出調車單，但未寫里程簽核單  簽核中     
  }    
  
  //// **************************************************************************
  ////  函數名稱: u_chk_sleip2flw()
  ////  函數功能: 檢查簽核單簽核結果是否為同意
  ////  使用方式: u_chk_sleip2flw($vsnum)
  ////  程式設計: 佳玟
  ////  設計日期: 2011.11.03
  //// **************************************************************************
  //function u_chk_sleip2flw($vsnum) {
  //  $query = "SELECT docs.sleip2flw.sleip2flw006,
  //                   docs.sleip2flw.sleip2flw008, 
  //                   docs.sleip2flw.resda021,
  //                   docs.ewb01.eb13
  //            FROM   docs.sleip2flw 
  //                   left join docs.ewb01 
  //                        on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 and
  //                           docs.sleip2flw.sleip2flw003 = 'docs' and 
  //                           docs.sleip2flw.sleip2flw004 = 'ewb01' and
  //                           docs.sleip2flw.d_date = '0000-00-00 00:00:00' 
  //            WHERE  docs.ewb01.s_num = '{$vsnum}'
  //                   and docs.sleip2flw.sleip2flw010 = '{$vsnum}'
  //            ORDER BY  docs.sleip2flw.sleip2flw008,docs.sleip2flw.sleip2flw006
  //           ";  
  //  if($vsnum=='120976' or $vsnum=='121409' or $vsnum=='121578'){ //add by 佳玟 2011.12.26 暐昕簽核卡在課長，為了方便暐昕申請油貼，開放此三筆顯示
  //    return 0;
  //  }         
  //             
  //  if($_SESSION['login_empno']=='1130091'){                          
  //    echo "<pre>".$query."</pre>";
  //  }
  //  $result = mysql_query($query); 
  //  $num = mysql_num_rows($result);   
  //  if($num==0){  //2011.10.04 以前是沒跑簽核者，則會顯示
  //    return 0;
  //  }                                     
  //  else{
  //    $fd_sign14 = "";
  //    while($row = mysql_fetch_array($result)){
  //
  //      $fd_flw008 = $row['sleip2flw008']; //類別 (1.外出調車單、3.物流調車單、4、哩程簽核單)
  //      $ar_flw008[$fd_flw008] = $fd_flw008;  //1、3、4 upd by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
  //
  //      switch($row['resda021']){
  //        case '':  //簽核第一關
  //             $ar_resda021[$fd_flw008] = '1';  //簽核中
  //             break;
  //        case '1':
  //        case '2':
  //             $ar_resda021[$fd_flw008] = $row['resda021'];   //未完成或同意
  //             break;
  //        case '3':
  //        case '4':
  //             $ar_resda021[$fd_flw008] = "N";  //不同意或抽單  
  //             break;
  //        default:
  //             break;
  //      
  //      }
  //
  //
  //      switch($row['sleip2flw008']){
  //        case '1':          
  //        case '3':
  //        case '11':  //add by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
  //             if($row['resda021'] == '2'){  //簽核
  //               $fd_sign13 = "Y";
  //               $fd_signeb13 = $row['eb13'];
  //             }
  //             break;
  //        case '4':
  //        case '12': //add by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
  //             if($row['resda021'] == '2'){  
  //               $fd_sign14 = "Y";
  //               $fd_signeb13='';
  //             }else{
  //               $fd_sign14 = "N";
  //             }
  //             break;
  //        default:
  //             break;
  //      
  //      }        
  //
  //      /*
  //      if($row['resda021']=='1' or $row['resda021']=='2'){  //1.未完成、2.同意        
  //        $ar_resda021[$fd_flw008] = $row['resda021']; 
  //      }else if($row['resda021']==''){
  //        $ar_resda021[$fd_flw008] = '1';
  //      }else if($ar_resda021[$fd_flw008]<>'1' and $ar_resda021[$fd_flw008]<>'2' and $ar_resda021[$fd_flw008]<>'1'){  //如簽核狀態不為未完成、同意的話，則不顯示
  //        $ar_resda021[$fd_flw008] = "N";         
  //      } 
  //      */
  //
  //                    
  //      /*       
  //      if($row['resda021']=='1' or $row['resda021']=='2'){  //1.未完成、2.同意        
  //        $ar_resda021[$fd_flw008] = $row['resda021']; 
  //      }else if($ar_resda021[$fd_flw008]=='3' or $ar_resda021[$fd_flw008]=='4'){  //如簽核狀態不為未完成、同意的話，則不顯示
  //        $ar_resda021[$fd_flw008] = "N";         
  //      }else if($ar_resda021[$fd_flw008]==null){
  //        $ar_resda021[$fd_flw008] = "1";
  //      }
  //      */
  //    }
  //    
  //    if($fd_sign13=="Y" and ($fd_signeb13<>0 and $fd_signeb13<>'') and $fd_sign14==''){
  //      return 0;   
  //    }
  //                  
  //    if($_SESSION['login_empno']=='1130091'){                  
  //      echo "<pre>";
  //      var_dump($ar_resda021);
  //      echo "</pre>";//exit;  
  //    } 
  //    $fd_key1 = $fd_key3 = $fd_key4 = $fd_key0 = "";        
  //    reset($ar_flw008); // 將陣列的指標指到陣列第一個元素
  //    while(list($key1,$value1)=each($ar_flw008)) {  //類別
  //      $fd_flw008 = $ar_flw008[$key1];
  //
  //      switch($fd_flw008){
  //        case '1':   //1.外出調車單
  //        case '11':  //add by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
  //             if($ar_resda021[$key1]=='N'){ // 不同意
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //簽核中 
  //               return 2;              
  //             }
  //             //else{
  //             //  $fd_key1 = $ar_resda021[$key1];
  //             //}                            
  //             break;
  //        case '3':  //3.物流調車單
  //             if($ar_resda021[$key1]=='N'){ // 不同意
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //簽核中 
  //               return 2;              
  //             }
  //             //else{
  //             //  $fd_key3 = $ar_resda021[$key1];
  //             //}                          
  //             break;
  //        case '4':  //4、哩程簽核單
  //        case '12': //add by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
  //             if($ar_resda021[$key1]=='N'){ // 不同意
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //簽核中 
  //               return 2;              
  //             }else{ //同意
  //               $fd_key4 = $ar_resda021[$key1];
  //             }               
  //             break;
  //        default:
  //             return 0; 
  //             break;    
  //      }         
  //      /* 
  //      if($fd_flw008==''){
  //        return 0;
  //      }        
  //      //if($fd_flw008=='1'){
  //        if($ar_resda021[$key1]<>'N'){  //為不同意或已抽單者，則不顯示
  //          return true;
  //        }else{
  //          return false;
  //        }
  //      //}    
  //      */ 
  //       
  //    }
  //    //upd by 佳玟 2011.11.09  尚未產生哩程簽核單，則計算於未簽核筆數中
  //    if($fd_key4==''){ //
  //      return 2;
  //    }else if($fd_key4<>'') {
  //      return 0;
  //    }
  //  }     
  //}  


  // **************************************************************************
  //  函數名稱: u_eip2del()
  //  函數功能: 簽核單簽核結果為抽單，作廢
  //  使用方式: u_eip2del()
  //  程式設計: 佳玟
  //  設計日期: 2011.11.23
  // **************************************************************************
  function u_eip2del() {
    $vb_empno   = 'it';
    $vb_date    = date("Y-m-d H:i:s");
    $vproc      = u_showproc(); // 程式檔名
    $fd_date    = mktime(0, 0, 0, date("m"), date("d")-5, date("Y"));      
    $vw_date1   = date('Y-m-d', $fd_date)." 00:00:00";
    $vw_date2   = date("Y-m-d")." 23:59:59";

      
    $query = "update docs.ewb01 
                     left join docs.sleip2flw 
                               on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 and
                                  docs.sleip2flw.sleip2flw003 = 'docs' and 
                                  docs.sleip2flw.sleip2flw004 = 'ewb01' and
                                  docs.sleip2flw.d_date = '0000-00-00 00:00:00'
              set    docs.ewb01.d_empno = '{$vb_empno}',
                     docs.ewb01.d_proc  = '({$vproc})簽核抽單作廢',
                     docs.ewb01.d_date  = '{$vb_date}'                     
              WHERE (docs.sleip2flw.resda020 = '4' and
                     docs.sleip2flw.resda021 = '4') and
                     docs.sleip2flw.sleip2flw008 in ('1','3','11') and
                     docs.ewb01.d_date = '0000-00-00 00:00:00' and
                     docs.sleip2flw.d_date = '0000-00-00 00:00:00' and
                     docs.sleip2flw.b_empno = '{$_SESSION["login_empno"]}'
                     and (docs.sleip2flw.resda019 between '{$vw_date1}' and '{$vw_date2}')    /*add by 佳玟 2012.01.31 增加判斷結案日期在5天內抽單資料者*/
             ";   //add by 佳玟 2012.01.12 外出經理級以上多增加 外出類別 11 里程類別 12 
    //echo "<pre>".$query."</pre>";
//    if(!mysql_query($query)){
//      if($_SESSION['login_empno']=='1130091'){
//        echo "簽核狀態抽單作廢失敗!!!<pre>".$query."</pre>";
//      }
//    }
    
    //$query = "SELECT group_concat(docs.sleip2flw.sleip2flw010 order by docs.sleip2flw.sleip2flw010 separator ',' ) as s_num
    //          FROM   docs.sleip2flw 
    //                 left join docs.ewb01 
    //                      on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 and
    //                         docs.sleip2flw.sleip2flw003 = 'docs' and 
    //                         docs.sleip2flw.sleip2flw004 = 'ewb01'
    //          WHERE (docs.sleip2flw.resda020 = '4' and
    //                 docs.sleip2flw.resda021 = '4') and
    //                 docs.sleip2flw.sleip2flw008 in ('1','3') and
    //                 docs.ewb01.d_date = '0000-00-00 00:00:00'                             
    //         ";                                                  
  }  

  // **************************************************************************
  //  函數名稱: u_chk_ewb01()
  //  函數功能: 查看資料是否有重覆新增
  //  使用方式: u_chk_ewb01($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.11.23
  // **************************************************************************
  function u_chk_ewb01($f_var) {
    $fd_eb05 = trim($f_var['f_eb05']);
    $fd_eb08 = trim($f_var['f_eb08']);
    $query = "SELECT *                                                                
              FROM   docs.ewb01
              WHERE  docs.ewb01.eb02 = '{$f_var['f_eb02']}'   /*外出日期*/
                     and docs.ewb01.eb03 = '{$f_var['f_eb03']}'   /*外出時間*/
                     and docs.ewb01.eb18 = '{$f_var['f_eb18']}'   /*員編*/     
                     and TRIM(docs.ewb01.eb05) = '{$fd_eb05}'   /* add by 2013.01.15 增加判斷前往事由*/
                     and TRIM(docs.ewb01.eb08) = '{$fd_eb08}'   /* add by 2013.01.15 增加判斷備註*/
                     /*and docs.ewb01.eb06 = '{$f_var['f_eb06']}'   回程日期*/
                     /*and docs.ewb01.eb07 = '{$f_var['f_eb07']}'       回程時間*/
                     and d_date='0000-00-00 00:00:'/*upd by mimi 2012.01.06 蔡佳俊來電,增加判斷作廢日期*/
             ";    
    //if($_SESSION['login_empno']=='1130091'){                          
    //  echo "<pre>".$query."</pre>";
    //}
    $result = mysql_query($query); 
    $num = mysql_num_rows($result);  
    if($num>0){
      return false;
    }else{
      return true;
    }
  } 

  // **************************************************************************
  //  函數名稱: u_chk_sleip2flw()
  //  函數功能: 檢查簽核單簽核結果是否為同意
  //  使用方式: u_chk_sleip2flw($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.11.03
  // **************************************************************************
  //function u_chk_sign2flw($vsnum) {
  //  $query = "SELECT docs.sleip2flw.sleip2flw006,
  //                   docs.sleip2flw.sleip2flw008, 
  //                   docs.sleip2flw.resda021
  //            FROM   docs.sleip2flw 
  //                   left join docs.ewb01 
  //                        on docs.ewb01.s_num=docs.sleip2flw.sleip2flw010 and
  //                           docs.sleip2flw.sleip2flw003 = 'docs' and 
  //                           docs.sleip2flw.sleip2flw004 = 'ewb01' and
  //                           docs.sleip2flw.d_date = '0000-00-00 00:00:00' 
  //            WHERE  docs.ewb01.s_num = '{$vsnum}'
  //            ORDER BY  docs.sleip2flw.sleip2flw008,docs.sleip2flw.sleip2flw006
  //           ";    
  //  if($_SESSION['login_empno']=='1130091'){                          
  //    echo "<pre>".$query."</pre>";
  //  }
  //  $result = mysql_query($query); 
  //  $num = mysql_num_rows($result);   
  //  if($num==0){  //2011.10.04 以前是沒跑簽核者，則會顯示
  //    return 0;
  //  }                                     
  //  else{

  //    while($row = mysql_fetch_array($result)){
      
  //    }
  //  }
  //}             

  // **************************************************************************
  //  函數名稱: u_chk_sleip2flw4()
  //  函數功能: 檢查哩程簽核單是否重覆新增
  //  使用方式: u_chk_sleip2flw4($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.12.06
  // **************************************************************************
  function u_chk_sign2flw4($row) {
    $query = "SELECT sleip2flw.sleip2flw002,
                     sleip2flw.sleip2flw008,
                     sleip2flw.sleip2flw010,
                     sleip2flw.sleip2flw900,
                     resda.resda019,
                     resda.resda020,
                     resda.resda021  
              FROM   sleip2flw 
                     LEFT JOIN resda ON sleip2flw.sleip2flw001 = resda.resda001 AND 
                                        sleip2flw.sleip2flw002 = resda.resda002
              WHERE  (sleip2flw.sleip2flw008='4' or sleip2flw.sleip2flw008='12') and
                     sleip2flw.sleip2flw010='{$row['fs_num']}' and      
                     sleip2flw.sleip2flw900='{$row['eb18']}' and
                     (resda.resda021='' or resda.resda021='1') and 
                     /*(resda.resda021='' or resda.resda021='1' or resda.resda021='2') and*/  
                     resda.resda019=''
             ";   //add by 佳玟 2012.01.12 外出經理級以上多增加里程單為 sleip2flw.sleip2flw008='12' 
    if($_SESSION['login_empno']=='1130091'){                          
      echo "<pre>".$query."</pre>";
    }
    u_openef2k('EF2KWeb');
    $result = mssql_query($query); 
    $num = mssql_num_rows($result);   
    if($num>0){
      return false;
    }                                     
    else{
      return true;
    }
  }
  
  // **************************************************************************
  //  函數名稱: u_chkeb12()
  //  函數功能: 是否修改里程
  //  使用方式: u_chkeb12($vsnum)
  //  程式設計: 佳玟
  //  設計日期: 2011.12.26
  // **************************************************************************
  function u_chkeb12($vsnum) {
    $query = "SELECT *                                                                
              FROM   docs.ewb01
              WHERE  docs.ewb01.s_num = '{$vsnum}'
             ";    
    //if($_SESSION['login_empno']=='1130091'){                          
    //  echo "<pre>".$query."</pre>";
    //}
    $result = mysql_query($query); 
    $num = mysql_num_rows($result);  
    if($num>0){
      $row = mysql_fetch_array($result);
      //if($row['eb12']<>'' and $row['eb12']<>'0'){
      $fd_eb09 = substr($row['eb09'],0,2); // 06公務車.07私車 併車搭乘
      if($row['eb12']<>'' and $row['eb12']<>'0' and $fd_eb09<>'07'){  //upd by 佳玟 (報修-16232)回應6.私車併乘者不納入里程簽核單
        //echo "簽";
        return true;
      }else{
        //echo "不簽";
        return false;
      }
    } 
    //exit; 
  } 
  



  // **************************************************************************
  //  函數名稱: u_seleb12()
  //  函數功能: 找尋上個月最後大一筆入廠里程
  //  使用方式: u_seleb12($f_var)
  //  程式設計: 佳玟
  //  設計日期: 2011.12.30
  // **************************************************************************
  function u_seleb12($f_var) {
    $y = substr($f_var['f_dateb'], 0, 4); //取前四碼 (年)        
    $m = substr($f_var['f_dateb'], 4, 2); //取最後二碥(月)      
    $lastmonth = mktime(0, 0, 0, $m-1, "01", $y);   //上個月 26 日     
    if( date("Ymd")<='20150110' AND ('9325760'==$f_var['f_empno'] OR '8165564'==$f_var['f_empno']) ){  /*add by 佳玟 2014.12.25 報修25296、25295 */
      $lastmonth = mktime(0, 0, 0, $m-2, "01", $y);   //上兩個月 26 日   
    }         
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //這個月 25 日止
    $f_var['f_dateb2'] = date('Ymd', $lastmonth);
    $f_var['f_datee2'] = date('Ymd', $nowmonth);                  
    $sql = "select docs.ewb01.eb12,docs.ewb01.eb02,docs.ewb01.s_num,docs.ewb01.eb23
            from   docs.ewb01
            where  docs.ewb01.eb18 = '{$f_var['f_empno']}' and 
                  (docs.ewb01.eb02 BETWEEN '{$f_var['f_dateb2']}' AND '{$f_var['f_datee2']}') and 
                   docs.ewb01.d_date = '0000-00-00 00:00:00' and
                   /*docs.ewb01.eb02 <> '{$f_var['top_date']}' and*/
                   docs.ewb01.eb02 <= '{$f_var['top_date']}' and
                   substring(docs.ewb01.eb09,2,1) in('2','3','4')
            order by docs.ewb01.eb02      
          ";  
    if( '8165564'==$_SESSION["login_empno"] ){
      echo "<font color=red><pre>".$sql."</pre></font>";
    }             
    
    $result = mysql_query($sql); 
    $num = mysql_num_rows($result); 
    //$in_num = 0;     
    if($num>0){
      $f_var['maxeb12'] = 0;
      while($row = mysql_fetch_array($result)){
        $fd_sleip2flw = u_chk_sleip2flw($row['s_num']); //判斷簽核是否已過
        if($fd_sleip2flw=='0'){
          $fd_eb02 = $row['eb02']; 
          $ar_mile[$fd_eb02] = $row['eb12'];   //$ar_mile[日期]=入廠公里數
        }    
      }
    }
    if( !empty($ar_mile) ){
      reset($ar_mile);  //員編
      while(list($key,$value)=each($ar_mile)) { 
        if( $vfv_eb02<>'' and  $key>=$f_var['top_date'] and $f_var['maxeb12']=='' ){  //排除第一次?圈比較，當日期大於等於要比較的日期，則紀錄入廠公里數 
          $f_var['maxeb12'] = $vfv_eb12;        
          break;  
        }
        $vfv_eb02 = $key; //日期
        $vfv_eb12 = $ar_mile[$key]; //入廠公里數
      }    
    }      
    if( $f_var['maxeb12']=='' ){
    	$f_var['maxeb12'] = 0;	
    }      
    return;     
  }
  /*
  function u_seleb12($f_var) {
    $y = substr($f_var['f_dateb'], 0, 4); //取前四碼 (年)        
    $m = substr($f_var['f_dateb'], 4, 2); //取最後二碥(月)      
    $lastmonth = mktime(0, 0, 0, $m-1, "26", $y);   //上個月 26 日       
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //這個月 25 日止
    $f_var['f_dateb2'] = date('Ymd', $lastmonth);
    $f_var['f_datee2'] = date('Ymd', $nowmonth);            
    $sql = "select docs.ewb01.eb12,docs.ewb01.eb02,docs.ewb01.s_num,docs.ewb01.eb23
            from   docs.ewb01
            where  docs.ewb01.eb18 = '{$f_var['f_empno']}' and 
                  (docs.ewb01.eb02 BETWEEN '{$f_var['f_dateb2']}' AND '{$f_var['f_datee2']}') and 
                   docs.ewb01.d_date = '0000-00-00 00:00:00' and
                   docs.ewb01.eb02 <> '{$f_var['top_date']}' and
                   substring(docs.ewb01.eb09,2,1) in('2','3','4')
            order by docs.ewb01.eb02 desc
                  
          ";
    //echo "<pre>".$sql."</pre>";
    $result = mysql_query($sql); 
    $num = mysql_num_rows($result);  
    if($num>0){
      $f_var['maxeb12'] = 0;
      while($row = mysql_fetch_array($result)){
        $fd_sleip2flw = u_chk_sleip2flw($row['s_num']); //判斷簽核是否已過
        if($fd_sleip2flw=='0'){
          //if($f_var['maxeb12']<$row['eb12']){  
          //  $f_var['maxeb12'] = $row['eb12'];
          //} 
        	if( $fd_eb12 < $row['eb12'] ){
        		$fd_eb12 = $row['eb12'];
        	}
        	if( $fd_eb12 > $row['eb12'] and $row['eb23']=='Y' ){ //為經辦認定正常的異常資料
        		$fd_eb12 = $row['eb12'];
        	}
          //upd by 佳玟 2012.08.06
        	if( $row['eb02']<$f_var['top_date'] ){
            $sdate = $row['eb02'];
          }
      	  if( $fd_eb12 > 0 and $f_var['maxeb12']=='' ){
      	  	$f_var['maxeb12'] = $fd_eb12;
      	  }            
        }
      }    
    }else{
    	$f_var['maxeb12'] = 0;
    	$sdate = 'n';
    }
    
    if( $sdate<>''){
      $sql2 = "select docs.ewb01.eb12,docs.ewb01.eb02,docs.ewb01.s_num,docs.ewb01.eb23
               from   docs.ewb01
               where  docs.ewb01.eb18 = '{$f_var['f_empno']}' and  
                      docs.ewb01.d_date = '0000-00-00 00:00:00' and
                      docs.ewb01.eb02 < '{$f_var['top_date']}' and 
                      docs.ewb01.eb02 <> '{$f_var['top_date']}' and
                      substring(docs.ewb01.eb09,2,1) in('2','3','4')
               order by docs.ewb01.eb02 desc     
               limit 10      
             ";         
      //echo "★<font color=red><pre>".$sql2."</pre></font>";
      $result2 = mysql_query($sql2); 
      $num2 = mysql_num_rows($result2);  
      if($num2>0){
        while($row2 = mysql_fetch_array($result2)){
         $fd_sleip2flw2 = u_chk_sleip2flw($row2['s_num']); //判斷簽核是否已過
         if($fd_sleip2flw2=='0'){
                  
            $f_var['maxeb12'] = $row2['eb12'];
            break;
          }
        }
      }
    }                   
    return;   
  }   
  */
  // **************************************************************************
  //  函數名稱: u_save_log()
  //  函數功能: 里程存入log檔
  //  使用方式: u_save_log($ar)
  //  程式設計: 佳玟
  //  設計日期: 2012.02.13
  // **************************************************************************
  function u_save_log($row) {  //改放置修改
    //echo "<font color=red>text: ".$row['fs_num']."-----".$row['eb04']."----".$row['eb16']."-----"."</font>";
    sl_open('docs');
    $vb_empno   = $_SESSION["login_empno"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vproc      = u_showproc(); // 程式代號  
    
    $fd_str = substr($row['eb04'],0,4);
    $query="select *
            from   zip
            where  sname like '%{$fd_str}%' or
                   city like '%{$fd_str}%' or
                   zone like '%{$fd_str}%'";
    //sl_open('slh,slc.com.tw');
    $result = mysql_query($query);             
    $total = mysql_num_rows($result); //目前總筆數       
    if($total>0){
      $query2="insert into ewb01_adr (ewb01_s_num,eb18,eb01,eb16,eb04,eb11,eb12,eb13,b_empno,b_dept_id,b_proc,b_date)
               select ewb01.s_num,ewb01.eb18,ewb01.eb01,ewb01.eb16,ewb01.eb04,ewb01.eb11,ewb01.eb12,ewb01.eb13,
                     '{$vb_empno}','{$vb_dept_id}','{$vproc}','{$vb_date}'
               from   ewb01
               where ewb01.s_num = '{$row['fs_num']}';      
             ";
      //echo "<pre>".$query2."</pre>";  
      //exit;     
      sl_open('docs');       
      if(!mysql_query($query2)){
        sl_errmsg("錯誤"."<pre>".$query2."</pre>");
      }
    }
  } 

  // **************************************************************************
  //  函數名稱: u_del_flw()
  //  函數功能: 簽核單抽單
  //  使用方式: u_del_flw($fd_sla015002)
  //  程式設計: 佳玟
  //  設計日期: 2013.12.24
  // **************************************************************************
  function u_del_flw($fd_sla015002) { 
    // 調車單(簽核中)   -> 調車單抽單、 外出資料作廢
    // 哩程單(簽核中)   -> 哩程單抽單
    $fd_sla015002 = $fd_sla015002;
    $fd_time      = date("Y/m/d H:i:s");
    $vb_empno     = $_SESSION["login_empno"];
    $vb_dept_id   = $_SESSION["login_dept_id"];
    $vb_date      = date("Y-m-d H:i:s");
    $vproc        = u_showproc(); // 程式代號      
    //echo "ffz:".$fd_sla015002;
    //exit;                              
    sl_openef2k('EF2KWeb');
    //.......................................................................
    // UPD resda
    //.......................................................................
    $sql_sda = "select resda022
                from   resda                  
                where  resda001 = 'SL-EIP2FLW'
                       and resda002 = '{$fd_sla015002}'";
    $result_sda = mssql_query($sql_sda);
    $a_sda = mssql_fetch_assoc($result_sda);
    
    if( $a_sda['resda022'] == '' ){
      $a_sda['resda022'] = '0000-0000-0000';
    }
    else{
      $a_sda['resda022'] = "{$a_sda['resda022']};0000-0000-0000";
    }      
    $sql_resda = "update resda
                  set    resda019 = '{$fd_time}',
                         resda020 = 4 ,
                         resda021 = 4 ,
                         resda022 = '{$a_sda['resda022']}'
                  where  resda001 = 'SL-EIP2FLW'
                         and resda002 = '{$fd_sla015002}'";
    //echo $sql_resda."<br>";
    if(!mssql_query($sql_resda)) { // 寫入失敗
      sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_resda.'!!'); //qq:para只丟str不丟font
      EXIT;
    }  
    //.......................................................................
    
    
    //.......................................................................
    // UPD resdc
    //.......................................................................            
    $sql_resdc = "update resdc
                  set    resdc007 = 11 ,
                         resdc008 = 9 
                  where  resdc001 = 'SL-EIP2FLW'
                         and resdc002 = '{$fd_sla015002}'";
    if(!mssql_query($sql_resdc)) { // 寫入失敗
      sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_resdc.'!!'); //qq:para只丟str不丟font
      EXIT;
    }  
    //.......................................................................  
    
    //.......................................................................
    // UPD resdd
    //.......................................................................                 
    $sql_resdd = "update resdd
                  set resdd014 = 11 ,
                      resdd015 = 9 ,
                      resdd902 = '{$vb_empno}' ,
                      resdd903 = '{$fd_time}'
                  where resdd001 = 'SL-EIP2FLW'
                  and resdd002 = '{$fd_sla015002}'";
    if(!mssql_query($sql_resdd)) { // 寫入失敗
      sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_resdd.'!!'); //qq:para只丟str不丟font
      EXIT;
    }  
    //....................................................................... 
    
    //.......................................................................
    // UPD sleip2flw
    //.......................................................................   
    sl_open('docs');
    $sql_2flw = "update  docs.sleip2flw
                 set     resda019 = '{$vb_date}',
                         resda020 = '4',
                         resda021 = '4',
                         m_empno  = '{$vb_empno}',
                         m_dept_id= '{$vb_dept_id}',
                         m_proc   = '{$vproc}',
                         m_date   = '{$vb_date}'
                 where   sleip2flw001='SL-EIP2FLW'
                         and sleip2flw002='{$fd_sla015002}'
                         and sleip2flw003='docs'
                         and sleip2flw004='ewb01'
                         and resda020 <> '3'
                ";         
    //echo $sql_2flw."<br>";               
    if(!mysql_query($sql_2flw)) { // 寫入失敗
      sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_2flw.'!!'); //qq:para只丟str不丟font
      EXIT;
    }    
                
  
    return;
  }  

  // **************************************************************************
  //  函數名稱: u_del_ewb()
  //  函數功能: DOCS內簽核單作廢
  //  使用方式: u_del_ewb($ar)
  //  程式設計: 佳玟
  //  設計日期: 2013.12.24
  // **************************************************************************
  function u_del_ewb($f_var) { 
    // 調車單(簽核中)   -> 調車單抽單、 外出資料作廢
    // 哩程單(簽核中)   -> 哩程單抽單
    $fd_time      = date("Y/m/d H:i:s");
    $vb_empno     = $_SESSION["login_empno"];
    $vb_dept_id   = $_SESSION["login_dept_id"];
    $vb_date      = date("Y-m-d H:i:s");
    $vproc        = u_showproc(); // 程式代號      
    
    sl_open('docs');
    $sql_ewb = "update  docs.ewb01
                 set     d_empno  = '{$vb_empno}',
                         d_dept_id= '{$vb_dept_id}',
                         d_proc   = '{$vproc}',
                         d_date   = '{$vb_date}'
                 where   s_num = '{$f_var['f_s_num']}'
                         and eb18 = '{$vb_empno}'
                ";         
    //echo $sql_2flw."<br>";               
    if(!mysql_query($sql_ewb)) { // 寫入失敗
      sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_ewb.'!!'); //qq:para只丟str不丟font
      EXIT;
    }    
               
  
    return;
  }    
  
  // **************************************************************************
  //  函數名稱: ul_eip2flw()
  //  函數功能: 報修32441-簽核至稽核最高主管
  //  使用方式:
  //  程式設計: 
  //  設計日期: 2017.09.20
  // **************************************************************************
  function ul_eip2flw(&$f_var) {
    Global $_SESSION;
    Global $f_var;
    $vb_empno   = $_SESSION["login_empno"];
    $vb_name    = $_SESSION["login_name"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vfromip    = $_SERVER["REMOTE_ADDR"];
    $vproc      = u_showproc(); // 程式代號
    //$f_var['mgo_url'] = "/~docs/erp_qa/erp_qa.php?msel=6&mqah_no={$_REQUEST['f_s_num']}";
    //$f_var['f_s_num'] = '6173';

    if(is_array($_REQUEST)) { // 有資料才處理
       while (list($f_fd_name,$f_fd_value) = each($_REQUEST)) {
              //echo "$f_fd_name=$f_fd_value----";
              $f_var[$f_fd_name] = $f_fd_value;
       }
    }
    $count_table= substr_count($f_var['f_table'],'.');
    $ex_table   = explode('.',$f_var['f_table']);
    $fd_table   = iif($count_table==0,$f_var['f_table'],$ex_table[1]);

    $fd_b_empno      = $f_var['f_b_empno'];                                          //建檔者員編
    $fd_sleip2flw003 = str_replace("\"","",$f_var['f_db']);                          //DB
    $fd_sleip2flw004 = str_replace("\"","",$fd_table);                               //table
    $fd_sleip2flw005 = str_replace("\"","",$f_var['f_file_path']);                   //附件路徑
    $fd_sleip2flw006 = date('Y/m/d',strtotime($f_var['f_b_date']));                  //填單日期
    $fd_sleip2flw007 = str_replace("\"","",$f_var['f_title']);                       //主旨
    $fd_sleip2flw008 = str_replace("\"","",$f_var['f_type']);                        //類別
    $fd_sleip2flw009 = str_replace("\"","",str_replace("'","",$f_var['f_content'])); //內容
    $fd_sleip2flw010 = str_replace("\"","",$f_var['f_s_num']);                       //s_num
    $fd_sleip2flw011 = str_replace("\"","",$f_var['f_cnt']);                         //次數 //upd by mimi 2011.06.13 增加轉檔次數
    $fd_resda020 = "2"; // Add By Tails 2015.06.09 新的簽核狀態預設
    $fd_resda021 = "1"; // Add By Tails 2015.06.09 新的簽核結果預設
    //if($f_var['f_file1'] <> ''){
    //  $remote_file[]= $f_var['f_file1'];         // remote的檔案名稱
    //}
    //if($f_var['f_file2'] <> ''){
    //  $remote_file[]= $f_var['f_file2'];         // remote的檔案名稱
    //}
    //if($f_var['f_file3'] <> ''){
    //  $remote_file[]= $f_var['f_file3'];         // remote的檔案名稱
    //}
    //upd by mimi 2011.07.01 增加至10個附件
    $fd_cnt=1;
    for($i=0;$i<10;$i++){
      $fd_file = "f_file".($fd_cnt+$i);
      if($f_var[$fd_file] <> ''){
        $remote_file[]= $f_var[$fd_file];         // remote的檔案名稱
      }
    }

    //echo '<pre>'.$fd_qah_5.'</pre>';exit;
    //echo $query1.'<br>'.$fd_b_empno;exit;
    $eipsql= 'docs';
    $vdat1 = 'EF2KWeb';
    $mftp_server  = "flow.slc.com.tw";         // ftp server
    $mftp_user    = "it";                   // ftp user name
    $mftp_pass    = "sl85";                 // ftp user password
    sl_openef2k($vdat1);
    //***************************************************************************
    // (報修20585)upd by 佳玟 2013.07.08 不給予權限人員在resak004會以員編+_U顯示
    //***************************************************************************
    $u_query = "SELECT resak001,resak002,resak015,resal002,resak013
                FROM resak
                     LEFT JOIN resal
                               ON resak015 = resal001
                WHERE LTrim(RTrim(resak004)) = '{$fd_b_empno}'
               ";
    $u_res   = mssql_query($u_query);
    $u_count = mssql_num_rows($u_res);
    if( $u_count==0 ){
      sl_errmsg("<b><font color='#FF0000'>注意!!</font> 員工: {$vb_name}({$fd_b_empno}) 電子簽核基本資料異常(組織.上層主管)請聯絡人是維護資料，謝謝！。</b>"); //qq:para只丟str不丟font
      exit;
    }
    //******************************************************************

    $query2 = "SELECT resak001,resak002,resak015,resal002,resak013
               FROM resak
                 LEFT JOIN resal
                   ON resak015 = resal001
               WHERE resak001 = '{$fd_b_empno}'
              ";
    $result2 = mssql_query($query2);
    $row2 = mssql_fetch_array($result2);
    $fd_resak015 = $row2['resak015'];  //FLW-部門代號
    $fd_resal002 = $row2['resal002'];  //FLW-部門名稱
    $fd_resak013 = $row2['resak013'];  //FLW-直屬主管

    $query3 = "SELECT top 1 resdz001,resdz002
               FROM resdz
               where resdz001 = 'SL-EIP2FLW'
               order by resdz002 DESC
              ";
    $result3 = mssql_query($query3);
    $row3 = mssql_fetch_array($result3);
    $fd_resdz001 = 'SL-EIP2FLW';    //FLW-單號
    $fd_resdz002 = str_pad(($row3['resdz002']+1),10,0,STR_PAD_LEFT);  //FLW-單別
    $fd_ymd      = date('Y/m/d');
    $fd_date     = date('Y/m/d H:i:s');

    //resdz 表單單號紀錄檔 (RESDZ) upd by mimi 2011.11.18 讀到單號單號後馬上寫入,如果又有重覆的則停止寫入,以避免程式異常~
    $query_head6 ="insert into {$vdat1}..resdz (resdz001,resdz002) values ('{$fd_resdz001}','{$fd_resdz002}')";
    //echo $query_head6.'<hr>';
    if(!mssql_query($query_head6)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!單別單號重覆，請重新輸入!!</b></font>'.$query_head6.'!!'); //qq:para只丟str不丟font
       exit;
    }


    $vins_fd1    ="sleip2flw001,sleip2flw002,
                   sleip2flw003,sleip2flw004,sleip2flw005,sleip2flw006,
                   sleip2flw007,sleip2flw008,sleip2flw009,sleip2flw010,sleip2flw011
                  ";
    $vins_value1 ="'{$fd_resdz001}','{$fd_resdz002}',
                   '{$fd_sleip2flw003}','{$fd_sleip2flw004}','{$fd_sleip2flw005}','{$fd_sleip2flw006}',
                   '{$fd_sleip2flw007}','{$fd_sleip2flw008}','{$fd_sleip2flw009}','{$fd_sleip2flw010}','{$fd_sleip2flw011}'
                  ";

    //eip-docs.sleip2flw
    sl_open($eipsql);
    $query_head7 ="insert into {$eipsql}.sleip2flw ({$vins_fd1},resda020,resda021,b_empno,b_dept_id,b_proc,b_date)
                   values ({$vins_value1},'{$fd_resda020}','{$fd_resda021}','{$vb_empno}','{$vb_dept_id}','{$vproc}','{$vb_date}')";
    if(!mysql_query($query_head7)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head7.'!!'); //qq:para只丟str不丟font
    }

    //flw-sleip2flw
    sl_openef2k($vdat1);
    $query_head1 ="insert into {$vdat1}..sleip2flw ({$vins_fd1},sleip2flw900,sleip2flw901,sleip2flw904)
                   values ({$vins_value1},'{$fd_b_empno}','{$fd_date}','{$fd_resak015}')";
    //echo $query_head1.'<hr>';
    if(!mssql_query($query_head1)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head1.'!!'); //qq:para只丟str不丟font
       //echo $f_var['query_data'];
       //exit;
    }

    //resda 表單流程異動主檔 (RESDA)
    $vins_fd2    =" resda001,resda002,resda015,resda016,resda017,resda018,resda019,resda020,resda021,resda022,resda023 ";
    $vins_value2 =" '{$fd_resdz001}','{$fd_resdz002}','{$fd_date}','{$fd_b_empno}','{$fd_b_empno}','{$fd_date}','','2','1','','' ";
    $vins_fd2   .=" ,resda030,resda031,resda032,resda033,resda034,resda900,resda901,resda904 ";
    $vins_value2.=" ,'','{$fd_sleip2flw007}','1','Y','','{$fd_b_empno}','{$fd_date}','{$fd_resak015}' ";
    $query4 = "SELECT resca.*
               FROM resca
               where resca001 = '{$fd_resdz001}'
              ";
    $result4 = mssql_query($query4);
    $row4 = mssql_fetch_array($result4);
    ksort($row4);
    while (list($key4,$value4) = each($row4)){
      if (ereg("^[r]",substr($key4,0,1))){
          switch ($key4) {
            case "resca004": //流程種類
              $vins_fd2   .=",resda003";
              $vins_value2.=",'{$value4}'";
              break;
            case "resca005": //自動編號?
            case "resca017": //填表人可否變更表單性質?
              break;
            case "resca006": //逾時警示開關
            case "resca007": //逾時警示-填表人
            case "resca008": //逾時警示-逾時人員之主管
            case "resca009": //逾時警示-指定管理人
            case "resca010": //逾時警示-指定管理人員工代號
            case "resca011": //逾時警示-警示間隔天數
            case "resca012": //逾時警示-警示次數
            case "resca013": //是否結案後通知所有人員?
            case "resca014": //是否逐級回報?
            case "resca015": //填表人可否強迫
            case "resca016": //填表人可否抽單?
              $fd_resda    ="resda".str_pad((substr($key4,5,3)-2),3,'0',STR_PAD_LEFT);
              $vins_fd2   .=",{$fd_resda}";
              $vins_value2.=",'{$value4}'";
              break;
            case "resca018": //原稿可否列印？
            case "resca019": //原稿可否轉寄？
            case "resca020": //原稿可否閱讀附件？
            case "resca021": //回函可否列印？
            case "resca022": //回函可否轉寄？
            case "resca023": //回函可否閱讀附件？
              $fd_resda    ="resda".str_pad((substr($key4,5,3)+6),3,'0',STR_PAD_LEFT);
              $vins_fd2   .=",{$fd_resda}";
              $vins_value2.=",'{$value4}'";
              break;
            default:
              break;
          }
      }
    }
    $query_head2 ="insert into {$vdat1}..resda ($vins_fd2) values ($vins_value2)";
    //echo $query_head2.'<hr>';
    if(!mssql_query($query_head2)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head2.'!!'); //qq:para只丟str不丟font
       //echo $f_var['query_data'];
       //exit;
    }

    //resdb 表單流程異動子檔 (RESDB),resdc 表單流程異動明細檔 (RESDC),resdd 表單流程異動明細檔 (RESDD)
    //$query51 = "SELECT rescd.rescd001,rescd.rescd002,rescd.rescd003,rescd.rescd004,EFormWizardCond.OperationDef,
    //                   rescd.rescd006,rescd.rescd007,rescc006,rescc007
    //           FROM rescd
    //             LEFT JOIN EFormWizardCond ON EFormWizardCond.CondID=rescd005
    //             LEFT JOIN rescc ON rescd001=rescc001 AND rescd002=rescc002 AND rescd003=rescc003
    //           WHERE rescd001='SL-EIP2FLW' AND rescd007='{$fd_sleip2flw008}'
    //          ";使用流程條件的方法
    $query51 = "SELECT rescf005,EFormWizardCond.OperationDef,rescf006,rescf007,resce005
                FROM rescf
                  LEFT JOIN  resce ON rescf001=resce001 AND rescf003=resce003
                  LEFT JOIN EFormWizardCond ON EFormWizardCond.CondID=rescf005
                WHERE rescf001='{$fd_resdz001}' AND CONVERT(VARCHAR(999), rescf007)='{$fd_sleip2flw008}'
              ";//使用子流程定義的方法
    $result51 = mssql_query($query51);
    $row51 = mssql_fetch_array($result51);
    $int_rescc006 = intval($row51['rescc006']);
    $int_rescc007 = intval($row51['rescc007']);
    $num_resdb    = 0;
    //echo $int_rescc006.'~~~~'.$int_rescc007.'<br>';
    //$query52 = "SELECT *
    //           FROM rescc
    //           WHERE rescc001='SL-EIP2FLW'
    //          ";
    $query52 = "SELECT *
                FROM resch
                WHERE resch001 = '{$row51['resce005']}'
              ";
    $result52 = mssql_query($query52);
    while($row52 = mssql_fetch_array($result52)){
      //echo $row52['rescc002'].'~~~~'.$row52['rescc003'].'<br>';
      $vins_fd3    =" resdb001,resdb002 ";
      $vins_value3 =" '{$fd_resdz001}','{$fd_resdz002}' ";
      $vins_fd3   .=" ,resdb900,resdb901,resdb904 ";
      $vins_value3.=" ,'{$fd_b_empno}','{$fd_date}','{$fd_resak015}' ";
      $num_resdb++;
      if('1'==$num_resdb){
        $vins_fd3   .=" ,resdb026 ";
        $vins_value3.=" ,'Y'";
        $resdc006=iif($row52['resch006']=='',$fd_resak013,$row52['resch006']);
        //resdc 表單流程異動明細檔 (RESDC)
        $vins_fd4    =" resdc001,resdc002,resdc005,resdc006,resdc007,resdc008,resdc900,resdc901,resdc904 ";
        $vins_value4 =" '{$fd_resdz001}','{$fd_resdz002}','0001','{$resdc006}','3','1','{$fd_b_empno}','{$fd_date}','{$fd_resak015}' ";

        //resdd 表單流程異動明細檔 (RESDD)
        $vins_fd5    =" resdd001,resdd002,resdd005,resdd006,resdd007,resdd008,resdd009 ";
        $vins_value5 =" '{$fd_resdz001}','{$fd_resdz002}','0001','01','{$resdc006}','','{$fd_date}' ";
        $vins_fd5   .=" ,resdd013,resdd014,resdd015,resdd017,resdd018,resdd019,resdd900,resdd901,resdd904 ";
        $vins_value5.=" ,'0','2','1','N','8','Y','{$fd_b_empno}','{$fd_date}','{$fd_resak015}' ";
      }
      else{
        $vins_fd3   .=" ,resdb026 ";
        $vins_value3.=" ,'N'";
      }
      //echo $row52['rescc002'].'---'.$row52['rescc003'].'<br>';
      
      ksort($row52);
      while (list($key52,$value52) = each($row52)){
        if (ereg("^[r]",substr($key52,0,1))){
          switch ($key52) {
            case "resch002": //關號  
            case "resch003": //支號
              $fd_resdb    ="resdb".str_pad((substr($key52,5,3)+1),3,'0',STR_PAD_LEFT);
              $vins_fd3   .=",{$fd_resdb}";
              $vins_value3.=",'{$value52}'";
              if('1'==$num_resdb){
                $fd_resdc    ="resdc".str_pad((substr($key52,5,3)+1),3,'0',STR_PAD_LEFT);
                $vins_fd4   .=",{$fd_resdc}";
                $vins_value4.=",'{$value52}'";

                $fd_resdd    ="resdd".str_pad((substr($key52,5,3)+1),3,'0',STR_PAD_LEFT);
                $vins_fd5   .=",{$fd_resdd}";
                $vins_value5.=",'{$value52}'";
              }
              break;
            case "resch004": //流程角色
            case "resch005": //簽核種類
            case "resch006": //流程角色參數1
            case "resch007": //流程角色參數2
            case "resch008": //流程角色參數3
            case "resch009": //流程角色參數4
            case "resch010": //容許簽核時間
            case "resch011": //自動ByPass?
            case "resch012": //ByPass方式
            case "resch013": //是否強制簽核?
            case "resch014": //是否單一簽核
            case "resch015": //可否列印?
            case "resch016": //可否撤簽?
            case "resch017": //可否加簽?
            case "resch018": //可否轉會?
            case "resch019": //可否轉寄?
            case "resch020": //可否新增附加檔?
            case "resch021": //可否修改附加檔?
            case "resch022": //可否刪除附加檔?
            case "resch023": //可否閱讀附加檔?
            case "resch024": //簽核時密碼驗證?
              $fd_resdb    ="resdb".str_pad((substr($key52,5,3)+1),3,'0',STR_PAD_LEFT);
              $vins_fd3   .=",{$fd_resdb}";
              $vins_value3.=",'{$value52}'";
              break;
            default:
              break;
          }
        }
      }
      $query_head3 ="insert into {$vdat1}..resdb ($vins_fd3) values ($vins_value3)";
      //echo $query_head3.'<hr>';
      if(!mssql_query($query_head3)) { // 寫入失敗
         sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head3.'!!'); //qq:para只丟str不丟font
         //echo $f_var['query_data'];
         //exit;
      }
    }
    //----------------------------------------------------------------------------
    //add by 佳玟 2017.09.19 依稽核甘大人指示,要看到稽核外出簽核單
    $sql_rk = " select rk.resak001, rk.resak002, 
                       rk1.resak001 as rka1, rk1.resak002 as rka1_n,  
                       rk2.resak001 as rka2, rk2.resak002 as rka2_n, 
                       rk3.resak001 as rka3, rk3.resak002 as rka3_n, 
                       rk4.resak001 as rka4, rk4.resak002 as rka4_n
                from   resak as rk
                       left join resak as rk1 on rk.resak013  = rk1.resak001
                       left join resak as rk2 on rk1.resak013 = rk2.resak001
                       left join resak as rk3 on rk2.resak013 = rk3.resak001
                       left join resak as rk4 on rk3.resak013 = rk4.resak001
                  where rk.resak001 = '{$_SESSION['login_empno']}'
              ";
    $res_rk = mssql_query($sql_rk);
    while($row_rk = mssql_fetch_array($res_rk)){
      $fd_rkemp = $row_rk['resak001']; //起草人
      $fd_rkemp1 = $row_rk['rka1']; //第1關
      $fd_rkemp2 = $row_rk['rka2']; //第2關
      $fd_rkemp3 = $row_rk['rka3']; //第3關 
      $fd_rkemp4 = $row_rk['rka4']; //第4關
      sl_open('sl');
      $femp = "'{$row_rk['resak001']}','{$row_rk['rka1']}','{$row_rk['rka2']}','{$row_rk['rka3']}','{$row_rk['rka4']}'";
      $sql_dt = "select empno, dept_id, job_id
                 from   sl.pass
                 where  empno in ({$femp})
                        and dept_id = 'S181'
                ";
      $res_dt = mysql_query($sql_dt);
      $cnt_dt = mysql_num_rows($res_dt);
      if( $cnt_dt>0 ){
        while ($ar_dt = mysql_fetch_assoc($res_dt)) {
          $ar_dpt[$ar_dt['empno']] = $ar_dt['dept_id']; //S181
        }
      }
      if( !empty($ar_dpt[$fd_rkemp3]) ){
        $ar_rk[] = $fd_rkemp3;
      }
      if( !empty($ar_dpt[$fd_rkemp4]) ){
        $ar_rk[] = $fd_rkemp4;
      }
    }
    sl_openef2k($vdat1);
    if( !empty($ar_rk) ){
      $fe_resdb003 = '0020';
      $fe_resdb007 = '0010';    
      foreach($ar_rk as $k1=>$v1){
        $fv_resdb003 = str_pad( ($fe_resdb003+10),4,'0',STR_PAD_LEFT);
        $fv_resdb007 = str_pad( ($fe_resdb007+10),4,'0',STR_PAD_LEFT);
        $sql_db = " insert into {$vdat1}..resdb
                           (resdb001,resdb002,resdb003,resdb004,resdb005,
                            resdb006,resdb007,resdb008,resdb009,resdb010,
                            resdb011,resdb012,resdb013,resdb014,resdb015,
                            resdb016,resdb017,resdb018,resdb019,resdb020,
                            resdb021,resdb022,resdb023,resdb024,resdb025,
                            resdb026,resdb027,
                            resdb900,resdb901,resdb902,resdb903,
                            resdb904,resdb905)
                    select resdb001,resdb002,
                           '{$fv_resdb003}' as resdb003,
                           '0010' as resdb004,
                           '2' as resdb005,
                           '2' as resdb006,
                           '{$fv_resdb007}' as resdb007,
                           '0010' as resdb008,
                           resdb009,resdb010,resdb011,resdb012,
                           resdb013,resdb014,resdb015,resdb016,
                           resdb017,resdb018,resdb019,resdb020,
                           resdb021,resdb022,resdb023,resdb024,
                           resdb025,resdb026,resdb027,
                           resdb900,resdb901,resdb902,resdb903,
                           resdb904,resdb905
                    from   {$vdat1}..resdb
                    where  resdb001 = '{$fd_resdz001}'
                           and resdb002 = '{$fd_resdz002}'
                           and resdb003 = '0020'
                  ";
        if(!mssql_query($sql_db)) { // 寫入失敗
          sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$sql_db.'!!');
        }
      }
    }
    
    //最後一關多拉一關直屬主管

    //----------------------------------------------------------------------------

    //resdc 表單流程異動明細檔 (RESDC)
    $query_head4 ="insert into {$vdat1}..resdc ($vins_fd4) values ($vins_value4)";
    //echo $query_head4.'<hr>';
    if(!mssql_query($query_head4)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head4.'!!'); //qq:para只丟str不丟font
       //echo $f_var['query_data'];
       //exit;
    }

    $query_head5 ="insert into {$vdat1}..resdd ($vins_fd5) values ($vins_value5)";
    //echo $query_head5.'<hr>';
    if(!mssql_query($query_head5)) { // 寫入失敗
       sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head5.'!!'); //qq:para只丟str不丟font
       //echo $f_var['query_data'];
       //exit;
    }

    //resde 表單流程附加檔 (RESDE) add by mimi 2010.07.07
    // **************************************************************************
    //  函數名稱: u_ftp_put()
    //  函數功能: 將檔案上傳至190
    //  使用方式: u_ftp_put($f_var)
    //  程式設計: Mimi
    //  設計日期: 2010.07.08
    // **************************************************************************
    $mftp_connect = ftp_connect($mftp_server); // connect ftp
    if($mftp_connect) {
      $mftp_login   = ftp_login($mftp_connect,$mftp_user,$mftp_pass); // login
      ftp_pasv($mftp_connect, FALSE);
      //ftp_chdir($mftp_connect, "/wms/{$f_var['f_stock_cd']}");
      $remote_dir = "/SL-EIP2FLW/{$fd_resdz002}/";
      //$local_dir  = "/home/docs/public_html/erp_qa/upfile/";
      //echo $remote_dir.'<br>';
      @ftp_mkdir($mftp_connect,$remote_dir);
      //$local_file
      //-----丟到.190的主機----------------------------------------------------------------
      $fd_resde003 = 0;  //序號
      for($i=0;$i<count($remote_file);$i++){
        if(ftp_put($mftp_connect,"{$remote_dir}{$remote_file[$i]}","{$fd_sleip2flw005}{$remote_file[$i]}", FTP_BINARY)) {
          //ftp_chmod($mftp_connect,0666,"{$remote_dir1}{$remote_file[$i]}");
          //u_errmsg('3','left','000000','FFFF99','FF9966',"{$remote_file[$i]} 資料轉檔成功\!!");
          $fd_resde003 ++;
          $fd_resde003 = str_pad($fd_resde003,4,'0',STR_PAD_LEFT);
          $fd_resde010 = filesize("{$fd_sleip2flw005}{$remote_file[$i]}");
          $vins_fd8    ="resde001,resde002,resde003,resde004,resde005,resde006,resde010,resde011,resde900,resde901,resde904";
          $vins_value8 ="'{$fd_resdz001}','{$fd_resdz002}','{$fd_resde003}',
                         '{$remote_file[$i]}','{$remote_file[$i]}','{$remote_file[$i]}','{$fd_resde010}','{$fd_date}',
                         '{$fd_b_empno}','{$fd_date}','{$fd_resak015}'";
          $query_head8 ="insert into {$vdat1}..resde ($vins_fd8) values ($vins_value8)";
          //echo $query_head8.'<hr>';
          if(!mssql_query($query_head8)) { // 寫入失敗
             sl_errmsg('<font color="#FF0000"><b>注意!!</b></font>'.$query_head8.'!!'); //qq:para只丟str不丟font
             //echo $f_var['query_data'];
             //exit;
          }
        }
        else{
          u_errmsg('3','left','000000','FFFF99','FF9966',"{$remote_file[$i]} 檔案上傳失敗!!");
        }
      }
      //-------------------------------------------------------------------------------------
      ftp_close($mftp_connect);                  // close ftp
      //-------------------------------------------------------------------------------------

    }
    else {
       u_errmsg('3','left','000000','FFFF99','FF9966','FWL主機連線失敗，請通知資訊部!!');
    }
    $f_var['f_resdz001']=$fd_resdz001;//upd by mimi 2011.06.02 回傳簽核表單別
    $f_var['f_resdz002']=$fd_resdz002;//upd by mimi 2011.06.02 回傳簽核表單號
    return $f_var;
    
  }  
  // **************************************************************************
  //  函數名稱: ul_essf21()
  //  函數功能: 轉hrm
  //  使用方式: ul_essf21($snum,$msel,$empid)
  // **************************************************************************
  function ul_essf21($snum,$msel,$empid){
    $fd_s_num = $snum;
    $fd_msel = $msel;   
    $fd_empid = $empid;  
    $fp = fopen("/home/docs/public_html/ewb/t_essf21.log", 'a'); 
    $fd_inLog = date("Y-m-d H:i:s")."\n";
    $fd_inLog .= "s_num: ".$fd_s_num." msel: ".$fd_msel." employeeid: ".$fd_empid."\n";
  
    sl_open('docs');
    $sql_1 = " select ewb01.*, sleip2flw.sleip2flw001, sleip2flw.sleip2flw002 
               from   docs.ewb01
                      left join docs.sleip2flw on ewb01.s_num = sleip2flw.sleip2flw010
                                and sleip2flw.sleip2flw003 = 'docs'
                                and sleip2flw.sleip2flw004 = 'ewb01'
               where  ewb01.s_num = '{$fd_s_num}'
                      and ewb01.b_empno = sleip2flw.b_empno
             "; 
    //echo "<pre>{$sql_1}</pre>";         
    $res_1 = mysql_query($sql_1);  
    $cnt_1 = mysql_num_rows($res_1); 
    if( $cnt_1>0 ){        
      $ar_1 = mysql_fetch_array($res_1);
      switch( $fd_msel ){
        case '1':
             $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
             $f_var['hrmws']['method'] = "CheckForESS";
             $f_var['hrmws']['parameterType'] = "";
             $f_var['hrmws']['parm'][1]['String'] = $ar_1['sleip2flw001']; //單別
             $f_var['hrmws']['parm'][2]['String'] = $ar_1['sleip2flw002']; //單號
             $f_var['hrmws']['parm'][3]['Int32'] = 2; //登記類型(1.按申請登記、2.直接登記)
             $f_var['hrmws']['parm'][4]['String'] = ""; //出差申請id (如果直接登記為空值)
             $f_var['hrmws']['parm'][5]['String'] = $fd_empid; //員工ID
             $f_var['hrmws']['parm'][6]['String'] = "701"; //出差類型id  A1136|出差(無伙食)   A1136|出差(無伙食)
             $chkmak = '/\s+|[&:@8*~%]|["|\']|[\[\]]|[\n\r\t]|[\\\\]/';
             //$fv_eb04 = str_replace("&","",$ar_1['eb04']);  //ws會gg
             $fv_eb04 = preg_replace($chkmak, "", $ar_1['eb04']);  //ws會gg
             $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($fv_eb04,'UTF-8','big5'); //出差地點
             $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($ar_1['eb02']); //開始日期
             $f_var['hrmws']['parm'][9]['String'] = substr($ar_1['eb03'],0,2).":".substr($ar_1['eb03'],2,2); //開始時間
             $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($ar_1['eb06']); //結束日期
             $f_var['hrmws']['parm'][11]['String'] = substr($ar_1['eb07'],0,2).":".substr($ar_1['eb07'],2,2); //結束時間
             $f_var['hrmws']['parm'][12]['Int32'] = "1"; //扣除休息班次
             //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //備註
             $f_var['hrmws']['parm'][13]['String'] = "-".$ar_1['s_num']; //備註
             $f_var['hrmws']['parm'][14]['Int32'] = "1"; //扣除非在公司時間
             $f_var['hrmws']['parm'][15]['Int32'] = "1"; //扣除休息班次?加班就餐段（0否，1是）
             sl_hrmws($f_var);                            
                  
             if( '0'==$f_var['hrmws']['status'] ){ //驗證成功  非0為失敗
               $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
               $f_var['hrmws']['method'] = "SaveForESS";                 
               $f_var['hrmws']['parameterType'] = "";
               //$fv_eb05 = str_replace("&","",$ar_1['eb05']);  //ws會gg
               $fv_eb05 = preg_replace($chkmak, "", $ar_1['eb05']);  //ws會gg     
               $f_var['hrmws']['parm'][16]['String'] = mb_convert_encoding($fv_eb05,'UTF-8','big5'); //出差原因
               $f_var['hrmws']['parm'][17]['Int32'] = "1"; //扣除休息班次內加班就餐段
               sl_hrmws($f_var);
               if( '0'==$f_var['hrmws']['status'] ){
                 $sql_upd = "update docs.ewb01
                             set    ws_res = '1',
                                    ws_id = '{$f_var['hrmws']['rtn'][1]}'
                             where  s_num = '{$fd_s_num}' ";
                 mysql_query($sql_upd); 
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
               }else{            
                 ul_delflw($ar_1['sleip2flw001'],$ar_1['sleip2flw002']); //add by 佳玟 2018.11.22 hrm不穩,也不確定什麼時候會卡住,所以判斷如果是要轉hrm的,然後驗證沒有成功的,就抽單
                 $fd_inLog .= "HRM發單回寫失敗-{$fd_s_num}\n";
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "error: ".$f_var['hrmws']['error']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
                 sl_errmsg("<font color=red size=+2>HRM發單回寫失敗-{$fd_s_num}! <BR>請確認外出的出退勤時段, 是否有需要轉入HRM取代打卡紀錄, 請再重新送單。<br>".$f_var['hrmws']['error']."</font>");
                 //echo "HRM發單回寫失敗-{$fd_s_num}\n";
                 //echo "<pre>";
                 //print_r($f_var['hrmws']);
                 //echo "</pre>";
                 exit;      
               }
             }else{
               ul_delflw($ar_1['sleip2flw001'],$ar_1['sleip2flw002']); //add by 佳玟 2018.11.22 hrm不穩,也不確定什麼時候會卡住,所以判斷如果是要轉hrm的,然後驗證沒有成功的,就抽單
               $fd_inLog .= "HRM發單驗證失敗-{$fd_s_num}\n";
               $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
               $fd_inLog .= "error: ".$f_var['hrmws']['error']."\n";
               $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
               //foreach($f_var['hrmws']['parm'] as $k1 => $v1) {
               //  foreach($f_var['hrmws']['parm'][$k1] as $k2 => $v2) {
               //    if( $k1=='7' ){
               //      $fd_inLog .= "parm: {$k1}-".$ar_1['eb04']."\n";
               //    }else{
               //      $fd_inLog .= "parm: {$k1}-".$f_var['hrmws']['parm'][$k1][$k2]."\n";
               //    }
               //    
               //  }
               //}
               fwrite($fp, $fd_inLog);
               fclose($fp);
               sl_errmsg("<font color=red size=+2>HRM發單驗證失敗-{$fd_s_num}! <BR>請確認外出的出退勤時段, 是否有需要轉入HRM取代打卡紀錄, 請再重新送單。<br>".$f_var['hrmws']['error']."</font>");
               //echo "HRM發單驗證失敗-{$fd_s_num}\n";
               echo "<pre>";
               print_r($f_var['hrmws']);
               echo "</pre>";
               exit;         
             }
             break;
        case '3':
             sl_openhrmdb("HRMDB");
             if( ''==$ar_1['ws_id'] ){
               $sql_brg2 = "select REPLACE(BusinessRegisterId,'-','') as brgid
                           from  BusinessRegister
                           where EmployeeId = '{$fd_empid}'
                                 and Remark like '{$ar_1['sleip2flw001']}-{$ar_1['sleip2flw002']}%'
                          ";
               //echo $sql_brg2."<br>";           
               $res_brg2 = mssql_query($sql_brg2);
               $qty_brg2 = mssql_num_rows($res_brg2);
               if($qty_brg2 > 0){
                 $row_brg2 = mssql_fetch_array($res_brg2);
                 $vstr = trim($row_brg2['brgid']);
                 $fd_brgid = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
               }           
             }else{
               $sql_brg = "select *
                           from  BusinessRegister
                           where BusinessRegisterId = '{$ar_1['ws_id']}'
                                 and EmployeeId = '{$fd_empid}'
                          ";
               //echo $sql_brg."<br>";           
               $res_brg = mssql_query($sql_brg);
               $qty_brg = mssql_num_rows($res_brg);
               if($qty_brg > 0){
                 $fd_brgid = $ar_1['ws_id'];
               }else{
                 $sql_brg2 = "select REPLACE(BusinessRegisterId,'-','') as brgid
                             from  BusinessRegister
                             where EmployeeId = '{$fd_empid}'
                                   and Remark like '{$ar_1['sleip2flw001']}-{$ar_1['sleip2flw002']}%'
                            ";
                 //echo $sql_brg2."<br>";           
                 $res_brg2 = mssql_query($sql_brg2);
                 $qty_brg2 = mssql_num_rows($res_brg2);
                 if($qty_brg2 > 0){
                   $row_brg2 = mssql_fetch_array($res_brg2);
                   $vstr = trim($row_brg2['brgid']);
                   $fd_brgid = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
                 }
               }  
             }  
             if( ''!=$fd_brgid  ){
               $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
               $f_var['hrmws']['method'] = "Delete";
               $f_var['hrmws']['parameterType'] = "System.Object";
               $f_var['hrmws']['parm'][1]['String'] = $fd_brgid; //出差登記id BusinessRegister.BusinessRegisterId
               sl_hrmws($f_var);
               
               //echo htmlspecialchars($f_var['hrmws']['pxml'],ENT_QUOTES)."<br>";
               
               if( '0'==$f_var['hrmws']['status'] ){
                 $sql_upd = "update docs.ewb01
                             set    ws_res = '3'
                             where  s_num = '{$fd_s_num}' ";
                 mysql_query($sql_upd); 
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
               }else{
                 $fd_inLog .= "HRM抽單失敗-{$fd_s_num}\n";
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "error: ".$f_var['hrmws']['error']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
                 echo "HRM抽單失敗-{$fd_s_num}\n";
                 echo "<pre>";
                 print_r($f_var['hrmws']);
                 echo "</pre>";
                 exit;    
               }
             }
             break;
        default:
             break;
      
      }
  
    }
    return;
    //mysql_close(); // 關閉資料庫
  }
  
  // **************************************************************************
  //  函數名稱: ul_delflw()
  //  函數功能: 電簽抽單
  //  使用方式: ul_delflw(&$f_var)
  // **************************************************************************
  function ul_delflw($fv_resdz001,$fv_resdz002){
    if( ''==$fv_resdz001 or ''==$fv_resdz002 ){
      return;
    }
    $ms_date = date("Y/m/d H:i:s");
    sl_openef2k('EF2KWeb'); 
    $sql_d1 = "update resda
               set    resda019 = '{$ms_date}',
                      resda020 = 4,
                      resda021 = 4,
                      resda022 = '0000-0000-0000'
               WHERE resda001 = '{$fv_resdz001}' 
                     AND resda002 = '{$fv_resdz002}'
              ";
    $sql_d2 = " update resdc
                set    resdc007 = 11,
                       resdc008 = 9
                WHERE resdc001 = '{$fv_resdz001}' 
                AND resdc002 = '{$fv_resdz002}'
              ";
    $sql_d3 = " update resdd
                set    resdd014 = 11,
                       resdd015 = 9,
                       resdd902 = resdd900,
                       resdd903 = '{$ms_date}'
                WHERE resdd001 = '{$fv_resdz001}' 
                      AND resdd002 = '{$fv_resdz002}'
              ";
    if(!mssql_query($sql_d1)){
      echo "upd resda error!! .. <pre>{$sql_d1}</pre>"; 
      exit;
    }
    if(!mssql_query($sql_d2)){
      echo "upd resdc error!! .. <pre>{$sql_d2}</pre>";
      exit;
    }
    if(!mssql_query($sql_d3)){
      echo "upd resdd error!! .. <pre>{$sql_d3}</pre>";
      exit;
    }
    return;
  }
?>

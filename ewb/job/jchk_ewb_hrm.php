#!/usr/local/php/bin/php
<?php
  //jck_ewb_hrm
  //撰寫日期: 2018.11.22
  //說明: 有發現使用者登打外出資料,有存入eip及轉電簽,但是沒有call ws到hrm裡
  include_once('/home/sl/public_html/sl_init.php');
  sl_open('sl');
  $vdate = date("Y-m-d H:i:s");
  //add by 佳玟 2018.12.05 依資訊網頁/權限管理/鼎新版更時間控制設定 
  $sql_tr = "select startime, endtime, reason     
              from  hrm.hrmupdatectrl
              where startime <= '{$vdate}'
                    and chk = 'Y'
                    and d_date = '0000-00-00 00:00:00'
             ";
  $res_tr = mysql_query($sql_tr);
  $qty_tr = mysql_num_rows($res_tr);
  if($qty_tr > 0){
    while($row_tr = mysql_fetch_array($res_tr)){
      exit;
    } //員工報到申請、員工眷屬加退保                                            
  }
  
  $f_var['f_date_s'] = date("Ymd",strtotime( date("Ymd")." -60 day" )); 
  $f_var['f_date_e'] = date("Ymd"); 
  //$f_var['in_emp'] = "'9169113'";
  //$f_var['in_emp'] = "'7866887','1731039','1430889','1130209','0970102'";
  //echo u_getFiscalYearId("FF93C277-4658-4480-8334-6886B4B07982","2018-11-07");
  //外出資料
  $f_var['f_empno'] = $_SERVER['argv'][1];
  $f_var['f_swhere_ewb'] = "";
  $f_var['f_swhere_hrm'] = "";
  if( ''!=trim($f_var['f_empno']) ){
    $f_var['f_swhere_ewb'] = " and ewb01.eb18 = '{$f_var['f_empno']}' ";
    $f_var['f_swhere_hrm'] = " and Employee.Code = '{$f_var['f_empno']}' ";
  }
  sl_open('docs');
  $sql_gwf = "SELECT ewb01.s_num as s_num,
                     ewb01.eb18 as Employee,
                     '701' as AttendanceType,
                     DATE_FORMAT( ewb01.eb02,'%Y-%m-%d' ) as BeginDate,
                     CONCAT(substring(ewb01.eb03,1,2),':',substring(ewb01.eb03,3,2)) as BeginTime,
                     DATE_FORMAT( ewb01.eb06,'%Y-%m-%d' ) as EndDate,
                     CONCAT(substring(ewb01.eb07,1,2),':',substring(ewb01.eb07,3,2)) as EndTime,
                     ewb01.eb05 as Remark,
                     DATE_FORMAT( ewb01.b_date,'%Y-%m-%d' ) as CreateDate,
                     DATE_FORMAT( ewb01.b_date,'%H:%i:%s' ) as CreateDateTime,
                     'SL-EIP2FLW' as EssType, 
                     sleip2flw.sleip2flw002 as EssNo, 
                     ewb01.eb04 as local, 
                     DATE_FORMAT( sleip2flw.resda019,'%Y%m%d' ) as flw_date,
                     DATE_FORMAT( sleip2flw.resda019,'%H:%i:%s' ) as flw_time,
                     sleip2flw.resda020 as flw_status,  /*1=未傳送,2=簽核中,3=已簽核,4=已抽單*/
                     sleip2flw.resda021 as flw_res,     /*1=未完成,2=同意,3=不同意,4=已抽單*/
                     'SL-EIP2FLW' as flw_class, /*單別*/
                     sleip2flw.sleip2flw002 as flw_no, /*單號*/ 
                     '' as sign_emp /*最後一關簽核人員編*/
              FROM   docs.ewb01
                     LEFT JOIN docs.sleip2flw ON ewb01.s_num = sleip2flw.sleip2flw010
                               and sleip2flw.sleip2flw004 = 'ewb01'
                               and sleip2flw.d_date = '0000-00-00 00:00:00'
              WHERE  DATE_FORMAT( ewb01.b_date,'%Y%m%d' ) >= '{$f_var['f_date_s']}'
                     AND DATE_FORMAT( ewb01.b_date,'%Y%m%d' ) <= '{$f_var['f_date_e']}'
                     AND DATE_FORMAT( ewb01.b_date,'%Y%m%d' ) >= '20180701'
                     AND sleip2flw.resda021 NOT IN ('3','4')
                     AND sleip2flw.sleip2flw008 IN ('1','11','3')
                     AND ewb01.tohrm = 'Y'
                     {$f_var['f_swhere_ewb']}
              ";
  
  $res_gwf = mysql_query($sql_gwf);
  $cnt_gwf = mysql_num_rows($res_gwf);
  //echo "<pre>{$sql_gwf}</pre>";
  //echo "EIP: {$cnt_gwf} <BR>";
  if ($cnt_gwf>0) {                         
    while($row_gwf = mysql_fetch_array($res_gwf)){
      $fv_empno = $row_gwf['Employee'];
      $fv_attype = $row_gwf['AttendanceType'];
      $fv_essno = $row_gwf['flw_no'];
      $ar_flw_rcd[$fv_empno][$fv_attype][$fv_essno] = $fv_essno; //[員編][假勤類別][簽核單號]
      $f_var['vhrm']['BeginDate'][$fv_essno] = $row_gwf['BeginDate'];
      $f_var['vhrm']['BeginTime'][$fv_essno] = $row_gwf['BeginTime'];
      $f_var['vhrm']['EndDate'][$fv_essno] = $row_gwf['EndDate'];
      $f_var['vhrm']['EndTime'][$fv_essno] = $row_gwf['EndTime'];
      $chkmak = '/\s+|[&:@8*~%]|["|\']|[\[\]]|[\n\r\t]|[\\\\]/';
      $f_var['vhrm']['Remark'][$fv_essno] = preg_replace($chkmak, "", $row_gwf['Remark']);
      $f_var['vhrm']['CreateDate'][$fv_essno] = $row_gwf['CreateDate'];
      $f_var['vhrm']['CreateDateTime'][$fv_essno] = $row_gwf['CreateDateTime'];
      $f_var['vhrm']['EssType'][$fv_essno] = $row_gwf['EssType'];
      $f_var['vhrm']['EssNo'][$fv_essno] = $row_gwf['EssNo'];
      $f_var['vhrm']['flw_status'][$fv_essno] = $row_gwf['flw_status']; //1=未傳送,2=簽核中,3=已簽核,4=已抽單
      $f_var['vhrm']['flw_res'][$fv_essno] = $row_gwf['flw_res']; ///*1=未完成,2=同意,3=不同意,4=已抽單*/
      $f_var['vhrm']['local'][$fv_essno] = preg_replace($chkmak, "", $row_gwf['local']);
      $f_var['vhrm']['snum'][$fv_essno] = $row_gwf['s_num'];
    }
  }
  //$sql_cxl = "SELECT cxlsle_b.flw002
  //            FROM   sle.cxlsle_b
  //                   left join docs.sleip2flw on cxlsle_b.flw002 = sleip2flw.sleip2flw002 
  //                                               and sleip2flw.sleip2flw004 = 'cxlsle'
  //            WHERE  sleip2flw.d_date = '0000-00-00 00:00:00'
  //                   and sleip2flw.resda021 not in ('3','4')
  //                   and cxlsle_b.cxl_6 = '701'
  //                   and cxlsle_b.d_date = '0000-00-00 00:00:00'
  //            ";
  //
  //$res_cxl = mysql_query($sql_cxl);
  //$cnt_cxl = mysql_num_rows($res_cxl);
  //echo "<pre>{$sql_cxl}</pre>";
  //echo "EIP: {$cnt_cxl} <BR>";
  //if ($cnt_cxl>0) {                         
  //  while($row_cxl = mysql_fetch_array($res_cxl)){
  //    $fv_no = $row_cxl['flw002'];
  //    $ar_cxlsle[$fv_no] = $fv_no;
  //  }
  //}
  sl_openef2k('EF2KWeb');
  $sql_flw = "select case 
                      when resda.resda019 != '' then CONVERT(char(8),convert(datetime, resda.resda019, 101), 112)
                    else '' end as sign_date, /*簽核日期 YYYYMMDD*/
                    case 
                      when resda.resda019 != '' then CONVERT(char(8),convert(datetime, resda.resda019, 101), 8)
                    else '' end as sign_time, /*簽核時間 HH:ii:ss*/
                    resda.resda020 as flw_status,
                    resda.resda021 as flw_res, /*簽核結果 resda021 -> 1=未完成, 2=同意, 3=不同意, 4=已抽單*/
                    resda.resda001 as flw_class, /*單別*/
                    resda.resda002 as flw_no, /*單號*/ 
                    resdd.resdd008 as sign_emp, /*最後一關簽核人員編*/
                    sleip2flw.sleip2flw900 as b_emp, /*建檔人*/
                    sleip2flw.sleip2flw004 as flw_type,
                    sleip2flw.sleip2flw010 as eip_no /* EIP單號 */
             from   resda
                    left join resdd on resda.resda001 = resdd.resdd001 
                                       and resda.resda002 = resdd.resdd002
                                       and resdd.resdd012 = (select max(rd2.resdd012)
                                                       from  resdd as rd2
                                                       where rd2.resdd001 = resda.resda001
                                                              and rd2.resdd002 = resda.resda002 )
                    left join sleip2flw on resda.resda001 = sleip2flw.sleip2flw001
                                           and resda.resda002 = sleip2flw.sleip2flw002
             where  resda.resda001 = 'SL-EIP2FLW'
                    and sleip2flw.sleip2flw004 = 'ewb01' 
                    and resda.resda020 in ('3','4')   
                    and CONVERT(char(8),convert(datetime, resda.resda901, 101), 112) >= '{$f_var['f_date_s']}'
                    and CONVERT(char(8),convert(datetime, resda.resda901, 101), 112) >= '20180701'
             ";
  $res_flw = mssql_query($sql_flw);
  $qty_flw = mssql_num_rows($res_flw);
  if($qty_flw > 0){
    while($row_flw = mssql_fetch_array($res_flw)){  
      $fv_no = $row_flw['flw_no'];
      $ar_signemp[$fv_no] = $row_flw['sign_emp'];
    }
  }
  
  
  sl_openhrmdb("HRMDB"); 
  //取得假勤類型ID
  $sql_tpe = "select AttendanceTypeId, Code, Name
              from   AttendanceType
             ";
  $res_tpe = mssql_query($sql_tpe);
  $qty_tpe = mssql_num_rows($res_tpe);
  if($qty_tpe > 0){
    while($row_tpe = mssql_fetch_array($res_tpe)){  
      $fv_code = $row_tpe['Code'];
      $ar_typeid[$fv_code] = trim($row_tpe['AttendanceTypeId']);
    }
  }
    
  $sql_rcd = "SELECT Employee.Code AS empno,
                     '701' AS attype,
                     CONVERT(char(8),convert(datetime, BusinessRegister.BeginDate, 101), 112) AS begindt,
                     CONVERT(char(8),convert(datetime, BusinessRegister.EndDate, 101), 112) AS enddt,
                     ISNULL(BusinessRegister.EssNo,'') as EssNo, 
                     ISNULL(BusinessRegister.EssType,'') as EssType, 
                     ISNULL(BusinessRegister.Remark,'') as Remark
              FROM   BusinessRegister
                     LEFT JOIN Employee on BusinessRegister.EmployeeId = Employee.EmployeeId
              WHERE  CONVERT(char(8),convert(datetime, BusinessRegister.CreateDate, 101), 112) >= '{$f_var['f_date_s']}'
                     AND CONVERT(char(8),convert(datetime, BusinessRegister.CreateDate, 101), 112) <= '{$f_var['f_date_e']}'
                     AND (( ISNULL(BusinessRegister.EssNo,'')<>'' AND BusinessRegister.EssType in ('SL-EIP2FLW') )
                           or BusinessRegister.Remark like 'SL-EIP2FLW-%' )
                     {$f_var['f_swhere_hrm']}
			        ORDER BY BusinessRegister.BeginDate             
             ";
  $res_rcd = mssql_query($sql_rcd);
  $qty_rcd = mssql_num_rows($res_rcd);    
  //echo "<pre>{$sql_rcd}</pre>";
  //echo "EIP: {$qty_rcd} <BR>";
  //echo "hrm cnt: ".$qty_rcd."<br>"; 
  if($qty_rcd > 0){  
    while($row_rcd = mssql_fetch_array($res_rcd)){
      $fd_essno = $row_rcd['EssNo'];
      $fd_esstype = $row_rcd['EssType'];
      if( ''==trim($row_rcd['EssNo']) ){
        
        $ex_mk = explode("-",trim($row_rcd['Remark']));
        //print_r($ex_mk);
        $fd_essno = $ex_mk[2]; 
        $fd_esstype = "SL-EIP2FLW"; 
      }
      $fv_empno = $row_rcd['empno'];
      $fv_attype = $row_rcd['attype'];
      $fv_begindt = $row_rcd['begindt'];
      $fv_essno = $fd_essno;
      $fv_esstype = $fd_esstype;
      $ar_hrm_rcd[$fv_empno][$fv_attype][$fv_essno] = $fv_essno; //[員編][假勤類別][簽核單號]
    }
  }
  //echo "<pre>";
  //print_r($ar_hrm_rcd);
  //echo "<pre>";
  //exit;
  //ul_flwaudit('0000474940','1230423','8665656','2');
  //exit;
  if($cnt_gwf>0){
    reset($ar_flw_rcd);
    while(list($key1,$value1)=each($ar_flw_rcd)) {
      reset($ar_flw_rcd[$key1]);
      while(list($key2,$value2)=each($ar_flw_rcd[$key1])) {
        reset($ar_flw_rcd[$key1][$key2]);
        while(list($key3,$value3)=each($ar_flw_rcd[$key1][$key2])) {
          //echo $key1."-".$key2."-".$key3."<br>";
          //$f_var['vhrm']['flw_status'][$fv_essno] = $row_flw['flw_status']; //1=未傳送,2=簽核中,3=已簽核,4=已抽單
          //$f_var['vhrm']['flw_res'][$fv_essno] = $row_flw['flw_res']; ///*1=未完成,2=同意,3=不同意,4=已抽單*/
          
      
          if( $ar_hrm_rcd[$key1][$key2][$key3]==null ){
            echo "<font color=red>".$key1."-".$key2."-".$key3."-".$f_var['vhrm']['flw_status'][$key3]."-".$f_var['vhrm']['flw_res'][$key3]."</font>\n";
            echo "<font color=blue>".$f_var['vhrm']['BeginDate'][$key3]." / ".$f_var['vhrm']['BeginTime'][$key3]." / ".$f_var['vhrm']['EndDate'][$key3]." / ".$f_var['vhrm']['EndTime'][$key3]."-".$f_var['vhrm']['snum'][$key3]."</font>\n";
            //echo "<font color=red>".$ar_flw_rcd[$key1][$key2][$key3]."</font><br>";
            $sql_at = "select REPLACE(EmployeeId,'-','') as 'newid'
                       from Employee
                       where  Code = '{$key1}'
                      ";   
            $res_at = mssql_query($sql_at);
            $qty_at = mssql_num_rows($res_at);
            if($qty_at > 0){
              while($row_at = mssql_fetch_array($res_at)){
                $vstr = $row_at["newid"];
                $f_var["newid"] = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
              }
            }  
            unset($f_var['hrmws']);
            $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
            $f_var['hrmws']['method'] = "CheckForESS";
            $f_var['hrmws']['parameterType'] = "";
            $f_var['hrmws']['parm'][1]['String'] = $f_var['vhrm']['EssType'][$key3]; //單別
            $f_var['hrmws']['parm'][2]['String'] = $f_var['vhrm']['EssNo'][$key3]; //單號
            $f_var['hrmws']['parm'][3]['Int32'] = 2; //登記類型(1.按申請登記、2.直接登記)
            $f_var['hrmws']['parm'][4]['String'] = ""; //出差申請id (如果直接登記為空值)
            $f_var['hrmws']['parm'][5]['String'] = $f_var["newid"]; //員工ID
            $f_var['hrmws']['parm'][6]['String'] = "701"; //出差類型id  A1136|出差(無伙食)   A1136|出差(無伙食)
            $fv_eb04 = str_replace("&","",$f_var['vhrm']['local'][$key3]);  //ws會gg
            $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($fv_eb04,'UTF-8','big5'); //出差地點
            $f_var['hrmws']['parm'][8]['DateTime'] = $f_var['vhrm']['BeginDate'][$key3]; //開始日期
            $f_var['hrmws']['parm'][9]['String'] = $f_var['vhrm']['BeginTime'][$key3]; //開始時間
            $f_var['hrmws']['parm'][10]['DateTime'] = $f_var['vhrm']['EndDate'][$key3]; //結束日期
            $f_var['hrmws']['parm'][11]['String'] = $f_var['vhrm']['EndTime'][$key3]; //結束時間
            $f_var['hrmws']['parm'][12]['Int32'] = "1"; //扣除休息班次
            //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //備註
            $f_var['hrmws']['parm'][13]['String'] = "-".$f_var['vhrm']['snum'][$key3]; //備註
            $f_var['hrmws']['parm'][14]['Int32'] = "1"; //扣除非在公司時間
            $f_var['hrmws']['parm'][15]['Int32'] = "1"; //扣除休息班次?加班就餐段（0否，1是）
            sl_hrmws($f_var);   
            if( '0'==$f_var['hrmws']['status'] ){ //驗證成功  非0為失敗
              $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
              $f_var['hrmws']['method'] = "SaveForESS";
              $f_var['hrmws']['parameterType'] = "";
              $fv_eb05 = str_replace("&","",$f_var['vhrm']['Remark'][$key3]);  //ws會gg
              $f_var['hrmws']['parm'][16]['String'] = mb_convert_encoding($fv_eb05,'UTF-8','big5'); //出差原因
              $f_var['hrmws']['parm'][17]['Int32'] = "1"; //扣除休息班次內加班就餐段
              sl_hrmws($f_var);
              if( '0'==$f_var['hrmws']['status'] ){
                $sql_upd = "update docs.ewb01
                            set    ws_res = '1',
                                   ws_id = '{$f_var['hrmws']['rtn'][1]}'
                            where  s_num = '{$f_var['vhrm']['snum'][$key3]}' ";
                mysql_query($sql_upd); 
                if( '3'==$f_var['vhrm']['flw_status'][$key3] ){ //已簽核
                  ul_flwaudit($f_var['vhrm']['EssNo'][$key3],$key1,$ar_signemp[$key3],$f_var['vhrm']['flw_res'][$key3]);   //單號,建檔人員編,最後簽核人,簽核結果
                }
                
              }else{
                $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
                $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
                echo "Error!! 回寫ng, {$fd_inLog}";
              }
            }else{
              $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
              $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
              echo "Error!! 驗證ng, {$fd_inLog}";
            }
          }
          
        }
      }
    }
  }



  //echo "<pre>";
  //print_r($ar_flw_rcd);
  //echo "<pre>";
  
  

  //------------------------------------------------------------------
  //函數名稱: u_getEmployeeId()
  //函數說明: 取得員工ID
  //------------------------------------------------------------------
  function u_getEmployeeId($vcode){
    $fd_wsid = '';
    sl_openhrmdb("HRMDB");
    $sql_hrm = "select REPLACE(Employee.EmployeeId,'-','') as vid
                from   Employee
                where  Code = '{$vcode}'
               ";
    $res_hrm = mssql_query($sql_hrm);
    $qty_hrm = mssql_num_rows($res_hrm);
    if($qty_hrm > 0){
      while($row_hrm = mssql_fetch_array($res_hrm)){  
        $vstr = trim($row_hrm['vid']); 
        $fd_wsid = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
      }
    }
    return $fd_wsid;
  }
  //------------------------------------------------------------------
  //函數名稱: u_getFiscalYearId()
  //函數說明: 取得財年id
  //------------------------------------------------------------------
  function u_getFiscalYearId($vempid,$vdate){  //員工ID,請假開始日期(Y-m-d)
    $fd_wsid = "";
    $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IAttendanceLeaveService,Dcms.HR.Business.AttendanceLeave "; 
    $f_var['hrmws']['method'] = "XGetHRUsefullDatas";
    $f_var['hrmws']['parameterType'] = "";
    $f_var['hrmws']['parm'][1]['String'] = 'attendanceleave_fiscalyear1'; 
    $f_var['hrmws']['parm'][2]['String'] = strtolower($vempid).",{$vdate}"; 
    $f_var['hrmws']['parm'][3]['String'] = "";
    $f_var['hrmws']['parm'][4]['String'] = "";
    sl_hrmws($f_var);
    if( '0'==$f_var['hrmws']['status'] ){ //驗證成功  非0為失敗
      $fd_wsid = $f_var['hrmws']['rtn'][0];
      if( ''!=$fd_wsid ){
        return $fd_wsid;
      }
    }
    return;
  }
  
  //------------------------------------------------------------------
  //函數名稱: ul_flwaudit()
  //函數說明: 審核
  //------------------------------------------------------------------
  function ul_flwaudit($essno,$bemp,$signemp,$signres){ //單號,建檔人員編,最後簽核人,簽核結果
    $sql_hrm = "select REPLACE(BusinessRegister.BusinessRegisterId,'-','') as vid,
                       REPLACE(Employee.EmployeeId,'-','') as empid
                from   BusinessRegister
                       left join BusinessRegisterInfo on BusinessRegister.BusinessRegisterId = BusinessRegisterInfo.BusinessRegisterId
                       left join Employee on BusinessRegister.EmployeeId = Employee.EmployeeId
                where  Employee.Code = '{$bemp}' 
					             and BusinessRegister.Remark like 'SL-EIP2FLW-{$essno}%'            
                       and BusinessRegisterInfo.IsRevoke='0' /*未申請銷假資料*/
                       and ISNULL(CONVERT(varchar(100), BusinessRegister.ApproveDate, 112),'') = ''  /*審核日期未註記*/
               ";
    //echo "<pre>{$sql_hrm}</pre>";   
    $res_hrm = mssql_query($sql_hrm);
    $qty_hrm = mssql_num_rows($res_hrm);
    if($qty_hrm > 0){
      while($row_hrm = mssql_fetch_array($res_hrm)){  
        $vstr = trim($row_hrm['vid']); //最後一關簽核人員員編
        $fd_wsid = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
        $vstr = trim($row_hrm['empid']);
        $fd_empid = substr($vstr,0,8)."-".substr($vstr,8,4)."-".substr($vstr,12,4)."-".substr($vstr,16,4)."-".substr($vstr,20);
      }
    }
    $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
    $f_var['hrmws']['method'] = "AuditForESS";
    $f_var['hrmws']['parameterType'] = "";
    $f_var['hrmws']['parm'][1]['String'] = 'ESSF21'; 
    $f_var['hrmws']['parm'][2]['String'] = $essno; 
    $f_var['hrmws']['parm'][3]['String'] = $fd_wsid; //出差登記id
    $f_var['hrmws']['parm'][4]['String'] = "";
    $f_var['hrmws']['parm'][5]['String'] = $signemp; 
    if( '3'==$signres ){ //1=未完成, 2=同意, 3=不同意, 4=已抽單
      $f_var['hrmws']['parm'][6]['Int32'] = "0";  //不同意
      $fd_flwres = "不同意";
    }else if( '2'==$signres ){
      $f_var['hrmws']['parm'][6]['Int32'] = "1";  
      $fd_flwres = "同意"; 
    }
    sl_hrmws($f_var);
    if( '0'!=$f_var['hrmws']['status'] ){ //驗證成功  非0為失敗
      //echo "<pre>";
      //print_r($f_var['hrmws']);
      //echo "</pre>";
      $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
      $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
      echo "Error!! 回寫審核紀錄ng, {$fd_inLog}";    
    }else{
      $vb_date  = date("Y-m-d H:i:s");
      $vproc    = u_showproc(); // 程式代號
      sl_open('docs'); 
      $f_var['log_yf'] .= "外出白板(出差登記), WS 審核成功。\n";
      $sql_upd = "update docs.ewb01
                  set    ws_res = '2',
                         m_proc = '{$vproc}',
                         m_date = '{$vb_date}'      
                  where  UPPER(ws_id) = '{$fd_wsid}'
             ";
      if(!mysql_query($sql_upd)){
        echo "Error!! 回寫審核紀錄ng一(EIP), {$sql_upd}";    
      }
    }
  }
?>
#!/usr/local/php/bin/php
<?php
  //jck_ewb_hrm
  //���g���: 2018.11.22
  //����: ���o�{�ϥΪ̵n���~�X���,���s�Jeip����qñ,���O�S��call ws��hrm��
  include_once('/home/sl/public_html/sl_init.php');
  sl_open('sl');
  $vdate = date("Y-m-d H:i:s");
  //add by �Ϊ� 2018.12.05 �̸�T����/�v���޲z/���s����ɶ�����]�w 
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
    } //���u����ӽСB���u���ݥ[�h�O                                            
  }
  
  $f_var['f_date_s'] = date("Ymd",strtotime( date("Ymd")." -60 day" )); 
  $f_var['f_date_e'] = date("Ymd"); 
  //$f_var['in_emp'] = "'9169113'";
  //$f_var['in_emp'] = "'7866887','1731039','1430889','1130209','0970102'";
  //echo u_getFiscalYearId("FF93C277-4658-4480-8334-6886B4B07982","2018-11-07");
  //�~�X���
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
                     sleip2flw.resda020 as flw_status,  /*1=���ǰe,2=ñ�֤�,3=�wñ��,4=�w���*/
                     sleip2flw.resda021 as flw_res,     /*1=������,2=�P�N,3=���P�N,4=�w���*/
                     'SL-EIP2FLW' as flw_class, /*��O*/
                     sleip2flw.sleip2flw002 as flw_no, /*�渹*/ 
                     '' as sign_emp /*�̫�@��ñ�֤H���s*/
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
      $ar_flw_rcd[$fv_empno][$fv_attype][$fv_essno] = $fv_essno; //[���s][�������O][ñ�ֳ渹]
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
      $f_var['vhrm']['flw_status'][$fv_essno] = $row_gwf['flw_status']; //1=���ǰe,2=ñ�֤�,3=�wñ��,4=�w���
      $f_var['vhrm']['flw_res'][$fv_essno] = $row_gwf['flw_res']; ///*1=������,2=�P�N,3=���P�N,4=�w���*/
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
                    else '' end as sign_date, /*ñ�֤�� YYYYMMDD*/
                    case 
                      when resda.resda019 != '' then CONVERT(char(8),convert(datetime, resda.resda019, 101), 8)
                    else '' end as sign_time, /*ñ�֮ɶ� HH:ii:ss*/
                    resda.resda020 as flw_status,
                    resda.resda021 as flw_res, /*ñ�ֵ��G resda021 -> 1=������, 2=�P�N, 3=���P�N, 4=�w���*/
                    resda.resda001 as flw_class, /*��O*/
                    resda.resda002 as flw_no, /*�渹*/ 
                    resdd.resdd008 as sign_emp, /*�̫�@��ñ�֤H���s*/
                    sleip2flw.sleip2flw900 as b_emp, /*���ɤH*/
                    sleip2flw.sleip2flw004 as flw_type,
                    sleip2flw.sleip2flw010 as eip_no /* EIP�渹 */
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
  //���o��������ID
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
      $ar_hrm_rcd[$fv_empno][$fv_attype][$fv_essno] = $fv_essno; //[���s][�������O][ñ�ֳ渹]
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
          //$f_var['vhrm']['flw_status'][$fv_essno] = $row_flw['flw_status']; //1=���ǰe,2=ñ�֤�,3=�wñ��,4=�w���
          //$f_var['vhrm']['flw_res'][$fv_essno] = $row_flw['flw_res']; ///*1=������,2=�P�N,3=���P�N,4=�w���*/
          
      
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
            $f_var['hrmws']['parm'][1]['String'] = $f_var['vhrm']['EssType'][$key3]; //��O
            $f_var['hrmws']['parm'][2]['String'] = $f_var['vhrm']['EssNo'][$key3]; //�渹
            $f_var['hrmws']['parm'][3]['Int32'] = 2; //�n�O����(1.���ӽеn�O�B2.�����n�O)
            $f_var['hrmws']['parm'][4]['String'] = ""; //�X�t�ӽ�id (�p�G�����n�O���ŭ�)
            $f_var['hrmws']['parm'][5]['String'] = $f_var["newid"]; //���uID
            $f_var['hrmws']['parm'][6]['String'] = "701"; //�X�t����id  A1136|�X�t(�L�뭹)   A1136|�X�t(�L�뭹)
            $fv_eb04 = str_replace("&","",$f_var['vhrm']['local'][$key3]);  //ws�|gg
            $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($fv_eb04,'UTF-8','big5'); //�X�t�a�I
            $f_var['hrmws']['parm'][8]['DateTime'] = $f_var['vhrm']['BeginDate'][$key3]; //�}�l���
            $f_var['hrmws']['parm'][9]['String'] = $f_var['vhrm']['BeginTime'][$key3]; //�}�l�ɶ�
            $f_var['hrmws']['parm'][10]['DateTime'] = $f_var['vhrm']['EndDate'][$key3]; //�������
            $f_var['hrmws']['parm'][11]['String'] = $f_var['vhrm']['EndTime'][$key3]; //�����ɶ�
            $f_var['hrmws']['parm'][12]['Int32'] = "1"; //�����𮧯Z��
            //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //�Ƶ�
            $f_var['hrmws']['parm'][13]['String'] = "-".$f_var['vhrm']['snum'][$key3]; //�Ƶ�
            $f_var['hrmws']['parm'][14]['Int32'] = "1"; //�����D�b���q�ɶ�
            $f_var['hrmws']['parm'][15]['Int32'] = "1"; //�����𮧯Z��?�[�Z�N�\�q�]0�_�A1�O�^
            sl_hrmws($f_var);   
            if( '0'==$f_var['hrmws']['status'] ){ //���Ҧ��\  �D0������
              $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
              $f_var['hrmws']['method'] = "SaveForESS";
              $f_var['hrmws']['parameterType'] = "";
              $fv_eb05 = str_replace("&","",$f_var['vhrm']['Remark'][$key3]);  //ws�|gg
              $f_var['hrmws']['parm'][16]['String'] = mb_convert_encoding($fv_eb05,'UTF-8','big5'); //�X�t��]
              $f_var['hrmws']['parm'][17]['Int32'] = "1"; //�����𮧯Z�����[�Z�N�\�q
              sl_hrmws($f_var);
              if( '0'==$f_var['hrmws']['status'] ){
                $sql_upd = "update docs.ewb01
                            set    ws_res = '1',
                                   ws_id = '{$f_var['hrmws']['rtn'][1]}'
                            where  s_num = '{$f_var['vhrm']['snum'][$key3]}' ";
                mysql_query($sql_upd); 
                if( '3'==$f_var['vhrm']['flw_status'][$key3] ){ //�wñ��
                  ul_flwaudit($f_var['vhrm']['EssNo'][$key3],$key1,$ar_signemp[$key3],$f_var['vhrm']['flw_res'][$key3]);   //�渹,���ɤH���s,�̫�ñ�֤H,ñ�ֵ��G
                }
                
              }else{
                $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
                $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
                echo "Error!! �^�gng, {$fd_inLog}";
              }
            }else{
              $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
              $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
              echo "Error!! ����ng, {$fd_inLog}";
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
  //��ƦW��: u_getEmployeeId()
  //��ƻ���: ���o���uID
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
  //��ƦW��: u_getFiscalYearId()
  //��ƻ���: ���o�]�~id
  //------------------------------------------------------------------
  function u_getFiscalYearId($vempid,$vdate){  //���uID,�а��}�l���(Y-m-d)
    $fd_wsid = "";
    $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IAttendanceLeaveService,Dcms.HR.Business.AttendanceLeave "; 
    $f_var['hrmws']['method'] = "XGetHRUsefullDatas";
    $f_var['hrmws']['parameterType'] = "";
    $f_var['hrmws']['parm'][1]['String'] = 'attendanceleave_fiscalyear1'; 
    $f_var['hrmws']['parm'][2]['String'] = strtolower($vempid).",{$vdate}"; 
    $f_var['hrmws']['parm'][3]['String'] = "";
    $f_var['hrmws']['parm'][4]['String'] = "";
    sl_hrmws($f_var);
    if( '0'==$f_var['hrmws']['status'] ){ //���Ҧ��\  �D0������
      $fd_wsid = $f_var['hrmws']['rtn'][0];
      if( ''!=$fd_wsid ){
        return $fd_wsid;
      }
    }
    return;
  }
  
  //------------------------------------------------------------------
  //��ƦW��: ul_flwaudit()
  //��ƻ���: �f��
  //------------------------------------------------------------------
  function ul_flwaudit($essno,$bemp,$signemp,$signres){ //�渹,���ɤH���s,�̫�ñ�֤H,ñ�ֵ��G
    $sql_hrm = "select REPLACE(BusinessRegister.BusinessRegisterId,'-','') as vid,
                       REPLACE(Employee.EmployeeId,'-','') as empid
                from   BusinessRegister
                       left join BusinessRegisterInfo on BusinessRegister.BusinessRegisterId = BusinessRegisterInfo.BusinessRegisterId
                       left join Employee on BusinessRegister.EmployeeId = Employee.EmployeeId
                where  Employee.Code = '{$bemp}' 
					             and BusinessRegister.Remark like 'SL-EIP2FLW-{$essno}%'            
                       and BusinessRegisterInfo.IsRevoke='0' /*���ӽоP�����*/
                       and ISNULL(CONVERT(varchar(100), BusinessRegister.ApproveDate, 112),'') = ''  /*�f�֤�������O*/
               ";
    //echo "<pre>{$sql_hrm}</pre>";   
    $res_hrm = mssql_query($sql_hrm);
    $qty_hrm = mssql_num_rows($res_hrm);
    if($qty_hrm > 0){
      while($row_hrm = mssql_fetch_array($res_hrm)){  
        $vstr = trim($row_hrm['vid']); //�̫�@��ñ�֤H�����s
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
    $f_var['hrmws']['parm'][3]['String'] = $fd_wsid; //�X�t�n�Oid
    $f_var['hrmws']['parm'][4]['String'] = "";
    $f_var['hrmws']['parm'][5]['String'] = $signemp; 
    if( '3'==$signres ){ //1=������, 2=�P�N, 3=���P�N, 4=�w���
      $f_var['hrmws']['parm'][6]['Int32'] = "0";  //���P�N
      $fd_flwres = "���P�N";
    }else if( '2'==$signres ){
      $f_var['hrmws']['parm'][6]['Int32'] = "1";  
      $fd_flwres = "�P�N"; 
    }
    sl_hrmws($f_var);
    if( '0'!=$f_var['hrmws']['status'] ){ //���Ҧ��\  �D0������
      //echo "<pre>";
      //print_r($f_var['hrmws']);
      //echo "</pre>";
      $fd_inLog = "status: ".$f_var['hrmws']['status']."<br>";
      $fd_inLog .= "rtn: ".$f_var['hrmws']['error']."<br>";
      echo "Error!! �^�g�f�֬���ng, {$fd_inLog}";    
    }else{
      $vb_date  = date("Y-m-d H:i:s");
      $vproc    = u_showproc(); // �{���N��
      sl_open('docs'); 
      $f_var['log_yf'] .= "�~�X�ժO(�X�t�n�O), WS �f�֦��\�C\n";
      $sql_upd = "update docs.ewb01
                  set    ws_res = '2',
                         m_proc = '{$vproc}',
                         m_date = '{$vb_date}'      
                  where  UPPER(ws_id) = '{$fd_wsid}'
             ";
      if(!mysql_query($sql_upd)){
        echo "Error!! �^�g�f�֬���ng�@(EIP), {$sql_upd}";    
      }
    }
  }
?>
<?php
  include_once('/home/sl/public_html/sl_init.php');  // �@�Φۭq��ƻP�ܼƳ]�w
    
  session_start();  //upd by mimi 2009.04.23 �O���~�X�ժO�d�߱���
  include_once( u_showproc().'_init.php');  // �����ﵽ�@�Φۭq��ƻP�ܼƳ]�w
  include_once( "ewb_pay_init.php"  );

  $f_var['eb09_value'] = array('--'        ,'01.���Ȩ�','02.�p������','03.�����q�ɧU�ʨ�-����-���q��I','04.�����q�ɧU�ʨ�-����-�ۦ��I','05.�j����q�u��','06.���Ȩ�(�֨��f��-���ɨ�)','07.�p������(�֨��f��-���л�o�K)','99.��L');
  $f_var['eb09_show']  = array('--�п��--','���Ȩ�'   ,'�p������'   ,'�����q�ɧU�ʨ�-����-���q��I'   ,'�����q�ɧU�ʨ�-����-�ۦ��I'   ,'�j����q�u��','���Ȩ�(�֨��f��-���ɨ�)','�p������(�֨��f��-���л�o�K)','��L');  //upd by �Ϊ� 2014.07.16  (����-24009)�W�[04.�����q�ɧU�ʨ�-����-�ۦ��I
  $f_var['eb09'] = array('value'=> $f_var['eb09_value']  ,'show'=> $f_var['eb09_show'] );
 
  $f_var['eb10_value'] = array('--'        ,'01.1300 CC�H�U','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC�H�W','06.������');
  $f_var['eb10_show']  = array('--�п��--','01.1300 CC�H�U','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC�H�W','06.������');
  $f_var['eb10'] = array('value'=> $f_var['eb10_value']  ,'show'=> $f_var['eb10_show']);

  u_setvar(&$f_var);   
  u_domain(&$f_var);  //�v�� ewb_pay_init.php
  include_once($sl_header_php); // header
  
  include_once(  $mtp_url."class.TemplatePower.inc.php"  ); //qq: $sl_tp_url ?
  $f_var["tp"] = new  TemplatePower (  $f_var['tpl']  );//'pa01.tpl';  // �˪��e����
  $f_var["tp"]-> assignInclude ("tb_sl_tpl_1","/home/sl/public_html/sl_tpl_1.tpl"      ); // �@�μ˪O��
  $f_var["tp"]-> prepare ();
  
  switch ($f_var['msel']) {
    case '1':
         break;
    case '11':
         break;
  
    default:
         break;
  }

  u_in_scr($f_var);
  
  $f_var["tp"]-> printToScreen ();
  include_once($sl_footer_php); // footer
  

  
  function u_in_scr($f_var){
    $fd_dept = $_SESSION["login_hrm_dept_name"];
    $fd_name = $_SESSION["login_name"];
    $fd_empno = $_SESSION["login_empno"];
    $ar_mgr = sl_getboss($_SESSION["login_empno"],1);
    $fd_mgr = $ar_mgr[1]['name'];

    sl_openhrmdb("HRMDB");
    $sql_hrm = "SELECT CONVERT(varchar(100), AttendanceEmpRank.Date, 112) AS WorkDate,
                       AttendanceRank.WorkBeginTime,
                       AttendanceRank.WorkEndTime
                FROM   Employee
                       LEFT JOIN AttendanceEmpRank ON Employee.EmployeeId = AttendanceEmpRank.EmployeeId
                       LEFT JOIN AttendanceRank ON AttendanceEmpRank.AttendanceRankId = AttendanceRank.AttendanceRankId
                WHERE  Employee.Code = '{$fd_empno}'
                       AND CONVERT(varchar(100), AttendanceEmpRank.Date, 112) = '".date('Ymd')."'
               ";     
    $res_hrm = mssql_query($sql_hrm);
    $qty_hrm = mssql_num_rows($res_hrm);
    if($qty_hrm > 0){
      $row_hrm = mssql_fetch_array($res_hrm);
      $fd_time_s = $row_hrm['WorkBeginTime'];
      $fd_time_e = $row_hrm['WorkEndTime'];
    }

    $fd_tohrm_memo = "(�Y��ܬ��y�O�z�A�~�X�ժO���N�X�Ԭ���)";
    
    $f_var["field"]['column']   =array('0'         ,'2'          ,'2'          ,'2'          ,'2'          ,'1'                  );
    $f_var["field"]['ename']    =array('�s�W'      ,'�����W��'   ,'���ݥD��'   ,'�P���m�W'   ,'�P�����s'   ,'�X�h����JHR(���s)' );
    $f_var["field"]['cname']    =array(''          ,'f_dept'     ,'f_mgr'      ,'f_eb01'     ,'f_eb18'     ,'f_tohrm'             );
    $f_var["field"]['type']     =array(''          ,'text'       ,'text'       ,'text'       ,'text'       ,'radio'              );
    $f_var["field"]['value']    =array(''          ,$fd_dept     ,$fd_mgr      ,$fd_name     ,$fd_empno    ,''                   );
    $f_var["field"]['size']     =array(''          ,'35'         ,'10'         ,'10'         ,'10'         ,''                   );
    $f_var["field"]['maxlength']=array(''          ,'50'         ,'15'         ,'15'         ,'10'         ,''                   );
    $f_var["field"]['chg']      =array(''          ,''           ,''           ,''           ,''           ,''                   );
	$f_var["field"]['color']    =array(''          ,''           ,''           ,''           ,''           ,''                   );
    $f_var["field"]['ary']      =array(''          ,''           ,''           ,''           ,''           ,''                   );
    $f_var["field"]['memo']     =array(''          ,''           ,''           ,''           ,''           ,$fd_tohrm_memo);
    $f_var["field"]['class']    =array(''          ,'field_color','field_color','field_color','field_color',''                   );
    $f_var["field"]['readonly'] =array(''          ,'readonly'   ,'readonly'   ,'readonly'   ,'readonly'   ,''                   );
    $f_var["field"]['save']     =array(''          ,''           ,''           ,''           ,''           ,''                   );
    
    array_push( $f_var["field"]['column']   ,'2'          ,'2'       ,'1'       ,'2'       ,'2'       ,'1'       ,'1'       );
    array_push( $f_var["field"]['ename']    ,'�~�X���'   ,'�~�X�ɶ�','�~�X�a�I','�^�{���','�^�{�ɶ�','�^�{�a�I','�e���ƥ�');
    array_push( $f_var["field"]['cname']    ,'f_eb02'     ,'f_eb03'  ,'f_eb04'  ,'f_eb06'  ,'f_eb07'  ,'f_eb04'  ,'f_eb05'  );
    array_push( $f_var["field"]['type']     ,'date'       ,'time'    ,'text'    ,'date'    ,'time'    ,'text'    ,'text'    );
    array_push( $f_var["field"]['value']    ,''           ,$fd_time_s,''        ,''        ,$fd_time_e,''        ,''        );
    array_push( $f_var["field"]['size']     ,'10'         ,'10'      ,'35'      ,'10'      ,'10'      ,'35'      ,'50'      );
    array_push( $f_var["field"]['maxlength'],'10'         ,'10'      ,'50'      ,'10'      ,'10'      ,'50'      ,'100'     );
    array_push( $f_var["field"]['chg']      ,''           ,''        ,''        ,''        ,''        ,''        ,''        );
	array_push( $f_var["field"]['color']    ,'#F4EAC6'    ,'#F4EAC6' ,''        ,'#F4EAC6' ,'#F4EAC6' ,''        ,''        );
    array_push( $f_var["field"]['ary']      ,''           ,''        ,''        ,''        ,''        ,''        ,''        );
    array_push( $f_var["field"]['memo']     ,'(�褸�~���)' ,'(�ɤ�)'    ,''        ,'(�褸�~���)'        ,''        ,''        ,''        );
    array_push( $f_var["field"]['class']    ,''           ,''        ,''        ,''        ,''        ,''        ,''        );
    array_push( $f_var["field"]['readonly'] ,''           ,''        ,''        ,''        ,''        ,''        ,''        );
    array_push( $f_var["field"]['save']     ,''           ,''        ,''        ,''        ,''        ,''        ,''        );

    $fd_eb10_memo = "(�p�����ΡB�����q�ɧU�ʨ��A�Ʈ�q������)";
    array_push( $f_var["field"]['column']   ,'2'          ,'2'          ,'1'       ,'1'       );
    array_push( $f_var["field"]['ename']    ,'����'       ,'�Ʈ�q'     ,'�����H��','�Ƶ�'    );
    array_push( $f_var["field"]['cname']    ,'f_eb09'     ,'f_eb10'     ,'f_eb15'  ,'f_eb08'  );
    array_push( $f_var["field"]['type']     ,'select'     ,'select'       ,'text'    ,'text'    );
    array_push( $f_var["field"]['value']    ,''           ,''           ,''        ,''        );
    array_push( $f_var["field"]['size']     ,'0'         ,'0'         ,'7'       ,'50'      );
    array_push( $f_var["field"]['maxlength'],'0'         ,'0'         ,'10'      ,'100'      );
    array_push( $f_var["field"]['chg']      ,''           ,''           ,''        ,''        );
	array_push( $f_var["field"]['color']    ,''           ,''           ,''        ,''        );
    array_push( $f_var["field"]['ary']      ,$f_var['eb09'],$f_var['eb10'],''        ,''        );
    array_push( $f_var["field"]['memo']     ,''           ,$fd_eb10_memo,''        ,'(�i��J�p���q��)'        );
	array_push( $f_var["field"]['class']    ,''           ,''           ,''        ,''        );
    array_push( $f_var["field"]['readonly'] ,''           ,''           ,''        ,''        );
    array_push( $f_var["field"]['save']     ,''           ,''           ,''        ,''        );
    
    $fd_eb24_memo = "(�̤��i16033�q�ԩ���ե��a�o�O�ɧU:�̹�ک��𨽵{��30�����[�p�q��O)";
    $fd_eb08_memo = "(<a href='http://fare.fetc.net.tw/Custom.aspx' target='_blank'>�p�{�q��O�պ�</a>)";
    array_push( $f_var["field"]['column']   ,'0'         ,'1'                   ,'2'          ,'2'          ,'1'          ,'1'                 );
    array_push( $f_var["field"]['ename']    ,'�ӽЪo�K'  ,'����ե��a����30����','�X�t������' ,'�J�t������' ,'���{��'     ,'���t�����q��O'    );
    array_push( $f_var["field"]['cname']    ,''          ,'f_eb24'              ,'f_eb11'     ,'f_eb12'     ,'f_eb13'     ,'f_eb08'  );
    array_push( $f_var["field"]['type']     ,''          ,'radio'               ,'text'       ,'text'       ,'text'       ,'text'    );
    array_push( $f_var["field"]['value']    ,''          ,''                    ,''           ,''           ,''           ,''        );
    array_push( $f_var["field"]['size']     ,''          ,''                    ,'7'          ,'7'          ,'7'      ,   '7'      );
    array_push( $f_var["field"]['maxlength'],''          ,''                    ,'10'         ,'10'         ,'10'         ,'10'      );
    array_push( $f_var["field"]['chg']      ,''          ,''                    ,''           ,''           ,''           ,''        );
	array_push( $f_var["field"]['color']    ,''          ,''                    ,''           ,''           ,''           ,''        );
    array_push( $f_var["field"]['ary']      ,''          ,''                    ,''           ,''           ,''           ,''        );
    array_push( $f_var["field"]['memo']     ,''          ,$fd_eb24_memo         ,''           ,''           ,''           ,$fd_eb08_memo );
    array_push( $f_var["field"]['class']    ,''          ,''                    ,''           ,''           ,'field_color',''        );
    array_push( $f_var["field"]['readonly'] ,''          ,''                    ,''           ,''           ,'readonly'   ,''        );
    array_push( $f_var["field"]['save']     ,''          ,''                    ,''           ,''           ,''           ,''        );


    $f_var["tp"]-> newBlock ( "tb_inscr" );
    for( $i=0; $i<count($f_var["field"]['ename']);  ){
      $f_var["tp"]-> newBlock ( "tb_inscr_tr" );
      switch($f_var["field"]['column'][$i]){
        case '1':
             $f_var["tp"]-> newBlock ( "tb_inscr_single" );
             $f_var["tp"]-> assign   ("tv_color"      , $f_var["field"]['color'][$i] );   
             $f_var["tp"]-> assign   ("tv_field_name" , $f_var["field"]['ename'][$i] );  
             $f_var["tp"]-> assign   ("tv_memo"       , $f_var["field"]['memo'][$i] );   
             $f_var["tp"]-> newBlock ( "tb_inscr_single_".$f_var["field"]['type'][$i] );
			 switch($f_var["field"]['type'][$i]){
			    case 'text':
                case 'date':
                case 'time':
                case 'radio':
                     $f_var["tp"]-> assign   ("tv_name"       , $f_var["field"]['cname'][$i] );
                     $f_var["tp"]-> assign   ("tv_id"         , $f_var["field"]['cname'][$i] );
                     $f_var["tp"]-> assign   ("tv_type"       , $f_var["field"]['type'][$i] );   
                     $f_var["tp"]-> assign   ("tv_value"      , $f_var["field"]['value'][$i] ); 
                     $f_var["tp"]-> assign   ("tv_size"       , $f_var["field"]['size'][$i] );   
                     $f_var["tp"]-> assign   ("tv_onchange"   , $f_var["field"]['chg'][$i] ); 
                     $f_var["tp"]-> assign   ("tv_class"      , $f_var["field"]['class'][$i] );   
                     $f_var["tp"]-> assign   ("tv_readonly"      , $f_var["field"]['readonly'][$i] );   
                     break;
                case 'select':
                     $f_var["tp"]-> newBlock ("tb_inscr_single_select"              );
                     $f_var["tp"]-> assign   ("tv_name"       , $f_var["field"]['cname'][$i] );
                     $f_var["tp"]-> assign   ("tv_size"       , $f_var["field"]['size'][$i] );   
                     while(list($mvalue)=each($f_var['eb09']['value'])) {
                       $f_var["tp"]-> newBlock ("tb_inscr_single_option"                  ); // option
                if($f_var['ep03']['value'][$mvalue]==''){        
                  $f_var["tp"]-> assign   ("tv_value"   , $f_var['eb09']['value'][$mvalue]  );
                  $f_var["tp"]-> assign   ("tv_show"    , $f_var['eb09']['show'][$mvalue]   );
                  if( $f_var['depts_limit']<>'' ){
                    $f_var["tp"]-> newBlock ("tv_option_hr"                  ); // option               
                    $f_var["tp"]-> assign   ("tv_value"   , "00" );
                    $f_var["tp"]-> assign   ("tv_show"    , "����" );  
                  }   

                }else{
                  $f_var["tp"]-> assign   ("tv_value"   , $f_var['ep03']['value'][$mvalue]  );
                  $f_var["tp"]-> assign   ("tv_show"    , $f_var['ep03']['show'][$mvalue]   );
                }
              }  
                    break;

			 }

                  
             $i++; 
             break;
        case '2':
             $f_var["tp"]-> newBlock ( "tb_inscr_double" );  
             for($j=$i; $j<($i+2); $j++){  
               $f_var["tp"]-> newBlock ( "tb_inscr_double_td" );
               $f_var["tp"]-> newBlock ( "tb_inscr_double_".$f_var["field"]['type'][$j] );
               switch($f_var["field"]['type'][$i]){
			     case 'text':
                 case 'date':
                 case 'time':
                 case 'radio':
			          $f_var["tp"]-> assign   ("tv_color"      , $f_var["field"]['color'][$j] );  
                      $f_var["tp"]-> assign   ("tv_field_name" , $f_var["field"]['ename'][$j] );  
                      $f_var["tp"]-> assign   ("tv_name"       , $f_var["field"]['cname'][$j] );
                      $f_var["tp"]-> assign   ("tv_id"         , $f_var["field"]['cname'][$j] );
                      $f_var["tp"]-> assign   ("tv_type"       , $f_var["field"]['type'][$j] );   
                      $f_var["tp"]-> assign   ("tv_value"      , $f_var["field"]['value'][$j] ); 
                      $f_var["tp"]-> assign   ("tv_size"       , $f_var["field"]['size'][$j] );  
                      $f_var["tp"]-> assign   ("tv_onchange"   , $f_var["field"]['chg'][$j] );  
                      $f_var["tp"]-> assign   ("tv_class"      , $f_var["field"]['class'][$j] );   
                      $f_var["tp"]-> assign   ("tv_memo"       , $f_var["field"]['memo'][$j] );
                      $f_var["tp"]-> assign   ("tv_readonly"   , $f_var["field"]['readonly'][$j] );   
                      break;
                 case 'select':
                      $f_var["tp"]-> assign   ("tv_color"      , $f_var["field"]['color'][$j] );  
                      $f_var["tp"]-> assign   ("tv_field_name" , $f_var["field"]['ename'][$j] ); 
                      $f_var["tp"]-> assign   ("tv_name"       , $f_var["field"]['cname'][$j] );
                      $f_var["tp"]-> assign   ("tv_size"       , $f_var["field"]['size'][$j] );  
                      $f_var["tp"]-> assign   ("tv_readonly"   , $f_var["field"]['readonly'][$j] );   
                      while(list($mvalue)=each($f_var["field"]['ary'][$j])) {
                        $f_var["tp"]-> newBlock ( "tb_inscr_double_option" ); 
                        $f_var["tp"]-> assign   ("tv_value"   , $f_var["field"]['ary'][$j]['value'][$mvalue]  );
                        $f_var["tp"]-> assign   ("tv_show"    , $f_var["field"]['ary'][$j]['show'][$mvalue]   );
                      }
                      break;
                 default:
                      break;
               }
             }
             
             $i=$i+2; 
             break;
        default:
             $f_var["tp"]-> newBlock ( "tb_inscr_sep" );
             $f_var["tp"]-> assign   ( "tv_title"      , $f_var["field"]['ename'][$i] );  
             $i++; 
             break;      
      }
      //$i++; 
    } 
    
    
    
    
  
    return;
  }
?>
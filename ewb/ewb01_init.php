<?
  //�z�w�w�w�w�w�w�w�w�w�w�s�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�{
  //�x�t�ΦW��: �xEWB01   �~�X�q�l�ժO�{����                                    �x
  //�x�{���W��: �xewb01_init.php     �ۭq��ƻP�ܼƳ]�w                         �x
  //�x�{������: �x�ۦ�}�o����ơA�H���ܼƳ]�w                                  �x
  //�x          �x                                                              �x
  //�x�{���]�p: �x�f�Yޱ                                                        �x
  //�x�]�p���: �x2008.01.30                                                    �x
  //�x�{���ק�: �x                                                              �x
  //�x�ק���: �x                                                              �x
  //�|�w�w�w�w�w�w�w�w�w�w�r�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�}
  //�z�w�w�w�w�w�w�w�w�w�w�s�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�{
  //�x��ƦW��  �x��ƥ\��                                                      �x
  //�u�w�w�w�w�w�w�w�w�w�w�q�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�t
  //�xu_setvar()�x�ܼƳ]�w                                                      �x
  //�xu_fd_var()�x�]�w����ܼ�                                                  �x
  //�|�w�w�w�w�w�w�w�w�w�w�r�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�}





  // **************************************************************************
  //  ��ƦW��: u_setvar()
  //  ��ƥ\��: �ܼƳ]�w
  //  �ϥΤ覡: u_setvar(&$f_var)
  //  �{���]�p: Tony
  //  �]�p���: 2006.09.27
  // **************************************************************************
  function u_setvar($f_var) {
    // post or get data Begin ............................................//
       //echo $_REQUEST.'---------';
       if(is_array($_REQUEST)) { // ����Ƥ~�B�z
          while (list($f_fd_name,$f_fd_value) = each($_REQUEST)) {
                 //echo "$f_fd_name=$f_fd_value----";
                 $f_var[$f_fd_name] = $f_fd_value;
          }
       }
    // post or get data End ..............................................//

    // ���ǤJ�Ȥ��w�]�ȳ]�w Begin.................................................//
       if(NULL==$f_var['msel']) {
          $f_var['msel']=4;
       }

       if(NULL==$f_var['f_page']) {
          $f_var['f_page']  = 1;         // ����
       }

       if(NULL==$f_var['f_del']) { // ���󬰥��@�o
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
       if(NULL==$f_var["f_change1"]) { // ���󬰼t���O$fd_dept = substr($row1['p_gid'],0,2); 
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
    // ���ǤJ�Ȥ��w�]�ȳ]�w End ..................................................//

    

    $mphp_name = u_showproc();
    //$f_var['ap_id']        = 'sl';       // sl.ap.ap_id
    $f_var['show_year']    = '2'; //  '4'��ܨq�褸�~ 2007, '2'��ܨq����~ 95
    $f_var['msel_name']    = array('1'=>'�s�W','2'=>'�ק�','3'=>'�R��','4'=>'�s��','5'=>'�d��','6'=>'���w�q','7'=>'�C�L'); // msel ����
    $f_var['ie_h_title']   = '�~�X�ժO';  //upd by �Ϊ� 2012.06.20  �g�z�i���A�ѥ~�X�q�l�ժO -> �~�X�ժO
    $f_var['msub_title']   = '�~�X�ժO';                 // �{���Ƽ��D �s��EIP-$f_var['msub_title']
    $f_var['mmaxline']     = 20;                             // �C���̤j����
    $f_var['break_pg_num'] = 8;                              // �C�L��������
    $f_var['mdb']          = 'docs';                         // db name
    $f_var['mtable']       = array('head'=>'ewb01','dept'=>'sl.dept','pass'=>'sl.pass');    // �ϥ� table �W�� h=���Y ; b=�ɨ�
    $f_var['tpl']          = 'ewb01.tpl';                    // �˪��e����
    $f_var['mque_color']   = 'background-color: #FFFF00; color: #000000; font-weight: bold'; // �d�ߦr���C��
    $f_var["mwidth1"]      = '15%'; // ��J�e����������쳡��
    $f_var["mwidth2"]      = '85%'; // ��J�e����input����
    $f_var["upd_ct"]       = 'empno';
    //$f_var['job_id']="5041/5042/5043/5001/5002/5003/5019/5020/5021";
    $f_var['job_id']="5001/5002/5003/5019/5020";   //upd by  �Ϊ�  2011.09.29 (����-15017)   �]�֤H���~�X�ժO�d���v���אּ�g�z�ťH�W
    $f_var['domain']= strstr($f_var['job_id'],$_SESSION['login_job_id']);
    
    $f_var['domain_S181'] = strstr("S112",$_SESSION['login_dept_id']);  //ADD BY �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��  
    if( date("Ymd")<'20160101' AND '8200092'==$_SESSION['login_empno'] ){ //add by �Ϊ� 2015.12.15 �}��̤��z
      $f_var['domain_S181'] = TRUE; 
    }
    
    //$f_var['domain1']= strstr('S122',$_SESSION['login_dept_id']);   //add by �Ϊ� 2011.08.11 �W�[�]�p���[�ݽ]���v��
    //$f_var['domain2']= strstr('8702080',$_SESSION['login_empno']);   //add by �Ϊ� 2011.08.11 �W�[���x���[�ݽ]���v��
    //echo $f_var['domain'].'=======<br>';
    $f_var["mfd_show"]  = array("dept_id","sname");   //����
    $f_var["mfd_value"] = array("dept_id","sname");
    $f_var['fmdb']          = 'sl';           
    $f_var['fmtable']       = array('head'=>'sl.dept');
    $f_var['fwhere'] = "{$f_var['fmtable']['head']}.d_date='0000-00-00' and {$f_var['fmtable']['head']}.stop='N'";
    $f_var['forder'] = "{$f_var['fmtable']['head']}.dept_id";
    list($f_var['dept_id_show'],$f_var['dept_id_value']) = sl_add_select3($f_var['fmdb'],$f_var['fmtable']['head'],$f_var['fwhere'],$f_var['forder'],$f_var["mfd_show"],$f_var["mfd_value"]); //�Ѹ�Ʈw�C�Xselect
    //$f_var['deptid'] = array('value'=> $f_var['dept_id_value']  ,'show'=> $f_var['dept_id_show'] );
    $f_var['deptid']['value'][]='00';
    $f_var['deptid']['show'][] ='����';
    while(list($hvalue)=each($f_var['dept_id_value'])){
      if("--"!=$f_var['dept_id_value'][$hvalue] ){
        $f_var['deptid']['value'][]=$f_var['dept_id_value'][$hvalue];
        $f_var['deptid']['show'][]=$f_var['dept_id_show'][$hvalue];
      }
    }
    $f_var['area_value'] = array('00','S1','S25','S26','S28','S35','S36','S38','E1','T1');
    $f_var['area_show']  = array('����','�`�޲z�B','�_�Ϻ޲z��','���Ϻ޲z��','�n�Ϻ޲z��','�_�Ϫo�~','���Ϫo�~','�n�Ϫo�~','��ȳ���','�s���ͧ�');
    $f_var['area'] = array('value'=> $f_var['area_value']  ,'show'=> $f_var['area_show'] );

    //$f_var['order_value'] = array('eb02'    ,'eb01','sname'    ,'eb06'        );
    //$f_var['order_show']  = array('�~�X���','�P��','�����W��' ,'�w�p�^�{���');    
    $f_var['order_value'] = array('eb02,eb18,eb02,eb03'    ,'eb01,eb02','sname'    ,'eb06'        );
    $f_var['order_show']  = array('�~�X���'          ,'�P��'     ,'�����W��' ,'�w�p�^�{���');
    $f_var['order'] = array('value'=> $f_var['order_value']  ,'show'=> $f_var['order_show'] );
    
    //$f_var['eb09_value'] = array('--'        ,'01.���Ȩ�','02.�p������','03.�����q�ɧU�ʨ�-����-���q��I','04.�����q�ɧU�ʨ�-����-�ۦ��I','05.�j����q�u��','06.���Ȩ�(�֨��f��-���ɨ�)','07.�p������(�֨��f��-���л�o�K)','99.��L'); //upd by �Ϊ� 2012.02.06 (����-16232) �W�[06.07�ﶵ
    //$f_var['eb09_show']  = array('--�п��--','01.���Ȩ�','02.�p������','03.�����q�ɧU�ʨ�-����-���q��I','04.�����q�ɧU�ʨ�-����-�ۦ��I','05.�j����q�u��','06.���Ȩ�(�֨��f��-���ɨ�)','07.�p������(�֨��f��-���л�o�K)','99.��L');
    //$f_var['eb09_value'] = array('--'        ,'01.���Ȩ�','02.�p������','03.�����q�ɧU�ʨ�-����-���q��I','05.�j����q�u��','06.���Ȩ�(�֨��f��-���ɨ�)','07.�p������(�֨��f��-���л�o�K)','99.��L'); //upd by �Ϊ� 2012.02.06 (����-16232) �W�[06.07�ﶵ
    //$f_var['eb09_show']  = array('--�п��--','���Ȩ�','�p������','�����q�ɧU�ʨ�-����-���q��I','�j����q�u��','���Ȩ�(�֨��f��-���ɨ�)','�p������(�֨��f��-���л�o�K)','��L');  //upd by �Ϊ� 2012.02.24  (����-16408)����04.�����q�ɧU�ʨ�-����-�ۦ��I
    $f_var['eb09_value'] = array('--'        ,'01.���Ȩ�','02.�p������','03.�����q�ɧU�ʨ�-����-���q��I','04.�����q�ɧU�ʨ�-����-�ۦ��I','05.�j����q�u��','06.���Ȩ�(�֨��f��-���ɨ�)','07.�p������(�֨��f��-���л�o�K)','99.��L');
    $f_var['eb09_show']  = array('--�п��--','���Ȩ�'   ,'�p������'   ,'�����q�ɧU�ʨ�-����-���q��I'   ,'�����q�ɧU�ʨ�-����-�ۦ��I'   ,'�j����q�u��','���Ȩ�(�֨��f��-���ɨ�)','�p������(�֨��f��-���л�o�K)','��L');  //upd by �Ϊ� 2014.07.16  (����-24009)�W�[04.�����q�ɧU�ʨ�-����-�ۦ��I
    $f_var['eb09'] = array('value'=> $f_var['eb09_value']  ,'show'=> $f_var['eb09_show'] );

    
    $f_var['eb10_value'] = array('--'        ,'01.1300 CC�H�U','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC�H�W','06.������');
    $f_var['eb10_show']  = array('--�п��--','01.1300 CC�H�U','02.1300-1500 CC','03.1501-1800 CC','04.1801-2000 CC','05.2001 CC�H�W','06.������');
    $f_var['eb10'] = array('value'=> $f_var['eb10_value']  ,'show'=> $f_var['eb10_show']);
    
    $f_var['else_calc_value'] = array('--'        ,'00'      ,'N'                           ,'Y');
    $f_var['else_calc_show']  = array('--�п��--','�p������',"�����q�ɧU�ʨ����׶O���q��I","�����q�ɧU�ʨ����׶O�ۦ��I");
    $f_var['else_calc'] = array('value'=> $f_var['else_calc_value']  ,'show'=> $f_var['else_calc_show'] );
    
    
    //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
    sl_open($f_var['mdb']);
    $query = "select group_concat( dept_id ORDER BY dept_id SEPARATOR '/' )  as dept_id
              from sl.dept
              where (dept_name LIKE '%���y%') AND stop = 'N' AND d_date='0000-00-00 00:00:00'
           ";
    //echo $query."<BR>";
    $result = mysql_query($query);
    $row =mysql_fetch_array($result);
    $f_var['domain1']=strstr($row['dept_id'],$_SESSION['login_dept_id']);//add by mimi 2011.06.02 ���ñ�֪�P�_�u�n���y
    $f_var['domain2']=strstr('S121,S122',$_SESSION['login_dept_id']);//add by mimi 2011.06.03 ���ñ�֪�P�_�u�n��T
    
    //add by mimi 2011.09.28 �W�[������ñ�֪�
    $query2 = "select group_concat( dept_id ORDER BY dept_id SEPARATOR '/' )  as dept_id
              from sl.dept
              where (dept_id like 'S6%') AND stop = 'N' AND d_date='0000-00-00 00:00:00'
           ";
    //echo $query2."<BR>";
    $result2 = mysql_query($query2);
    $row2 =mysql_fetch_array($result2);
    $f_var['domain3']=strstr($row2['dept_id'],$_SESSION['login_dept_id']);//add by mimi 2011.06.02 ���ñ�֪�P�_�u�n����

    //add by �Ϊ� 2012.01.12 �ݿ�-14426 �����]�w��(ewb_set01)�]�w�����ǤH���uñ�֤@�h
    sl_open('docs');
    $sql2 = "select  group_concat( es01 ORDER BY es01 SEPARATOR '/' )  as empno
              from   ewb_set1
              where  d_date='0000-00-00 00:00:00'
           ";
    $res2 = mysql_query($sql2);
    $ar2 =mysql_fetch_array($res2);
    $f_var['domain4']=strstr($ar2['empno'],$_SESSION['login_empno']); //add by �Ϊ� 2012.01.12 �ݿ�-14426 �����]�w��(ewb_set01)�]�w�����ǤH���uñ�֤@�h
    //$f_var['domain4']=strstr("/5003/5019/5020",$_SESSION['login_job_id']);//add by mimi 2012.01.12 ����-16058 �g�z�ťH�W�u�nñ�֤@�h
    //echo 'domain4: '.$f_var['domain4'];
    
    //add by �Ϊ� 2018.12.04 �̸�T����/�v���޲z/���s����ɶ�����]�w ����}��l�ήɶ�
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
        $f_var['hrmctrl_ing'] = "�`�N!! ���s�H�ƨt�Ϊ�����@���C\r\n����ɶ�: {$row_tr['startime']} ~ {$row_tr['endtime']} (�������,�i�X�h�Ԭ�����JHR(���s)�j��ܡu�O�v�N�L�k�e��)\n";
        //$f_var['hrmctrl_ing'] = "�`�N!! ���s�H�ƨt�Ϊ�����@���C\n
        //                     ����ɶ�: {$row_tr['startime']} ~ {$row_tr['endtime']}\n
        //                     �����]: {$row_tr['reason']}\n
        //                     �е����󵲧���, �A�ϥΡC\n
        //                     (���s�������w�p�����ɶ�,�|�����᪺�i��)\n
        //                     (�������,�i�X�h�Ԭ�����JHR(���s)�j��ܡu�O�v�N�L�k�e��)\n";
        $f_var['hrmctrl_ing2'] = "<font size='+1' style='font-family:Microsoft JhengHei;'>�`�N!! ���s�H�ƨt�Ϊ�����@���C<br>
                             ����ɶ�: <font style='font-weight:bold;color:blue;'>{$row_tr['startime']} ~ {$row_tr['endtime']}</font> <br>
                             �����]: <font style='font-weight:bold;color:blue;'>{$row_tr['reason']}</font><br>
                             �е����󵲧���, �A�ϥΡC<br>
                             <font style='font-weight:bold;color:green;'>(���s�������w�p�����ɶ�,�|�����᪺�i��)</font><br>";
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
        $f_var['hrmctrl'] = "<font size='+1' style='font-family:Microsoft JhengHei;'>������s�H�ƨt�Ϊ�����@�ɶ�: <br>
                             ����ɶ�: <font style='font-weight:bold;color:blue;'>{$row_tr2['startime']} ~ {$row_tr2['endtime']}</font> <br>
                             �����]: <font style='font-weight:bold;color:blue;'>{$row_tr2['reason']}</font><br>
                             <font style='font-weight:bold;color:green;'>(�`�N! �������,<font style='font-weight:bold;color:red;'>�i�X�h�Ԭ�����JHR(���s)�j��ܡu�O�v</font>�N�L�k�e��,�д��e�ӽ�)</font></font>";
      }                                                   
    }
    
    
    
    $f_var['fd']        = u_fd_var($f_var); // �]�w����ܼơA�@�w�n��b $f_var['area']�P$f_var['kind']����A�]���|�ϥΨ즹�}�C���e�C
 
 // �ŧiList�s�����e���]�w Begin.................................................//
    // th_width = ���j�p�ʤ���, ���`�X��<=100)
    // th_name  = ���Y���W��
    // fd_align = ��ƨq�X��m left=��,right=�k,center=����
    // fd_name  = table �������W��

    $f_var["list"]=array('th_width' => array(7         ,6         ,7         ,5         ,10        ,18        ,7             ,6          ,8             ,8      ,10                       ,2       ,2        ), 
                         'th_name'  => array('�����W��','�P��'    ,'�~�X��'  ,'�ɶ�'    ,'�e���a�I','�~�X�ƥ�','�w�p�^�{'    ,'�w�p<br>�ɶ�' ,'�w�p�^�{<br>�a�I','�Ƶ�'  ,'�ը���/���{��/���{<br><b>�}�����</b>'               ,'��'    ,'�o'     ), 
                         'fd_align' => array('left'    ,'left'    ,'center'  ,'center'  ,'left'    ,'left'    ,'center'      ,'center'   ,'left'        ,'left'  ,'left'                ,'center','center' ), 
                         'fd_name'  => array('sname'   ,'eb01'    ,'eb02'    ,'eb03'    ,'eb04'    ,'eb05'    ,'eb06'        ,'eb07'     ,'eb16'        ,'eb08'  ,'u_chksign(s_num)'        ,'u_upd' ,'u_del'  ),
                         'fd_type'  => array(''        ,''        ,''        ,'time'    ,''        ,''        ,''            ,'time'     ,''            ,''      ,''                      ,''      ,''       )
                                   );                                                                                                    
    // �s�����e���]�w End ..................................................//



    // �d�߱���]�w Begin ................................................//
       $f_var['que']['memo']  = '�d����쬰:�i';
       $mnum = 0;
       reset($f_var['fd']); // �N�}�C�����Ы���}�C�Ĥ@�Ӥ���
       while(list($mfd_id)=each($f_var['fd'])) {
             if('Y'==$f_var['fd'][$mfd_id]['que']) { // �i�d�����
                if($mnum>=1) {
                   $f_var['que']['memo'] .= '�B';
                }
                $f_var['que']['fd'][]  = $mfd_id;
                $f_var['que']['memo'] .= $f_var['fd'][$mfd_id]['cname'];
                $mnum++;
             }
       }
       $f_var['que']['memo']  .= '�j��J�������I��T�w�C';
    // �d�߱���]�w End ..................................................//
    $f_var['today'] = date("Ymd");
     
    //$f_var['mwhere'] = "{$f_var['mtable']['head']}.b_date>'0000-00-00' and (({$f_var['mtable']['head']}.b_empno = '{$_SESSION['login_empno']}' and  {$f_var['mtable']['head']}.dc05 = 'N' ) or ({$f_var['mtable']['head']}.b_empno = '{$_SESSION['login_empno']}' and {$f_var['mtable']['head']}.dc05 = 'Y') or {$f_var['mtable']['head']}.dc05 = 'N') and ";
    switch ($f_var['f_del']) {
         case "N": // N.���@�o                        
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or '1130091'==$_SESSION["login_empno"] or ''!=$f_var['domain_S181'] ){  //add by �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date='0000-00-00 00:00:00' "; //js_h.date='0000-
              }
              else{
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date='0000-00-00 00:00:00' and {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
              }
              break;
         case "Y": // Y.�w�@�o
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181']){   //add by �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date<>'0000-00-00 00:00:00' ";
               }
              else{
                $f_var['mwhere'] .= "{$f_var['mtable']['head']}.d_date<>'0000-00-00 00:00:00' and {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
              }
              break;
         default: // ����
              if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181']){  //add by �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��
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
  //  ��ƦW��: u_fd_var()
  //  ��ƥ\��: �]�w����ܼ�
  //  �ϥΤ覡: u_fd_var($f_var)
  //  �{���]�p: Tony
  //  �]�p���: 2006.09.25
  // **************************************************************************
  function u_fd_var($f_var) {
    //$_SESSION['login_car_id'];         // ����
    //$_SESSION['login_car_kind'];       // ����
    //$_SESSION['login_exhaust'];        // �Ʈ�q
    //$_SESSION['login_vip_card'];       // �s��VIP�d��
    sl_open($f_var['mdb']); // �}�Ҹ�Ʈw  
    
    

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
    $row1 = mysql_fetch_array($result1); //add by �Ϊ�  2011.10.05 (�ݿ�-14426 �^��29) ���]�w�ҥ~�H���]�w�ɤ~����

    $fd_disabled  = iif($f_var['msel']=='2','disabled',''); //select�ϥ�    
    $fd_readonly  = iif($f_var['msel']=='2','readonly','');
    $fd_class     = iif($f_var['msel']=='2','field_color','');     
    $fd_inputtype = iif($f_var['msel']=='2','text','date'); //���������
    
    $fd_eb09 = strstr("01/05/06/07/99",substr($row1['eb09'],0,2));
    $fd_readonly_msel= iif($fd_eb09<>'' and $f_var['msel']=='2','readonly','');
    $fd_class_msel   = iif($fd_eb09<>'' and $f_var['msel']=='2','field_color','');         
    
    //--�j�M�ҥ~�H���]�w�ɡA�O�_�����зǨ��{---------------------// 
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
      //$fd_eb17 = "Y"; //����ƫh�����зǨ��{
      $fd_eb24 = "Y"; //����ƫh�����зǨ��{
    }
    //if( $row1['b_date']<>'' ){  //�ק�
    //  $fd_eb17 = $row1['eb17']; 
    //} 
    //-----------------------------------------------------------//
    mysql_close(); // ������Ʈw
        
    
    //if($fd_eb17=='Y' AND $f_var['msel']=='2'){  //add by �Ϊ�  2011.10.17 �ק�A�ҥ~�H����ƪ�]�w�O Y ��
    //  $fd_eb17s = $fd_eb17;
    //}
    //else if($f_var['msel']!='2'){  //�s�W�A �̾ڨҥ~�H����ƪ�]�w����
    //  $fd_eb17s = $fd_eb17;
    //}
    //else{  //�ק�A�������Ʈw���x�s����
    //  $fd_eb17s ='';
    //}
    
    //$fd_resda019 = u_chksign($f_var['f_s_num']); //�j�M���{�}�����
    //$ar_key = explode("<br>",$fd_resda019);
    //$fd_resda0192 = strip_tags($ar_key[1]); //�h���Ҧ�html����
    //echo $fd_resda0192;
    $fd_var['s_num'] = array(  //add by �Ϊ� 2011.11.24  ���os_num�A�d�ߥ~�X��ñ�ֵ��פ�� (�ˬd���{�T�餺�n��)
                              'ename'     => 'f_s_num',
                              'cname'     => 's_num',
                              'type'      => 'hidden',
                              'save'      => 'N',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 20,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // �O�_�}��d��
                              'js_rule'   => '',
                              'memo'      => '' ,         
                            );      
                                
    $fd_var['sname'] = array(
                              'ename'     => 'f_sname',
                              'cname'     => '�����W��',
                              'type'      => 'text',
                              'value'     => $_SESSION['login_sname'],
                              'size'      => 10,
                              'maxlength' => 10,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'save'      => 'N',
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => '',   
                              'memo'      => ''                           
                            );
    $fd_var['eb01'] = array(
                              'ename'     => 'f_eb01',
                              'cname'     => '�P���m�W',
                              'type'      => 'text',
                              'value'     => $_SESSION["login_name"],
                              'size'      => 10,
                              'maxlength' => 12,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                               
                              //'readonly'  => "{$fd_readonly}",
                              //'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
                              'pkey'      => 'Y',
                              'memo'      => ''
                            );
    $fd_var['eb18'] = array(
                              'ename'     => 'f_eb18',
                              'cname'     => '�P�����s',
                              'type'      => 'text',
                              'value'     => $_SESSION["login_empno"],
                              'size'      => 7,
                              'maxlength' => 7,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
                              'pkey'      => 'Y',
                              'memo'      => ''
                            );        
    $fd_var['eb02'] = array(
                              'ename'     => 'f_eb02',
                              'cname'     => '�~�X���',
                              'type'      => $fd_inputtype,        // ����form��input_type,��ƫ��A���� char(),�����O�n�s�� BLOCK:tb_date
                              'value'     => date("Ymd"),   // ����form��input_value
                              'size'      => 10,            // ����form��input_size
                              'maxlength' => 8,
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'chkdate','chk_len'=>'8'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_�����
                              'pkey'      => 'Y',  
                              'memo'      => '�п�J�褸�~���A�d�ҡG20071005'
                            );
    $fd_var['eb03'] = array(
                              'ename'     => 'f_eb03',
                              'cname'     => '�~�X�ɶ�',
                              'type'      => 'time',
                              'value'     => date("Hi"),
                              'size'      => 10,
                              'maxlength' => 4,       //�r������
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'time','chk_len'=>'4'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'pkey'      => 'Y',  
                              'memo'      => '�п�J�ɤ��A�d�ҡG0930'   
                            );
    $fd_var['eb04'] = array(
                              'ename'     => 'f_eb04',
                              'cname'     => '�e���a�I',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 40,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );

    $fd_var['eb05'] = array(
                              'ename'     => 'f_eb05',
                              'cname'     => '�e���ƥ�',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 60,
                              'maxlength' => 60,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );
    $fd_var['eb06'] = array(
                              'ename'     => 'f_eb06',
                              'cname'     => '�w�p�^�{���',
                              'type'      => $fd_inputtype,        // ����form��input_type,��ƫ��A���� char(),�����O�n�s�� BLOCK:tb_date
                              'value'     => date("Ymd"),   // ����form��input_value
                              'size'      => 10,            // ����form��input_size
                              'maxlength' => 8,
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��                              
                              'js_rule'   => array('kind'=>'chkdate','chk_len'=>'8'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_�����
                              'pkey'      => 'Y',  
                              'memo'      => '�п�J�褸�~���A�d�ҡG20071005'
                            );
    $fd_var['eb07'] = array(
                              'ename'     => 'f_eb07',
                              'cname'     => '�w�p�^�{�ɶ�',
                              'type'      => 'time',
                              'value'     => '',
                              'size'      => 10,
                              'maxlength' => 4,            //�r������
                              'readonly'  => "{$fd_readonly}",
                              'class'     => "{$fd_class}",
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'time','chk_len'=>'4'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'pkey'      => 'Y',  
                              'memo'      => '�п�J�ɤ��A�d�ҡG0930'   
                            );
    $fd_var['eb16'] = array(
                              'ename'     => 'f_eb16',
                              'cname'     => '�w�p�^�{�a�I',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 40,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'required','chk_value'=>''),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'pkey'      => 'Y',  
                              'memo'      => ''   
                            );
      //add by �Ϊ� 2018.03.27 ����33599-�~�X�ժO�s�W�ﶵ  -> �X�h�Ԭ�����JHR(���s)
      $fd_var['tohrm'] = array(
                                'ename'     => 'f_tohrm',
                                'cname'     => '�X�h�Ԭ�����JHR(���s)',
                                'type'      => 'select2',
                                'show'      => array('--�п��--','�_','�O'),
                                'value'     => array('-','N','Y'), 
                                'selected'  => $fd_eb24,
                                'size'      => 0,
                                'maxlength' => 0,   
                                //'readonly'  => '',
                                'class'     => '',
                                'multiple'  => $fd_disabled,
                                'show_scr'  => 'Y',  
                                //'js_rule'   => '',      
                                'js_rule'   => array('kind'=>'required','chk_value'=>'-'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
                                'pkey'      => 'Y',                                
                                'memo'      => '�Y��ܬ��y�O�z�A�~�X�ժO���N�X�Ԭ���'
                                
                            );    
      $fd_var['eb09'] = array(
                                'ename'     => 'f_eb09',
                                'cname'     => '����',
                                'type'      => 'select2',
                                'selected'  => $_SESSION['login_car_kind'],
                                'show'      => $f_var['eb09']['show'],
                                'value'     => $f_var['eb09']['value'], 
                                'size'      => 0,
                                'maxlength' => 0,
                                'show_scr'  => 'Y',
                                'que'       => 'Y',          // �O�_�}��d��
                                //'multiple'  => "{$fd_disabled}",  //mark by �Ϊ� 2012.12.21 (��18956)                        
                                'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
                                'pkey'      => 'Y',
                                'memo'      => '���ج��p�����ΡB�����q�ɧU�ʨ��A�Ʈ�q������'     
                              );      
      $fd_var['eb10'] = array(
                                'ename'     => 'f_eb10',
                                'cname'     => '�Ʈ�q',
                                'type'      => 'select2',
                                'show'      => $f_var['eb10']['show'],
                                'value'     => $f_var['eb10']['value'], 
                                'selected'  => $_SESSION['login_exhaust'],
                                'size'      => 0,
                                'maxlength' => 0,
                                'show_scr'  => 'Y',
                                'que'       => 'Y',          // �O�_�}��d��
                                //'multiple'  => "{$fd_disabled}",  //mark by �Ϊ� 2012.12.21 (��18956)                           
                                //'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   //add by �Ϊ� 2011.08.10 �p���]�w�A�Ӫo�p��|�����~
                                                                                                
                                //'pkey'      => 'Y',
                                'memo'      => '�п�J��ӤW���T��Ʈ�q'     
                              );
    /*                          
     $fd_var['eb17'] = array(
                              'ename'     => 'f_eb17',
                              'cname'     => '�����зǨ��{',
                              'type'      => 'text',
                              'show'      => '',
                              'value'     => $fd_eb17, 
                              'size'      => 1,
                              'maxlength' => 1,
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'show_scr'  => 'Y',          // �O�_�A�^�����ɥi��J���
                              'js_rule'   => '',
                              'memo'      => '�Ȭ�Y, ��C�L�p�����ίӪo�έp��ɷ|�N���{�Ʀ���120����'
                            );  */ 
    //mark by �Ϊ� 2016.04.08 ����28783 -���q�H�o��120�����{                        
    //if( $row1['b_date']=='' and $fd_eb17<>'Y' ){ //�s�W                       
    //  $fd_var['eb17'] = array(
    //                            'ename'     => 'f_eb17',
    //                            'cname'     => '�����зǨ��{',
    //                            'type'      => 'select2',
    //                            'show'      => array('--�п��--','N','Y'),
    //                            'value'     => array('--','N','Y'), 
    //                            //'selected'  => '',
    //                            'size'      => 0,
    //                            'maxlength' => 0,
    //                            'readonly'  => '',
    //                            'class'     => '',
    //                            'show_scr'  => 'Y',          // �O�_�A�^�����ɥi��J���
    //                            //'js_rule'   => '',      
    //                            'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
    //                            'pkey'      => 'Y',                                
    //                            'memo'      => '���Y,��C�L�p�����ίӪo�έp��ɷ|�N���{�Ʀ���120����'
    //                            
    //                          ); //upd by �Ϊ� 2011.10.11 (����-15148) ���x�׻��A�ثe�����S���ѨM��k�A�ҥH��^���e�ۦ��J      
    //}else{ //�ק�
    //  $fd_var['eb17'] = array(
    //                            'ename'     => 'f_eb17',
    //                            'cname'     => '�����зǨ��{',
    //                            'type'      => 'text',
    //                            'value'     => $fd_eb17,
    //                            'readonly'  => 'readonly',
    //                            'class'     => 'field_color',
    //                            'size'      => 1,
    //                            'maxlength' => 1,            //�r������
    //                            'show_scr'  => 'Y',
    //                            'que'       => 'N',          // �O�_�}��d��
    //                            //'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
    //                            'memo'      => '' ,         
    //                          );  
    //}
    $fd_var['eb24'] = array(
                                'ename'     => 'f_eb24',
                                'cname'     => '����ե��a����30����',
                                'type'      => 'select2',
                                'show'      => array('--�п��--','N','Y'),
                                'value'     => array('--','N','Y'), 
                                'selected'  => $fd_eb24,
                                'size'      => 0,
                                'maxlength' => 0,   
                                'readonly'  => '',
                                'class'     => '',
                                'show_scr'  => 'Y',          // �O�_�A�^�����ɥi��J���
                                //'js_rule'   => '',      
                                'js_rule'   => array('kind'=>'required','chk_value'=>'--'),   // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���ť�
                                'pkey'      => 'Y',                                
                                'memo'      => '�̤��i16033�q�ԩ���ե��a�o�O�ɧU:�̹�ک��𨽵{��30�����[�p�q��O'
                                
                            );     
    $fd_var['eb11'] = array(
                              'ename'     => 'f_eb11',
                              'cname'     => '�X�t������',
                              'type'      => 'text',
                              //'readonly'  => 'onBlur=\'javascript:document.input_form.f_eb13.value=eval(parseInt(document.input_form.f_eb12.value)-parseInt(this.value));if(document.input_form.f_eb13.value<=0){alert("���{�Ƥ��i�p��0");}if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb13.value=0;}\'',
                              'readonly'  => 'onBlur=\'javascript:if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb11.value="";document.input_form.f_eb13.value=0;}\'',
                              'value'     => '',
                              'size'      => 7,
                              'maxlength' => 7,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'readonly'  => "{$fd_readonly_msel}",
                              'class'     => "{$fd_class_msel}",                              
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'memo'      => '' ,         
                            ); 
    $fd_var['eb12'] = array(
                              'ename'     => 'f_eb12',
                              'cname'     => '�J�t������',
                              'type'      => 'text',
                              'value'     => '',
                              'readonly'  => 'onBlur=\'javascript:input_form.f_eb13.value=eval(parseInt(this.value)-parseInt(input_form.f_eb11.value));if(input_form.f_eb13.value<=0){alert("���{�Ƥ��i�H�p��s");}if(document.input_form.f_eb13.value=="NaN"){document.input_form.f_eb13.value=0;}\'',
                              'size'      => 7,
                              'maxlength' => 7,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'readonly'  => "{$fd_readonly_msel}",
                              'class'     => "{$fd_class_msel}",                              
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'memo'      => '' ,         
                            );         
    $fd_var['eb13'] = array(
                              'ename'     => 'f_eb13',
                              'cname'     => '���{��',
                              'type'      => 'text',
                              'value'     => '',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',
                              'size'      => 4,
                              'maxlength' => 4,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => array('kind'=>'chkstr','chk_value'=>'num','chk_len'=>'0'),    // �@�w�n��J�ȡA�]�N�O�ˬd�O�_���Ʀr
                              'memo'      => '' ,         
                            );          
    $fd_var['eb14'] = array(
                              'ename'     => 'f_eb14',
                              'cname'     => '�^�Ʋ�(���t�����q��O)',   //upd by �Ϊ� 2013.12.27(����22108)�~�X�ժO��D�q��O   ALTER TABLE  `ewb01` CHANGE  `eb14`  `eb14` INT( 8 ) NOT NULL COMMENT  '�^�Ʋ�(���t�����q���O)'
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 6,
                              'maxlength' => 8,            //�r������
                              'show_scr'  => 'Y',                                     
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => '',    
                              'memo'      => '<a href="http://fare.fetc.net.tw/Custom.aspx" target="_blank">�p�{�q��O�պ�</a>' ,         
                            );                   
    $fd_var['eb15'] = array(
                              'ename'     => 'f_eb15',
                              'cname'     => '�����H��',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 1,
                              'maxlength' => 1,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => '',    
                              'memo'      => '' ,         
                            );            
    $fd_var['eb08'] = array(
                              'ename'     => 'f_eb08',
                              'cname'     => '�Ƶ�',
                              'type'      => 'text',
                              'value'     => '',
                              'size'      => 60,
                              'maxlength' => 60,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'Y',          // �O�_�}��d��
                              'js_rule'   => '',
                              'memo'      => '�i��J�p���q��' ,         
                            );
    $fd_var['resda019'] = array(  //add by �Ϊ� 2011.11.24  ���os_num�A�d�ߥ~�X��ñ�ֵ��פ�� (�ˬd���{�T�餺�n��)
                              'ename'     => 'f_resda019',
                              'cname'     => '�ը���ñ�֤��',
                              'type'      => 'text',
                              'save'      => 'N',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                              
                              'value'     => '',
                              'size'      => 20,
                              'maxlength' => 20,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // �O�_�}��d��
                              'js_rule'   => '',
                              'memo'      => '' , 
                                      
                            );      
    $fd_var['resda0192'] = array(  //add by 2012.03.02 �Ϊ�  �Ʋz�i���W�[���{�}��������
                              'ename'     => 'f_resda0192',
                              'cname'     => '���{�}��ק����',
                              'type'      => 'text',
                              'save'      => 'N',
                              'readonly'  => 'readonly',
                              'class'     => 'field_color',                              
                              'value'     => "",
                              'size'      => 20,
                              'maxlength' => 20,            //�r������
                              'show_scr'  => 'Y',
                              'que'       => 'N',          // �O�_�}��d��
                              'js_rule'   => '',
                              'memo'      => '' , 
                                      
                            );  
    //if( '1130091'==$_SESSION["login_empno"] ){                          
    $fd_var['hrmctrl'] = array(  //add by �Ϊ� 2018.12.04 �̸�T����/�v���޲z/���s����ɶ�����]�w ����}��l�ήɶ�
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
  //  ��ƦW��: u_chksign()
  //  ��ƥ\��: �ˬdñ�ֳ�ñ�ֵ��G�O�_���P�N
  //  �ϥΤ覡: u_chksign($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.12.23
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
    if($num>0){  //2011.10.04 �H�e�O�S�]ñ�̡֪A�h�|���
      while($row = mysql_fetch_array($result)){
        $fd_eb09 = substr($row['eb09'],0,2);  //����
        $fd_carkey = strstr('02/03/04',$fd_eb09); //add by �Ϊ� 2012.03.07 ���ج��p�����ΡB�����q�ɧU�ʨ�
        if($row['sleip2flw008']=='1' or $row['sleip2flw008']=='3' or $row['sleip2flw008']=='11'){
          $fd_flw13 = iif($row['resda019']=='0000-00-00 00:00:00',"ñ�֤�","<font color=#693837>".substr($row['resda019'],5,5)."</font>");
          //add by 2012.03.02 �Ϊ�  �Ʋz�i���W�[���{�}��������
          $fd_resda19 = iif($row['resda019']=='0000-00-00 00:00:00',$fd_resda19,str_replace('-','',substr($row['resda019'],0,10))); //ñ�֤�
        }else if($row['sleip2flw008']=='4' or $row['sleip2flw008']=='12'){
          $fd_flw4 = iif($row['resda019']=='0000-00-00 00:00:00',"/ñ�֤�","/<font color=#693837>".substr($row['resda019'],5,5)."</font>");
        }
        
        if( '1'==$row['sleip2flw011'] ){
          switch( $row['resda020'] ){
            case '4':
                 return "�w���";
                 echo $row['s_num'];
                 break;
            default:
                 break;
          }
        }

        $fd_eb13 = $row['eb13'];
        
        $fd_eb18 = $row['eb18']; //���s
        $fd_eb02 = $row['eb02']; //�~�X���
        $fd_eb20 = $row['eb20']; //�O�_���o�K -> �O�_����ñ���
      }
      $fd_str .= $fd_flw13;
      //$fd_str .= iif($fd_flw4==null and $fd_eb13<>'0'," / {$fd_eb13}Km",$fd_flw4);
      $fd_str .= iif($fd_flw4==null,'',$fd_flw4);
      $fd_str .= iif($fd_eb13=='0' or $fd_eb13=='','',"/{$fd_eb13}");
      
      //return "�~�X��:".$fd_resda0191."/���{��:".$fd_resda0192."/".$fd_eb13;
      
      
      //�p����ñ��ơA�h�}��T�Ӥ� add by �Ϊ� 2012.05.31 (�ݿ�14426)
      $y2 = substr($fd_eb02, 0, 4); //���e�|�X (�~)        
      $m2 = substr($fd_eb02, 4, 2); //���̫�G��(��)  
      $d2 = substr($fd_eb02, 6, 2); //��
      if($fd_eb02>substr($fd_eb02,0,6).'25'){
        $fd_sday3 = mktime(0, 0, 0, $m2+2, $d2, $y2);  //�W�L25�A��U�Ӥ�
      }else{
        $fd_sday3 = mktime(0, 0, 0, $m2+1, $d2, $y2);  //25���A����
      }
      $fd_sday3 = substr(date('Ymd', $fd_sday3),0,6);
      $fd_close = $fd_sday3."06";  //�w�]���b��  upd by �Ϊ� 2012.02.10 (�ݿ�-14426)�^��95.3 �Τ@���w5�� 23:59:59          
      $y3 = substr($fd_close, 0, 4); //���e�|�X (�~)        
      $m3 = substr($fd_close, 4, 2); //���̫�G��(��)  
      $d3 = substr($fd_close, 6, 2); //��            	   	
      $fd_vdate  = date('Ym',mktime(0, 0, 0, $m3+1, $d3, $y3))."05";      
      if($fd_eb20 == 'N'){  //��ñ���
        $fd_str .= "<br><b><font color=#693837>".substr(sl_4ymd($fd_vdate),5,5)."</font></b>";
        return $fd_str;   
      }
      
      
      
      
      //add by 2012.03.02 �Ϊ�  �Ʋz�i���W�[���{�}��������
      //�j�M�~�X�ժO�}��ק�]�w�ɬO�_�����---------------------------------------------// 
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
                ";  //�j�M ewb_set03 �O�_���]�w�}��~�X
       //echo '<pre>'.$query_es.'</pre>';
      $result_es  = mysql_query($query_es);
      $num_es = mysql_num_rows($result_es);  //����
      if($num_es>0){             
        $row_es = mysql_fetch_array($result_es);
        $fd_setdate = str_replace('-','',substr($row_es['date'],0,10));
        //$fd_resda19 = $fd_setdate;  //�����̤j���ɩβ��ʤ��  
        
        //upd by �Ϊ� 2013.11.22 �Ҫ��ӯ�A�L�g�z11/18���o�ק���{�A�]�����H�ܳ]�w�ɤ��]�w�H���}��ק悔�{�A�{���|�P�_�إߤ�b_date �Ӱ����̾ڶ}��I���
        if( $fd_resda19<$fd_setdate ){ //ñ�֧����� < �]�w�}��� �A�~�H�]�w�ɤ��}��鬰�D
          $fd_resda19 = $fd_setdate;  //�����̤j���ɩβ��ʤ��  
        }
      }     
      //�p��T�Ѥ��ư���w����-----------------------------------------------------------// 
      $cal_cnt=0;
      for($fd_cnt=0;$fd_cnt<='3';$fd_cnt++){ //�T�Ѥ������w����  
        $y = substr($fd_resda19, 0, 4); //�~          
        $m = substr($fd_resda19, 4, 2); //��  
        $d = substr($fd_resda19, 6, 2); //��          
        $fd_resda192_mk = mktime(0, 0, 0, $m, $d+$cal_cnt, $y);  //upd by �Ϊ� 2012.04.14 �C�X������~
        $fd_resda192    = date('Ymd', $fd_resda192_mk);
        $ch_resda192    = $fd_resda192 - 19110000;      
      
        //$fd_resda192 = date('Ymd',strtotime("{$fd_resda19} +{$cal_cnt} day"));
        //$ch_resda192 = (date('Ymd',strtotime("{$fd_resda19} +{$cal_cnt} day"))-19110000);
        sl_open('sle');    //��w����
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
           //add by �Ϊ� 2013.01.02 �H�ư�w����]�w�ɥ���J sle0a �A���Ȯɥ[�W��w�P�_
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
      if($fd_carkey<>''){ //add by �Ϊ� 2012.03.07 ���w���ؤ~��ܨ��{�}�����
        $fd_str .= iif($fd_resda19<>'',"<br><b><font color=#693837>".substr(sl_4ymd($fd_resda192),5,5)."</font></b>",'');    
      }   
      return $fd_str;
    }                                     
    else{
      return "<font color=#693837>�~�X��e�Xñ�ֲ��`</font>";
    }
  }               
  
?>

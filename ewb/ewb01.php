<?
  //�z�w�w�w�w�w�w�w�w�w�w�s�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�{
  //�x�t�ΦW��: �xEWB01   �~�X�q�l�ժO�{����                                    �x
  //�x          �x                                                              �x
  //�x�{���W��: �xewb01.php  EWB01   �~�X�q�l�ժO                               �x
  //�x�{������: �x                                                              �x
  //�x�˪O�W��: �xewb01.tpl                                                     �x
  //�x          �x/home/sl/public_html/sl_tpl_1.tpl �@�μ˪O��                  �x
  //�x          �x                                                              �x
  //�x��Ʈw  : �xeip :docs                                                     �x
  //�x��ƪ�  : �xewb01     ���D����-���Y                                       �x
  //�x          �x                                                              �x
  //�x�����{��: �x/home/sl/public_html/sl_init.php �@�Ψ��                     �x
  //�x          �x/home/sl/public_html/tp/*.*      �˪O�M��                     �x
  //�x          �xewb01_init.php                   �~�X�q�l�ժO�ۭq���         �x
  //�x          �x                                                              �x
  //�x          �x/home/sl/public_html/sl.css      css ��                       �x
  //�x          �x/home/sl/public_html/sl.js        javascript �ۭq���         �x
  //�x          �x/home/sl/public_html/sl_header.inc.php  ����                  �x
  //�x          �x/home/sl/public_html/sl_footer.inc.php  ����                  �x
  //�x          �x                                                              �x
  //�x�������: �x/home/docs/public_html/doc/ewb01.txt          �ت�            �x
  //�x          �x                                                              �x
  //�x�`�N�ƶ�: �x������ select ���U�Ԧ����W�h�A�e���@�w�n�O�d�T�X��@�P�_�X�A�x
  //�x          �x���M�@�Ψ�Ʒ|����C                                          �x
  //�x          �x�Ҧp: <select name="f_dept">                                  �x
  //�x          �x        <option value="01.�`���q">�`���q</option>             �x
  //�x          �x                       ^^^--->�N�O�o�T�X��I                  �x
  //�x          �x      </select>                                               �x
  //�x          �x                                                              �x
  //�x          �x                                                              �x
  //�x�{���]�p: �x�f�Yޱ                                                        �x
  //�x�]�p���: �x2008.01.30                                                    �x
  //�x          �x                                                              �x
  //�x�{���ק�: �x                                                              �x
  //�x�ק���: �x                                                              �x
  //�x�ק鷺�e: �x                                                              �x
  //�x          �x                                                              �x
  //�x          �x                                                              �x
  //�x          �x                                                              �x
  //�x          �x                                                              �x
  //�x          �x                                                              �x
  //�|�w�w�w�w�w�w�w�w�w�w�r�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�w�}

  // -----  session �Ұ� Begin ------------ //
     //session_cache_limiter("private");      // ���W����,���e���ȥi�O�d,�Y�Q�j���n�X��,�h�L�k�A�n�J,�B�Y�{����s��,�����ª�,���D��Ctrl+F5,�ΰ��D�NIE�Ȧs�ɲM��
     //session_cache_limiter("nocache");    //
     //session_start();            
  // ------ session �Ұ� End -------------- //
  if ($_COOKIE['alertewb01'] != 1 and date('Ymd') <= '20111126') {  //add by �Ϊ��@2011.11.24
    setcookie('alertewb01', 1, time()+10800);  //3600(1hr)*3  3hr��A�~�|�A���ܤ@��
    echo "<script type='text/javascript'>";
    echo "alert('�`���q�`�Ȳդ��i:\\n\\n11/26�_�A��J�^�{���{���਽�{ñ�ֳ�A�ݩ�T�餺�n�������C');";
    echo "</script>";  
  }

  include_once('/home/sl/public_html/sl_init.php');  // �@�Φۭq��ƻP�ܼƳ]�w
  /* ajax start */
  if ($_REQUEST['msel']=='ajax_get_emp') {
    $q = mb_convert_encoding($_REQUEST["q"],'big5','utf-8');
    /*
    big5�䴩�����D!����r�X�e���j�M������
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
    big5�䴩�����D!����r�X�e���j�M������
    */
    if ($q==null) return;
    
    sl_openef2k('EF2KWeb');  //�j�M�޲z������
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
      if( '' == $row_dept['resal004']){//�S�޳�����+����
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
    foreach($a as $key => $val){ //�޲z���H��
      if( '' != $key ){
		    $jobid = $_SESSION['login_job_id'];  
        if('5'==substr($jobid,0,1)){//�޲z���h
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
    //big5�䴩�����D!����r�X�e���j�M������

    $y = date('Y'); //�~        
    $m = date('m'); //��
    $d = date('d'); //��      
    $fd_date = date('Ymd', mktime(0, 0, 0, $m-2, $d, $y));   //�e�G�Ӥ�      

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
  // �p��Ƥ��O���A�ӬO���e�����ñ��ơA�h�ݧP�_�O�_�٬O�����`
  //---------------------------------------------------------------
  if ($_REQUEST['msel']=='ajax_chk_eb11') {
    $fd_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8'); //�~�X���
    $fd_eb18 = mb_convert_encoding($_REQUEST["f_eb18"],'big5','utf-8'); //���s
    $fd_eb11 = mb_convert_encoding($_REQUEST["f_eb11"],'big5','utf-8'); //�J�t������
    //big5�䴩�����D!����r�X�e���j�M������

    $fd_ndate = date("Ymd");  //�{�b���
    $y = substr($fd_eb02, 0, 4); //�~         
    $m = substr($fd_eb02, 4, 2); //��  
    $d = substr($fd_eb02, 6, 2); //��
    $fd_eday = substr(date('Ymd',mktime(0, 0, 0, $m-2, $d, $y)),0,6)."01";  //�e�G�Ӥ�
    
    if($fd_eb02 > substr($fd_eb02,0,6).'25'){
      $fd_cday = mktime(0, 0, 0, $m+2, $d, $y);  //�W�L25�A��U�Ӥ�
    }else{
      $fd_cday = mktime(0, 0, 0, $m+1, $d, $y);  //25���A����
    }
    $fd_cday = substr(date('Ymd', $fd_cday),0,6);
    $fd_close = $fd_cday."06";  //���b��  upd by �Ϊ� 2012.02.10 (�ݿ�-14426)�^��95.3 �Τ@���w5�� 23:59:59   
    //echo $fd_ndate."-----".$fd_close."...";
    if($fd_ndate > $fd_close){  //���L���A��ܤU�Ӥ�  (��ñ���)
    	// �~�X��ƻP�e��G�������
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
    $fd_eb02 = mb_convert_encoding($_REQUEST["f_eb02"],'big5','utf-8'); //�~�X���
    $fd_eb12 = mb_convert_encoding($_REQUEST["f_eb12"],'big5','utf-8'); //�J�t������
    $fd_eb18 = mb_convert_encoding($_REQUEST["f_eb18"],'big5','utf-8'); //���s
    //big5�䴩�����D!����r�X�e���j�M������

    $fd_ndate = date("Ymd");  //�{�b���
    $y = substr($fd_eb02, 0, 4); //�~        
    $m = substr($fd_eb02, 4, 2); //��  
    $d = substr($fd_eb02, 6, 2); //��
    //$fd_eday = substr(date('Ymd',mktime(0, 0, 0, $m-2, $d, $y)),0,6)."";  //�e�G�Ӥ� 
    
    if($fd_eb02 > substr($fd_eb02,0,6).'25'){
      $fd_cday = mktime(0, 0, 0, $m+2, $d, $y);  //�W�L25�A��U�Ӥ�     
    }else{
      $fd_cday = mktime(0, 0, 0, $m+1, $d, $y);  //25���A����
    }
    $fd_cday = substr(date('Ymd', $fd_cday),0,6);
    $fd_close = $fd_cday."06";  //���b��  upd by �Ϊ� 2012.02.10 (�ݿ�-14426)�^��95.3 �Τ@���w5�� 23:59:59   
    //echo $fd_ndate."-----".$fd_close."...";
    if($fd_ndate > $fd_close){  //���L���A��ܤU�Ӥ�
    	// 1. �~�X��ƻP�e��G�������
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
    $f_var['hrmws']['parm'][1]['String'] = "SL-EIP2FLW"; //��O
    $f_var['hrmws']['parm'][2]['String'] = "00000000"; //�渹
    $f_var['hrmws']['parm'][3]['Int32'] = 2; //�n�O����(1.���ӽеn�O�B2.�����n�O)
    $f_var['hrmws']['parm'][4]['String'] = ""; //�X�t�ӽ�id (�p�G�����n�O���ŭ�)
    $f_var['hrmws']['parm'][5]['String'] = $_SESSION["login_hrm_empid"]; //���uID
    $f_var['hrmws']['parm'][6]['String'] = "701"; //�X�t����id  A1136|�X�t(�L�뭹)   A1136|�X�t(�L�뭹)
    $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($f_eb04,'UTF-8','big5'); //�X�t�a�I
    $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($f_eb02); //�}�l���
    $f_var['hrmws']['parm'][9]['String'] = substr($f_eb03,0,2).":".substr($f_eb03,2,2); //�}�l�ɶ�
    $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($f_eb06); //�������
    $f_var['hrmws']['parm'][11]['String'] = substr($f_eb07,0,2).":".substr($f_eb07,2,2); //�����ɶ�
    $f_var['hrmws']['parm'][12]['Int32'] = "0"; //�����𮧯Z��
    //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //�Ƶ�
    $f_var['hrmws']['parm'][13]['String'] = "-ajax_chkhrm"; //�Ƶ�
    $f_var['hrmws']['parm'][14]['Int32'] = "0"; //�����D�b���q�ɶ�
    $f_var['hrmws']['parm'][15]['Int32'] = "0"; //�����𮧯Z��?�[�Z�N�\�q�]0�_�A1�O�^
    sl_hrmws($f_var); 
    //if( '1530693'==$_SESSION["login_empno"] ){
    //  echo "<pre>";
    //  print_r($f_var['hrmws']);
    //  echo "</pre>";
    //  echo "<font color=red>";
    //  echo htmlspecialchars($f_var['hrmws']['pxml'],ENT_QUOTES)."<br>";
    //  echo "</font>";
    //}
    if( '0'==$f_var['hrmws']['status'] ){  //���Ҧ��\  �D0������
      $value = mb_convert_encoding("0; ",'UTF-8','big5');
    }else{
      $val  = "1;"; //�D0������        
      //if( ''==trim($f_var['hrmws']['status']) and ''==trim($f_var['hrmws']['error']) and strstr($f_eb04,"&")!=null ){
        //$val .= "�нT�{�u�e���a�I�v���o�s�b�u&�v�Ÿ�"; //���~�T��
      //}else{
        $val .= $f_var['hrmws']['error']; //���~�T��
      //}
      $val .= "\n�䥦���`�i��: �нT�{�u�e���a�I�v���o�s�b�u&�v�Ÿ�"; //���~�T��
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
    big5�䴩�����D!����r�X�e���j�M������
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
    if($rows > 0){ //�����
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
    big5�䴩�����D!����r�X�e���j�M������
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
  //    $value = mb_convert_encoding($ar['resda019'].';'.$ar['sleip2flw010'].';'.$fd_eb06,'UTF-8','big5'); //upd by �Ϊ� 2011.12.12 (����-15683)�}�񰪥å� 7966431 �ק悔�{  11/28.11/29.12/2
  //  }
    //$value2 .= mb_convert_encoding($value.";".sl_4ymd($value),'UTF-8','big5');  //upd by �Ϊ� 2011.12.12 (����-15683)�}�񰪥å� 7966431 �ק悔�{  11/28.11/29.12/2
  //  $value = json_encode($value);
  //  echo "$value\n";
  //  exit;
  //}
  /* ajax end */    

  /* ajax start */
  //if ($_REQUEST['msel']=='ajax_get_day') {
  //  $fd_sd = mb_convert_encoding($_REQUEST["f_sd"],'big5','utf-8');
    /*
    big5�䴩�����D!����r�X�e���j�M������
    */
  //  if ($fd_sd==null) return;
  //  $y = substr($fd_sd, 0, 4); //���e�|�X (�~)        
  //  $m = substr($fd_sd, 4, 2); //���̫�G��(��)
  //  $d = substr($fd_sd, 6, 2); //���̫�G��(��)
  //  $fd_sday = mktime(0, 0, 0, $m, $d, $y);      
  //  $add2day  = mktime(0, 0, 0, $m, $d+20, $y);   //��[20��
    //$lastmonth = mktime(0, 0, 0, $m, "01", $y);   //���M����Ĥ@�� 
    //$nowmonth = strtotime('+1 month -1 days', $lastmonth);   //���M����̫�@��      
  //  $fd_sd2 = date('Ymd', $add2day);
  //  $fd_sde = $fd_sd2 - 19110000;  //�����~
  //  $fd_sds = $fd_sd - 19110000; //�����~
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
  //       $value=$ar_date[$j]+19110000; //��褸�~
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

  session_start();  //upd by mimi 2009.04.23 �O���~�X�ժO�d�߱���
  include_once('ewb01_init.php');  // �����ﵽ�@�Φۭq��ƻP�ܼƳ]�w
  include_once(  "ewb_pay_init.php"  );
  u_setvar(&$f_var);            // �{���ܼƳ]�w,������ΰ}�C�ܼ�,���A�� global u_setvar(&$f_var),�ݭn��&,�ǭ�,�i�H�N�Ȧ^��,�᭱�~��έ�
  u_domain(&$f_var);  //�v�� ewb_pay_init.php
  include_once($sl_header_php); // header

  include_once(  $mtp_url."class.TemplatePower.inc.php"  ); //qq: $sl_tp_url ?
  $f_var["tp"] = new  TemplatePower (  $f_var['tpl']  );//'pa01.tpl';  // �˪��e����
  $f_var["tp"]-> assignInclude ("tb_sl_tpl_1","/home/sl/public_html/sl_tpl_1.tpl"      ); // �@�μ˪O��
  $f_var["tp"]-> prepare ();

  sl_open($f_var['mdb']); // �}�Ҹ�Ʈw
  $f_var['f_b_empno']=$_SESSION['login_empno'];
  $f_var['f_db']=$f_var['mdb'];
  $f_var['f_table']=$f_var['mtable']['head'];
  $f_var['f_file_path']='';
  $f_var['f_b_date']=date('Ymd');
  $f_var['f_file1']='';
  $f_var['f_file2']='';
  $f_var['f_file3']='';
//  $msg_title = "�~�X�ժO�۰��ন<font color=blue>�~�Xñ�ֳ�</font>��<font color=blue>���{ñ�ֳ�</font>,��11/07�_�w����Ϩϥ�.<br><br>
//                1. ��<font color=blue>�ը�ñ�ֳ�</font>ñ��<font color=red>�P�N</font>��A�Y�i�ק悔�{�A�æ۰���<font color=blue>���{ñ�ֳ�</font>�C<br>
//                2. ��<font color=blue>���{ñ�ֳ�</font>ñ��<font color=red>�P�N</font>��A�~�|�p���p�����βέp��C<br>
//                3. 11/07��A�ѩ�<font color=blue>�h�����{��J</font>���|�]ñ�֡A�ҥH���\�ಾ���A��<font color=blue>�浧</font>�ק�~�X���{�C<br>
//                4. �Y���ðݽи߰��`���q�`�ȲաC";
  $msg_title = "�~�X�ժO�۰��ন<font color=blue>�~�Xñ�ֳ�</font>��<font color=blue>���{ñ�ֳ�</font>,��11/07�_�w����Ϩϥ�.<br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;1. ��<font color=blue>�ը�ñ�ֳ�</font>ñ��<font color=red>�P�N</font>��A�Y�i�ק悔�{�A����<font color=blue>���{ñ�ֳ�</font>�C<br>
                &nbsp;&nbsp;&nbsp;&nbsp;2. ��<font color=blue>���{ñ�ֳ�</font>ñ��<font color=red>�P�N</font>��A�~�|�p���p�����βέp��C<br>
                &nbsp;&nbsp;&nbsp;&nbsp;3. 11/07��A�ѩ�<font color=blue>�h�����{��J</font>���|�]ñ�֡A�ҥH���\�ಾ���A��<font color=blue>�浧</font>�ק�~�X���{�C<br>
                <font color=red>��</font>4. <font size='3'><b>���`���q�W�w��11/26�_�A��J�^�{���{���਽�{ñ�ֳ�A�ݩ�<font color=red>ñ�ֵ���(�w�p�^�{��)��T�餺</font>�n�������C</b></font><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ex: ��Ǥ� 2011-12-21(�T)�A�䩹���T�鬰 2011-12-23(��)(�t)�e�n��g�����{�I���]�]�t��T�餺�I<br>
                <font color=red>��</font>5. <font color=red>�Y���ðݽи߰��`���q�`�ȲաC</font><br>
                <font color=red>��</font>6. <b>�sñ</b>ñ�֪��~�X��ơA���ɮɶ���<font color=red>���I</font>�A�Щ����ɵ�����A�i��ק�<br>
                <font color=red>��</font>7. <b>��g���{</b>�A�Щ�<font color=blue>�ը�ñ�ֳ�</font>ñ��<font color=red>�P�N</font>��A�A�i��ק��g�C<br>
                <font color=red>��</font>8. �p���{����A�N<font color=blue>���{ñ�ֳ�</font><font color=red>���</font>��A�i�A���ק悔�{���Ǩ��{ñ�ֳ�(��W�w�T�餺)�C<br>
                <font color=red>��</font>9. �p���{�n�����~�άO�w�W�L�n�������A���}��Ь��U��<font color=red>�޲z�ҽҪ�</font>�C
                ";

  //u_eip2del();  //add by �Ϊ�  2011.11.23  �Ҫ�����ñ�ֳ�p�����̡A�^��d_date�@�o   upd by �Ϊ� 2011.12.28 ����s���e���~����
  $f_var["tp"]-> newBlock ("tb_text_ndate");    //add by �Ϊ� 2011.11.24  ����ϥΪ̦ۦ��ܧ�t�Τ���A�ҥH�P�_����ĥ�servertime.html�����A���ɶ�
  $f_var["tp"]-> assign   ("tv_value" ,date("Y-m-d"));       
  switch ($f_var['msel']) {
       case "1": // �s�W-�e��  
         if( ''!=trim($f_var['hrmctrl']) ){ //add by �Ϊ� 2018.12.04 �̸�T����/�v���޲z/���s����ɶ�����]�w ����}��l�ήɶ�
           sl_errmsg($f_var['hrmctrl']);
         }   
         sl_chk_rak013(&$f_var);//add by mimi 2011.11.28 ����-15581 �T�{�O�_�����ݥD��
         //$f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by �Ϊ� 2011.12.28  �g�z���ܡA�N�W��`�N�ƶ����úP�|
         //sl_errmsg($msg_title);
         $f_var["tp"]->newBlock('tb_memo1');
         u_in_scr($f_var);
         $f_var["tp"]->newBlock('fd_script_eb13');
         $f_var["tp"]->newBlock('fd_script_eb01');
         $f_var["tp"]->newBlock('fd_script_close_eb12');  //add by �Ϊ� 2011.12.23  �s�W�~�X�ɡA�J�t���{���o��J�]���^ (�ݿ�-14426�^��61)
         break;
       case "11": // �s�W-�x�s
         if( 'Y'==$f_var['f_tohrm']){  //���T�w�����򦳤H���Ljson����, �bsave�e�A���Ҥ@��                                          
           $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
           $f_var['hrmws']['method'] = "CheckForESS";
           $f_var['hrmws']['parameterType'] = "";
           $f_var['hrmws']['parm'][1]['String'] = ''; //��O
           $f_var['hrmws']['parm'][2]['String'] = ''; //�渹
           $f_var['hrmws']['parm'][3]['Int32'] = 2; //�n�O����(1.���ӽеn�O�B2.�����n�O)
           $f_var['hrmws']['parm'][4]['String'] = ""; //�X�t�ӽ�id (�p�G�����n�O���ŭ�)
           $f_var['hrmws']['parm'][5]['String'] = $_SESSION["login_hrm_empid"]; //���uID
           $f_var['hrmws']['parm'][6]['String'] = "701"; //�X�t����id  A1136|�X�t(�L�뭹)   A1136|�X�t(�L�뭹)
           $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($f_var['f_eb04'],'UTF-8','big5'); //�X�t�a�I
           $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($f_var['f_eb02']); //�}�l���
           $f_var['hrmws']['parm'][9]['String'] = substr($f_var['f_eb03'],0,2).":".substr($f_var['f_eb03'],2,2); //�}�l�ɶ�
           $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($f_var['f_eb06']); //�������
           $f_var['hrmws']['parm'][11]['String'] = substr($f_var['f_eb07'],0,2).":".substr($f_var['f_eb07'],2,2); //�����ɶ�
           $f_var['hrmws']['parm'][12]['Int32'] = "1"; //�����𮧯Z��
           //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //�Ƶ�
           $f_var['hrmws']['parm'][13]['String'] = "-msel=11"; //�Ƶ�
           $f_var['hrmws']['parm'][14]['Int32'] = "1"; //�����D�b���q�ɶ�
           $f_var['hrmws']['parm'][15]['Int32'] = "1"; //�����𮧯Z��?�[�Z�N�\�q�]0�_�A1�O�^
           sl_hrmws($f_var);                            
           //echo "<pre>";
           //print_r($f_var['hrmws']);
           //echo "</pre>";      
           if( '0'!=$f_var['hrmws']['status'] ){ //���Ҧ��\  �D0������
             $fd_inLog  = "<font style='font-weight:bold;color:red;font-size:24px;'>�`�N!! �~�X��Ʀ�HRM���ҥ���, �~�X�ӽв��`</font><br>";
             $fd_inLog .= "status: ".$f_var['hrmws']['status']." (�D0������)<br>";
             $fd_inLog .= "error: <font style='font-weight:bold;color:blue;font-size:16px;'>".$f_var['hrmws']['error']."</font><br><br>";
             $fd_inLog .= "�X�t�a�I: ".$f_var['f_eb04']."<br>";
             $fd_inLog .= "�~�X���: ".sl_4ymd($f_var['f_eb02'])." ".substr($f_var['f_eb03'],0,2).":".substr($f_var['f_eb03'],2,2)."<br>";
             $fd_inLog .= "�^�{���: ".sl_4ymd($f_var['f_eb06'])." ".substr($f_var['f_eb07'],0,2).":".substr($f_var['f_eb07'],2,2)."<br>";
             $fd_inLog .= "<br><br><font style='font-weight:bold;color:red;'>�u�X�h�Ԭ�����JHR(���s)�v</font>�z��ܬ� <font style='font-weight:bold;color:red;'>Y</font> , HRM�M�ҫᦳ���`, ��ƵL�k��J, <br>�Х��T�{��J����Ʈ榡�L�~, �λP�U�ϤH�ƤF�Ѱ��D�᭫�s�n���C<br><br>";
             $fd_inLog .= "�i<a href='/~docs/ewb/ewb01.php?msel=1'>�^�~�X�s�W�e��</a>�j<br>";
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
           $f_var['f_eb17'] = "Y"; //����ƫh�����зǨ��{
         }        
         //echo "eb17: ".$f_var['f_eb17']."<br>";
         //exit;
         $f_var['f_cnt']='1';//upd by mimi 2011.06.13 �W�[���ɦ���
         //echo $_SESSION['login_job_id'].'****'.$f_var['domain'].'****'.$f_var['domain4'].'----'.$_SESSION['login_dept_id'].'******'.$f_var['domain2'];exit;
         if($f_var['domain4']<>''){//add by mimi 2012.01.12 ����-16058 �g�z�ťH�W�u�nñ�֤@�h type=11.�ը���(�g�z)
           $f_var['f_type']='11';
         }
         else{
           $f_var['f_type']=iif($f_var['domain1']<>'','3','1');//type=3.���y�ը��� type=1.�@��ը���
         }
         $to_date=date("Ymd");
         
         //add by �Ϊ� 2012.01.18 (����-16099)���a�� 7665865 12/26�_��1/13�~�X�s�W
         $fd_opensave = 'N';
         $f_var['qa16099'] = strstr('7665865',$_SESSION["login_empno"]);
         if($f_var['qa16099']<>null and ($f_var['f_eb02']>='20111226' and $f_var['f_eb02']<='20120113')){
           $fd_opensave = 'Y';
         }
         //add by �Ϊ� 2014.11.11 (����24995)�}�Ӥ�ը���ñ�֦��~
         $f_var['qa24995'] = strstr('1430451',$_SESSION["login_empno"]);
         if($f_var['qa24995']<>null and ($f_var['f_eb02']>='20141104' and $f_var['f_eb02']<='20141104')){
           $fd_opensave = 'Y';
         }         
         //$f_var['qa0515'] = strstr('0883608/1070263/8166480/1330776/7968256/1330011',$_SESSION["login_empno"]);
         //if($f_var['qa0515']<>null and ($f_var['f_eb02']>='20140509' and $f_var['f_eb02']<='20140515')){
         //  $fd_opensave = 'Y';  
         //}        
         if($f_var['f_eb02']>=$to_date or $fd_opensave=='Y'){  //�u��s�W >= ���Ѥ�����~�X���           
           $fd_eb023 =$f_var['f_eb02'].$f_var['f_eb03']; 
           $fd_eb067 =$f_var['f_eb06'].$f_var['f_eb07']; 
           if($fd_eb023<=$fd_eb067){
             //sl_save(&$f_var);
             //if('' <> $f_var['domain1'] or '' <> $f_var['domain2'] or '' <> $f_var['domain3']){//add by mimi 2011.06.02 �P�_���y�M��ƪ�,�~�n��ñ�֪�
               //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
               $query = "select *
                         from information_schema.TABLES 
                         where TABLE_SCHEMA = '{$f_var['mdb']}' and TABLE_NAME = '{$f_var['mtable']['head']}'
                      ";
               //echo $query."<BR>";
               //echo $row['AUTO_INCREMENT'];
               $result = mysql_query($query);
               $row =mysql_fetch_array($result);
               $f_var['f_s_num']=$row['AUTO_INCREMENT'];
               $f_var['f_title']=substr($f_var['f_eb09'],3)."�~�X�ը��� {$f_var['f_eb01']} ".date('m/d',strtotime($f_var['f_eb02']));
               if( 'Y'==$f_var['f_tohrm']){ 
                 $f_var['f_title']= "*".substr($f_var['f_eb09'],3)."�~�X�ը��� {$f_var['f_eb01']} ".date('m/d',strtotime($f_var['f_eb02']));
               }
               $f_var['f_content']="
�@�@�@�@�@�@�~�X����G".date('m/d',strtotime($f_var['f_eb02']))." ".date('H:i',strtotime($f_var['f_eb03']))." ~ ".date('m/d',strtotime($f_var['f_eb06']))." ".date('H:i',strtotime($f_var['f_eb07']))."
�@�@�@�@�@�@��p�϶��G{$f_var['f_eb16']} ~ {$f_var['f_eb04']}   

�@�@�@�@�@�@�~�X�ƥѡG{$f_var['f_eb05']}  
�@�@�@�@�@�@�@�@���ءG".substr($f_var['f_eb09'],3)." ".substr($f_var['f_eb10'],3)."
����ե��a����30�����G{$f_var['f_eb24']}�@�^�Ʋ��G{$f_var['f_eb14']}�@�����H�ơG{$f_var['f_eb15']}   
�@�@�@�@�@�@�@�@�Ƶ��G{$f_var['f_eb08']}
�@�@�@�@�@�@������G".date('Y/m/d H:i')."
�@�@�@�@";
//�����зǨ��{�G{$f_var['f_eb17']}�@�^�Ʋ��G{$f_var['f_eb14']}�@�����H�ơG{$f_var['f_eb15']}
//   upd by �Ϊ� 2011.10.05 (�ݿ�-14426 �^��30)  
//               $f_var['f_title']="{$f_var['f_eb01']} �~�X�ը���";           
//               $f_var['f_content']="
//�@�@�P���m�W�G{$f_var['f_sname']}-{$f_var['f_eb01']}
//
//�@�@�~�X����G".date('Y/m/d',strtotime($f_var['f_eb02']))." ".date('H:i',strtotime($f_var['f_eb03']))."
//�@�@�e���a�I�G{$f_var['f_eb04']}   
//  
//�@�@�^�{����G".date('Y/m/d',strtotime($f_var['f_eb06']))." ".date('H:i',strtotime($f_var['f_eb07']))."
//�@�@�^�{�a�I�G{$f_var['f_eb16']}
//  
//�@�@�e���ƥѡG{$f_var['f_eb05']}  
//�@�@�@�@���ءG{$f_var['f_eb09']}
//�@�@�@�Ʈ�q�G{$f_var['f_eb10']} 
//�����зǨ��{�G{$f_var['f_eb17']} 
//�@�@�@�^�Ʋ��G{$f_var['f_eb14']}   
//�@�@�����H�ơG{$f_var['f_eb15']}   
//�@�@�@�@�Ƶ��G{$f_var['f_eb08']}
//�@�@���ɤ���G".date('Y/m/d H:i:s')."
//�@�@�@�@";

             if(u_chk_ewb01($f_var)){ //add by �Ϊ� 2011.11.23  �d�\�O�_���зs�W
               $f_var['chkewb'] = "y";   
               /*if( 'S181'==$_SESSION["login_dept_id"] ){  //add by �Ϊ� ����32441-ñ�֦ܽ]�ֳ̰��D��
                 ul_eip2flw(&$f_var);
               }else mark by �p��20191022����37078 �N�]�֥~�X�ժO��אּ�̷ӭ�]�w �G��*/ 
               if( strstr('1730055/1130091',$_SESSION["login_empno"])!=NULL ){
                 sl_eip2flwV2(&$f_var);       
               }else{
                 sl_eip2flw(&$f_var);//add by mimi 2011.06.02 ��ñ�֪�
               }
                 
               //}  //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
               sl_open('docs');
               sl_save(&$f_var);//upd by mimi 2011.11.18 �אּ���g�Jñ�֪��A�^�JEIP    

                 
                 
             }else{
               $f_var['chkewb'] = "n";
               sl_errmsg("�~�X/�w�p�^�{����ɶ��w�����и�Ʀs�b,�нT�{��ƬO�_���~!");//add by mimi 2012.01.06 �W�[���~�����ܰT��~ 
             }
           }
           else{
             sl_errmsg("�нT�{�~�X/�w�p�^�{����ɶ�,�O�_���~!"); 
           }
         }
         else{
           sl_errmsg("�~�X������~!"); 
         }
         break;
       case "2": // �ק�
         
         sl_chk_rak013(&$f_var);//add by mimi 2011.11.28 ����-15581 �T�{�O�_�����ݥD��
         //add by �Ϊ�  2011.10.17 �P�_es03���O�_�]�w��y�A�p�O�h�]�w���������{120
         $sql_set = "select docs.ewb_pay_emp_set.es02
                 from   docs.ewb_pay_emp_set 
                 where  docs.ewb_pay_emp_set.es02 = '{$_SESSION["login_empno"]}' and 
                        docs.ewb_pay_emp_set.es03 = 'Y'
                ";
         $rs_set = mysql_query($sql_set);
         $count_set = mysql_num_rows($rs_set);
         if($count_set>0){
           $fd_eb17 = "Y"; //����ƫh�����зǨ��{
         }else{
           $fd_eb17 = "N";
         }         
         echo "<input name='fdny' type='hidden' value='{$fd_eb17}'>";  //add by �Ϊ�  2011.10.17 �@��javascript�O�_��w�u�����зǨ��{�v���̾�        
         $f_var["tp"]->newBlock('tb_memo2');
         //sl_errmsg("�~���ժO�s���q�lñ�֨t��,��6/7�_�󪫬y�B����ϥ�,�̰���z����,����e�@�Ѷ�g.");
         //20110411 �Ϊ� (�W�[��o�K�έp���P�_ ewb_pay01.php)
         $f_var['check_mwhere']="{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
         $sql = "select {$f_var['mtable']['head']}.*
                 from   {$f_var['mtable']['head']}
                 where  {$f_var['check_mwhere']}
                ";     //20110607-(����13954)- �Nwhere����and ewb01.eb19<>''����
         $rs = mysql_query($sql);
         //$check_total = mysql_num_rows($rs);
         $ar = mysql_fetch_assoc($rs);
         //if($ar['eb19'] != ''){  //�w���ɲ��Ͳέp��(ewb_pay01.php)
         if($ar['eb22'] != ''){  // upd by �Ϊ� 2012.05.29 �@�b�~�뤣���ťաA��ܤw�@�b�o�o�K
           sl_errmsg("�w��p�����ίӪo�έp��! �L�k�ק���! ");
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
                                 WHEN resda021 = '' THEN '<font color=blue>ñ�ֶi�椤</font>'
                                 WHEN resda021 = '1' THEN '<font color=blue>ñ�ֶi�椤</font>'
                                 WHEN resda021 = '2' THEN '<font color=#006600>�w�P�N</font>'
                                 WHEN resda021 = '3' THEN '<font color=red>���P�N</font>'
                                 WHEN resda021 = '4' THEN '<font color=red>�w���</font>'
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
             $num = mysql_num_rows($result);  //����
             if($num > 0){
              while($row = mysql_fetch_array($result)){
                if('1'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'])){ //�ը��� ������,���P�N,�w��泣���i�A�ק�
                  $fd_upd_chk="N";
                  $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} �ը�ñ�ֳ�ثe���{$row['resda021_list']},�]�����i�i��ק�C";
                }else if( '1'==$row['sleip2flw011'] and '2'==$row['resda021'] ){
                  $fd_upd_chk="Y"; //upd by 7/21ñ�ֳ榳���D�B�z
                }
                if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '2'==$row['resda021'])){ //�ը��� ������,���P�N,�w��泣���i�A�ק�
                  //if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'])){ //�ը��� ������,���P�N,�w��泣���i�A�ק�
                  $fd_upd_chk="N";
                  $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} ���{ñ�ֳ� �ثe���{$row['resda021_list']},�]�����i�i��ק�C";
                }
                
                if(('1'==$row['sleip2flw008'] or '3'==$row['sleip2flw008'] or '11'==$row['sleip2flw008']) and '2'==$row['resda021']){ //�ը��欰�P�N��
                  $fd_resda19 = $row['resda019'];
                }
                if('4'==$row['sleip2flw008'] and '3'==$row['resda021']){  //���{ñ�ֳ椣�P�N��
                  $fd_resda194 = $row['resda019'];
                }                
                //if('4'==$row['sleip2flw008'] and '2'==$row['resda021']){  //���{ñ�ֳ�P�N��
                //  $fd_qa1223_2 = 'Y';
                //}                                        
              }
             }
             
             $fd_sign = substr($ar['eb06'], 0, 4)."-".substr($ar['eb06'], 4, 2)."-".substr($ar['eb06'], 6, 2); //�w�p�^�{����K�X         
             if($fd_resda19<$fd_sign){  //add by �Ϊ� 2011.12.22   ��w�p�^�{����j��ñ�֤���� 
               $fd_resda19 = $fd_sign;       
             }
             if($fd_resda194>$fd_resda19 and $fd_resda194>$fd_sign){  //���{ñ�ֳ椣�P�N�̡A������`�A�줣�P�N�檺���פ��
               $fd_resda19 = $fd_resda194;
             }
             $fd_setdate = str_replace('-','',substr($fd_resda19,0,10)); //�� 2012-05-31  -> 21020531
             $fd_resda19 = $fd_setdate;  //�����̤j���ɩβ��ʤ��           
             
             //if( '8365628'==$_SESSION["login_empno"] ){
             //    echo $fd_resda19.'<br>';
             //  }
                                
             //ECHO $fd_resda19;
             //�j�M�~�X�ժO�}��ק�]�w�ɬO�_�����---------------------------------------------// 
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
                       ";  //�j�M ewb_set03 �O�_���]�w�}��~�X
             //echo '<pre>'.$query_es.'</pre>';
             $result_es  = mysql_query($query_es);
             $num_es = mysql_num_rows($result_es);  //����
             if($num_es>0){             
               $row_es = mysql_fetch_array($result_es);
               $fd_start_eb02 = $row_es['es03'];  //�����̤p�~�X��_
               $fd_end_eb02   = $row_es['es04'];  //�����̤j�~�X�騴
               $fd_setdate = str_replace('-','',substr($row_es['date'],0,10)); //�� 2012-05-31  -> 21020531
               //$fd_resda19 = $fd_setdate;  //�����̤j���ɩβ��ʤ��  
               
               //upd by �Ϊ� 2013.11.22 �Ҫ��ӯ�A�L�g�z11/18���o�ק���{�A�]�����H�ܳ]�w�ɤ��]�w�H���}��ק悔�{�A�{���|�P�_�إߤ�b_date �Ӱ����̾ڶ}��I���
               if( $fd_resda19<$fd_setdate ){ //ñ�֧����� < �]�w�}��� �A�~�H�]�w�ɤ��}��鬰�D
                 $fd_resda19 = $fd_setdate;  //�����̤j���ɩβ��ʤ��  
               }
             
             }    

             //�p��T�Ѥ��ư���w����-----------------------------------------------------------// 
             $cal_cnt=0;
             $y = substr($fd_resda19, 0, 4); //�~          
             $m = substr($fd_resda19, 4, 2); //��  
             $d = substr($fd_resda19, 6, 2); //��        
             for($fd_cnt=0;$fd_cnt<='3';$fd_cnt++){ //�T�Ѥ������w����       
               $fd_resda192_mk = mktime(0, 0, 0, $m, $d+$cal_cnt, $y);  //upd by �Ϊ� 2012.04.14 �C�X������~
             	 $fd_resda192    = date('Ymd', $fd_resda192_mk);
             	 $ch_resda192    = $fd_resda192 - 19110000;
             	 
             	 //echo $y."---".$m."---".$d."---".$fd_resda192."---".$ch_resda192."<br>"; 
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
                 //add by �Ϊ� 2013.01.02 �H�ư�w����]�w�ɥ���J sle0a �A���Ȯɥ[�W��w�P�_
                 //if( strstr("1020101/1020105/1020106/1020112/1020113/1020119/1020120/1020126/1020127","{$ch_resda192}") ){
                 //  $fd_cnt-=1;
                 //}
                 //if( strstr("1020202/1020203/1020209/1020210/1020211/1020212/1020213/1020214/1020215/1020216/1020217/1020224/1020228","{$ch_resda192}") ){
                 //  $fd_cnt-=1;
                 //}                 
               //}
               $cal_cnt++;
               
               
               
            }
            
            //�]�w���b��------------------------------------------------------------------------// 
            $fd_ndate = date("Ymd");  //�{�b���
            //add by �Ϊ� 2012.01.03 ���b����
            $y2 = substr($ar['eb02'], 0, 4); //���e�|�X (�~)        
            $m2 = substr($ar['eb02'], 4, 2); //���̫�G��(��)  
            $d2 = substr($ar['eb02'], 6, 2); //��
            if($ar['eb02']>substr($ar['eb02'],0,6).'25'){
              $fd_sday3 = mktime(0, 0, 0, $m2+2, $d2, $y2);  //�W�L25�A��U�Ӥ�
            }else{
              $fd_sday3 = mktime(0, 0, 0, $m2+1, $d2, $y2);  //25���A����
            }
            $fd_sday3 = substr(date('Ymd', $fd_sday3),0,6);
            $fd_close = $fd_sday3."06";  //�w�]���b��  upd by �Ϊ� 2012.02.10 (�ݿ�-14426)�^��95.3 �Τ@���w5�� 23:59:59            
            
            //�}��T���K���׭ק悔�{----------------------------------------------------------//
            //�Q�]�w��ñ���~�X��ơA�O�d�T�Ӥ�A�W�L�������P���  (�ݿ�14426 �^��137) 
            if($num_es>0 AND 'N'!=$fd_upd_chk ){ //�pset03 �]�w�}��ק靈�Ȫ��ܡA�d�ݬO�_�}��   upd by �Ϊ� 2016.06.24 ����29315-�W�[$fd_upd_chk�P�_
              $y3 = substr($fd_close, 0, 4); //���e�|�X (�~)        
              $m3 = substr($fd_close, 4, 2); //���̫�G��(��)  
              $d3 = substr($fd_close, 6, 2); //��            	   	
              $fd_vdate  = date('Ym',mktime(0, 0, 0, $m3+3, $d3, $y3))."05";
              //echo $ar['eb20']."---".$fd_ndate."---".$fd_vdate."---".$fd_resda192."<br>";
              if($ar['eb02']>=$fd_start_eb02 and $ar['eb02']<=$fd_end_eb02){  //�}��~�X����϶� 
                 //if($fd_ndate<=$fd_resda192 and $fd_ndate<$fd_close){ //�����b�餺
                 if($ar['eb20']=='N'){ //��ñ���
                   if($fd_ndate<=$fd_vdate){  //upd by 2012.05.30 (�ݿ�14426 137)�}��T�Ӥ�
                     u_in_scr($f_var);
                     $f_var["tp"]->newBlock('fd_script_eb01');   
                     $fd_openkey='Y'; //�w�}��  
                   }else{
                     sl_errmsg("�w�W�L�}���(".sl_4ymd($fd_vdate).")�I");
                   }
                 }else{
                   if($fd_ndate<=$fd_resda192){  //�D��ñ��ơA�}������̶}��T��
                     u_in_scr($f_var);
                     $f_var["tp"]->newBlock('fd_script_eb01');   
                     $fd_openkey='Y'; //�w�}��  
                   }else{
                     sl_errmsg("�w�W�L�}���(".sl_4ymd($fd_resda192).")�I");
                   }
                 }
                 //if($fd_ndate<=$fd_vdate){  //upd by 2012.05.30 (�ݿ�14426 137)�}��T�Ӥ�
                 //  u_in_scr($f_var);
                 //  $f_var["tp"]->newBlock('fd_script_eb01');   
                 //  $fd_openkey='Y'; //�w�}��  
                 //}else{
                 //  sl_errmsg("�w�W�L�}���(".sl_4ymd($fd_resda192).")�A�Τw���b(".sl_4ymd($fd_close).")�I");
                 //}                 
              }             
            } 
            //ECHO $fd_resda192;
             sl_open('docs');
             if('N'==$fd_upd_chk and $fd_openkey<>'Y'){
               sl_errmsg($fd_noupd_msg);
             }
             else if($fd_openkey<>'Y'){  // $fd_openkey �w�}��L(����X�{�G�� IN_SCR)
               //echo $fd_ndate."-----".$fd_resda192."<br>";
               if($fd_ndate<=$fd_resda192){
                 if($fd_ndate<$fd_close){
                   u_in_scr($f_var);
                   $f_var["tp"]->newBlock('fd_script_eb01');
                 }else{   //add by �Ϊ� 2012.01.03 �p����w���b��A�h����ק�
                   sl_errmsg("�w���b�I(".sl_4ymd($fd_close)."), �U���`�ȸg��H���w�J����!");
                 }
               }else{
                 sl_errmsg("�ݩ�ը���ñ�ֵ��׫�T�餺�A".sl_4ymd($fd_resda192)." (�t)���A��g�����{ñ�ֳ�! <br>�p���}��, ���p��<font color=blue>�U�Ϻ޲z�ҽҪ�</font>�ӽж}��!");
               } 
             }
           }
           else{
             sl_errmsg("�D���H�A�L�k�ק���! ");
           }
         }
         break;
       case "21": // �ק�-�x�s
         $sql = "select *
                 from   ewb01
                 where  s_num='{$f_var['f_s_num']}' ";
         $result = mysql_query($sql);
         $row = mysql_fetch_array($result);
         //echo $row['eb09']."<br>".$row['eb10'];
         
         //$f_var['f_eb09'] = $row['eb09'];   //�ק�ɡA���ءB�Ʈ�q���ק� mark by �Ϊ� 2012.12.21 (��18956)
         //$f_var['f_eb10'] = $row['eb10'];          
         $f_var['f_eb17'] = $row['eb17']; //�����зǨ��{���ק�
              
         //echo "eb17: ".$f_var['f_eb17']."<br>";       
         //exit;
         //echo $f_var['f_eb13']."----".$f_var['f_eb12']."-----".$f_var['f_eb11']."<br>";
         //exit;   
         if($f_var['f_eb12']<>'' and $f_var['f_eb12']<>'0' ){  //add by �Ϊ� 2012.02.14  ����javascript���ġA�x�s�ɦA�p��@�����{��
           $f_var['f_eb13'] = $f_var['f_eb12']-$f_var['f_eb11'];
         }
         
     
         //echo $f_var['f_eb13'];
         //exit;   
         sl_open('docs');
         sl_save(&$f_var);
         break;
       case "3": // �@�o     
         //sl_errmsg("�~���ժO�s���q�lñ�֨t��,��6/7�_�󪫬y�B����ϥ�,�̰���z����,����e�@�Ѷ�g.");
         $fd_upd_chk="N";
         $count_table= substr_count($f_var['mtable']['head'],'.');
         $ex_table   = explode('.',$f_var['mtable']['head']);
         $fd_table   = iif($count_table==0,$f_var['mtable']['head'],$ex_table[1]);
         sl_openef2k('EF2KWeb');  // �}�Ҹ�Ʈw
         $sql_flw = "select sleip2flw.*,
                            resda.resda019,
                            resda.resda020,
                            resda.resda021,
                            CASE 
                              WHEN resda.resda021 = '' THEN '<font color=blue>ñ�ֶi�椤</font>'
                              WHEN resda.resda021 = '1' THEN '<font color=blue>ñ�ֶi�椤</font>'
                              WHEN resda.resda021 = '2' THEN '<font color=#006600>�w�P�N</font>'
                              WHEN resda.resda021 = '3' THEN '<font color=red>���P�N</font>'
                              WHEN resda.resda021 = '4' THEN '<font color=red>�w���</font>'
                            END AS resda021_list,
                            CASE 
                              WHEN resda.resda021 = '' THEN 'ñ�ֶi�椤'
                              WHEN resda.resda021 = '1' THEN 'ñ�ֶi�椤'
                              WHEN resda.resda021 = '2' THEN '�w�P�N'
                              WHEN resda.resda021 = '3' THEN '���P�N'
                              WHEN resda.resda021 = '4' THEN '�w���'
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
         $num        = mssql_num_rows($result_flw);  //����
         if( $num>0 ){
           while($row = mssql_fetch_array($result_flw)){
             // sleip2flw011 ��e����  ;  resda021 ñ�ֵ��G 1=������,2=�P�N,3=���P�N,4=�w���
             if('1'==$row['sleip2flw011'] and ( ''==$row['resda021'] or '1'==$row['resda021'] ) ){ //�ը��� ������
               $fd_btn_txt = "���@�o";
               $fd_upd_chk = "Y";                                
               //$fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} �ը�ñ�ֳ�ثe���{$row['resda021_list']},�]�����i�i��@�o�C";
               $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} �ը�ñ�ֳ�ثe���{$row['resda021_list']}�C";
               $fd_msgbox_1 ="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']}";
               $fd_msgbox_2 ="�ը�ñ�ֳ�ثe��ܡy{$row['resda021_msg']}�z";
               $fd_msgbox_3 ="�ը�ñ�ֳ�( �渹�G{$row['sleip2flw002']} )�i���j�F�~�X�ժO�ӥ~�X��ơi�@�o�j";
             }
             if('2'==$row['sleip2flw011'] and ( ''==$row['resda021'] or '1'==$row['resda021'] ) ){ //��ñ�� ������ 
               $fd_btn_txt = "���";
               $fd_upd_chk="Y";
               //$fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} ���{ñ�ֳ� �ثe���{$row['resda021_list']},�]�����i�i��@�o�C";
               $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} ���{ñ�ֳ� �ثe���{$row['resda021_list']}�C";
               $fd_msgbox_1 ="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']}";
               $fd_msgbox_2 ="���{ñ�ֳ�ثe��ܡy{$row['resda021_msg']}�z";
               $fd_msgbox_3 ="���{ñ�ֳ�( �渹�G{$row['sleip2flw002']} )�i���j";               
             }
             if( '2'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'] ){
               $fd_btn_txt = "�@�o";
               $fd_upd_chk="Y";
               $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} ���{ñ�ֳ� �ثe���{$row['resda021_list']}�C";
               $fd_msgbox_1 ="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']}";
               $fd_msgbox_2 ="�ը�ñ�ֳ�ثe��ܡy{$row['resda021_msg']}�z";
               $fd_msgbox_3 ="�~�X�ժO�ӥ~�X��ơi�@�o�j";               
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
                             WHEN resda021 = '' THEN '<font color=blue>ñ�ֶi�椤</font>'
                             WHEN resda021 = '1' THEN '<font color=blue>ñ�ֶi�椤</font>'
                             WHEN resda021 = '2' THEN '<font color=#006600>�w�P�N</font>'
                             WHEN resda021 = '3' THEN '<font color=red>���P�N</font>'
                             WHEN resda021 = '4' THEN '<font color=red>�w���</font>'
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
         $num = mysql_num_rows($result);  //����
         if($num > 0){
          while($row = mysql_fetch_array($result)){
            if('1'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '3'==$row['resda021'] or '4'==$row['resda021'])){ //�ը��� ������,���P�N,�w��泣���i�A�ק�
              $fd_upd_chk="N";
              $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} �ը�ñ�ֳ�ثe���{$row['resda021_list']},�]�����i�i��@�o�C";
            }
            if('2'==$row['sleip2flw011'] and (''==$row['resda021'] or '1'==$row['resda021'] or '2'==$row['resda021'])){ //�ը��� ������,���P�N,�w��泣���i�A�ק�
              $fd_upd_chk="N";
              $fd_noupd_msg="��O�G{$row['sleip2flw001']}�@�渹�G{$row['sleip2flw002']} ���{ñ�ֳ� �ثe���{$row['resda021_list']},�]�����i�i��@�o�C";
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
       case "31": // �@�o-�x�s
         $sql_tr = "select tohrm
                    from   docs.ewb01
                    where  s_num = '{$f_var['f_s_num']}'
                           and d_date = '0000-00-00 00:00:00'
                           and tohrm = 'Y'
                   ";
         $res_tr = mysql_query($sql_tr);
         $qty_tr = mysql_num_rows($res_tr);
         if($qty_tr > 0){
           if( ''!=trim($f_var['hrmctrl_ing2']) ){ //add by �Ϊ� 2018.12.04 �̸�T����/�v���޲z/���s����ɶ�����]�w ����}��l�ήɶ�
             sl_errmsg($f_var['hrmctrl_ing2']."<br><a href='/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}' target=_blank><font color=red>�^�s���e��</font></a>");
             exit;
           }
         }
         //upd by �Ϊ� 2013.12.27 ����22017 �W�[�@�o�\��
         // �ը���(ñ�֤�)   -> �ը�����B �~�X��Ƨ@�o
         // �ը���(ñ�֧���) -> �~�X��Ƨ@�o
         // ���{��(ñ�֤�)   -> ���{����
         // ���{��(ñ�֧���) -> �~�X��Ƨ@�o        
         sl_openef2k('EF2KWeb');  // �}�Ҹ�Ʈw
         $sql_flw = "select sleip2flw.*,
                           resda.resda019,
                           resda.resda020,
                           resda.resda021,
                           CASE 
                             WHEN resda.resda021 = '' THEN '<font color=blue>ñ�ֶi�椤</font>'
                             WHEN resda.resda021 = '1' THEN '<font color=blue>ñ�ֶi�椤</font>'
                             WHEN resda.resda021 = '2' THEN '<font color=#006600>�w�P�N</font>'
                             WHEN resda.resda021 = '3' THEN '<font color=red>���P�N</font>'
                             WHEN resda.resda021 = '4' THEN '<font color=red>�w���</font>'
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
         $fd_sla015002 = $ar_flw['sleip2flw002']; //�渹       
         
         if('2'==$ar_flw['sleip2flw011'] and ( ''==$ar_flw['resda021'] or '1'==$ar_flw['resda021'] ) ){ //��ñ�� ������(���@�o�~�X�ժO) 
           u_del_flw($fd_sla015002); //���              
         }else if( '1'==$ar_flw['sleip2flw011'] and (''==$ar_flw['resda021'] or '1'==$ar_flw['resda021']) ){ //�ը���ñ�֤��A���and�@�o�~�X���
           u_del_flw($fd_sla015002); //��� 
           u_del_ewb($f_var); //�@�o�~�X���
         }else{
           u_del_ewb($f_var); //�@�o�~�X���
         }
         if( date("Ymd")>='20180701' ){
           ul_essf21($f_var['f_s_num'],"3",$_SESSION["login_hrm_empid"]); 
           //mark by �Ϊ� 2018.09.05 popen �X�{ Resource temporarily unavailable �䤣���],�ثe���J�I����,���X��fucntion
           //$t_path = "/home/docs/public_html/ewb/t_essf21.php {$f_var['f_s_num']} 3 {$_SESSION["login_hrm_empid"]} &";
           //$t_popen = popen($t_path,"r");
           //while ($t_popen and !feof($t_popen)) {      //?�q�D�������o?��
           //  $out = fgets($t_popen, 4096);
           //  //echo $out;         //���L�X?
           //}
           //pclose($t_popen);
         }    
         echo sl_jreplace("/~docs/ewb/ewb01.php");	
                  
         
         //sl_save(&$f_var);
         break;
       case "4": // �s��        
         //sl_errmsg($msg_title);
         //u_eip2del();  //add by �Ϊ�  2011.11.23  �Ҫ�����ñ�ֳ�p�����̡A�^��d_date�@�o
         $f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by �Ϊ� 2011.12.28  �g�z���ܡA�N�W��`�N�ƶ����úP�|
         $_SESSION['f_b_dept_id']= $f_var['f_b_dept_id'];
         $_SESSION['f_sname']    = $f_var['f_sname'];    
         $_SESSION['f_eb01']     = $f_var['f_eb01'];           
         $_SESSION['f_order']    = $f_var['f_order'];          
         $_SESSION['f_dateb']    = $f_var['f_dateb'];          
         $_SESSION['f_datee']    = $f_var['f_datee']; 
         //echo $_SESSION['f_eb01'];
         u_list(&$f_var);
         break;
       case "41": // �s��
         //sl_errmsg("�~���ժO�s���q�lñ�֨t��,��6/7�_�󪫬y�B����ϥ�,�̰���z����,����e�@�Ѷ�g.");
         u_disp($f_var);
         break;
       case "5": // �d��-showform
         //sl_errmsg("�~���ժO�s���q�lñ�֨t��,��6/7�_�󪫬y�B����ϥ�,�̰���z����,����e�@�Ѷ�g.");
         $f_var["tp"]->newBlock('tp_in_prn_7');
         $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=4&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}");
         $f_var["tp"]->assign('tv_title' , "�п�J�d�߱���");
         list_disp($f_var);
         break;
       case "7": // �C�L��J�e��
         if('1'==$f_var['num']){
           $f_var["tp"]->newBlock('tp_in_prn_7');
           $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=71&num=1");
           $f_var["tp"]->assign('tv_title' , "�п�J�C�L����");
           list_disp($f_var);
         }
         if('2'==$f_var['num']){
           $f_var["tp"]-> newBlock ("fd_script_showmsg"); //upd by �Ϊ� 2011.12.28  �g�z���ܡA�N�W��`�N�ƶ����úP�|
           $f_var["tp"]->newBlock('fd_script_msel72');
           prn_que($f_var);
         }
         break;
       case "71":  // �C�L�e��
          if('1'==$f_var['num']){
           list_prn1($f_var);//�C�L�e��-��ܦC�L
          }
          if('2'==$f_var['num']){
           list_prn2($f_var);//�C�L�e��-�p������
          }
          if('3'==$f_var['num']){
           list_prn3($f_var);//�C�L�e��-�ը���
          }
          break;
       case "8": // �਽�{ñ�ֳ�
         $f_var['f_cnt'] ='2';//upd by mimi 2011.06.13 �W�[���ɦ��� 
         $f_var['f_type']=iif($f_var['domain4']<>'','12','4');//upd by mimi 2012.01.12 ����-16058 �g�z�ťH�W�u�nñ�֤@�h type=4.���{ñ�ֳ� type=12.���{ñ�ֳ�(�g�z)
         $query = "select *, docs.ewb01.s_num as fs_num
                    from docs.ewb01  
                      left join sl.dept on dept.dept_id = ewb01.b_dept_id and dept.stop='N'
                    where ewb01.s_num='{$f_var['f_s_num']}'
                   ";
         //echo $query."<BR>";
         $result = mysql_query($query);
         $row =mysql_fetch_array($result);
         $f_var['f_title']=substr($row['eb09'],3)."��ڨ��{ñ�ֳ� {$row['eb01']} ".date('m/d',strtotime($row['eb02']));
         //echo $f_var['f_title'];exit;
         $f_var['f_content']="
�@�@�~�X����G".date('m/d',strtotime($row['eb02']))." ".date('H:i',strtotime($row['eb03']))." ~ ".date('m/d',strtotime($row['eb06']))." ".date('H:i',strtotime($row['eb07']))."
�@�@��p�϶��G{$row['eb16']} ~ {$row['eb04']}   
�@�@��p���{�G{$row['eb13']} km ({$row['eb12']}-{$row['eb11']})
  
�@�@�~�X�ƥѡG{$row['eb05']}
�@�@�p���Ʈ�G".substr($row['eb10'],3)."�@����ե��a����30�����G{$row['eb24']}�@�^�Ʋ��G{$row['eb14']}�@�����H�ơG{$row['eb15']}
�@�@������G".date('Y/m/d H:i:s')."
�@�@�@�@";
//�p���Ʈ�G".substr($row['eb10'],3)."�@�����зǨ��{�G{$row['eb17']}�@�^�Ʋ��G{$row['eb14']}�@�����H�ơG{$row['eb15']}        
/*    upd by �Ϊ� 2011.10.05 (�ݿ�-14426 �^��29)       
         $f_var['f_title']="{$row['eb01']} ���{ñ�ֳ�";
         //echo $f_var['f_title'];exit;
         $f_var['f_content']="
      ���{�ơG{$row['eb13']}({$row['eb12']}-{$row['eb11']})
        
    �P���m�W�G{$row['sname']}-{$row['eb01']}
    
�@�@�~�X����G".date('Y/m/d',strtotime($row['eb02']))." ".date('H:i',strtotime($row['eb03']))."
�@�@�e���a�I�G{$row['eb04']}   

�@�@�^�{����G".date('Y/m/d',strtotime($row['eb06']))." ".date('H:i',strtotime($row['eb07']))."
�@�@�^�{�a�I�G{$row['eb16']}  
  
�@�@�e���ƥѡG{$row['eb05']}  
�@�@�@�@���ءG{$row['eb09']}
�@�@�@�Ʈ�q�G{$row['eb10']} 
�����зǨ��{�G{$row['eb17']} 
�@�@�@�^�Ʋ��G{$row['eb14']}   
�@�@�����H�ơG{$row['eb15']}   
�@�@�@�@�Ƶ��G{$row['eb08']}
�@�@���ɤ���G".date('Y/m/d H:i:s')."
�@�@�@�@";
*/
         if(u_chk_sign2flw4($row)){ // add by �Ϊ� 2011.12.06 ����еo�e���{ñ�ֳ�
           //echo "�L����";
           //exit;
           u_save_log($row); //add by �Ϊ� 2012.02.13 �W�[�������p�϶�table   ewb01_adr
           /*if( 'S181'==$_SESSION["login_dept_id"] ){ //add by �Ϊ� ����32441-ñ�֦ܽ]�ֳ̰��D��
             ul_eip2flw(&$f_var);
           }else mark by �p��20191022����37078 �N�]�֥~�X�ժO��אּ�̷ӭ�]�w �G��*/ 
           if( strstr('1730055/1130091',$_SESSION["login_empno"])!=NULL ){
             sl_eip2flwV2(&$f_var);     
           }else{
             sl_eip2flw(&$f_var);//add by mimi 2011.06.02 ��ñ�֪�
           }    
           //sl_eip2flw(&$f_var);//add by mimi 2011.06.02 ��ñ�֪�
           echo "<script language='JavaScript'>";
           echo "alert('�w��ܭ��{ñ�ֳ� {$f_var['f_resdz001']}-{$f_var['f_resdz002']} �Ыe���d�ݡC');";
           echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           echo "</script>";
         }else{
           //if($row['eb18']=='8266174' and $row['eb02']=='20111227'){  //add by �Ϊ� 2012.01.11 (����-16047)�ѩ��o��12/27�w���{ñ�ֹL�A�ҥH���B�~�W�[�P�_�]ñ��
           //  sl_eip2flw(&$f_var);//add by mimi 2011.06.02 ��ñ�֪�
           //  echo "<script language='JavaScript'>";
           //  echo "alert('�w��ܭ��{ñ�ֳ� {$f_var['f_resdz001']}-{$f_var['f_resdz002']} �Ыe���d�ݡC');";
           //  echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           //  echo "</script>";           
           //}             
           //echo "���зs�W";
           echo "<script language='JavaScript'>";
           echo "alert('���{ñ�ֳ�w�ǰe�I');";
           echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
           echo "</script>";
         }
         break;
       default:
         break;
  }

  u_sel_link(&$f_var);      // �k�W���I����]�w
  if(!empty($f_var['query_data'])) { //�p�Gquery_data�����,�N����mysql_query(),only for�s�W�x�s,�ק��x�s,�@�o�x�s,
     u_log($f_var);
     if(!mysql_query($f_var['query_data'])) { // �g�J����
        sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$f_var['query_data'].'!!'); //qq:para�u��str����font
        exit;
     }
     switch ($f_var['msel']) {                            
       case "11": // �s�W�x�s
            if($f_var['chkewb']=="y"){  // add by �Ϊ�  2011.11.23  �L���зs�W
              $f_var['autoindex']  = mysql_insert_id();  //�s�W��s_num
              //if( strstr("1130091/0883430/1300282/1330075",$_SESSION["login_empno"])!=NULL ){
              if( date("Ymd")>='20180701' AND 'Y'==$f_var['f_tohrm'] ){
                //$mgo_url = "/~docs/ewb/t_essf21v2.php?f_snum={$f_var['autoindex']}&f_msel=1&f_empid={$_SESSION["login_hrm_empid"]}";
                ul_essf21($f_var['autoindex'],"1",$_SESSION["login_hrm_empid"]); 
              }
              //mark by �Ϊ� 2018.09.05 popen �X�{ Resource temporarily unavailable �䤣���],�ثe���J�I����,���X��fucntion
              //else if( date("Ymd")>='20180701' AND 'Y'==$f_var['f_tohrm'] ){
              //  $t_path = "/home/docs/public_html/ewb/t_essf21.php {$f_var['autoindex']} 1 {$_SESSION["login_hrm_empid"]} &";
              //  $t_popen = popen($t_path,"r");
              //  while ($t_popen and !feof($t_popen)) {      //?�q�D�������o?��
              //    $out = fgets($t_popen, 4096);
              //    //echo $out;         //���L�X?
              //  }
              //  pclose($t_popen);
              //}        
              u_send($f_var);
              //if('' <> $f_var['domain2'] or '' <> $f_var['domain3']){
              //upd by �Ϊ� 2012.01.31 mimi����ӹq�A�C�L�ը��沾��
              //if('' <> $f_var['domain2']){  //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
              //  echo "<script language=\"javascript\">";
              //  echo "  if (confirm('�w�N�ը�����ܹq�lñ�� {$f_var['f_resdz001']}-{$f_var['f_resdz002']}�A�O�_�C�L�ը���H')){";
              //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=71&num=3&f_s_num={$f_var['autoindex']}\");";
              //  echo "  }";
              //  echo "  else {";
              //  echo "    location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['autoindex']}\");";
              //  echo "  }";
              //  echo "</script>";
              //}
              //else{   //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
                //if('' <> $f_var['domain1']){
                //if( '1130091'!=$_SESSION["login_empno"] ){
                echo "<script language='JavaScript'>";
                echo "alert('�w�N�ը�����ܹq�lñ�� {$f_var['f_resdz001']}-{$f_var['f_resdz002']} �Ыe���d�ݡC');";
                echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['autoindex']}\");";
                echo "</script>";
                //}else{
                //  exit;
                //}
              //}
            }  
            break;
       case "21": // �^���x�s

            u_send($f_var);
            if(u_chkeb12($f_var['f_s_num'])){ //upd by �Ϊ� 2011.12.26 �©������A���ܦh�H�S�I���਽�{ñ�ֳ�A�ɭP�o�K���p��A�אּ�p���{��key�A�j���਽�{ñ�ֳ�            
              echo "<script language=\"javascript\">";            
              echo "location.replace(\"/~docs/ewb/ewb01.php?msel=8&f_s_num={$f_var['f_s_num']}\");";
              echo "</script>";              
            }else{       
              echo "<script language=\"javascript\">";            
              echo "location.replace(\"/~docs/ewb/ewb01.php?msel=41&f_s_num={$f_var['f_s_num']}\");";
              echo "</script>";                    
            }
            
            //upd by �Ϊ� 2011.11.04  �B�g�z���ܡA���Ϸs�W�~�X����q�lñ��
            //if('' <> $f_var['domain1'] or '' <> $f_var['domain2'] or '' <> $f_var['domain3']){
            //  echo "<script language=\"javascript\">";
            //  echo "  if (confirm('�O�_��ܨ��{ñ�ֳ�H')){";
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
  
  if("9" == $f_var['msel']){// ����~�X�e�� 
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
    list_today($f_var);//�C�L�e��-����~�X
  }
  $f_var["tp"]-> printToScreen ();
  //mysql_close(); // ������Ʈw

  include_once($sl_footer_php); // footer
?>
<?
  // **************************************************************************
  //  ��ƦW��: u_list()
  //  ��ƥ\��: �s��
  //  �ϥΤ覡: u_list($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2007.08.15
  // **************************************************************************
  function u_list($f_var) {
    $f_var['msnum']  = ($f_var['f_page']*$f_var['mmaxline'])-$f_var['mmaxline'];   // �_�l���
    
    if(NULL<>$f_var["f_sname"] or NULL<>$f_var["f_b_dept_id"] or NULL<>$f_var["f_eb01"] or NULL<>$f_var["f_dateb"] or NULL<>$f_var["f_datee"]) { // List,���o$f_var['mwhere'] qq:�O�_�N���q��func�N��?
      $fd_dept_sn = substr($f_var['f_sname'],0,4); 
      $f_var['where_dept'] = iif($f_var['f_sname'] == '00',""," and ewb01.b_dept_id = '{$fd_dept_sn}' "); 
      //$f_var['mwhere']  .= iif($f_var['f_b_dept_id'] == '00',""," and substring(ewb01.b_dept_id,1,2) = '{$f_var['f_b_dept_id']}'"); 
      //upd by �Ϊ� 2011.09.22 �쵥���אּlike
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
       if(NULL<>$f_var["f_change1"] ) { // �H���A�d��
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
    if(NULL<>$f_var['f_order'] ) { // �H���A�d��
      $f_var['morder']="{$f_var['f_order']} desc,b_date desc";
    }
     
     // qq: {$f_var ���@��?
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
     
     $f_var['mstock_qty']= mysql_num_rows($f_var['list_result_cnt']); // �ثe�`����
     $f_var['qty_cnt']= mysql_num_rows($f_var['list_result_cnt']); // �ثe�`����
     $f_var['mpagetot'] = floor(((($f_var['mmaxline']-1)+$f_var['mstock_qty'])/$f_var['mmaxline'])); // �D��ơA�̤j����

     if($f_var['mstock_qty']>0) { // �����
        sl_list($f_var);  // �C�X�s���������Y�Ptable��Ƥ��e sl_init.php // Block=tb_list_01�B Block=tb_list_01_body...
     }
     else {
        sl_errmsg('�L��ܸ�ơI');
     }
     return;
  }

  // **************************************************************************
  //  ��ƦW��: u_sel_link()
  //  ��ƥ\��: �I����]�w
  //  �ϥΤ覡: u_sel_link(&$f_var)
  //  ��    ��: �I����]�w
  //  �{���]�p: Mimi
  //  �]�p���: 2007.09.04
  // **************************************************************************
  function u_sel_link($f_var) {
     if($f_var['f_page']==1) {  // �����A���i�A���W
        $f_var['mup_page'] = $f_var['f_page'];
     }
     else {
        $f_var['mup_page'] = $f_var['f_page']-1;
     }
     if($f_var['f_page']==$f_var['mpagetot']) {  // �����A���i�A���W
        $f_var['mdn_page'] = $f_var['f_page'];
     }
     else {
        $f_var['mdn_page'] = $f_var['f_page']+1;
     }

    $y = date('Y'); //�~        
    $m = date('m'); //��  
    $d = date('d'); //��
    $fd_cday = mktime(0, 0, 0, $m-3, $d, $y);  //�W�L25�A��U�Ӥ�     
    $fd_cday = date('Ymd', $fd_cday);
     
     if('71' != $f_var['msel'] ){
       $f_var["tp"]-> newBlock ("tb_sel_link"              ); // �s�W���
       $f_var["tp"]-> assign   ("tv_vname"     ,$_SESSION["login_name"]);
       $f_var["tp"]-> assign   ("tv_dateb"     ,$fd_cday);
       $f_var["tp"]-> assign   ("tv_datee"     ,date("Ymd"));
       $f_var["tp"]-> assign   ("tv_dept_id"   ,$_SESSION["login_dept_id"]);
       
       $f_var["tp"]-> assign   ("tv_add"     , u_showproc().".php?msel=1&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}"              ); // �s�W
       $f_var["tp"]-> assign   ("tv_list"    , u_showproc().".php?msel=4&f_page=1&f_del=N&f_change1={$f_var['f_change1']}"                                                                                                   ); // �s��
       $f_var["tp"]-> assign   ("tv_que"     , u_showproc().".php?msel=5&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"              ); // �d��
       $f_var["tp"]-> assign   ("tv_prn"     , u_showproc().".php?msel=7&num=1&f_page={$f_var['f_page']}&f_del={$f_var['f_del']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"              ); // �C�L
            
       $f_var["tp"]-> assign   ("tv_up_page" , u_showproc().".php?msel=4&f_page={$f_var['mup_page']}&f_del={$f_var['f_del']}&f_que={$f_var['f_que']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}&f_change2={$f_var['f_change2']}&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}" ); // �W��
       $f_var["tp"]-> assign   ("tv_dn_page" , u_showproc().".php?msel=4&f_page={$f_var['mdn_page']}&f_del={$f_var['f_del']}&f_que={$f_var['f_que']}&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}&f_change2={$f_var['f_change2']}&f_b_dept_id={$f_var['f_b_dept_id']}&f_sname={$f_var['f_sname']}&f_eb01={$f_var['f_eb01']}&f_dateb={$f_var['f_dateb']}&f_datee={$f_var['f_datee']}&f_order={$f_var['f_order']}" ); // �U��
       $f_var["tp"]-> assign   ("tv_del_n"   , u_showproc().".php?msel=4&f_page=1&f_del=N&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // N.���o
       $f_var["tp"]-> assign   ("tv_del_y"   , u_showproc().".php?msel=4&f_page=1&f_del=Y&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // Y.�@�o
       $f_var["tp"]-> assign   ("tv_del_a"   , u_showproc().".php?msel=4&f_page=1&f_del=A&f_order_fd={$f_var['f_order_fd']}&f_order_md={$f_var['f_order_md']}&f_change1={$f_var['f_change1']}"                                   ); // A.����
       
       $f_var['f_page'] = 1;
       if('9' != $f_var['msel'] ){
         $f_var["tp"]-> newBlock ("tb_select_statu"       );//�H���A�d��
         $f_var["tp"]-> assign   ("tv_change1"  , u_showproc().".php?msel=4&f_del=A&f_page={$f_var['f_page']}&f_change2={$f_var['f_change2']}&f_change1="               ); 
         if(NULL == $f_var['f_change1']){$f_var['f_change1'] = "00";}else{}
         $f_var["tp"]-> assign   ("tv_f_change"  , $f_var['f_change1']);     
         //$f_var["tp"]-> newBlock ("tv_option1"                  ); // option
         //$f_var["tp"]-> assign   ("tv_value"   , "--"  );
         //$f_var["tp"]-> assign   ("tv_show"    , "--�п��--"   );
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
  //  ��ƦW��: u_disp()
  //  ��ƥ\��: �s��
  //  �ϥΤ覡: u_disp($f_var)
  //  �{���]�p: Tony
  //  �]�p���: 2006.09.29
  // **************************************************************************
  function u_disp($f_var) {
     //echo $f_var['f_s_num'].'----';
     $f_var['mwhere'] = "{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
     $f_var['morder'] = "{$f_var['mtable']['head']}.s_num";


     //add by 2012.03.02 �Ϊ�  �Ʋz�i���W�[���{�}��������
     $fd_resda019 = u_chksign($f_var['f_s_num']); //�j�M���{�}������  ewb01_init.php u_chksign���
     $ar_key = explode("<br>",$fd_resda019);
     $fd_resda0192 = strip_tags($ar_key[1]); //�h���Ҧ�html����
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

        
     sl_disp_1($f_var); // �C�X�浧��� // Block=tb_disp_01
     $res = mysql_query($query1);
     $ar = mysql_fetch_array($res);  
     $fd_str = substr($ar['eb09'],0,2);
     if('41'==$f_var['msel'] and $fd_str<>'06'){  //upd by �Ϊ� 2012.02.07  (����-16232)���Ȩ�(�֨��f��-���ɨ�)�C�L"�ը���"����,���s�b
       $f_var["tp"]-> newBlock (  "tb_btn" ); 
       $f_var["tp"]-> assign   (  "tv_link" , u_showproc().".php?msel=71&num=3&f_s_num={$f_var['f_s_num']}&f_key=1"   ); //
     }
     return;
  }




  // **************************************************************************
  //  ��ƦW��: u_in_scr()
  //  ��ƥ\��: ��J�e��
  //  �ϥΤ覡: u_in_scr($vsel,$vno,$vbtn_str,$vque)
  //  �{���]�p: Tony
  //  �]�p���: 2006.09.27
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
     if($check_total != 0){  //�w���ɲ��Ͳέp��(ewb_pay01.php)
       sl_errmsg("�w��p�����ίӪo�έp��! �L�k�ק���! ");
     }
     */              
     $f_var["tp"]-> newBlock (  "tb_in_01"                 ); // �s�W���
     $f_var["tp"]-> assign   (  "tv_scrmsg"     , $f_var['msel_name'][ $f_var['msel'] ]         ); // ���s��r
     $f_var["tp"]-> assign   (  "tv_qah_action" , u_showproc().".php?msel={$f_var['msel']}1&f_s_num={$f_var['f_s_num']}&f_que={$f_var['f_que']}&f_page={$f_var['f_page']}"); // form action
     $f_var['mwhere'] = "{$f_var['mtable']['head']}.s_num='{$f_var['f_s_num']}'";
     $f_var['morder'] = "{$f_var['mtable']['head']}.s_num";

     //add by �Ϊ� 2011.08.11 �W�[�Ʈ�q���P�_�A�P�_�Ʈ�q�n�]�w�A�����Ȩ�
      reset($f_var['fd']); // �N�}�C�����Ы���}�C�Ĥ@�Ӥ���
      while(list($mfd_id)=each($f_var['fd'])) {          
       if(NULL!=$f_var['fd'][$mfd_id]['js_rule']['kind']) {   //�ˬd�������
           $vjs_rule .= sl_js_rule($f_var['fd'][$mfd_id]['js_rule']['kind'],
                                   $f_var['fd'][$mfd_id]['ename'],
                                   $f_var['fd'][$mfd_id]['cname'],
                                   $f_var['fd'][$mfd_id]['js_rule']['chk_value'],
                                   $f_var['fd'][$mfd_id]['js_rule']['chk_len']
                                 );       
       }
      }
     //$vjs_rule .= "if(this.f_eb10.value=='--'){
     //                if(this.f_eb09.value=='01.���Ȩ�' || this.f_eb09.value=='05.�j����q�u��' || this.f_eb09.value=='99.��L' || this.f_eb09.value=='06.���Ȩ�(�֨��f��-���ɨ�)' || this.f_eb09.value=='07.�p������(�֨��f��-���л�o�K)'){
     //                  return(true);
     //                }
     //                else{
     //                  alert('�y�Ʈ�q�z���~!!') ;
     //                  this.f_eb10.focus();
     //                  return(false);
     //                }
     //              };                
     //            "; //upd by �Ϊ� 2012.02.06 (����-16232) �W�[06.07�ﶵ  
     //$vjs_rule .= "if(this.f_eb10.value=='06.������'){
     //                if(this.f_eb09.value=='02.�p������'){
     //                  return(true);
     //                }
     //                else{
     //                  alert('�y�������z�ȯର�p������!!') ;
     //                  this.f_eb10.focus();
    //                   return(false);
     //                }
     //              };                
     //            "; //upd by �Ϊ� 2012.05.11 ���������w����                               
     $f_var["tp"]-> assign   ( "tv_js_rule"    , $vjs_rule);

     //add by 2012.03.02 �Ϊ�  �Ʋz�i���W�[���{�}��������
     $fd_resda019 = u_chksign($f_var['f_s_num']); //�j�M���{�}������  ewb01_init.php u_chksign���
     $ar_key = explode("<br>",$fd_resda019);
     $fd_resda0192 = strip_tags($ar_key[1]); //�h���Ҧ�html����                    
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
  //  ��ƦW��: list_disp()
  //  ��ƥ\��: ��J�e��
  //  �ϥΤ覡: list_disp($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.01.30
  // **************************************************************************
  function list_disp($f_var) {
    //echo $_SESSION['f_b_dept_id'];
    //upd by mimi 2009.04.23 �O���~�X�ժO�d�߱���-------------------------
    $f_b_dept_id= iif($_SESSION['f_b_dept_id']<>'',$_SESSION['f_b_dept_id'],'00');
    $f_sname    = iif($_SESSION['f_sname']<>''    ,$_SESSION['f_sname'],'00');
    $f_eb01     = iif($_SESSION['f_eb01']<>''     ,$_SESSION['f_eb01'],'');
    $f_order    = iif($_SESSION['f_order']<>''    ,$_SESSION['f_order'],'eb02');
    $f_dateb    = iif($_SESSION['f_dateb']<>''    ,$_SESSION['f_dateb'],date("Ymd"));
    $f_datee    = iif($_SESSION['f_datee']<>''    ,$_SESSION['f_datee'],date("Ymd")); 
    //--------------------------------------------------------------------
    //echo $f_b_dept_id;   
    $fd_cname     = array('�t���O'     ,'�����O' ,'�m�W'        ,'�~�X����_�W'                        ,'�ƧǤ覡');
    $fd_ename     = array('f_b_dept_id','f_sname','f_eb01'      ,''                                    ,'f_order' );
    $fd_value     = array($f_b_dept_id ,$f_sname ,$f_eb01       ,''                                    ,$f_order  );
    $fd_tbhr      = array('select'     ,'select' ,'text'        ,'date'                                ,'select'  );
    $fd_memo      = array(''           ,''       ,'(�ťաG����)','(�褸�~���,�d�ҡG20080130~20080217)','');
    for($i=0;$i<count($fd_cname);$i++){
      $f_var["tp"]->newBlock('tb_in_que_hr_tr');
      $f_var["tp"]->assign('tv_cname', $fd_cname[$i]);
      switch ($fd_tbhr[$i]) {
        case "date":             
          $f_var["tp"]-> newBlock (  "tb_date_hr"                );
          $f_var["tp"]-> assign   (  "tv_ename"     , $fd_ename[$i]);
          $f_var["tp"]-> assign   ( "tp_dateb"      , $f_dateb                   ); // ����_
          $f_var["tp"]-> assign   ( "tp_datee"      , $f_datee                   ); // ����W
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
  //  ��ƦW��: prn_que()
  //  ��ƥ\��: ��J�e��
  //  �ϥΤ覡: prn_que($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.06.23
  // **************************************************************************
  function prn_que($f_var) {    
    //sl_errmsg("<font color='#FF0000'><b>�`�N!!</b></font>���έp��ȦC�X���ج��i�p�����Ρj�B�i�����q�ɧU�ʨ��j"); //qq:para�u��str����font
    $f_var["tp"]->newBlock('tp_in_prn_7');
    $f_var["tp"]->assign('tv_action', u_showproc().".php?msel=71&num=2");
    $f_var["tp"]->assign('tv_title' , "�п�J�p�����ίӪo�έp�����");
    //upd by �Ϊ� 2011.08.15  �������جd�� 
    $fd_cname     = array('���u�s��','����'    ,'�|���d�d��','�~��'    ,'�ư����{�Ƭ��s');
    $fd_ename     = array('f_empno' ,'f_car'   ,'f_card'    ,'f_date'      ,'f_eb13'            );
    $fd_value     = array($_SESSION['login_empno'],$_SESSION['login_car_id'],$_SESSION['login_vip_card'],'',''            );
    $fd_tbhr      = array('text'    ,'text'    ,'text'      ,'text','select'        );
    $fd_size      = array('7'       ,'8'       ,'8'         ,'6',''        );
    $fd_maxl      = array('7'       ,'8'       ,'8'         ,'6',''        );
    $fd_memo      = array('(�п�J���s�Ωm�W�d��)','(�Ц� <a href="/~sl/sl_person.php" target=_blank><font color=red>�ӤH�򥻳]�w</font></a> ��g�A��g����<font color=red>���s�n�JEIP</font>�d�ߡI)','','(�褸�~��, �d�ҡG201109, ���2011.08.26~2011.09.25)','');
    $fd_readonly  = array(''        ,'readonly','readonly'  ,'','');
    $fd_class     = array(''        ,'field_color','field_color'  ,'','');
    //$fd_readonly  = array('','onChange="javascript:this.value=this.value.toUpperCase();"','','','');
    
    /*
    $fd_cname     = array('���u�s��','����'    ,'�|���d�d��','����','�~�X����_�W','�ư����{�Ƭ��s');
    $fd_ename     = array('f_eb01'  ,'f_car'   ,'f_card'    ,'f_else_calc'    ,'','f_eb13'            );
    $fd_value     = array($_SESSION['login_empno'],$_SESSION['login_car_id'],$_SESSION['login_vip_card'],'','',''            );
    $fd_tbhr      = array('text'    ,'text'    ,'text'      ,'select'      ,'date','select'        );
    $fd_size      = array('7'       ,'8'       ,'8'         ,'','',''        );
    $fd_maxl      = array('7'       ,'8'       ,'8'         ,'' ,'',''        );
    $fd_memo      = array('','','','','(�褸�~���,�d�ҡG20080130~20080217)','');
    $fd_readonly  = array('','onChange="javascript:this.value=this.value.toUpperCase();"','','','');    
    */
    for($i=0;$i<count($fd_cname);$i++){
      $f_var["tp"]->newBlock('tb_in_que_hr_tr');                                          
      $f_var["tp"]->assign('tv_cname', $fd_cname[$i]);
      switch ($fd_tbhr[$i]) {
        case "date":             
           $f_var["tp"]-> newBlock (  "tb_date_hr"                );
           $f_var["tp"]-> assign   (  "tv_ename"     , $fd_ename[$i]);
           $f_var["tp"]-> assign   ( "tp_dateb"      , date("Ymd")                   ); // ����_
           $f_var["tp"]-> assign   ( "tp_datee"      , date("Ymd")                   ); // ����W
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
                      alert('�y���u�s���z���i���ť�!!') ;
                      this.f_eb01.focus();
                      return(false)
                  };
                  if(this.f_car.value==''){
                    alert('�y�����z���i���ť�!!') ;
                    this.f_car.focus();
                    return(false)
                  }; 
                  if(this.f_date.value.length!=6 || this.f_date.value==''){
                    alert('�y�~��z��J���~!!') ;
                    this.f_date.focus();
                    return(false)
                  };                                    
                  
                 "; 
/*  upd by �Ϊ� 2011.09.23 �o�{���H�S���d��   �������ˬd 

                  if(this.f_card.value==''){
                    alert('�y�|���d�d���z���i���ť�!!') ;
                    this.f_card.focus();
                    return(false)
                  };


*/
     $f_var["tp"]-> assignglobal   (  "tv_js_rule"    , $vjs_rule); // js rule            
  }
  // **************************************************************************
  //  ��ƦW��: list_prn1()
  //  ��ƥ\��: �C�L�e��-��ܦC�L
  //  �ϥΤ覡: list_prn1($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.01.30
  // **************************************************************************
  function list_prn1($f_var) {    
    //echo $f_var['f_b_dept_id'].'---'.$f_var['f_eb01'].'---'.$f_var['f_dateb'].'---'.$f_var['f_datee'].'<br>';  
    //�L���Ӫ���
    $fd_date = date("Y-m-d h:i:s");
    $res=strpos($f_var['f_sname'],"-")+1;
    $len=strlen($f_var['f_sname'])-$res;
    $fd_dept_id = substr($f_var['f_sname'],$res,$len); 
    $fd_dept_sn = substr($f_var['f_sname'],0,4); 
    //$fd_dateby  = $f_var['f_dateb']-19110000;
    //$fd_dateey  = $f_var['f_datee']-19110000;
    $fd_dateb   = substr($f_var['f_dateb'],0,4).'-'.substr($f_var['f_dateb'],4,2).'-'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($f_var['f_datee'],0,4).'-'.substr($f_var['f_datee'],4,2).'-'.substr($f_var['f_datee'],6,2);
    $fd_trtitle = array('�t���O '     ,'�����O '  ,'�P���m�W ','�^�Ʋ� ','�~�X��� ','�~�X�ɶ� ','�e���a�I '            ,'�~�X�ƥ� '                                 ,'�^�{��� ','�^�{�ɶ� ','�Ƶ�'                );    
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
    
    if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181'] ){ //add by �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��
      $f_var['mwhere'] .= " ";
     }
    else{
      //$f_var['mwhere'] .= " and  {$f_var['mtable']['head']}.b_dept_id <>'S181' "; //js_h.date='0000-
      $f_var['mwhere'] .= " and  pass.dept_id <>'S181' "; //js_h.date='0000-
    }
    if(NULL<>$f_var['f_order'] ) { // �H���A�d��
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
      //�C�L����
      $fd_cut++;
      $fd_cut = iif($fd_cut < 10,"0{$fd_cut}",$fd_cut); 
      $fd_dept = substr($row1['p_gid'],0,2); 
      switch ($fd_dept) {
        case "S1":  
              $fd_area = "�`�޲z�B";
            break;
        case "S2":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            //echo $vfd_dept;
            switch ($vfd_dept) {
              case "S25":  
                    $fd_area = "�_�Ϻ޲z��";
                  break;
              case "S26":  
                    $fd_area = "���Ϻ޲z��";
                  break;
              default:
                    $fd_area = "�n�Ϻ޲z��";
                break;
            }   
            break;
        case "S3":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            switch ($vfd_dept) {
              case "S35":  
                    $fd_area = "�_�Ϫo�~";
                  break;
              case "S36":  
                    $fd_area = "���Ϫo�~";
                  break;
              default:
                    $fd_area = "�n�Ϫo�~";
                break;
            }   
            break;
        case "E1":  
              $fd_area = "��ȳ���";
            break;
        case "T1":  
              $fd_area = "�s���ͧ�";
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
      //�g��      
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
        $fd_word4 = str_pad("�ثe�����G{$page_cnt}/{$page_sum}",95, " ", STR_PAD_LEFT);
        echo "<h2>�~�X�C�L�d��</h2>";
        echo "<br>�~�X����_�W�G{$fd_dateb}��{$fd_datee} {$fd_word4}<br><br>";
        echo "<br><br>===========================================================================================================================================================<br>{$fd_word1}<br>{$fd_line}<br>";
      }      
      if($fd_dept1 != $fd_dept2 and NULL != $fd_dept2){
        echo "----------------------------------------------------------------------------------------------------------------------------------------------------------- <br>";
      }   
      $fd_dept2 = $fd_area; 
      echo "{$fd_word2}<br>";  
      if("40" == $mjump_cnt){
        echo "------���U��-----------------------------------------------------------------------------------------------------------------------------------------------";
        echo "<br><div STYLE='page-break-after: always;'></div>";
        $mjump_cnt=0;
      }
      //} 
    }
    $fd_totle = number_format($fd_totle);
    $fd_len   = strlen("�`���ơG{$num1}");
    //echo "======================================================================================================================================== ";
    echo "{$fd_line}<br>�`���ơG{$num1}<br>";
    echo "=========================================================================================================================================================== ";
    echo "<br>                                        �C�L����G{$fd_date}                �@�@�@�@�@�@�@�@                   �C�L�H��:{$_SESSION['login_name']}"; 
    echo "</pre>"; 
  }
  // **************************************************************************
  //  ��ƦW��: list_prn2()
  //  ��ƥ\��: �C�L�e��-�p������
  //  �ϥΤ覡: list_prn2($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.06.23
  // **************************************************************************
  function list_prn2($f_var) {
    //upd by �Ϊ� 2011.10.05 (�ݿ�-14426 �^��32(2)) �N�~�X����_�W�G�ץ����ȥi�H��J�~��,�t�έp�⬰�W��26�ܥ���25
    $y = substr($f_var['f_date'], 0, 4); //���e�|�X (�~)        
    $m = substr($f_var['f_date'], 4, 2); //���̫�G��(��)  
    $lastmonth = mktime(0, 0, 0, $m-1, "26", $y);   //�W�Ӥ� 26 ��       
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //�o�Ӥ� 25 ���
    $f_var['f_dateb'] = date('Ymd', $lastmonth);
    $f_var['f_datee'] = date('Ymd', $nowmonth);
    $f_var['close_date'] = date('Y-m-d', mktime(0, 0, 0, $m+1, "7", $y))." 00:00:00"; //���b��j��7��H�e
    //echo $f_var['close_date'];
    //�o�ƭp�⪺����
     //02.�p������
     //$vfd_litre['206'] = 20;
     $vfd_litre['206'] = 10; //upd by �Ϊ� 2016.01.12 ����28170-��H10����/���ɸɧU
     $vfd_litre['201'] = 4;
     $vfd_litre['202'] = 4;
     $vfd_litre['203'] = 4;
     $vfd_litre['204'] = 4;
     $vfd_litre['205'] = 4;          
     //03.�����q�ɧU�ʨ�-����-���q��I
     $vfd_litre['301'] = 13;
     $vfd_litre['302'] = 12;
     $vfd_litre['303'] = 11;
     $vfd_litre['304'] = 10;
     $vfd_litre['305'] = 9;                 
     //04.�����q�ɧU�ʨ�-����-�ۦ��I
     $vfd_litre['401'] = 10;
     $vfd_litre['402'] = 9;
     $vfd_litre['403'] = 8;
     $vfd_litre['404'] = 7;
     $vfd_litre['405'] = 6;
    //$vfd_litre['306'] = 1;

    //-------------------------------------------------------------------------
    // add by �Ϊ� 2012.06.25 (����17550)�ư���뤣�o�o�K(���D����)
    //-------------------------------------------------------------------------      
    $month_m3 = mktime(0, 0, 0, $m-3, "26", $y);   //�e�T�Ӥ�e 26 ��       
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
        $y4 = substr($row4['es03'], 0, 4); //���e�|�X (�~)        
        $m4 = substr($row4['es03'], 4, 2); //���̫�G��(��)  
        $month_m1 = mktime(0, 0, 0, $m4-1, "26", $y4);   //�W�Ӥ� 26 ��       
        $month_m2  = mktime(0, 0, 0, $m4,   "25", $y4);   //�o�Ӥ� 25 ���
        $fd_mm1 = date('Ymd', $month_m1);
        $fd_mm2 = date('Ymd', $month_m2); 
        $swhere_set2 .= " and not (docs.ewb01.eb02 BETWEEN '{$fd_mm1}' AND '{$fd_mm2}') ";        
      }
    }  
    //-------------------------------------------------------------------------
    

    //�L���Ӫ���
    $fd_date = date("Y-m-d h:i:s");
    $f_var['mwhere'].= " and docs.ewb01.eb02 between '{$f_var['f_date1']}' and '{$f_var['f_date2']}' ";
    $fd_dateb   = substr($f_var['f_dateb'],0,4).'-'.substr($f_var['f_dateb'],4,2).'-'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($f_var['f_datee'],0,4).'-'.substr($f_var['f_datee'],4,2).'-'.substr($f_var['f_datee'],6,2);
    $f_var['mwhere']  = "docs.ewb01.eb18 = '{$f_var['f_empno']}' ";
    //-------------------------------------------------------------
    // �O�_�w��έp�� (��έp��e����ܸ�Ƥ��P)
    //-------------------------------------------------------------
    $query3 = "select docs.ewb_pay_ym.*
               from   docs.ewb_pay_ym
               where  docs.ewb_pay_ym.d_date = '0000-00-00 00:00:00'
                      and docs.ewb_pay_ym.ey01 = '{$f_var['f_date']}'
                      and docs.ewb_pay_ym.ey02 = '{$f_var['f_empno']}'
           ";
    $result3 = mysql_query($query3);
    $count3  = mysql_num_rows($result3);     
    if(0==$count3){  //���@�b
      $ybe = substr($f_var['f_dateb'], 0, 4); //���e�|�X (�~)        
      $mbe = substr($f_var['f_dateb'], 4, 2); //���̫�G��(��)          
      $befor_month = mktime(0, 0, 0, $mbe-1, "25", $ybe);   //�e�@�Ӥ�e 26 ��  upd by 20120705  ����
      $befor_month = date('Ymd', $befor_month);    
      $f_var['mwhere'] .= " and (((docs.ewb01.eb02 BETWEEN '{$f_var['f_dateb']}' AND '{$f_var['f_datee']}')
                                   or (docs.ewb01.eb20 = 'Y' and docs.ewb01.eb19 = '' and (docs.ewb01.eb02 > '{$befor_month}' and docs.ewb01.eb02 <= '{$f_var['f_datee']}'))
                                   {$swhere_set2}
                                  )
                                 /*�F�N11/26~12/25�~�X��Ƶ��� */
                                 OR ( docs.ewb01.eb18 = '9166637'
                                      AND docs.ewb01.eb02 BETWEEN '20121126' AND '20121225' 
                                      AND docs.ewb01.eb20 = 'Y'
                                      AND docs.ewb01.eb19 = ''
                                  )
                                 /*add by �Ϊ� 2014.12.25 ����25296�B25295 */
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
                          "; //$swhere_set2 ->>  upd by �Ϊ� 2012.06.25 (��17550) �ư���뤣�o�o�K�]�w�ɩҳ]�w���~��    	
    }else{  //�w�@�b
      //$f_var['mwhere'].= " and (docs.ewb01.eb22 = '{$f_var['f_date']}')
      //                     and docs.ewb01.d_date = '0000-00-00 00:00:00'   
      //                   ";  //upd by �Ϊ� 2012.05.17 (�ݿ�14426�^��125) �C�X���e��Ƭ�������@�b
      
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
                           sl.person_set.ps03 as car  # ����
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
    $add_eb142=0; //add by 2014.01.03�p�{�q��O
    $pre_eb10 ='';
    $result1 = mysql_query($query1); 
    $num1 = mysql_num_rows($result1); 
    if($num1==0){
      sl_errmsg("�L�i��ܸ��!!");
    }
    else{  
      $fd_cut=1;
      $fd_jump='N';
      $fd_agree = 0;
      $fd_disagree = 0;
      $fd_signin = 0;      
      while($row1 = mysql_fetch_array($result1)){
        $fd_sleip2flw = u_chk_sleip2flw($row1['s_num']);  //0 �P�N  1 ���P�N  2 ��ñ��

        switch($fd_sleip2flw){  //�p��ñ�ּ�  0 �P�N  1 ���P�N  2 ��ñ��(ñ�֤�)
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
               $fd_resign++;  //��ñ
               break;               
          default:
               break;
        }

        //echo $row1['s_num']."-----".$fd_sleip2flw."<br>";
        if($fd_sleip2flw=="0"){ //����ܨ��{ñ�֦P�N���~�X  20111107�W�u
        	  //-------------------------------------------------------------
        	  // add by �Ϊ� 2011.08.10 �P�_�O�_eb10(�Ʈ�q) ���L�ĭ�
        	  //-------------------------------------------------------------
            $ex_error =iif(trim($row1['eb10'])=='--' or trim($row1['eb10'])=='',"E","C");
            if($f_var['f_car']==''){
              $f_car=$_REQUEST['f_car'];
            }else{
              $f_car=$f_var['f_car'];
            }        	  
        	  //-------------------------------------------------------------
        	  // �򥻸��
        	  //-------------------------------------------------------------  
            if($fd_cut==1){  //�Ĥ@�j��
              $f_var["tp"]-> newBlock (  "tb_list_prn"                );
              $f_var["tp"]-> assign   ('tv_action', u_showproc().".php?msel=42&f_trn_ym={$f_var['f_trn_ym']}&f_empno={$f_var['f_empno']}&f_name={$row1['eb01']}");  //�x�s
              $f_var["tp"]-> newBlock (  "tb_title"                   );          
              $f_var["tp"]-> assign   (  "tv_date1"  , sl_4ymd($f_var['f_dateb'] ));
              $f_var["tp"]-> assign   (  "tv_date2"  , sl_4ymd($f_var['f_datee'] ));
              $f_var["tp"]-> assign   (  "tv_name"   , $row1['ebname']  );  //upd by �Ϊ� 2018.11.06 ��ȯ\��ӹq,���s1830083,���W�r�|����¦W
              //$f_var["tp"]-> assign   (  "tv_name"   , $row1['eb01']  );  //����  ebname
              $f_var["tp"]-> assign   (  "tv_car"    , $f_car         );
              $f_var["tp"]-> assign   (  "tv_card"   , $f_var['f_card']);              
              $fd_setes14 = iif($row1['es14']<>NULL,$row1['es14'],0);
              $f_var["tp"]-> assign   (  "tv_set"    , number_format($fd_setes14));  //�T�w�o�K
              $f_var["tp"]-> assign   (  "tv_car"    , $row1['car']   );  //����
              $f_var["tp"]-> newBlock (  "tb_body"                    );
              $fd_jump='Y'; //�����]�w
            }   
            $f_var["tp"]-> assign   (  "tb_title.tv_eb01"  , $row1['eb01']   );
            $f_var["tp"]-> assign   (  "tb_title.tv_dept"  , $row1['sname']   );
            $f_var["tp"]-> assign   (  "tb_title.tv_eb10"  , substr($row1['eb10'],3,99)   );

            $fd_eb02  = substr(sl_4ymd($row1['eb02']),5); //��� 
        
        	  //-------------------------------------------------------------
        	  // add by 2011.04.14 �Ϊ�  �����q�ɧU�ʨ� �L ������
        	  //-------------------------------------------------------------  
            $fd_eb10  = iif(substr($row1['eb09'],1,1)=='3' and substr($row1['eb10'],0,2)=='06',$pre_eb10,$row1['eb10']);
            $fd_eb91  = substr($row1['eb09'],1,1).substr($fd_eb10,0,2); //���o�o�� KM/L
            $pre_eb10 = substr($row1['eb10'],0,2);  //�������eeb10��
            $vfd_litre['206'] = 10;
            if( $row1['eb02']<'20160101' ){ //add by �Ϊ� 2016.01.12 ����28170-2016/1/1�H�e�~�X,�������H20����/���ɸɧU
              //echo $row1['eb02'];
              $vfd_litre['206'] = 20;
            }
            $fd_litre = $vfd_litre[$fd_eb91];   //�����Ӫo    
            
        	  //-------------------------------------------------------------
        	  // ��p���{
        	  //-------------------------------------------------------------
            //$fd_eb17_1 = iif($row1['eb17']=='Y',"<font color='#ff0000'>��</font>",""); //�����зǨ��{ ���O
            $fd_eb17_1 = iif($row1['eb24']=='Y',"<font color='#ff0000'>��</font>",""); //�����зǨ��{ ���O
            $fd_veb13 = $row1['eb12']-$row1['eb11'];
            //$fd_eb17_2 = iif($row1['eb17']=='Y',"<font color='#ff0000' size='1'><b>({$fd_veb13})-120</b></font>&nbsp;<br>","");
            $fd_eb17_2 = iif($row1['eb24']=='Y',"<font color='#ff0000' size='1'><b>({$fd_veb13})-30</b></font>&nbsp;<br>","");
            //$dec_eb13  = iif($row1['eb17']=='Y',(($row1['eb12']-$row1['eb11'])-120),($row1['eb12']-$row1['eb11']));
            $dec_eb13  = iif($row1['eb24']=='Y',(($row1['eb12']-$row1['eb11'])-30),($row1['eb12']-$row1['eb11']));
            
            $fd_eb13   = iif($dec_eb13>0,$dec_eb13,0);
            $fd_eb13   = iif('N'==$row1['eb20'],0,$fd_eb13);  //�O�_�Q�]�w�������o�K
            $add_eb13 += $fd_eb13; //��p���{�֥[       
            
        	  //-------------------------------------------------------------
        	  // �Ʈ�q�����ĭȤ~�p��A���M�|�X��
        	  //-------------------------------------------------------------              
            if($ex_error=="C"){
              $fd_eb09   = substr($row1['eb09'],0,2); //����
              //$fd_gast   = iif($row1['eb10']=='--' or $row1['eb10']=='',"0",$fd_eb13/$fd_litre);
              //$fd_lpsum  =  $fd_gast* $row1['gas_cost']; 
              $fd_gast   = iif($row1['eb10']=='--' or $row1['eb10']=='',"0",round(($fd_eb13/$fd_litre),2)); //upd by �Ϊ� 2013.01.11 ���|�ˤ��J�ܤp�ƲĤG���A��95���
              $fd_lpsum  =  round($fd_gast* $row1['gas_cost']); 
                               
              $v_litre   =  $fd_litre;  //�����Ӫo
              $fd_lpsum  = iif('N'==$row1['eb20'],0,$fd_lpsum);  //�O�_�Q�]�w�������o�K
              $v_lpsum   =  number_format($fd_lpsum,0); //���ӽЪ��B(E)
              $v_gast    =  number_format($fd_gast,2);  //���ӽЪo��(C)
              $add_lpsum +=  round($fd_lpsum,0);  //���ӽЪ��B(E)�֥[  
              $add_gast  +=  $fd_gast;  //���ӽЪo��(C)�֥[
             
              
            }else{
              $v_litre = '';
              $v_lpsum = ''; 
              $v_gast  = '';  
              $row1['eb14']='0';//���Ʋ��`�A�����]�w��0     
            }  
                 
            //$add_eb14 += iif('N'==$row1['eb20'],0,$row1['eb14']); //�����֥[        

        	  //-------------------------------------------------------------
        	  // �ӵ��o���|����J [�����Ǧr]
        	  //-------------------------------------------------------------             
            $fd_strike=iif($row1['gas_cost']==NUll,"text-decoration: line-through; color: #C0C0C0; background-color: #FF0000",""); 

            //--------------------------------------------------
            // �������o�K���~�X��ơA�b���{�u�_�v�������x
            //--------------------------------------------------
            if(''==$row1['eb19']){ //upd by �Ϊ� 2012.05.09 (����14426 �^��125)
            	$fd_str_eb11 = "<font color='#4F8917'>x&nbsp;</font>";
            }else{
            	$fd_str_eb11 = "";
            }

            //--------------------------------------------------
            // �_���O�_���`�P�_
            //--------------------------------------------------            
            if($ar_oldeb12<>''){
              if($ar_oldeb12>$row1['eb11'] and $row1['eb23']<>'Y'){ //���e���W > �{�b���_ (���`)
                $fd_str_eb11.= '<font color=red>��</font>'.number_format($row1['eb11']);
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
              if($ar_oldeb12>$row1['eb11'] and $row1['eb23']<>'Y'){ //�W��̤j�@���W > �{�b���_ (���`)
                $fd_str_eb11.= '<font color=red>��</font>'.number_format($row1['eb11']);
              }else{
                $fd_str_eb11.= number_format($row1['eb11']);
                $ar_oldeb12 = $row1['eb12'];            
              }                                             
            }   
             
            if('N'<>$row1['eb20']){  // �O�_���o�K
            	$fd_eb13 = $fd_eb17_2.number_format($fd_eb13);
            }
            
        	  //-------------------------------------------------------------
        	  // �C�X�C���~�X���
        	  //-------------------------------------------------------------        
            $weekday  = date('w', strtotime($row1['eb02']));
            $weeklist = array('��', '�@', '�G', '�T', '�|', '��', '��');  
            if( !empty($row1['E0A_1']) ){  //��w����
              $fd_week = "<font color=red>({$weeklist[$weekday]})</font>";          
            }else{
              $fd_week = "(".$weeklist[$weekday].")";
            }  
                            
            $f_var["tp"]-> newBlock (  "tb_body_tr"                      );
            $f_var["tp"]-> assign   (  "tv_style"  , $fd_strike          );  //����   
            $f_var["tp"]-> assign   (  "tv_eb02"   , $fd_eb17_1.$fd_eb02."<font size=-2>".$fd_week."</font>" );  //���  
            $f_var["tp"]-> assign   (  "tv_vchkb"  , $row1['s_num']      );  //ewb01�y����
            if($row1['eb20']=='N'){  //checkbox �O�_�w�]�Ŀ�
              $f_var["tp"]-> assign   (  "tv_checked1"  , 'checked'); 
              $f_var["tp"]-> assign   (  "tv_disabled1"  , 'disabled'); 
              $f_var["tp"]-> assign   (  "tv_disabled2"  , 'disabled'); 
            }
            if($row1['eb23']=='Y'){ 
              $f_var["tp"]-> assign   (  "tv_checked2"  , 'checked'); 
              $f_var["tp"]-> assign   (  "tv_disabled1"  , 'disabled'); 
            }
            $f_var["tp"]-> assign   (  "tv_eb21"   , $row1['eb21']);  //��ñ��]
            $f_var["tp"]-> assign   (  "tv_eb11"   , $fd_str_eb11);   //�_            
            $f_var["tp"]-> assign   (  "tv_eb12"   , number_format($row1['eb12']));   //�W
            $f_var["tp"]-> assign   (  "tv_eb13"   , $fd_eb13);    //��p���{
            //echo $fd_eb13."<br>";
            $f_var["tp"]-> assign   (  "tv_litre"  , $v_litre);   //�����Ӫo
            $f_var["tp"]-> assign   (  "tv_gast"   , $v_gast);  //���ӻ�o��
            $f_var["tp"]-> assign   (  "tv_cost"   , $row1['gas_cost']);   //95���
            $f_var["tp"]-> assign   (  "tv_lpsum"  , $v_lpsum);    //���ӽЪ��B
            //if($row1['eb20']=='N'){
            // 	$fd_eb14 = '0';
            //}else{
            //  $fd_eb14 = $row1['eb14'];
            //}
            //$f_var["tp"]-> assign   (  "tv_eb14"   , $fd_eb14);   //����
            if( $row1['eb02']>"20140101" ){ //�~�X���>20140101�h�}�l�֥[���q�p�{�O
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
            //$add_eb141 += iif('N'==$row1['eb20'],0,$fd_eb141); //�����֥[  
            $add_eb142 += iif('N'==$row1['eb20'],0,$fd_eb142); //�p�{�q��O�֥[  
                                                  
            //$atime = sl_4ymd($row1['eb02'])." ".substr($row1['eb03'],0,2).":".substr($row1['eb03'],2,2).":00";
            //$btime = sl_4ymd($row1['eb06'])." ".substr($row1['eb07'],0,2).":".substr($row1['eb07'],2,2).":00";
            //$ar_diff = sl_timediff($atime,$btime); //2012-07-09 01:40:00 upd by 2014.12.01 ����25124
            //$fd_hr = $ar_diff['hour'] + round(($ar_diff['min']/60),2);
            
            if( empty($ar_E01_5[$row1['eb02']]) ){
              $ar_E01_5[$row1['eb02']] = $row1['E01_5'];
              $fd_E01_5 = $row1['E01_5'];
            }else{
              $fd_E01_5 = 0;
            }
            
            $add_eb141 += $fd_E01_5; //�[�Z�I                                 
            $f_var["tp"]-> assign   (  "tv_eb141"   , iif($fd_E01_5=='',0,$fd_E01_5) );   //�[�Z�I    upd by 2014.12.01 ����25124
            //$f_var["tp"]-> assign   (  "tv_eb141"   , $fd_eb141);   //����            
            $f_var["tp"]-> assign   (  "tv_eb142"   , $fd_eb142);   //�p�{�q��O
            
            $f_var["tp"]-> assign   (  "tv_eb04"   , $row1['eb04']);   //�e���a�I
            $fd_streb08 = iif($row1['eb08']=='',''," / ".$row1['eb08']);  //upd by �Ϊ� 2011.12.29 ���x�׭n�D�W�[�Ƶ�
            $f_var["tp"]-> assign   (  "tv_eb05"   , $row1['eb05'].$fd_streb08);   //�ƥ�  
            if($fd_cut==50 and $fd_jump=='Y'){  //50������
              $f_var["tp"]-> newBlock (  "tb_jump_page"             );
              $fd_cut=0;
            }
            $fd_cut++; //���ƥ[�[
            $fd_wman = $row1['eb01']; //add by �Ϊ� 2011.08.26  ���x�רӹq�A�s�W��ܥӽФH�m�W
        }    //echo $add_lpsum."<br>";
      }
      if($fd_agree==0){
        $fd_signa = $fd_signin+$fd_resign;  //ñ�Ĥ��@�ϡ@��ñ
        sl_errmsg("�����~�X���ñ�֧���(���{ñ�ֳ�P�N)�I<BR>ñ�֤����Ʀ@: {$fd_signa} ��");
      }

      //add by �Ϊ� 2011.12.15  (�ݿ�-14426 �^��52) �s�W��ܥ[����B  line: 1595~1613
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
          $f_var["tp"]-> assign   (  "tv_ac06"   , $row2['ac06']);    //�[����B����
          $f_var["tp"]-> assign   (  "tv_ac05"   , $row2['ac05']);    //�[����B
          $fd_tac05 += $row2['ac05'];
        }
      }else{
        $fd_tac05 = 0;
      } 

      //-------------------------------------------------------------
      // �`�p�C
      //-------------------------------------------------------------       
      $fd_signa = $fd_signin+$fd_resign;
      $f_var["tp"]-> newBlock (  "tb_body_tol"                            );
      $f_var["tp"]-> assign   (  "tv_count"   , "�P�N:{$fd_agree}  ���P�N:{$fd_disagree}  ñ�֤�:{$fd_signa} ");
      $f_var["tp"]-> assign   (  "tv_eb13"    , number_format($add_eb13)  );
      $f_var["tp"]-> assign   (  "tv_gast"    , number_format($add_gast,2));
      $add_lpsum2 = $add_lpsum + $fd_tac05;  //upd by �Ϊ� 2011.12.15  (�ݿ�-14426 �^��52) �s�W��ܥ[����B  
      $f_var["tp"]-> assign   (  "tv_lpsum"   , number_format($add_lpsum2,0)); //$fd_tac05 -> �[����B   
      //$f_var["tp"]-> assign   (  "tv_eb14"    , $add_eb14                 );
      $f_var["tp"]-> assign   (  "tv_eb141"    , $add_eb141                 );
      $f_var["tp"]-> assign   (  "tv_eb142"    , $add_eb142                 ); //add by 2014.01.03�p�{�q��O     
      $f_var["tp"]-> newBlock (  "tb_body_final"                          );
      $f_var["tp"]-> assign   (  "tv_wman"    , $fd_wman                  ); //add by �Ϊ� 2011.08.26  ���x�רӹq�A�s�W��ܥӽФH�m�W
      $f_var["tp"]-> assign   (  "tv_man"     , $_SESSION['login_name']   );
    }
  }
  // **************************************************************************
  //  ��ƦW��: list_prn3()
  //  ��ƥ\��: �C�L�e��-�ը���
  //  �ϥΤ覡: list_prn3($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.07.15
  // **************************************************************************
  function list_prn3($f_var) { 
    $f_var["tp"]-> newBlock (  "tb_list_prn2"                ); 
    //echo "<pre>";
    //var_dump($f_var["tp"]);
    //echo "</pre>";   
    $query1      = "select ewb01.eb01,   /*�ӽФH*/
                           CONCAT(substring(eb02,5,2),'-',substring(eb02,7,2)) eb02,
                           CONCAT(substring(eb03,1,2),':',substring(eb03,3,2)) eb03,
                           CONCAT(substring(eb06,5,2),'-',substring(eb06,7,2)) eb06,
                           CONCAT(substring(eb07,1,2),':',substring(eb07,3,2)) eb07,
                           TIMEDIFF(CONCAT(substring(eb06,1,4),'-',substring(eb06,5,2),'-',substring(eb06,7,2),' ',substring(eb07,1,2),':',substring(eb07,3,2)) , CONCAT(substring(eb02,1,4),'-',substring(eb02,5,2),'-',substring(eb02,7,2),' ',substring(eb03,1,2),':',substring(eb03,3,2))) dif, 
                           ewb01.eb05,   /*�ƥ�*/ ewb01.eb04,   /*�e���a�I*/
                           substring(ewb01.eb09,1,2) eb09,   /*����,�O�_���p��*/ 
                           ewb01.eb10,   /*�Ʈ�q*/
                           ewb01.eb11,   /*�X�t������*/ ewb01.eb12,   /*�J�t������*/
                           ewb01.eb15,   /*�����H��*/
                           ewb01.b_date, /*���ɤ��*/ sl.dept.dept_name  /*�ӽг��*/
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
        $fd_b_date=substr($row1['b_date'],0,4)."�~".substr($row1['b_date'],5,2)."��".substr($row1['b_date'],8,2)."��";
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
  //  ��ƦW��: list_today()
  //  ��ƥ\��: �C�L�e��-����~�X
  //  �ϥΤ覡: list_today($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.01.30
  // **************************************************************************
  function list_today($f_var) {    
    //echo $f_var['f_b_dept_id'].'---'.$f_var['f_eb01'].'---'.$f_var['f_dateb'].'---'.$f_var['f_datee'].'<br>';  
    switch ($f_var['fd_ord']) {
      case "ASC": // �Ƨ�
        $f_var['morder'] = "sl.dept.p_gid,dftime ASC,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="DESC";
        break;
      case "DESC": // �Ƨ�
        $f_var['morder'] = "sl.dept.p_gid,dftime DESC,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="ASC";
        break;
      default:
        $f_var['morder'] = "sl.dept.p_gid,ewb01.b_dept_id,ewb01.b_date ASC";
        $f_var['fd_ord']="ASC";
        break;
    }      
    //echo $f_var['fd_ord'];
    //�L���Ӫ���
    $fd_date = date("Ymd");
    $fd_date2= (date("Y")-1911).'-'.date("m-d");
    //$fd_dateby  = $f_var['f_dateb']-19110000;
    //$fd_dateey  = $f_var['f_datee']-19110000;
    $fd_dateb   = substr($fd_dateby,0,2).'.'.substr($f_var['f_dateb'],4,2).'.'.substr($f_var['f_dateb'],6,2);
    $fd_datee   = substr($fd_dateey,0,2).'.'.substr($f_var['f_datee'],4,2).'.'.substr($f_var['f_datee'],6,2);
    $fd_trtitle = array('�t���O '     ,'�����O '  ,'�P���m�W ',"<A HREF='ewb01.php?msel=9&fd_area={$f_var['fd_area']}&fd_ord={$f_var['fd_ord']}'>�~�X�ɼ�</A> ",'�~�X��� ','�~�X�ɶ� ','�e���a�I '            ,'�~�X�ƥ� '                                 ,'�^�{��� ','�^�{�ɶ� ','�^�{�a�I ','�Ƶ�'                 );
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
    if('S181' == $_SESSION["login_dept_id"] or '' != trim($f_var['domain']) or ''!=$f_var['domain_S181'] ){ //add by �Ϊ� 2015.01.12 ����25484-�]�֤H���~�X�ժO�d���v���W�[�H�Ƴ��
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
    //mark by �Ϊ� 2016.10.13 �g�z��,�o����ܤ��n,�ҥH�令table
    //echo "<pre>"; 
    //echo "<h2>����~�X($fd_date2)</h2><A HREF='ewb01.php?msel=9&fd_area=0'>����</A>|<A HREF='ewb01.php?msel=9&fd_area=S1'>�`�޲z�B</A>|<A HREF='ewb01.php?msel=9&fd_area=S25'>�_�Ϻ޲z��</A>|<A HREF='ewb01.php?msel=9&fd_area=S26'>���Ϻ޲z��</A>|<A HREF='ewb01.php?msel=9&fd_area=S28'>�n�Ϻ޲z��</A>|<A HREF='ewb01.php?msel=9&fd_area=S35'>�_�Ϫo�~</A>|<A HREF='ewb01.php?msel=9&fd_area=S36'>���Ϫo�~</A>|<A HREF='ewb01.php?msel=9&fd_area=S38'>�n�Ϫo�~</A>|<A HREF='ewb01.php?msel=9&fd_area=E1'>��ȳ���</A>|<A HREF='ewb01.php?msel=9&fd_area=T1'>�s���ͧ�</A><br><br>";
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
      //�C�L����
      //$fd_cut++;
      //$fd_cut = iif($fd_cut < 10,"0{$fd_cut}",$fd_cut);
      $fd_dept = substr($row1['p_gid'],0,2); 
      switch ($fd_dept) {
        case "S1":  
              $fd_area = "�`�޲z�B";
            break;
        case "S2":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            //echo $vfd_dept;
            switch ($vfd_dept) {
              case "S25":  
                    $fd_area = "�_�Ϻ޲z��";
                  break;
              case "S26":  
                    $fd_area = "���Ϻ޲z��";
                  break;
              default:
                    $fd_area = "�n�Ϻ޲z��";
                break;
            }   
            break;
        case "S3":  
            $vfd_dept = substr($row1['p_gid'],0,3); 
            switch ($vfd_dept) {
              case "S35":  
                    $fd_area = "�_�Ϫo�~";
                  break;
              case "S36":  
                    $fd_area = "���Ϫo�~";
                  break;
              default:
                    $fd_area = "�n�Ϫo�~";
                break;
            }   
            break;
        case "E1":  
              $fd_area = "��ȳ���";
            break;
        case "T1":  
              $fd_area = "�s���ͧ�";
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
        if(date("YmdHi") >= $fd_time){ //�ثe�ɶ��w�W�L�^�{�ɶ��̩m�W�Ǧ�
          $f_var["tp"]-> assign   ("tv_fcolor"     , "#A0A0A0" );
        }
        $f_var["tp"]-> assign   ("tv_num"    , $fd_num );  //�� 
        $f_var["tp"]-> assign   ("tv_dept1"  , $fd_area );  //�t���O 
        $f_var["tp"]-> assign   ("tv_dept2"  , $row1['sname'] );  //�����O 
        if(date("YmdHi") >= $fd_time){ //�ثe�ɶ��w�W�L�^�{�ɶ��̩m�W�Ǧ�
          $f_var["tp"]-> assign   ("tv_name"   , $row1['eb01'] );  //�P���m�W
        }else{ //�_�h�m�W���Ŧ�
          $f_var["tp"]-> assign   ("tv_name"   , "<font color='#003399'>".$row1['eb01']."</font>" );  //�P���m�W
        }                      
        $f_var["tp"]-> assign   ("tv_hr"     , $fd_eftime );  //�~�X�ɼ� 
        $f_var["tp"]-> assign   ("tv_godate" , $fd_eb02 );  //�~�X��� 
        $f_var["tp"]-> assign   ("tv_time"   , $fd_eb03 );  //�~�X�ɶ� 
        $f_var["tp"]-> assign   ("tv_place"  , $row1['eb04'] );  //�e���a�I 
        $f_var["tp"]-> assign   ("tv_content", $row1['eb05'] );  //�~�X�ƥ� 
        $f_var["tp"]-> assign   ("tv_redate" , $fd_eb06 );  //�^�{���          
        $f_var["tp"]-> assign   ("tv_retime" , $fd_eb07 );  //�^�{�ɶ�
        $f_var["tp"]-> assign   ("tv_replace" , $row1['eb16'] );  //�^�{�a�I
        $f_var["tp"]-> assign   ("tv_memo"    , $row1['eb08'] );  //�Ƶ�
        $fd_num++;         
      //}      


      $fd_value = array($fd_area,$row1['sname'],$row1['eb01'],$fd_eftime,$fd_eb02,$fd_eb03,$row1['eb04'],$row1['eb05'],$fd_eb06,$fd_eb07,$row1['eb16'],$row1['eb08']);
      //�g��      
      $fd_word2 = str_pad($fd_value[0],$fd_width[0], " ", STR_PAD_RIGHT);
      $fd_word2 .= str_pad($fd_value[1],$fd_width[1], " ", STR_PAD_RIGHT);
      //$fd_word2 = "<A NAME='{$fd_dept}'>{$fd_word2}</A>";
      $fd_dept1 = $fd_area;      
      if(date("YmdHi") >= $fd_time){ //�ثe�ɶ��w�W�L�^�{�ɶ��̩m�W�Ǧ�
        $fd_name = "<font color='#A0A0A0'>".str_pad($fd_value[2],$fd_width[2], " ", STR_PAD_RIGHT)."</font>";
      }
      else{                        //�_�h�m�W���Ŧ�
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
      //mark by �Ϊ� 2016.10.13 �g�z��,�o����ܤ��n,�ҥH�令table
      //if($fd_dept1 != $fd_dept2 and NULL != $fd_dept2){
      //    echo "-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>";
      //  }       
      //  $fd_dept2 = $fd_area;
      //  if(date("YmdHi") >= $fd_time){ //�ثe�ɶ��w�W�L�^�{�ɶ��̦Ǧr
      //    echo "<font color='#A0A0A0'>{$fd_word2}<br></font>";
      //  }
      //  else{
      //    echo "{$fd_word2}<br>"; 
      //  }
      //mark end  

    }
    //mark by �Ϊ� 2016.10.13 �g�z��,�o����ܤ��n,�ҥH�令table
    //echo "<br>================================================================================================================================================================================== ";
    //echo "</pre>";
    //mark end 
  }
  
  // **************************************************************************
  //  ��ƦW��: u_send()
  //  ��ƥ\��: �ǰe�T��
  //  �ϥΤ覡: u_send($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2007.09.11
  // **************************************************************************
  function u_send($f_var) {
     //��X�Ҧ������          
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
       case "11": // �s�W�x�s
            $msubject  = "�i{$f_var['f_eb01']}�j�s�W�@���~�X��ơI";
            $f_var["subject"] = "�i{$f_var['f_eb01']}�j�z�s�W�@���~�X��ơI";
            $f_var["message"] = "";  
            while(list($vfd_id)=each($f_var['fd'])) {
              $vins_cname = $f_var['fd'][$vfd_id]['cname'];
              $vins_ename = $f_var[$f_var['fd'][$vfd_id]['ename']];
              //$f_var["message"] .= "{$vins_cname}�G{$vins_ename}"."\n";
              if($vins_cname!='s_num'){    //upd by �Ϊ� 2011.11.24  s_num����J�o�e�T����
                $f_var["message"] .= "{$vins_cname}�G{$vins_ename}"."\n";   
              }                                    
            }     
            $f_var['to']["{$_SESSION['login_empno']}"] = $_SESSION['login_empno'];
            break;
       case "21": // �ק��x�s
            $fd_eb02=(substr($f_var['f_eb02'],0,4)-1911).'.'.substr($f_var['f_eb02'],4,2).'.'.substr($f_var['f_eb02'],6,2);
            $msubject  = "�i{$f_var['f_eb01']}�j�ק�{$fd_eb02}�~�X��ơI";
            $f_var["subject"] = "�i{$f_var['f_eb01']}�j�z�ק�{$fd_eb02}�~�X��ơI";
            $f_var["message"] = "";  
            while(list($vfd_id)=each($f_var['fd'])) {
              $vins_cname = $f_var['fd'][$vfd_id]['cname'];
              $vins_ename = $f_var[$f_var['fd'][$vfd_id]['ename']];
              //$f_var["message"] .= "{$vins_cname}�G{$vins_ename}"."\n";
              if($vins_cname!='s_num'){   //upd by �Ϊ� 2011.11.24  s_num����J�o�e�T����
                $f_var["message"] .= "{$vins_cname}�G{$vins_ename}"."\n";   
              }                              
            }     
            $f_var['to']["{$_SESSION['login_empno']}"] = $_SESSION['login_empno'];
            break;
       default:
            break;
     }
     //�O�_����
     reset ($f_var['to']);
     foreach ($f_var['to'] as $value) {
         if(''!=$value){
          $man[] =$value; 
        }
     }
     //�T���ǰe
     for($i=0;$i<count($man);$i++){
        sl_send_msg('it',$man[$i],$f_var["subject"],$f_var["message"]);            
     } 
     
     
     //upd by �Ϊ� 2012.07.05 �N�Ʋz�o�e�T����������
     //�o�e�l��TO tony  
     
     //$fd_man   = "tony@slc.com.tw";
     //$fd_man   = "mimi@slc.com.tw";
     //$mcontent = "<pre>";  
     //$mexdata   = "Content-Type:text/html;charset=big5\n";
     //$mexdata  .= "X-MSMail-Priority: High\n";
     //$mexdata  .= "From:".$fd_man."\nReply-To:".$fd_man."\n";
     //$mcontent .= "{$f_var['message']}</pre>";  
     
     //if(!mail($fd_man, $msubject , $mcontent , $mexdata) ) {
     //   u_errmsg('2','left','FF99FF','FF0000','FF9966','<font color="#FFFFFF"><b>�`�N!!</b></font>&nbsp;&nbsp;�T�{�l��ǰe����!!<br>���p����T��..');
     //} 
     
     
     
     //exit;
  return;
  }
  
  // **************************************************************************
  //  ��ƦW��: u_log()
  //  ��ƥ\��: �ǰe�T��
  //  �ϥΤ覡: u_log($f_var)
  //  �{���]�p: Mimi
  //  �]�p���: 2008.07.07
  // **************************************************************************
  function u_log($f_var) {
    //sl_open($f_var['mdb']); // �}�Ҹ�Ʈw
    $vb_empno   = $_SESSION["login_empno"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vfromip    = $_SERVER["REMOTE_ADDR"];
    $vproc      = u_showproc(); // �{���N�� 
    switch ($f_var['msel']) {
      case "11": // �s�W�x�s
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
      case "21": // �ק��x�s
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
  //  ��ƦW��: u_chk_sleip2flw()
  //  ��ƥ\��: �ˬdñ�ֳ�ñ�ֵ��G�O�_���P�N
  //  �ϥΤ覡: u_chk_sleip2flw($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.11.03
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
    if($num==0){  //2011.10.04 �H�e�O�S�]ñ�̡֪A�h�|���
      return 0;
    }else{
      while($row = mysql_fetch_array($result)){
        $fd_flw008 = $row['sleip2flw008']; //���O (1.�~�X�ը���B3.���y�ը���B4�B���{ñ�ֳ�)
        $ar_flw008[$fd_flw008]   = $fd_flw008;  //1�B3�B4 upd by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
        $ar_resda021[$fd_flw008] = $row['resda021'];  //�̷s�@��ñ�֪��A
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
      		     if($ar_resda021[$key]=='3'){  //���P�N
      		     	 return 1;	
      		     }
      		     if($ar_resda021[$key]<>'2'){
      		     	 return 2;
      		     }   		     
      		     break;
      		case '4':
      		case '12':
      		     if($ar_resda021[$key]=='2'){  //�P�N
      		     	 if('xx'==substr($ar_flw010[$key],-2)){  //��ñ
      		     	 	 return 3;
      		     	 }
      		       return 0;	
      		     }else if($ar_resda021[$key]=='3'){  //���P�N
      		     	 return 1;	
      		     }else{ //ñ�֤� 
      		     	 return 2;	
      		     }
      		     break;
      		default:
      		     break;      		     
      	}     	
      }
    }
    return 2;  //����g�~�X�ը���A�����g���{ñ�ֳ�  ñ�֤�     
  }    
  
  //// **************************************************************************
  ////  ��ƦW��: u_chk_sleip2flw()
  ////  ��ƥ\��: �ˬdñ�ֳ�ñ�ֵ��G�O�_���P�N
  ////  �ϥΤ覡: u_chk_sleip2flw($vsnum)
  ////  �{���]�p: �Ϊ�
  ////  �]�p���: 2011.11.03
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
  //  if($vsnum=='120976' or $vsnum=='121409' or $vsnum=='121578'){ //add by �Ϊ� 2011.12.26 �©�ñ�֥d�b�Ҫ��A���F��K�©��ӽЪo�K�A�}�񦹤T�����
  //    return 0;
  //  }         
  //             
  //  if($_SESSION['login_empno']=='1130091'){                          
  //    echo "<pre>".$query."</pre>";
  //  }
  //  $result = mysql_query($query); 
  //  $num = mysql_num_rows($result);   
  //  if($num==0){  //2011.10.04 �H�e�O�S�]ñ�̡֪A�h�|���
  //    return 0;
  //  }                                     
  //  else{
  //    $fd_sign14 = "";
  //    while($row = mysql_fetch_array($result)){
  //
  //      $fd_flw008 = $row['sleip2flw008']; //���O (1.�~�X�ը���B3.���y�ը���B4�B���{ñ�ֳ�)
  //      $ar_flw008[$fd_flw008] = $fd_flw008;  //1�B3�B4 upd by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
  //
  //      switch($row['resda021']){
  //        case '':  //ñ�ֲĤ@��
  //             $ar_resda021[$fd_flw008] = '1';  //ñ�֤�
  //             break;
  //        case '1':
  //        case '2':
  //             $ar_resda021[$fd_flw008] = $row['resda021'];   //�������ΦP�N
  //             break;
  //        case '3':
  //        case '4':
  //             $ar_resda021[$fd_flw008] = "N";  //���P�N�Ω��  
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
  //        case '11':  //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
  //             if($row['resda021'] == '2'){  //ñ��
  //               $fd_sign13 = "Y";
  //               $fd_signeb13 = $row['eb13'];
  //             }
  //             break;
  //        case '4':
  //        case '12': //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
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
  //      if($row['resda021']=='1' or $row['resda021']=='2'){  //1.�������B2.�P�N        
  //        $ar_resda021[$fd_flw008] = $row['resda021']; 
  //      }else if($row['resda021']==''){
  //        $ar_resda021[$fd_flw008] = '1';
  //      }else if($ar_resda021[$fd_flw008]<>'1' and $ar_resda021[$fd_flw008]<>'2' and $ar_resda021[$fd_flw008]<>'1'){  //�pñ�֪��A�����������B�P�N���ܡA�h�����
  //        $ar_resda021[$fd_flw008] = "N";         
  //      } 
  //      */
  //
  //                    
  //      /*       
  //      if($row['resda021']=='1' or $row['resda021']=='2'){  //1.�������B2.�P�N        
  //        $ar_resda021[$fd_flw008] = $row['resda021']; 
  //      }else if($ar_resda021[$fd_flw008]=='3' or $ar_resda021[$fd_flw008]=='4'){  //�pñ�֪��A�����������B�P�N���ܡA�h�����
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
  //    reset($ar_flw008); // �N�}�C�����Ы���}�C�Ĥ@�Ӥ���
  //    while(list($key1,$value1)=each($ar_flw008)) {  //���O
  //      $fd_flw008 = $ar_flw008[$key1];
  //
  //      switch($fd_flw008){
  //        case '1':   //1.�~�X�ը���
  //        case '11':  //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
  //             if($ar_resda021[$key1]=='N'){ // ���P�N
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //ñ�֤� 
  //               return 2;              
  //             }
  //             //else{
  //             //  $fd_key1 = $ar_resda021[$key1];
  //             //}                            
  //             break;
  //        case '3':  //3.���y�ը���
  //             if($ar_resda021[$key1]=='N'){ // ���P�N
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //ñ�֤� 
  //               return 2;              
  //             }
  //             //else{
  //             //  $fd_key3 = $ar_resda021[$key1];
  //             //}                          
  //             break;
  //        case '4':  //4�B���{ñ�ֳ�
  //        case '12': //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
  //             if($ar_resda021[$key1]=='N'){ // ���P�N
  //               return 1;
  //             }else if($ar_resda021[$key1]=='1'){  //ñ�֤� 
  //               return 2;              
  //             }else{ //�P�N
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
  //        if($ar_resda021[$key1]<>'N'){  //�����P�N�Τw���̡A�h�����
  //          return true;
  //        }else{
  //          return false;
  //        }
  //      //}    
  //      */ 
  //       
  //    }
  //    //upd by �Ϊ� 2011.11.09  �|�����ͭ��{ñ�ֳ�A�h�p���ñ�ֵ��Ƥ�
  //    if($fd_key4==''){ //
  //      return 2;
  //    }else if($fd_key4<>'') {
  //      return 0;
  //    }
  //  }     
  //}  


  // **************************************************************************
  //  ��ƦW��: u_eip2del()
  //  ��ƥ\��: ñ�ֳ�ñ�ֵ��G�����A�@�o
  //  �ϥΤ覡: u_eip2del()
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.11.23
  // **************************************************************************
  function u_eip2del() {
    $vb_empno   = 'it';
    $vb_date    = date("Y-m-d H:i:s");
    $vproc      = u_showproc(); // �{���ɦW
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
                     docs.ewb01.d_proc  = '({$vproc})ñ�֩��@�o',
                     docs.ewb01.d_date  = '{$vb_date}'                     
              WHERE (docs.sleip2flw.resda020 = '4' and
                     docs.sleip2flw.resda021 = '4') and
                     docs.sleip2flw.sleip2flw008 in ('1','3','11') and
                     docs.ewb01.d_date = '0000-00-00 00:00:00' and
                     docs.sleip2flw.d_date = '0000-00-00 00:00:00' and
                     docs.sleip2flw.b_empno = '{$_SESSION["login_empno"]}'
                     and (docs.sleip2flw.resda019 between '{$vw_date1}' and '{$vw_date2}')    /*add by �Ϊ� 2012.01.31 �W�[�P�_���פ���b5�Ѥ�����ƪ�*/
             ";   //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[ �~�X���O 11 ���{���O 12 
    //echo "<pre>".$query."</pre>";
//    if(!mysql_query($query)){
//      if($_SESSION['login_empno']=='1130091'){
//        echo "ñ�֪��A���@�o����!!!<pre>".$query."</pre>";
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
  //  ��ƦW��: u_chk_ewb01()
  //  ��ƥ\��: �d�ݸ�ƬO�_�����зs�W
  //  �ϥΤ覡: u_chk_ewb01($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.11.23
  // **************************************************************************
  function u_chk_ewb01($f_var) {
    $fd_eb05 = trim($f_var['f_eb05']);
    $fd_eb08 = trim($f_var['f_eb08']);
    $query = "SELECT *                                                                
              FROM   docs.ewb01
              WHERE  docs.ewb01.eb02 = '{$f_var['f_eb02']}'   /*�~�X���*/
                     and docs.ewb01.eb03 = '{$f_var['f_eb03']}'   /*�~�X�ɶ�*/
                     and docs.ewb01.eb18 = '{$f_var['f_eb18']}'   /*���s*/     
                     and TRIM(docs.ewb01.eb05) = '{$fd_eb05}'   /* add by 2013.01.15 �W�[�P�_�e���ƥ�*/
                     and TRIM(docs.ewb01.eb08) = '{$fd_eb08}'   /* add by 2013.01.15 �W�[�P�_�Ƶ�*/
                     /*and docs.ewb01.eb06 = '{$f_var['f_eb06']}'   �^�{���*/
                     /*and docs.ewb01.eb07 = '{$f_var['f_eb07']}'       �^�{�ɶ�*/
                     and d_date='0000-00-00 00:00:'/*upd by mimi 2012.01.06 ���ΫT�ӹq,�W�[�P�_�@�o���*/
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
  //  ��ƦW��: u_chk_sleip2flw()
  //  ��ƥ\��: �ˬdñ�ֳ�ñ�ֵ��G�O�_���P�N
  //  �ϥΤ覡: u_chk_sleip2flw($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.11.03
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
  //  if($num==0){  //2011.10.04 �H�e�O�S�]ñ�̡֪A�h�|���
  //    return 0;
  //  }                                     
  //  else{

  //    while($row = mysql_fetch_array($result)){
      
  //    }
  //  }
  //}             

  // **************************************************************************
  //  ��ƦW��: u_chk_sleip2flw4()
  //  ��ƥ\��: �ˬd���{ñ�ֳ�O�_���зs�W
  //  �ϥΤ覡: u_chk_sleip2flw4($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.12.06
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
             ";   //add by �Ϊ� 2012.01.12 �~�X�g�z�ťH�W�h�W�[���{�欰 sleip2flw.sleip2flw008='12' 
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
  //  ��ƦW��: u_chkeb12()
  //  ��ƥ\��: �O�_�ק悔�{
  //  �ϥΤ覡: u_chkeb12($vsnum)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.12.26
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
      $fd_eb09 = substr($row['eb09'],0,2); // 06���Ȩ�.07�p�� �֨��f��
      if($row['eb12']<>'' and $row['eb12']<>'0' and $fd_eb09<>'07'){  //upd by �Ϊ� (����-16232)�^��6.�p���֭��̤��ǤJ���{ñ�ֳ�
        //echo "ñ";
        return true;
      }else{
        //echo "��ñ";
        return false;
      }
    } 
    //exit; 
  } 
  



  // **************************************************************************
  //  ��ƦW��: u_seleb12()
  //  ��ƥ\��: ��M�W�Ӥ�̫�j�@���J�t���{
  //  �ϥΤ覡: u_seleb12($f_var)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2011.12.30
  // **************************************************************************
  function u_seleb12($f_var) {
    $y = substr($f_var['f_dateb'], 0, 4); //���e�|�X (�~)        
    $m = substr($f_var['f_dateb'], 4, 2); //���̫�G��(��)      
    $lastmonth = mktime(0, 0, 0, $m-1, "01", $y);   //�W�Ӥ� 26 ��     
    if( date("Ymd")<='20150110' AND ('9325760'==$f_var['f_empno'] OR '8165564'==$f_var['f_empno']) ){  /*add by �Ϊ� 2014.12.25 ����25296�B25295 */
      $lastmonth = mktime(0, 0, 0, $m-2, "01", $y);   //�W��Ӥ� 26 ��   
    }         
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //�o�Ӥ� 25 ���
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
        $fd_sleip2flw = u_chk_sleip2flw($row['s_num']); //�P�_ñ�֬O�_�w�L
        if($fd_sleip2flw=='0'){
          $fd_eb02 = $row['eb02']; 
          $ar_mile[$fd_eb02] = $row['eb12'];   //$ar_mile[���]=�J�t������
        }    
      }
    }
    if( !empty($ar_mile) ){
      reset($ar_mile);  //���s
      while(list($key,$value)=each($ar_mile)) { 
        if( $vfv_eb02<>'' and  $key>=$f_var['top_date'] and $f_var['maxeb12']=='' ){  //�ư��Ĥ@��?�����A�����j�󵥩�n���������A�h�����J�t������ 
          $f_var['maxeb12'] = $vfv_eb12;        
          break;  
        }
        $vfv_eb02 = $key; //���
        $vfv_eb12 = $ar_mile[$key]; //�J�t������
      }    
    }      
    if( $f_var['maxeb12']=='' ){
    	$f_var['maxeb12'] = 0;	
    }      
    return;     
  }
  /*
  function u_seleb12($f_var) {
    $y = substr($f_var['f_dateb'], 0, 4); //���e�|�X (�~)        
    $m = substr($f_var['f_dateb'], 4, 2); //���̫�G��(��)      
    $lastmonth = mktime(0, 0, 0, $m-1, "26", $y);   //�W�Ӥ� 26 ��       
    $nowmonth  = mktime(0, 0, 0, $m,   "25", $y);   //�o�Ӥ� 25 ���
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
        $fd_sleip2flw = u_chk_sleip2flw($row['s_num']); //�P�_ñ�֬O�_�w�L
        if($fd_sleip2flw=='0'){
          //if($f_var['maxeb12']<$row['eb12']){  
          //  $f_var['maxeb12'] = $row['eb12'];
          //} 
        	if( $fd_eb12 < $row['eb12'] ){
        		$fd_eb12 = $row['eb12'];
        	}
        	if( $fd_eb12 > $row['eb12'] and $row['eb23']=='Y' ){ //���g��{�w���`�����`���
        		$fd_eb12 = $row['eb12'];
        	}
          //upd by �Ϊ� 2012.08.06
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
      //echo "��<font color=red><pre>".$sql2."</pre></font>";
      $result2 = mysql_query($sql2); 
      $num2 = mysql_num_rows($result2);  
      if($num2>0){
        while($row2 = mysql_fetch_array($result2)){
         $fd_sleip2flw2 = u_chk_sleip2flw($row2['s_num']); //�P�_ñ�֬O�_�w�L
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
  //  ��ƦW��: u_save_log()
  //  ��ƥ\��: ���{�s�Jlog��
  //  �ϥΤ覡: u_save_log($ar)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2012.02.13
  // **************************************************************************
  function u_save_log($row) {  //���m�ק�
    //echo "<font color=red>text: ".$row['fs_num']."-----".$row['eb04']."----".$row['eb16']."-----"."</font>";
    sl_open('docs');
    $vb_empno   = $_SESSION["login_empno"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vproc      = u_showproc(); // �{���N��  
    
    $fd_str = substr($row['eb04'],0,4);
    $query="select *
            from   zip
            where  sname like '%{$fd_str}%' or
                   city like '%{$fd_str}%' or
                   zone like '%{$fd_str}%'";
    //sl_open('slh,slc.com.tw');
    $result = mysql_query($query);             
    $total = mysql_num_rows($result); //�ثe�`����       
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
        sl_errmsg("���~"."<pre>".$query2."</pre>");
      }
    }
  } 

  // **************************************************************************
  //  ��ƦW��: u_del_flw()
  //  ��ƥ\��: ñ�ֳ���
  //  �ϥΤ覡: u_del_flw($fd_sla015002)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2013.12.24
  // **************************************************************************
  function u_del_flw($fd_sla015002) { 
    // �ը���(ñ�֤�)   -> �ը�����B �~�X��Ƨ@�o
    // ���{��(ñ�֤�)   -> ���{����
    $fd_sla015002 = $fd_sla015002;
    $fd_time      = date("Y/m/d H:i:s");
    $vb_empno     = $_SESSION["login_empno"];
    $vb_dept_id   = $_SESSION["login_dept_id"];
    $vb_date      = date("Y-m-d H:i:s");
    $vproc        = u_showproc(); // �{���N��      
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
    if(!mssql_query($sql_resda)) { // �g�J����
      sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_resda.'!!'); //qq:para�u��str����font
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
    if(!mssql_query($sql_resdc)) { // �g�J����
      sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_resdc.'!!'); //qq:para�u��str����font
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
    if(!mssql_query($sql_resdd)) { // �g�J����
      sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_resdd.'!!'); //qq:para�u��str����font
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
    if(!mysql_query($sql_2flw)) { // �g�J����
      sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_2flw.'!!'); //qq:para�u��str����font
      EXIT;
    }    
                
  
    return;
  }  

  // **************************************************************************
  //  ��ƦW��: u_del_ewb()
  //  ��ƥ\��: DOCS��ñ�ֳ�@�o
  //  �ϥΤ覡: u_del_ewb($ar)
  //  �{���]�p: �Ϊ�
  //  �]�p���: 2013.12.24
  // **************************************************************************
  function u_del_ewb($f_var) { 
    // �ը���(ñ�֤�)   -> �ը�����B �~�X��Ƨ@�o
    // ���{��(ñ�֤�)   -> ���{����
    $fd_time      = date("Y/m/d H:i:s");
    $vb_empno     = $_SESSION["login_empno"];
    $vb_dept_id   = $_SESSION["login_dept_id"];
    $vb_date      = date("Y-m-d H:i:s");
    $vproc        = u_showproc(); // �{���N��      
    
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
    if(!mysql_query($sql_ewb)) { // �g�J����
      sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_ewb.'!!'); //qq:para�u��str����font
      EXIT;
    }    
               
  
    return;
  }    
  
  // **************************************************************************
  //  ��ƦW��: ul_eip2flw()
  //  ��ƥ\��: ����32441-ñ�֦ܽ]�ֳ̰��D��
  //  �ϥΤ覡:
  //  �{���]�p: 
  //  �]�p���: 2017.09.20
  // **************************************************************************
  function ul_eip2flw(&$f_var) {
    Global $_SESSION;
    Global $f_var;
    $vb_empno   = $_SESSION["login_empno"];
    $vb_name    = $_SESSION["login_name"];
    $vb_dept_id = $_SESSION["login_dept_id"];
    $vb_date    = date("Y-m-d H:i:s");
    $vfromip    = $_SERVER["REMOTE_ADDR"];
    $vproc      = u_showproc(); // �{���N��
    //$f_var['mgo_url'] = "/~docs/erp_qa/erp_qa.php?msel=6&mqah_no={$_REQUEST['f_s_num']}";
    //$f_var['f_s_num'] = '6173';

    if(is_array($_REQUEST)) { // ����Ƥ~�B�z
       while (list($f_fd_name,$f_fd_value) = each($_REQUEST)) {
              //echo "$f_fd_name=$f_fd_value----";
              $f_var[$f_fd_name] = $f_fd_value;
       }
    }
    $count_table= substr_count($f_var['f_table'],'.');
    $ex_table   = explode('.',$f_var['f_table']);
    $fd_table   = iif($count_table==0,$f_var['f_table'],$ex_table[1]);

    $fd_b_empno      = $f_var['f_b_empno'];                                          //���ɪ̭��s
    $fd_sleip2flw003 = str_replace("\"","",$f_var['f_db']);                          //DB
    $fd_sleip2flw004 = str_replace("\"","",$fd_table);                               //table
    $fd_sleip2flw005 = str_replace("\"","",$f_var['f_file_path']);                   //������|
    $fd_sleip2flw006 = date('Y/m/d',strtotime($f_var['f_b_date']));                  //�����
    $fd_sleip2flw007 = str_replace("\"","",$f_var['f_title']);                       //�D��
    $fd_sleip2flw008 = str_replace("\"","",$f_var['f_type']);                        //���O
    $fd_sleip2flw009 = str_replace("\"","",str_replace("'","",$f_var['f_content'])); //���e
    $fd_sleip2flw010 = str_replace("\"","",$f_var['f_s_num']);                       //s_num
    $fd_sleip2flw011 = str_replace("\"","",$f_var['f_cnt']);                         //���� //upd by mimi 2011.06.13 �W�[���ɦ���
    $fd_resda020 = "2"; // Add By Tails 2015.06.09 �s��ñ�֪��A�w�]
    $fd_resda021 = "1"; // Add By Tails 2015.06.09 �s��ñ�ֵ��G�w�]
    //if($f_var['f_file1'] <> ''){
    //  $remote_file[]= $f_var['f_file1'];         // remote���ɮצW��
    //}
    //if($f_var['f_file2'] <> ''){
    //  $remote_file[]= $f_var['f_file2'];         // remote���ɮצW��
    //}
    //if($f_var['f_file3'] <> ''){
    //  $remote_file[]= $f_var['f_file3'];         // remote���ɮצW��
    //}
    //upd by mimi 2011.07.01 �W�[��10�Ӫ���
    $fd_cnt=1;
    for($i=0;$i<10;$i++){
      $fd_file = "f_file".($fd_cnt+$i);
      if($f_var[$fd_file] <> ''){
        $remote_file[]= $f_var[$fd_file];         // remote���ɮצW��
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
    // (����20585)upd by �Ϊ� 2013.07.08 �������v���H���bresak004�|�H���s+_U���
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
      sl_errmsg("<b><font color='#FF0000'>�`�N!!</font> ���u: {$vb_name}({$fd_b_empno}) �q�lñ�ְ򥻸�Ʋ��`(��´.�W�h�D��)���p���H�O���@��ơA���¡I�C</b>"); //qq:para�u��str����font
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
    $fd_resak015 = $row2['resak015'];  //FLW-�����N��
    $fd_resal002 = $row2['resal002'];  //FLW-�����W��
    $fd_resak013 = $row2['resak013'];  //FLW-���ݥD��

    $query3 = "SELECT top 1 resdz001,resdz002
               FROM resdz
               where resdz001 = 'SL-EIP2FLW'
               order by resdz002 DESC
              ";
    $result3 = mssql_query($query3);
    $row3 = mssql_fetch_array($result3);
    $fd_resdz001 = 'SL-EIP2FLW';    //FLW-�渹
    $fd_resdz002 = str_pad(($row3['resdz002']+1),10,0,STR_PAD_LEFT);  //FLW-��O
    $fd_ymd      = date('Y/m/d');
    $fd_date     = date('Y/m/d H:i:s');

    //resdz ���渹������ (RESDZ) upd by mimi 2011.11.18 Ū��渹�渹�ᰨ�W�g�J,�p�G�S�����Ъ��h����g�J,�H�קK�{�����`~
    $query_head6 ="insert into {$vdat1}..resdz (resdz001,resdz002) values ('{$fd_resdz001}','{$fd_resdz002}')";
    //echo $query_head6.'<hr>';
    if(!mssql_query($query_head6)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!��O�渹���СA�Э��s��J!!</b></font>'.$query_head6.'!!'); //qq:para�u��str����font
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
    if(!mysql_query($query_head7)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head7.'!!'); //qq:para�u��str����font
    }

    //flw-sleip2flw
    sl_openef2k($vdat1);
    $query_head1 ="insert into {$vdat1}..sleip2flw ({$vins_fd1},sleip2flw900,sleip2flw901,sleip2flw904)
                   values ({$vins_value1},'{$fd_b_empno}','{$fd_date}','{$fd_resak015}')";
    //echo $query_head1.'<hr>';
    if(!mssql_query($query_head1)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head1.'!!'); //qq:para�u��str����font
       //echo $f_var['query_data'];
       //exit;
    }

    //resda ���y�{���ʥD�� (RESDA)
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
            case "resca004": //�y�{����
              $vins_fd2   .=",resda003";
              $vins_value2.=",'{$value4}'";
              break;
            case "resca005": //�۰ʽs��?
            case "resca017": //���H�i�_�ܧ���ʽ�?
              break;
            case "resca006": //�O��ĵ�ܶ}��
            case "resca007": //�O��ĵ��-���H
            case "resca008": //�O��ĵ��-�O�ɤH�����D��
            case "resca009": //�O��ĵ��-���w�޲z�H
            case "resca010": //�O��ĵ��-���w�޲z�H���u�N��
            case "resca011": //�O��ĵ��-ĵ�ܶ��j�Ѽ�
            case "resca012": //�O��ĵ��-ĵ�ܦ���
            case "resca013": //�O�_���׫�q���Ҧ��H��?
            case "resca014": //�O�_�v�Ŧ^��?
            case "resca015": //���H�i�_�j��
            case "resca016": //���H�i�_���?
              $fd_resda    ="resda".str_pad((substr($key4,5,3)-2),3,'0',STR_PAD_LEFT);
              $vins_fd2   .=",{$fd_resda}";
              $vins_value2.=",'{$value4}'";
              break;
            case "resca018": //��Z�i�_�C�L�H
            case "resca019": //��Z�i�_��H�H
            case "resca020": //��Z�i�_�\Ū����H
            case "resca021": //�^��i�_�C�L�H
            case "resca022": //�^��i�_��H�H
            case "resca023": //�^��i�_�\Ū����H
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
    if(!mssql_query($query_head2)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head2.'!!'); //qq:para�u��str����font
       //echo $f_var['query_data'];
       //exit;
    }

    //resdb ���y�{���ʤl�� (RESDB),resdc ���y�{���ʩ����� (RESDC),resdd ���y�{���ʩ����� (RESDD)
    //$query51 = "SELECT rescd.rescd001,rescd.rescd002,rescd.rescd003,rescd.rescd004,EFormWizardCond.OperationDef,
    //                   rescd.rescd006,rescd.rescd007,rescc006,rescc007
    //           FROM rescd
    //             LEFT JOIN EFormWizardCond ON EFormWizardCond.CondID=rescd005
    //             LEFT JOIN rescc ON rescd001=rescc001 AND rescd002=rescc002 AND rescd003=rescc003
    //           WHERE rescd001='SL-EIP2FLW' AND rescd007='{$fd_sleip2flw008}'
    //          ";�ϥάy�{���󪺤�k
    $query51 = "SELECT rescf005,EFormWizardCond.OperationDef,rescf006,rescf007,resce005
                FROM rescf
                  LEFT JOIN  resce ON rescf001=resce001 AND rescf003=resce003
                  LEFT JOIN EFormWizardCond ON EFormWizardCond.CondID=rescf005
                WHERE rescf001='{$fd_resdz001}' AND CONVERT(VARCHAR(999), rescf007)='{$fd_sleip2flw008}'
              ";//�ϥΤl�y�{�w�q����k
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
        //resdc ���y�{���ʩ����� (RESDC)
        $vins_fd4    =" resdc001,resdc002,resdc005,resdc006,resdc007,resdc008,resdc900,resdc901,resdc904 ";
        $vins_value4 =" '{$fd_resdz001}','{$fd_resdz002}','0001','{$resdc006}','3','1','{$fd_b_empno}','{$fd_date}','{$fd_resak015}' ";

        //resdd ���y�{���ʩ����� (RESDD)
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
            case "resch002": //����  
            case "resch003": //�丹
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
            case "resch004": //�y�{����
            case "resch005": //ñ�ֺ���
            case "resch006": //�y�{����Ѽ�1
            case "resch007": //�y�{����Ѽ�2
            case "resch008": //�y�{����Ѽ�3
            case "resch009": //�y�{����Ѽ�4
            case "resch010": //�e�\ñ�֮ɶ�
            case "resch011": //�۰�ByPass?
            case "resch012": //ByPass�覡
            case "resch013": //�O�_�j��ñ��?
            case "resch014": //�O�_��@ñ��
            case "resch015": //�i�_�C�L?
            case "resch016": //�i�_�Mñ?
            case "resch017": //�i�_�[ñ?
            case "resch018": //�i�_��|?
            case "resch019": //�i�_��H?
            case "resch020": //�i�_�s�W���[��?
            case "resch021": //�i�_�ק���[��?
            case "resch022": //�i�_�R�����[��?
            case "resch023": //�i�_�\Ū���[��?
            case "resch024": //ñ�֮ɱK�X����?
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
      if(!mssql_query($query_head3)) { // �g�J����
         sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head3.'!!'); //qq:para�u��str����font
         //echo $f_var['query_data'];
         //exit;
      }
    }
    //----------------------------------------------------------------------------
    //add by �Ϊ� 2017.09.19 �̽]�֥̤j�H����,�n�ݨ�]�֥~�Xñ�ֳ�
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
      $fd_rkemp = $row_rk['resak001']; //�_��H
      $fd_rkemp1 = $row_rk['rka1']; //��1��
      $fd_rkemp2 = $row_rk['rka2']; //��2��
      $fd_rkemp3 = $row_rk['rka3']; //��3�� 
      $fd_rkemp4 = $row_rk['rka4']; //��4��
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
        if(!mssql_query($sql_db)) { // �g�J����
          sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$sql_db.'!!');
        }
      }
    }
    
    //�̫�@���h�Ԥ@�����ݥD��

    //----------------------------------------------------------------------------

    //resdc ���y�{���ʩ����� (RESDC)
    $query_head4 ="insert into {$vdat1}..resdc ($vins_fd4) values ($vins_value4)";
    //echo $query_head4.'<hr>';
    if(!mssql_query($query_head4)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head4.'!!'); //qq:para�u��str����font
       //echo $f_var['query_data'];
       //exit;
    }

    $query_head5 ="insert into {$vdat1}..resdd ($vins_fd5) values ($vins_value5)";
    //echo $query_head5.'<hr>';
    if(!mssql_query($query_head5)) { // �g�J����
       sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head5.'!!'); //qq:para�u��str����font
       //echo $f_var['query_data'];
       //exit;
    }

    //resde ���y�{���[�� (RESDE) add by mimi 2010.07.07
    // **************************************************************************
    //  ��ƦW��: u_ftp_put()
    //  ��ƥ\��: �N�ɮפW�Ǧ�190
    //  �ϥΤ覡: u_ftp_put($f_var)
    //  �{���]�p: Mimi
    //  �]�p���: 2010.07.08
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
      //-----���.190���D��----------------------------------------------------------------
      $fd_resde003 = 0;  //�Ǹ�
      for($i=0;$i<count($remote_file);$i++){
        if(ftp_put($mftp_connect,"{$remote_dir}{$remote_file[$i]}","{$fd_sleip2flw005}{$remote_file[$i]}", FTP_BINARY)) {
          //ftp_chmod($mftp_connect,0666,"{$remote_dir1}{$remote_file[$i]}");
          //u_errmsg('3','left','000000','FFFF99','FF9966',"{$remote_file[$i]} ������ɦ��\\!!");
          $fd_resde003 ++;
          $fd_resde003 = str_pad($fd_resde003,4,'0',STR_PAD_LEFT);
          $fd_resde010 = filesize("{$fd_sleip2flw005}{$remote_file[$i]}");
          $vins_fd8    ="resde001,resde002,resde003,resde004,resde005,resde006,resde010,resde011,resde900,resde901,resde904";
          $vins_value8 ="'{$fd_resdz001}','{$fd_resdz002}','{$fd_resde003}',
                         '{$remote_file[$i]}','{$remote_file[$i]}','{$remote_file[$i]}','{$fd_resde010}','{$fd_date}',
                         '{$fd_b_empno}','{$fd_date}','{$fd_resak015}'";
          $query_head8 ="insert into {$vdat1}..resde ($vins_fd8) values ($vins_value8)";
          //echo $query_head8.'<hr>';
          if(!mssql_query($query_head8)) { // �g�J����
             sl_errmsg('<font color="#FF0000"><b>�`�N!!</b></font>'.$query_head8.'!!'); //qq:para�u��str����font
             //echo $f_var['query_data'];
             //exit;
          }
        }
        else{
          u_errmsg('3','left','000000','FFFF99','FF9966',"{$remote_file[$i]} �ɮפW�ǥ���!!");
        }
      }
      //-------------------------------------------------------------------------------------
      ftp_close($mftp_connect);                  // close ftp
      //-------------------------------------------------------------------------------------

    }
    else {
       u_errmsg('3','left','000000','FFFF99','FF9966','FWL�D���s�u���ѡA�гq����T��!!');
    }
    $f_var['f_resdz001']=$fd_resdz001;//upd by mimi 2011.06.02 �^��ñ�֪��O
    $f_var['f_resdz002']=$fd_resdz002;//upd by mimi 2011.06.02 �^��ñ�֪�渹
    return $f_var;
    
  }  
  // **************************************************************************
  //  ��ƦW��: ul_essf21()
  //  ��ƥ\��: ��hrm
  //  �ϥΤ覡: ul_essf21($snum,$msel,$empid)
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
             $f_var['hrmws']['parm'][1]['String'] = $ar_1['sleip2flw001']; //��O
             $f_var['hrmws']['parm'][2]['String'] = $ar_1['sleip2flw002']; //�渹
             $f_var['hrmws']['parm'][3]['Int32'] = 2; //�n�O����(1.���ӽеn�O�B2.�����n�O)
             $f_var['hrmws']['parm'][4]['String'] = ""; //�X�t�ӽ�id (�p�G�����n�O���ŭ�)
             $f_var['hrmws']['parm'][5]['String'] = $fd_empid; //���uID
             $f_var['hrmws']['parm'][6]['String'] = "701"; //�X�t����id  A1136|�X�t(�L�뭹)   A1136|�X�t(�L�뭹)
             $chkmak = '/\s+|[&:@8*~%]|["|\']|[\[\]]|[\n\r\t]|[\\\\]/';
             //$fv_eb04 = str_replace("&","",$ar_1['eb04']);  //ws�|gg
             $fv_eb04 = preg_replace($chkmak, "", $ar_1['eb04']);  //ws�|gg
             $f_var['hrmws']['parm'][7]['String'] = mb_convert_encoding($fv_eb04,'UTF-8','big5'); //�X�t�a�I
             $f_var['hrmws']['parm'][8]['DateTime'] = sl_4ymd($ar_1['eb02']); //�}�l���
             $f_var['hrmws']['parm'][9]['String'] = substr($ar_1['eb03'],0,2).":".substr($ar_1['eb03'],2,2); //�}�l�ɶ�
             $f_var['hrmws']['parm'][10]['DateTime'] = sl_4ymd($ar_1['eb06']); //�������
             $f_var['hrmws']['parm'][11]['String'] = substr($ar_1['eb07'],0,2).":".substr($ar_1['eb07'],2,2); //�����ɶ�
             $f_var['hrmws']['parm'][12]['Int32'] = "1"; //�����𮧯Z��
             //$f_var['hrmws']['parm'][13]['String'] = "-".mb_convert_encoding($ar_1['eb08'],'UTF-8','big5'); //�Ƶ�
             $f_var['hrmws']['parm'][13]['String'] = "-".$ar_1['s_num']; //�Ƶ�
             $f_var['hrmws']['parm'][14]['Int32'] = "1"; //�����D�b���q�ɶ�
             $f_var['hrmws']['parm'][15]['Int32'] = "1"; //�����𮧯Z��?�[�Z�N�\�q�]0�_�A1�O�^
             sl_hrmws($f_var);                            
                  
             if( '0'==$f_var['hrmws']['status'] ){ //���Ҧ��\  �D0������
               $f_var['hrmws']['serviceType'] = "Dcms.HR.Services.IBusinessRegisterService,Dcms.HR.Business.Business"; 
               $f_var['hrmws']['method'] = "SaveForESS";                 
               $f_var['hrmws']['parameterType'] = "";
               //$fv_eb05 = str_replace("&","",$ar_1['eb05']);  //ws�|gg
               $fv_eb05 = preg_replace($chkmak, "", $ar_1['eb05']);  //ws�|gg     
               $f_var['hrmws']['parm'][16]['String'] = mb_convert_encoding($fv_eb05,'UTF-8','big5'); //�X�t��]
               $f_var['hrmws']['parm'][17]['Int32'] = "1"; //�����𮧯Z�����[�Z�N�\�q
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
                 ul_delflw($ar_1['sleip2flw001'],$ar_1['sleip2flw002']); //add by �Ϊ� 2018.11.22 hrm��í,�]���T�w����ɭԷ|�d��,�ҥH�P�_�p�G�O�n��hrm��,�M�����ҨS�����\��,�N���
                 $fd_inLog .= "HRM�o��^�g����-{$fd_s_num}\n";
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "error: ".$f_var['hrmws']['error']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
                 sl_errmsg("<font color=red size=+2>HRM�o��^�g����-{$fd_s_num}! <BR>�нT�{�~�X���X�h�Ԯɬq, �O�_���ݭn��JHRM���N���d����, �ЦA���s�e��C<br>".$f_var['hrmws']['error']."</font>");
                 //echo "HRM�o��^�g����-{$fd_s_num}\n";
                 //echo "<pre>";
                 //print_r($f_var['hrmws']);
                 //echo "</pre>";
                 exit;      
               }
             }else{
               ul_delflw($ar_1['sleip2flw001'],$ar_1['sleip2flw002']); //add by �Ϊ� 2018.11.22 hrm��í,�]���T�w����ɭԷ|�d��,�ҥH�P�_�p�G�O�n��hrm��,�M�����ҨS�����\��,�N���
               $fd_inLog .= "HRM�o�����ҥ���-{$fd_s_num}\n";
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
               sl_errmsg("<font color=red size=+2>HRM�o�����ҥ���-{$fd_s_num}! <BR>�нT�{�~�X���X�h�Ԯɬq, �O�_���ݭn��JHRM���N���d����, �ЦA���s�e��C<br>".$f_var['hrmws']['error']."</font>");
               //echo "HRM�o�����ҥ���-{$fd_s_num}\n";
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
               $f_var['hrmws']['parm'][1]['String'] = $fd_brgid; //�X�t�n�Oid BusinessRegister.BusinessRegisterId
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
                 $fd_inLog .= "HRM��楢��-{$fd_s_num}\n";
                 $fd_inLog .= "status: ".$f_var['hrmws']['status']."\n";
                 $fd_inLog .= "error: ".$f_var['hrmws']['error']."\n";
                 $fd_inLog .= "rtn: ".implode(",",$f_var['hrmws']['rtn'])."\n";
                 fwrite($fp, $fd_inLog);
                 fclose($fp);
                 echo "HRM��楢��-{$fd_s_num}\n";
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
    //mysql_close(); // ������Ʈw
  }
  
  // **************************************************************************
  //  ��ƦW��: ul_delflw()
  //  ��ƥ\��: �qñ���
  //  �ϥΤ覡: ul_delflw(&$f_var)
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

<?php

    
  if(!function_exists('jam_menit'))
  {   
    function jam_menit($time)
    {
      $p=explode(":",$time);
      return $p[0].":".$p[1];
    }
  }

  if(!function_exists('mix_2Date'))
  {    
    function mix_2Date($date1,$date2,$format="us")
    {
      $explodedDate1 = explode("-",$date1);
      $explodedDate2 = explode("-",$date2);
      $result="";
      if($format='us')
      {
        if($date1!=$date2)
        {
          if($explodedDate1[0]==$explodedDate2[0])
          {
            if($explodedDate1[1]==$explodedDate2[1])
            {
              $month = $explodedDate1[1];
              $year = $explodedDate1[0];
              $result = $explodedDate1[2] . " - " . $explodedDate2[2] . " " . get_monthName($month,"id") . " " . $year;
            }        
            else
            {
              $year = $explodedDate1[0];
              $result = $explodedDate1[2] . " " . get_monthName($explodedDate1[1],"id") . " - " . $explodedDate2[2] . " " . get_monthName($explodedDate2[1],"id") . " " . $year;
            }
          }
          else
          {
              $result = $explodedDate1[2] . " " . get_monthName($explodedDate1[1],"id") . " " . $explodedDate1[0] . " - " . $explodedDate2[2] . " " . get_monthName($explodedDate2[1],"id") . " " . $explodedDate2[0];          
          }
        }
        else
        {
           $result = $explodedDate1[2]." ".get_monthName($explodedDate1[1],"id")." ".$explodedDate1[0];
        }
      }
      
      return $result;
    }
  }

  if(!function_exists('mix_2Month'))
  {    
    function mix_2Month($date1,$date2)
    {
      $result="";
      $explodedDate1 = explode("-",$date1);
      $explodedDate2 = explode("-",$date2);
      if($explodedDate1[1]==$explodedDate2[1])
      {
        $result=strtoupper(get_monthName($explodedDate1[0],"indonesia"))." S/D ".strtoupper(get_monthName($explodedDate2[0],"indonesia")). " ".$explodedDate1[1];
      }
      else
      {
        $result=strtoupper(get_monthName($explodedDate1[0],"indonesia"))." ".$explodedDate1[1]." S/D ".strtoupper(get_monthName($explodedDate2[0],"indonesia"))." ".$explodedDate2[1];
      }
      
      return $result;
    }
  }
  
  if(!function_exists('indo_date_format'))
  {
    function indo_date_format($data,$type)
    {    
      $str_len = strLen($data);
      $dd="";
      $mm="";
      $yyyy="";
      $result="";
      
      $dd = substr($data,-2,2);
      $mm = substr($data,5,2);
      $yyyy = substr($data,0,4);      
      
      if($type=="longDate")
      {        
        $MM = get_monthName($mm,"id");
        $result = $dd . " " . $MM . " " . $yyyy;
      }
      else if($type=="withDayName")
      {
        $MM = get_monthName($mm,"id");
        $dn = get_dayName($data);      
        $result = $dn.", " . $dd . " " . $MM . " " . $yyyy; 
      }
      else if($type=="shortDate")
      {
        $result = $dd."-".$mm."-".$yyyy;
      }
      return $result;
    }
  }

  if(!function_exists('us_date_format'))
  {
    function us_date_format($data)
    {    
      $str_len = strLen($data);
      $dd="";
      $mm="";
      $yyyy="";
      $result="";
      
      $dd = substr($data,0,2);
      $mm = substr($data,3,2);      
      $yyyy = substr($data,6,4);
            
      $result = $yyyy."-".$mm."-".$dd;
      return $result;
    }
  }
  
  if(!function_exists('get_monthName'))
  {
    function get_monthName($month,$lang='id',$type='long')
    {
      $month_ = (int)$month;
      $arr_monthNumber = array(1,2,3,4,5,6,7,8,9,10,11,12);

      if(in_array($month_,$arr_monthNumber))
      {
        $arr_monthName = array(
                      1=>array('id'=>array('long'=>'Januari','short'=>'Jan'),'us'=>array('long'=>'January','short'=>'Jan')),
                      2=>array('id'=>array('long'=>'Februari','short'=>'Feb'),'us'=>array('long'=>'February','short'=>'Feb')),
                      3=>array('id'=>array('long'=>'Maret','short'=>'Mar'),'us'=>array('long'=>'March','short'=>'Mar')),
                      4=>array('id'=>array('long'=>'April','short'=>'Apr'),'us'=>array('long'=>'April','short'=>'Apr')),
                      5=>array('id'=>array('long'=>'Mei','short'=>'Mei'),'us'=>array('long'=>'May','short'=>'May')),
                      6=>array('id'=>array('long'=>'Juni','short'=>'Jun'),'us'=>array('long'=>'June','short'=>'Jun')),
                      7=>array('id'=>array('long'=>'Juli','short'=>'Jul'),'us'=>array('long'=>'July','short'=>'Jul')),
                      8=>array('id'=>array('long'=>'Agustus','short'=>'Agt'),'us'=>array('long'=>'August','short'=>'Agt')),
                      9=>array('id'=>array('long'=>'September','short'=>'Sep'),'us'=>array('long'=>'September','short'=>'Sep')),
                      10=>array('id'=>array('long'=>'Oktober','short'=>'Okt'),'us'=>array('long'=>'October','short'=>'Oct')),
                      11=>array('id'=>array('long'=>'November','short'=>'Nov'),'us'=>array('long'=>'November','short'=>'Nov')),
                      12=>array('id'=>array('long'=>'Desember','short'=>'Des'),'us'=>array('long'=>'December','short'=>'Dec'))
                      );
        
        return $arr_monthName[$month_][$lang][$type];
      }
      else
        return $bulan;

    }
  }

  
  if(!function_exists('get_dayName'))
  {
    function get_dayName($date)
    {
      $d = substr($date,8,2);
      $m = substr($date,5,2);
      $y = substr($date,0,4);
      $n = date('w',mktime(0,0,0,$m,$d,$y));
  	
      switch($n)
      {
        case "0":$day="Minggu";break;
        case "1":$day="Senin";break;
        case "2":$day="Selasa";break;
        case "3":$day="Rabu";break;
        case "4":$day="Kamis";break;
        case "5":$day="Jumat";break;
        case "6":$day="Sabtu";break;        
      }
      return $day;
    }
  }

  function firstOfMonth($month='',$year='') 
  {
    $month = ($month==''?date('m'):$month);
    $year = ($year==''?date('Y'):$year);
    return date("Y-m-d", strtotime($month.'/01/'.$year.' 00:00:00'));
  }

  function lastOfMonth($month='',$year='') {
    $month = ($month==''?date('m'):$month);
    $year = ($year==''?date('Y'):$year);
    return date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime($month.'/01/'.$year.' 00:00:00'))));
  }

  function check_status_dateRange($date1,$date2){
      $cd = date('Y-m-d');
      $x_cd = explode('-',$cd);
      $x_date1 = explode('-',$date1);
      $x_date2 = explode('-',$date2);

      $curr_jd = GregorianToJD($x_cd[1],$x_cd[2],$x_cd[0]);
      $date1_jd = GregorianToJD($x_date1[1],$x_date1[2],$x_date1[0]);
      $date2_jd = GregorianToJD($x_date2[1],$x_date2[2],$x_date2[0]);
      
      $diff1 = $date1_jd-$curr_jd;
      $diff2 = $date2_jd-$curr_jd;      

      $result = '';
      if($diff1>0)
        $result = 'pre';
      else if($diff1<=0 and $diff2>=0)
        $result = 'on';
      else if($diff2<0)
        $result = 'finish';

      return $result;
  }

  function dateadd($date,$days){

    $x = explode('-',$date);
    $new_date = date('Y-m-d',mktime(0,0,0,$x[1],$x[2]+(int)$days,$x[0]));
    return $new_date;
    
  }

  function week_in_month($date, $rollover='sunday')
  {
      $cut = substr($date, 0, 8);
      $daylen = 86400;

      $timestamp = strtotime($date);
      $first = strtotime($cut . "00");
      $elapsed = ($timestamp - $first) / $daylen;

      $weeks = 1;

      for ($i = 1; $i <= $elapsed; $i++)
      {
          $dayfind = $cut . (strlen($i) < 2 ? '0' . $i : $i);
          $daytimestamp = strtotime($dayfind);

          $day = strtolower(date("l", $daytimestamp));

          if($day == strtolower($rollover))  $weeks ++;
      }

      return $weeks;
  }
?>

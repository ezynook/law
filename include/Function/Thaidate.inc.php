<?php
date_default_timezone_set('Asia/Bangkok');
/* ฟังค์ชั่นแปลง คศ. เป็น พศ. */
function convertDate($strDate){
		if(preg_match('/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/',$strDate)){
			$year = (date('Y', strtotime($strDate))+543);
			$month = date('m', strtotime($strDate));
			$day = date('d', strtotime($strDate));
			$times = date('H:i:s', strtotime($strDate));
			$mapdate = $day.'/'.$month.'/'.$year.' '.$times;
			return $mapdate;
		}else{
			$year = (date('Y', strtotime($strDate))+543);
			$month = date('m', strtotime($strDate));
			$day = date('d', strtotime($strDate));
			$mapdate = $day.'/'.$month.'/'.$year;
			return $mapdate;
		}
}
<?php
class Timezone {
	static function convert($date, $user_timezone, $format){
		$utc_time = $date;
		$date_obj = new DateTime($utc_time, new DateTimeZone('UTC'));
		$date_obj->setTimezone(new DateTimeZone($user_timezone));
		return $date_obj->format($format);
	}	
}
<?php #Определяет загрузку процессора 
$log->LogInfo('Got this file');
function getServerCPULoad(){
	 
	//проверяем возможность чтения виртуальной директории
	if (@is_readable('/proc/stat')){
	 
	//делаем первый замер
	$file_first = file("/proc/stat");
	 
	//определяем значения состояний (описаны выше)
	$tmp_first = explode(" ",$file_first[0]);
	 
	$cpu_user_first = $tmp_first[2];
	$cpu_nice_first = $tmp_first[3];
	$cpu_sys_first = $tmp_first[4];
	$cpu_idle_first = $tmp_first[5];
	$cpu_io_first = $tmp_first[6];
	 
	sleep(2);//промежуток до второго замера
	 
	//делаем второй замер
	$file_second = file("/proc/stat");
	$tmp_second = explode(" ",$file_second[0]);
	 
	$cpu_user_second= $tmp_second[2];
	$cpu_nice_second= $tmp_second[3];
	$cpu_sys_second = $tmp_second[4];
	$cpu_idle_second= $tmp_second[5];
	$cpu_io_second = $tmp_second[6];
	 
	//определяем разницу использованного процессорного времени
	$diff_used = ($cpu_user_second-$cpu_user_first)+($cpu_nice_second-$cpu_nice_first)+($cpu_sys_second-$cpu_sys_first)+($cpu_io_second-$cpu_io_first);
	 
	//определяем разницу общего процессорного времени
	$diff_total = ($cpu_user_second-$cpu_user_first)+(
	 
	$cpu_nice_second-$cpu_nice_first)+($cpu_sys_second-$cpu_sys_first)+($cpu_io_second-$cpu_io_first)+($cpu_idle_second-$cpu_idle_first);
	 
	//определение загрузки cpu
	$cpu = round($diff_used/$diff_total, 2);
	 
	return $cpu; (от 0 до 1, если нужно в % - x100)
	}
	return null;
}
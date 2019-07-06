<?php
	/* Finally, A light, permissions-checking logging class. 
	 * 
	 * Author	: Kenneth Katzgrau < katzgrau@gmail.com >
	 * Adapted for SWP: Alexey Romanyuk <admin@popwebstudio.ru>
	 * Date	: July 26, 2008
	 * Comments	: Originally written for use with wpSearch
	 * Website	: http://codefury.net
	 * Version	: 1.0
	 *
	 * Usage: 
	 *		$log = new KLogger ( 'INFO' );
	 *		$log->LogInfo("Returned a million search results");	//Prints to the log file
	 *		$log->LogFATAL("Oh dear.");				//Prints to the log file
	 *		$log->LogDebug("x = 5");					//Prints nothing due to priority setting
	
	 *	DEBUG 	= 1;	// Вся логика подробно. Например, сообщения, выдаваемые пользователю. Все что не перечислено в следующих уровнях, присваиваем debug
	 *
	 *	INFO 	= 2;	// Переход на новый скрипт (в начале каждого скрипта). Тип запроса (ajax или обычный). Данные, присланные пользователем. 
	 *					// Факт удачного входа в систему. Выбранная страница, язык и тп.
	 *
	 *	WARN 	= 3;	// Факт неудачного входа в систему
	 *
	 *	ERROR 	= 4;	// Под error мы пишем ошибки вроде не найденных страниц (404). Неправильные значения переменных, присланных пользователем. 
	 *					// Невозможность отправить оповещение пользователю
	 *
	 *	FATAL 	= 5;	// Под фаталом прописываем самые жестокие ошибки вроде обходов защиты, наличие $block, не найденные части системы и тп
	 *
	*/
	
class KLogger{
	
	const DEBUG 	= 1;	// Most Verbose
	const INFO 		= 2;	// ...
	const WARN 		= 3;	// ...
	const ERROR 	= 4;	// ...
	const FATAL 	= 5;	// Least Verbose
	const OFF 		= 6;	// Nothing at all.
	
	const LOG_OPEN 		= 1;
	const OPEN_FAILED 	= 2;
	const LOG_CLOSED 	= 3;
	
	/* Public members: Not so much of an example of encapsulation, but that's okay. */
	public $Log_Status 	= KLogger::LOG_CLOSED;
	public $DateFormat	= "Y-m-d H:i:s";
	public $MessageQueue;
	
	private $log_file;
	private $priority = KLogger::INFO;
	
	private $file_handle;
	
	private $cust_ip;
	private $fullpath_len;
		
	public function __construct( $priority ){	
		include($_SERVER['DOCUMENT_ROOT']."/core/IPreal.php");# IP
		global $fullpath,$base_memory_usage,$tableprefix,$console_flag,$ajaxflag,$styleflag,$dbconnconnect,$log_dir,$projectname;
		
		
		
		if($console_flag==1) $this->cust_ip='localhost';
		else $this->cust_ip=$ip;

		if($priority!=="OFF"){
			# Правила формирования файлов с логами
			$log_rules_q=mysql_query("SELECT * FROM `$tableprefix-logmanager` WHERE `log_level` != 'OFF';");
			
			if($log_rules_q>0){
			
				while( $log_rule = mysql_fetch_assoc ($log_rules_q) ) {
					
					
					$rule_match=0;//Счетчик совпадений параметров данного rule с реалиями данного запроса
					$rule_cond_count=0;// Счетчик количества условий данного запроса
					if(!empty($log_rule['ip'])){
						$rule_cond_count++;//Увеличили счетчик количества условий данного rule
						if($log_rule['ip']==$ip){
							$rule_match++; // Увеличили количество совпадений условий данного rule с реальностью запроса
						}
					}
					if(!empty($log_rule['site_domain'])){
						$rule_cond_count++;//Увеличили счетчик количества условий данного rule
						if($log_rule['site_domain']==$_SERVER[ 'HTTP_HOST']){
							$rule_match++; // Увеличили количество совпадений условий данного rule с реальностью запроса
						}
					}
					if(!empty($log_rule['page'])){
						$rule_cond_count++;//Увеличили счетчик количества условий данного rule
						if($log_rule['page']==$_GET[ 'page']){
							$rule_match++; // Увеличили количество совпадений условий данного rule с реальностью запроса
						}
					}
					if(!empty($log_rule['uri'])){
						$rule_cond_count++;//Увеличили счетчик количества условий данного rule
						//if($log_rule['uri']==$_SERVER['REQUEST_URI'] or $log_rule['uri']==urldecode($_SERVER['REQUEST_URI'])){
						if(mb_strstr($_SERVER['REQUEST_URI'],$log_rule['uri']) or mb_strstr(urldecode($_SERVER['REQUEST_URI']),$log_rule['uri'])){
							$rule_match++; // Увеличили количество совпадений условий данного rule с реальностью запроса
						}
					}
					// !!!доработать в нужном месте
					//if(!empty($log_rule['login'])){
					
					//if(!empty($log_rule['company_id'])){
					
					//if(!empty($log_rule['userrole'])){
					#Проверяем, подходит ли данный запрос под условия данного rule
					if(!empty($log_rule['request_type'])){
						
						$rule_cond_count++;//Увеличили счетчик количества условий данного rule
						if ($console_flag==1 and $log_rule['request_type']=="cron") $rule_match++;
						elseif ($ajaxflag==1 and $log_rule['request_type']=="ajax") $rule_match++;
						elseif ($styleflag==1 and $log_rule['request_type']=="style") $rule_match++;
						elseif($log_rule['request_type']=="http" and !$console_flag and !$ajaxflag and !$styleflag) $rule_match++;
						elseif($log_rule['request_type']=="all") $rule_match++;
					}
					if($rule_cond_count==$rule_match){
						$this->log_files[]=$log_rule['file'];//Записали этот файл в массив файлов
						if($log_rule['log_level']=="DEBUG") $this->filePriority[$fullpath.'project/'.$projectname. $log_dir.$log_rule['file']]=1;
						elseif($log_rule['log_level']=="INFO") $this->filePriority[$fullpath.'project/'.$projectname. $log_dir.$log_rule['file']]=2;
						elseif($log_rule['log_level']=="WARN") $this->filePriority[$fullpath.'project/'.$projectname. $log_dir.$log_rule['file']]=3;
						elseif($log_rule['log_level']=="ERROR") $this->filePriority[$fullpath.'project/'.$projectname. $log_dir.$log_rule['file']]=4;
						elseif($log_rule['log_level']=="FATAL") $this->filePriority[$fullpath.'project/'.$projectname. $log_dir.$log_rule['file']]=5;

					}
					
				}
			}
		}

		if(!empty($_SERVER[ 'HTTP_HOST'])) $this->sitedomain=$_SERVER[ 'HTTP_HOST'];
		elseif($console_flag==1)$this->sitedomain='cron';

		$this->fullpath_len=strlen($fullpath);
		$this->memory_base=$base_memory_usage;
		

		if ( $priority !== "OFF" ) { //Логи включены
			
			if($this->log_files){
				foreach($this->log_files as $filepath){

					$this->log_file =$fullpath.'project/'.$projectname. $log_dir.$filepath;
					$this->MessageQueue = array();
					$this->priority = $priority;
					if ( file_exists( $this->log_file ) ){
						if ( !is_writable($this->log_file) )
						{
							$this->Log_Status = KLogger::OPEN_FAILED;
							$this->MessageQueue[] = "<!--The log file exists, but could not be opened for writing. Check that appropriate permissions have been set.-->";
							print_r($this->MessageQueue);
							return;
						}
					} else {
						# Попытка создать новый файл
						$this->file_creation = fopen($this->log_file, "w");
						fclose($this->file_creation);
						if(!$this->file_creation){
							$this->MessageQueue[] = $this->log_file." Log file does not exist. Please, create it manually-->";
							print_r($this->MessageQueue);
						} else $first_start_flag=1; // Флаг о том, что файл создан заново
					}
					
					if ( $this->file_handle[$this->log_file] = fopen( $this->log_file , "a" ) ){
						$this->Log_Status = KLogger::LOG_OPEN;
						//$this->filePriority[$this->log_file]=
						$this->MessageQueue[] = $this->log_file." The log file was opened successfully.";
						if($first_start_flag==1) {
							$this->WriteFreeFormLine ('[LEVEL] TIMESTAMP | DOMAIN | USER IP | USER ROLE | SCRIPT | ROW | MEMORY USAGE | MESSAGE'."\n");
							unset($first_start_flag);// уничтожаем временный флаг
						}
						
					}
					else{
						$this->Log_Status = KLogger::OPEN_FAILED;
						$this->MessageQueue[] = '<!--'.$this->log_file." The log file could not be opened. Check permissions.-->";
						print_r($this->MessageQueue);
					}
				}
			}
		}
		return;
		
	}
	
	public function __destruct()
	{		
			
		if( $this->file_handle){
			foreach( $this->file_handle as $file_path=>$file_h){
				if ( $file_h ) fclose($file_h );
			}
		}
		closelog(); // Для Syslog
	}
	
	public function LogDebug($line)
	{
		$this->Log( $line , KLogger::DEBUG );
	}
	
	public function LogInfo($line)
	{
		$this->Log( $line , KLogger::INFO );
	}
	
	public function LogWarn($line)
	{
		$this->Log( $line , KLogger::WARN );	
	}
	
	public function LogError($line)
	{
		$this->Log( $line , KLogger::ERROR );		
	}

	public function LogFatal($line)
	{
		$this->Log( $line , KLogger::FATAL );
	}
	
	public function Log($line, $priority)
	{

# Запись в лог
		global $writelogto, $login;
		if (!$login){$login="guest";}
		

		switch( $priority )
			{
				case KLogger::DEBUG: $loglevtext="DEBUG"; break;
				case KLogger::INFO:	$loglevtext="INFO "; break;
				case KLogger::WARN:	$loglevtext="WARN "; break;
				case KLogger::ERROR: $loglevtext="ERROR"; break;
				case KLogger::FATAL: $loglevtext="FATAL"; break;
				default: $loglevtext="LOG   "; break;
			}
		
		$trace = debug_backtrace(); # Данные о вызвавшем скипте
		
		if($writelogto=="Собственный лог" or $writelogto=="Собственный и SYSLOG" ){
			$timest = $this->getTimeLine($priority);
			
			$this->WriteFreeFormLine ( '['.$loglevtext.'] '.$timest.' | '.$this->sitedomain.' | '.$this->cust_ip.' | '.$login.' | '.substr($trace[1]['file'],$this->fullpath_len).' | '.$trace[1]['line'].' | '.(memory_get_usage()-$this->memory_base).' | '.$line."\n", $priority );
		} 
		if($writelogto=="SYSLOG" or $writelogto=="Собственный и SYSLOG" ){
			syslog(LOG_DEBUG,"$sitedomain | $this->cust_ip | $login | ".substr($trace[1]['file'],$this->fullpath_len)." | ".$trace[1]['line']." | $line");
		}
	}
	
	
	
	public function WriteFreeFormLine( $line , $priority)
	{
		
		if ( $this->Log_Status == KLogger::LOG_OPEN && $this->priority != KLogger::OFF)
		{ #Записываем во все файлы логов
			foreach( $this->file_handle as $file_path=>$file_h){
				if( $priority >= $this->filePriority[ $file_path]) fwrite( $file_h , $line) ;
			}
		}
	}
	
	private function getTimeLine()
	{		
		$mtime = microtime(true);
		$time1 = floor($mtime);
		$ms = $mtime - $time1;
		$time = date( $this->DateFormat ).":".substr($ms,2,4);
		return $time;
	}

}

class emptyLogger { # Заглушка, если логи выключены
		
	public function LogDebug($line)
	{
		return TRUE;
	}
	
	public function LogInfo($line)
	{
		return TRUE;
	}
	
	public function LogWarn($line)
	{
		return TRUE;
	}
	
	public function LogError($line)
	{
		return TRUE;
	}

	public function LogFatal($line)
	{
		return TRUE;
	}
}
?>
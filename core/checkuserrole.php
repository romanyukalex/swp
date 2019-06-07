<?  # Аутентификация и авторизация пользователей услуги (абонентов)
$log->LogInfo('Got this file');
//Определяем тип запроса
if (isset($_REQUEST['login'])){// пришли данные для логина
	$log->LogInfo('Users data received');
	@include_once($_SERVER['DOCUMENT_ROOT'].'/core/functions/process_user_data.php');
	$userrole='guest';					
	$login=process_data($_REQUEST['login'],40);
	$password=process_data($_REQUEST['password'],40);
	$Family= process_data($_REQUEST['Family'],1);
	if ($login or $password)
		{//Что то пришло
		#Проверка полученного:
		/// Все ли данные передались/передали?
		$showmessage='';$err=0;
		if (empty($login) or empty($password)) {/*Если чтото из них пустое - не все поля заполнил юзер */
			$log->LogInfo('Empty login or password');
			$err=1;
			$showmessage=$sitemessage['system']['fill_all_fields'];
		}
		if($_SESSION['blocked_login'] and $passinptrydelay>(time()-$_SESSION['blocked_login'])) { #Оба есть, проверяем блокированных пользователей
			# Проверяем время, может пора пустить
			$err=1;
			$log->LogInfo('Attempt to logon was blocked because too small time period');
			$showmessage=$sitemessage['system']['Logon blocked.Small period'].'. Подождите '.(ceil(($passinptrydelay-(time()-$_SESSION['blocked_login']))/60)).' мин';
		}	
		if ($loginisonlydigits=='Только цифры' and !preg_match('/^([0-9])+$/',$login)){# Введен логин, состоящий не только из цифр
			$log->LogInfo('Login content not only digits');
			//$err=2;
			$showmessage=$sitemessage['system']['Login_is_only_digits'];
			$err=1;
		}
		if (!preg_match('/^([A-Za-z0-9])+$/',$password)){//Содержит плохие знаки
			$log->LogInfo('Password match bad chars');
			$err=1;
			$showmessage=$sitemessage['system']['Pass_is_digits_or_letters'];
			//$err=3;
		}
		if($Family!=='') {//Это ловушка для роботов.Робот бы заполнил
			$log->LogWarn('Robot login attempt detected');
			//$err=6;
			$showmessage=$sitemessage['system']['Session_parameters_is_wrong(1)'];
			$err=1;
		}
		if($err!==0){
			$log->LogWarn('User login failed');
			$userrole='guest';
			$messagecolor='red';
		} else {
			#Проверка формата пройдена успешно,поиск юзера
			$log->LogInfo('Login parameters checked succeed.');
			$showmessage='';
			if($login_method=='Скрипт'){# Особая аутентификация проекта
				$log->LogDebug('Trying to login via login_script.php');
				include($_SERVER['DOCUMENT_ROOT'].'/project/'.$projectname.'/scripts/login_script.php');
				
			} elseif($login_method=='LDAP'){# Доделать
			} else{ #$login_method=='Локальная';
				include_once($_SERVER['DOCUMENT_ROOT'].'/core/db/dbconn.php');
				include_once($_SERVER['DOCUMENT_ROOT'].'/core/system-param.php');
				if($authlogin=='only_login'){
					$log->LogInfo('Login by username.');
					$loginphrase="`login`='$login'";
				}
				elseif($authlogin=='only_email'){
					$log->LogInfo('Login by email.');
					$loginphrase="`contactmail`='$login'";
				}
				elseif($authlogin=='both'){
					$log->LogInfo('Login by username or email (both).');
					$loginphrase="(`login`='$login' or `contactmail`='$login')";
				}
				# Ищем пользователя в БД
				$rand=rand(0,2323232323);
				$userquery_qt="SELECT * FROM `$tableprefix-users` WHERE $loginphrase and `password`='$password' -- ".$rand.";";
				$userquery_q=mysql_query($userquery_qt);
				$log->LogDebug("Try to find user with '".$userquery_qt."'");
				if(mysql_num_rows($userquery_q) > 1){
					$log->LogError('Few user was found - '.$loginphrase);
				}
				elseif(mysql_num_rows($userquery_q) == 1){# Однозначно аутентифицировали
					$userquery=mysql_fetch_assoc($userquery_q);
					$_SESSION['user_data']=$userquery; // Все данные о юзере в одном сессионном массиве
					$userrole=$_SESSION['userrole']=$userquery['userrole'];
					$userid=$_SESSION['userid']=$userquery['userid'];
					$log->LogInfo('Authentication successful with userrole '.$userrole);
					
						
					if($_SESSION['blocked_login']){ # Сбрасываем ограничение на вход и счетчик попыток
						unset ($_SESSION['blocked_login']);
						mysql_query("UPDATE `$tableprefix-users` SET `passw_inp_count` = '0' WHERE `userid` = '$userid';");
					}
					
					$_SESSION['login']=$login;
					$_SESSION['password']=$password;
					$nickname=$_SESSION['nickname']=$userquery['nickname'];
					$fullname=$_SESSION['fullname']=$userquery['fullname'];
					$gender=$_SESSION['gender']=$userquery['gender'];
					$changepassmust=$_SESSION['changepassmust']=$userquery['changepassmust'];
					if($userquery['avatar']) $user_avatar=$_SESSION['avatar']=$userquery['avatar'];
					if($userquery['status']=='active'){
						$showmessage='Добро пожаловать,';
						if($nickname){$showmessage.=$nickname;}
						elseif($fullname){$showmessage.=$fullname;}
						else $showmessage.=$userlist['second_name'].' '.$userlist['first_name'];
						$messagecolor='green';
						if($userquery['changepassmust']!=='2' and $mandatorychpassperiod){# Проверяем, не протух ли пароль
							$passw_last_change_date_ts = strtotime($userquery['passw_last_change_date']);
							$now = time();
							$passw_chngd_days_ago = floor(($now - $passw_last_change_date_ts) / (60*60*24));
							if($mandatorychpassperiod<$passw_chngd_days_ago){
								$changepassmust=$_SESSION['changepassmust']='yes';
								$showmessage.='<br>'.$sitemessage['system']['Should_change_pass'];
								$log->LogDebug('User should change password');
							}
						}
						if($userquery['changepassmust']=='2'){// Юзер должен поменять пароль
							$changepassmust=$_SESSION['changepassmust']='yes';
							$showmessage.='<br>'.$sitemessage['system']['Should_change_pass'];
							$log->LogDebug('User should change password');		
						}
						
						$_SESSION['log']='1'; // Признак залогиненности
							
						# Получаем все rights юзера по userid
						$userrightsreq=mysql_query("SELECT DISTINCT * FROM `$tableprefix-users` u,
						`$tableprefix-users-groupmembers` gm,`$tableprefix-users-grouprights` gr
						WHERE u.`userid`=gm.`userid` and	gr.`group_id`=gm.`group_id` and	u.`userid`='$userid'");
						$log->LogDebug('Rights for user - '.mysql_num_rows($userrightsreq).' items');
						# Данные о компании пользователя
						if($userquery['company_id']){$_SESSION['company_id']=$userquery['company_id'];$company_id=$userquery['company_id'];
							//$companyinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-companies` WHERE `company_id`='$company_id' limit 0,1;"));
							$companyinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$companiesprefix-companies` WHERE `company_id`='$company_id' limit 0,1;"));
						}
					} else{ #Пользователь заблокирован (не активен)
						$messagecolor='red';
						$showmessage.=$sitemessage['system']['User_is_not_active'];
						$log->LogInfo('User is in '.$userquery['status'].' status');
						$userrole='guest';
					}
				} else {//Нет такого юзера и/или пароля
					$log->LogInfo('Auth not successful');
					//Выясняем подробнее
					$userquery2=mysql_fetch_array(mysql_query("SELECT * FROM `$tableprefix-users` WHERE $loginphrase limit 0,1;"));
					if($userquery2['userid']){# Пользователь с таким именем существует, значит неверен только пароль
						$log->LogDebug('User exists, pass is wrong');
						$inp_pass_err_report=mysql_query("UPDATE `$tableprefix-users` SET `passw_inp_count` = `passw_inp_count` + 1,`passw_inp_last_try`= CURRENT_TIMESTAMP() WHERE `userid`='$userquery2[userid]';");
						if($passinptrymaxcount<=$userquery2['passw_inp_count']){# Преышен максимальный порог количества попыток ввести пароль. Блокируем пользователя на запросы пароля
							$_SESSION['blocked_login']=time();
							$log->LogDebug('Block login (max count of trying to login)');
						}
					}
					// Что показываем пользователю?
					if($showpasserror=='Пароль'){//Выясняем подробнее
						if($userquery2['userid']){ # Пользователь с таким именем существует, значит неверен только пароль
							$showmessage=$sitemessage['system']['Pass_is_wrong'];
						} else { # Нет такого пользователя
							$showmessage=$sitemessage['system']['Login_is_wrong'];
						}
					} else $showmessage=$sitemessage['system']['LoginPass_is_wrong'];
					$messagecolor='red';
					$userrole='guest';
					$log->LogDebug('Show message to user: '.$showmessage);
				}
			}
		}
	}
} elseif($_SESSION['log']=='1'){#В сессионных куках юзера есть данные о юзернейме
	
	$login=$_SESSION['login'];
	$userrole=$_SESSION['userrole'];
	$userid=$_SESSION['userid'];
	$password=$_SESSION['password'];
	$nickname=$_SESSION['nickname'];
	$fullname=$_SESSION['fullname'];
	if($_SESSION['avatar']) $user_avatar=$_SESSION['avatar'];
	$log->LogDebug('User already logged in - userrole='.$userrole.' userid='.$userid.' login='.$login.' avatar ='.$user_avatar.$_SESSION['avatar']);
	if(isset($_SESSION['gender'])) $gender=$_SESSION['gender'];
	$changepassmust=$_SESSION['changepassmust'];
	# Получаем все rights юзера по userid
	$userrightsreq=mysql_query("SELECT DISTINCT * FROM 
	`$tableprefix-users` u,	`$tableprefix-users-groupmembers` gm,`$tableprefix-users-grouprights` gr
	WHERE
	u.`userid`=gm.`userid` and	gr.`group_id`=gm.`group_id` and	u.`userid`='$userid'");
	$log->LogDebug('Rights for user - '.mysql_num_rows($userrightsreq).' items');
	if(isset($_SESSION['company_id'])){
		$company_id=$_SESSION['company_id'];
		$companyinfo=mysql_fetch_array(mysql_query("SELECT * FROM `$companiesprefix-companies` WHERE `company_id`='$company_id' limit 0,1;"));
	}
	
	#Если зашли каким то модулем и в сессии нет данных о пользователей
	if(!$_SESSION['user_data']){
		$userquery_qt="SELECT * FROM `$tableprefix-users` WHERE `userid`='$userid' -- ".$rand.";";
		$userquery_q=mysql_query($userquery_qt);
		$userquery=mysql_fetch_assoc ($userquery_q);
		$_SESSION['user_data']=$userquery; // Все данные о юзере в одном сессионном массиве
	}
} else {$log->LogDebug('Not found REQUEST or SESSION data');
	$userrole='guest';
}
$log->LogDebug('Userrole is '.$userrole);
?>
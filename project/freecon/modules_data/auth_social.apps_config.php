<? # Конфигурационный файл проекта с данными приложений соц сетей, через которые будет логиниться пользователь в этом конкретном проекте

# Put this applications config to /project/$projectname/modules_data/$modulename.apps_config.php



	/*
	VK
	https://vk.com/editapp?act=create
	В открывшейся форме введите название приложения; выберите тип “Веб-сайт”; В качестве адреса сайта введите путь к папке с проектом на вашем локальном сервере. В моём случае, это http://localhost/vk-auth. Базовый домен: localhost.
	После нажатия на кнопку “Подключить сайт”, вам наверняка придётся ввести проверочный код, который придёт по смс. Если вы пройдёте проверку, то вам должна открыться следующая форма с настройками приложения
	Из данной формы нам понадобятся такие данные, как `ID приложения`, `Защищённый ключ`, `Адрес сайта`.
	
	FACEBOOK
	https://developers.facebook.com/apps
	
	*/
$adapterConfigs = array(
	'vk' => array(
		'client_id'     => '6219018',
		'client_secret' => '3aaSAL2Pe0phjYN3auKW',
		'redirect_uri'  => $redirect_url.'provider=vk]'
	),
	'mailru' => array(
		'client_id'     => '764312',
		'client_secret' => 'a2c6abeacbf49f86a07e045ec33f0576',
		'redirect_uri'  => $redirect_url.'provider=mailru]'
	),
	/*
	'yandex' => array(
		'client_id'     => 'ec889e48dd88442aacd1d41c1cf6fc9c',
		'client_secret' => '5042d900b76b4cbf99aebd8f928472a6',
		'redirect_uri'  => $redirect_url.'provider=yandex]'
	),*/
		
);
/*
$adapterConfigs["facebook"]=array(
	'client_id'     => '300626623690724',
	'client_secret' => 'fa672b9d57009be894b443a7609beb96',
	'redirect_uri'  => $redirect_url.'provider=facebook]'
);

*/




	
/*	$adapterConfigs = array(
		'vk' => array(
			'client_id'     => '5956312',
			'client_secret' => 'POqYwW7euUohchd8soUs',
			'redirect_uri'  => $redirect_url.'|provider=vk]'
		),
	/*	'odnoklassniki' => array(
			'client_id'     => '',
			'client_secret' => '',
			'redirect_uri'  => 'http://localhost/auth?provider=odnoklassniki',
			'public_key'    => 'CBADCBMKABABABABA'
		),
		'mailru' => array(
			'client_id'     => '',
			'client_secret' => '',
			'redirect_uri'  => 'http://localhost/auth/?provider=mailru'
		),
		'yandex' => array(
			'client_id'     => '',
			'client_secret' => '',
			'redirect_uri'  => 'http://localhost/auth/?provider=yandex'
		),
		'google' => array(
			'client_id'     => '',
			'client_secret' => '',
			'redirect_uri'  => 'http://localhost/auth?provider=google'
		),
		'facebook' => array(
			'client_id'     => '300626623690724',
			'client_secret' => 'fa672b9d57009be894b443a7609beb96',
			'redirect_uri'  => $redirect_url.'|provider=facebook]'
		)
	);*/
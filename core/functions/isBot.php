<? # Проверка UserAgent - бот?
	
function isBot(&$bot_name = ''){
/* Эта функция будет проверять, является ли посетитель роботом поисковой системы */
  $bots = array(
       'Googlebot', 
        'Baiduspider', 
        'ia_archiver',
        'R6_FeedFetcher', 
        'NetcraftSurveyAgent', 
        'Sogou web spider',
        'bingbot', 
        'Yahoo! Slurp', 
        'facebookexternalhit', 
        'PrintfulBot',
        'msnbot', 
        'Twitterbot', 
        'UnwindFetchor', 
        'urlresolver', 
        'Butterfly', 
        'TweetmemeBot',
        'PaperLiBot',
        'MJ12bot',
        'AhrefsBot',
        'Exabot',
        'Ezooms',
        'YandexBot',
        'SearchmetricsBot',
        'picsearch',
        'TweetedTimes Bot',
        'QuerySeekerSpider',
        'ShowyouBot',
        'woriobot',
        'merlinkbot',
        'BazQuxBot',
        'Kraken',
        'SISTRIX Crawler',
        'R6_CommentReader',
        'magpie-crawler',
        'GrapeshotCrawler',
        'PercolateCrawler',
        'MaxPointCrawler',
        'R6_FeedFetcher',
        'NetSeer crawler',
        'grokkit-crawler',
        'SMXCrawler',
        'PulseCrawler',
        'Y!J-BRW',
        '80legs.com/webcrawler',
        'Mediapartners-Google', 
		'Spinn3r'
		, 'InAGist'
        , 'Python-urllib'
        , 'NING'
        , 'TencentTraveler'
        , 'Feedfetcher-Google'
        , 'mon.itor.us'
        , 'spbot'
        , 'Feedly'
        , 'bitlybot'
        , 'ADmantX Platform'
        , 'Niki-Bot'
        , 'Pinterest'
        , 'python-requests'
        , 'DotBot'        
        , 'HTTP_Request2'
        , 'linkdexbot'
        , 'A6-Indexer'   
        , 'Baiduspider'
        , 'TwitterFeed'
        , 'Microsoft Office'
        , 'Pingdom'
        , 'BTWebClient'
        , 'KatBot'
        , 'SiteCheck'
        , 'proximic'
        , 'Sleuth'
        , 'Abonti'
        , '(BOT for JCE)'
        , 'Baidu'
        , 'Tiny Tiny RSS'
        , 'newsblur'
        , 'updown_tester'
        , 'linkdex'
        , 'baidu'
        , 'searchmetrics'
        , 'genieo'
        , 'majestic12'
        , 'spinn3r'
        , 'profound'
        , 'domainappender'
        , 'VegeBot'
        , 'terrykyleseoagency.com'
        , 'CommonCrawler Node'
        , 'AdlesseBot'
        , 'metauri.com'
        , 'libwww-perl'
        , 'rogerbot-crawler'
        , 'MegaIndex.ru'
		, 'ltx71'
		, 'Qwantify'
		, 'Traackr.com'
		, 'Re-Animator Bot'
        , 'Pcore-HTTP'
        , 'BoardReader'
        , 'omgili'
        , 'okhttp'
		, 'SemrushBot'

  );
  foreach($bots as $bot)
    if(stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false){
      $bot_name = $bot;
      return true;
    }
  return false;
}
?>

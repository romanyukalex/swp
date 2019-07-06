var fs = require('fs');
var page = require('webpage').create();
var url = 'https://rusagro.ts-cloud.ru/login.do';

// Открываем страницу
page.open(url, function (status) {
  if (status === 'success') {
    console.log('Страница загружена');

    // Подключаем jQuery
    page.injectJs('../../../js/lib/jquery/jquery.min.js');

      // Получаем нужный контент
    html = page.evaluate(function() {
        titles = '';
        $('.post_title').each(function(){
          titles += $(this).html() + '\n';
        });
        return titles;
    });

    // Пишем в файл
    var file = fs.open('articles.txt', "w+");
    file.write(html + '\n');
    file.close();
    phantom.exit();
  }
});
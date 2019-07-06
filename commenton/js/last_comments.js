var lostComments = function (elem, limit, type) {
    var xhr = new XMLHttpRequest();
    var body = 'type=' + type + '&limit_comments=' + limit + '&action=last_comment';
    xhr.open('POST', '/commenton/components/ajax.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(body);
    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) return;
        if (xhr.status === 200) {
            elem.innerHTML = xhr.responseText;
        }
    }
};

var cnElem = document.querySelectorAll('.commentonLast');
var cnLimit = cnElem[0].getAttribute('data-cn-limit');
var cnType = cnElem[0].getAttribute('data-cn-type') || 'all';
lostComments(cnElem[0], cnLimit, cnType);
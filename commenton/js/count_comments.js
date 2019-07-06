var countComments = function (cnElems, url) {
    var xhr = new XMLHttpRequest();
    var body = 'url=' + url + '&action=count_comment';
    xhr.open('POST', '/commenton/components/ajax.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(body);
    xhr.onreadystatechange = function () {
        if (xhr.readyState !== 4) return;
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            cnElems.innerText = xhr.responseText;
        }
    }
};

//window.onload = function () {
var cnElems = document.querySelectorAll('.commentonCount');
for (var i = 0; i < cnElems.length; i++) {
    var cnUrl = cnElems[i].getAttribute('data-cn-url');
    countComments(cnElems[i], cnUrl);
}
//};
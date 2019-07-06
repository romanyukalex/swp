<? #Функция проверки доступности видеозаписей (есть аналог получше в module
function youTubeVideoExists($videoID) {
    $theURL = "http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=".$videoID."&format=json";
    $headers = get_headers($theURL);

    if (substr($headers[0], 9, 3) !== "404") {
        return true;
    } else {
        return false;
    }
}

/*
Example Usage:
$id = 'Ifb5fR5WMuE'; //Video id goes here

if (yt_exists($id)) {
    echo 'yes!';
    //  Yep, video is still up and running :)
} else {
    echo 'damn';
    //  These aren't the droids you're looking for :(
}
*/

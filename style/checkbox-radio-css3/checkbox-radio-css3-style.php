<? # Стильные radio and checkbox
/* <div class="checkbox-radio-css3-show">
            <h1>Стилизация элементов checkbox и radio button на CSS3</h1>
            <input type="checkbox" id="c1" name="cc" />
            <label for="c1"><span></span>Check Box 1</label>
            <p>
            <input type="checkbox" id="c2" name="cc" />
            <label for="c2"><span></span>Check Box 2</label>
            <p><br/>
            <input type="radio" id="r1" name="rr" />
            <label for="r1"><span></span>Radio Button 1</label>
            <p>
            <input type="radio" id="r2" name="rr" />
            <label for="r2"><span></span>Radio Button 2</label>
        </div>
*/
?>
div.checkbox-radio-css3-show {
    //width:280px;
    //height:200px;
    padding:20px;
    position: relative;
    top: 35%;
    margin:0 auto;
    //background:#40464b;
    background:#777777;
    border-radius:6px;
}

div.checkbox-radio-css3-show h1 {
    font-size:16px;
    color:#f2f2f2;
    text-align:center;
    margin:0 0 20px;
    padding:0;
    font-family:Arial;
}

div.checkbox-radio-css3-show input[type="checkbox"] {
    display:none;
}

div.checkbox-radio-css3-show input[type="checkbox"] + label {
    color:#f2f2f2;
    font-family:Arial, sans-serif;
    font-size:14px;
}

div.checkbox-radio-css3-show input[type="checkbox"] + label span {
    display:inline-block;
    width:19px;
    height:19px;
    margin:-1px 4px 0 0;
    vertical-align:middle;
    background:url(/style/checkbox-radio-css3/check_radio_sheet.png) left top no-repeat;
    cursor:pointer;
}

div.checkbox-radio-css3-show input[type="checkbox"]:checked + label span {
    background:url(/style/checkbox-radio-css3/check_radio_sheet.png) -19px top no-repeat;
}

div.checkbox-radio-css3-show input[type="radio"] {
    display:none;
}

div.checkbox-radio-css3-show input[type="radio"] + label {
    color:#f2f2f2;
    font-family:Arial, sans-serif;
    font-size:14px;
}

div.checkbox-radio-css3-show input[type="radio"] + label span {
    display:inline-block;
    width:19px;
    height:19px;
    margin:-1px 4px 0 0;
    vertical-align:middle;
    background:url(/style/checkbox-radio-css3/check_radio_sheet.png) -38px top no-repeat;
    cursor:pointer;
}

div.checkbox-radio-css3-show input[type="radio"]:checked + label span {
    background:url(/style/checkbox-radio-css3/check_radio_sheet.png) -57px top no-repeat;
}
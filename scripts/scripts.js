function CheckValid(id, listid) {
    var x = document.getElementById(id).value;
    var y = document.getElementById(listid).options;
    var change = document.getElementById(id);
    var submit = document.getElementById("submit");
    var valid = false;
    for (var i = 0; i < y.length; i++) {
        if (y[i].value == x) {
            valid = true;
            break;
        }
    }
    if (valid == false) {
        change.style.borderColor = "red";
        submit.disabled = true;
    } else {
        change.style.borderColor = "transparent";
        submit.disabled = false;
    }
}
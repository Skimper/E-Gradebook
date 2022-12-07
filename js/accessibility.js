function accessibilityContrast(isOn) {
    switch (isOn){
        case true:
            document.body.style.color = "yellow";
            document.body.style.background = "black";
            document.getElementById("normal").style.color = "white";
            document.getElementsByTagName("h1")[0].style.color = "#ffffaa";
            let navlist = document.querySelectorAll('nav a');
                navlist.forEach(el => el.style.color = "#ffffaa");
            break;
        case false:
            return;
    }
}

function accessibilityFont(isOn) {
    switch (isOn){
        case true:
            document.body.style.fontSize = "yellow";
            document.getElementById("normal").style.color = "white";
            let navlist = document.querySelectorAll('nav a');
                navlist.forEach(el => el.style.fontSize = "");
            break;
        case false:
            return;
    }
}
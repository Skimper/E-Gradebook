function accessibilityContrast(contrast) {
    switch (contrast){
        case 1:
            document.body.style.color = "yellow";
            document.body.style.background = "black";
            
            let h1list = document.querySelectorAll('h1');
                h1list.forEach(el => el.style.color = "#ffffaa");
            let navlist = document.querySelectorAll('nav a');
                navlist.forEach(el => el.style.color = "#ffffaa");
            break;
        case false:
            return;
    }
}

function accessibilityFont(font) {
    console.log(font);
    switch (font){
        case 1:
            document.body.style.setProperty("font-size", "110%", "important");
            let navlist = document.querySelectorAll('nav a');
                navlist.forEach(el => el.style.fontSize = "110%");
                console.log('???');
            break;
        case 2:
            document.body.style.setProperty("font-size", "120%", "important");
            let navlist2 = document.querySelectorAll('nav a');
                navlist2.forEach(el => el.style.fontSize = "120%");
            break;
        case false:
            return;
    }
}
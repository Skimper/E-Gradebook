function accessibilityContrast(contrast) {
    switch (contrast){
        case 1:
            document.body.style.color = "yellow";
            document.body.style.background = "black";
            
            let root = document.querySelector(':root');
                root.style.setProperty('--color10', 'yellow');
                root.style.setProperty('--color11', 'yellow');
                root.style.setProperty('--color12', 'yellow');
                root.style.setProperty('--color13', 'yellow');
            break;
        case 0:
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
            break;
        case 2:
            document.body.style.setProperty("font-size", "120%", "important");
            let navlist2 = document.querySelectorAll('nav a');
                navlist2.forEach(el => el.style.fontSize = "120%");
            break;
        case 0:
            return;
    }
}
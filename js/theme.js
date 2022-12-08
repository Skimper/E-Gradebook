function setTheme(theme) {
    const root = document.querySelector(':root');

    switch(theme){
        case 1:
            root.style.setProperty('--color4', '#000428');
            root.style.setProperty('--color5', '#002252');
            root.style.setProperty('--color6', '#003068');
            root.style.setProperty('--color7', '#003F7D');
            root.style.setProperty('--color8', '#004e92');
            break;
        case 2:
            root.style.setProperty('--color4', '#B6FBFF');
            root.style.setProperty('--color5', '#ACEAF6');
            root.style.setProperty('--color6', '#A2D8EE');
            root.style.setProperty('--color7', '#97C7E5');
            root.style.setProperty('--color8', '#83A4D4');

            root.style.setProperty('--color13', '#131313', 'important');
            break;
    }

    console.log("Loaded theme " + theme);
}

function setColor(color) {
    const root = document.querySelector(':root');

    switch(color){
        case 1:
            root.style.setProperty('--color0', '#d4d4d4');
            root.style.setProperty('--color1', '#eeeeee');
            root.style.setProperty('--color2', 'rgba(17, 17, 17, 0.7)');
            root.style.setProperty('--color3', 'rgba(17, 17, 17, 0.3)');
            root.style.setProperty('--color9', '#b3b3b3');
            root.style.setProperty('--color10', '#686868');
            root.style.setProperty('--color11', '#181818');
            root.style.setProperty('--color12', '#dbdbdb');
            console.log("Loaded colors " + color);
            break;
    }
    
}
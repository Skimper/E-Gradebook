function setTheme(theme) {
    const root = document.querySelector(':root');

    switch(theme){
        case "1":
            root.style.setProperty('--bg1', '#130f14');
            root.style.setProperty('--bg2', '#130f14');
            root.style.setProperty('--color1', '#000428');
            break;
    }

    console.log("Loaded theme " + theme);
}
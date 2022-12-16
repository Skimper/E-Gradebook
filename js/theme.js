function setTheme(number) {
    const root = document.querySelector(':root');

    const theme = {
        1: {
            1: '#000428', 
            2: '#002252',
            3: '#003068',
            4: '#003F7D',
            5: '#004e92',
            6: '#f5f5f5'
        },
        2: {
            1: '#B6FBFF', 
            2: '#ACEAF6', 
            3: '#A2D8EE', 
            4: '#97C7E5', 
            5: '#83A4D4', 
            6: '#131313'
        },
        3: {
            1: '#29323C', 
            2: '#2F3944', 
            3: '#35404C', 
            4: '#3C4753', 
            5: '#485563', 
            6: '#f5f5f5'
        },
        4: {
            1: '#FF6B6B', 
            2: '#DD696C', 
            3: '#BB676D', 
            4: '#99666E', 
            5: '#485563', 
            6: '#f5f5f5'
        },
        5: {
            1: '#6E48AA', 
            2: '#774AAD', 
            3: '#814BB1', 
            4: '#8A4DB4', 
            5: '#485563', 
            6: '#f5f5f5'
        },
        6: {
            1: '#12FFF7', 
            2: '#32FFE8', 
            3: '#52FFD9', 
            4: '#73FFC9', 
            5: '#B3FFAB', 
            6: '#131313'
        },
        7: {
            1: '#B31217', 
            2: '#BD171A', 
            3: '#C71D1D', 
            4: '#D12221', 
            5: '#E52D27', 
            6: '#131313'
        },
        8: {
            1: '#4B1248', 
            2: '#6C3552', 
            3: '#8D585C', 
            4: '#AE7C67', 
            5: '#F0C27B', 
            6: '#f5f5f5'
        },
        9: {
            1: '#F9D423', 
            2: '#FAB92C', 
            3: '#FB9E35', 
            4: '#FD843E', 
            5: '#FF4E50', 
            6: '#131313'
        },
        10: {
            1: '#7B920A', 
            2: '#859F08', 
            3: '#8FAB06', 
            4: '#99B804', 
            5: '#ADD100', 
            6: '#131313'
        },
        11: {
            1: '#BB377D', 
            2: '#C85693', 
            3: '#D575A8', 
            4: '#E195BE', 
            5: '#FBD3E9', 
            6: '#131313'
        },
        12: {
            1: '#3F4C6B', 
            2: '#465271', 
            3: '#4C5977', 
            4: '#535F7C', 
            5: '#606C88', 
            6: '#f5f5f5'
        },
        13: {
            1: '#3A7BD5', 
            2: '#2E8CDD', 
            3: '#239EE6', 
            4: '#17AFEE', 
            5: '#00D2FF', 
            6: '#f5f5f5'
        },
        14: {
            1: '#73C8A9', 
            2: '#67AC95', 
            3: '#5B9081', 
            4: '#4F736C', 
            5: '#373B44', 
            6: '#f5f5f5'
        },
    }
    root.style.setProperty('--color4', theme[number][1]);
    root.style.setProperty('--color5', theme[number][2]);
    root.style.setProperty('--color6', theme[number][3]);
    root.style.setProperty('--color7', theme[number][4]);
    root.style.setProperty('--color8', theme[number][5]);

    root.style.setProperty('--color13', theme[number][6], 'important');

    console.log("Loaded theme " + theme[number]);
}

function setColor(color) {
    const root = document.querySelector(':root');
    
    const colors = {
        1: {
            1: '#d4d4d4',
            2: '#eeeeee',
            3: 'rgba(238, 238, 238, 0.7)',
            4: 'rgba(238, 238, 238, 0.3)',
            9: '#b3b3b3',
            10: '#686868',
            11: '#181818',
            12: '#111111'
        },
        2: {

        }
    }
    switch(color){
        case 1:
            root.style.setProperty('--color0', '#d4d4d4');
            root.style.setProperty('--color1', '#eeeeee');
            root.style.setProperty('--color2', 'rgba(238, 238, 238, 0.7)');
            root.style.setProperty('--color3', 'rgba(238, 238, 238, 0.3)');
            root.style.setProperty('--color9', '#b3b3b3');
            root.style.setProperty('--color10', '#686868');
            root.style.setProperty('--color11', '#181818');
            root.style.setProperty('--color12', '#111111');
            console.log("Loaded colors " + color);
        break;
        case 2:
            root.style.setProperty('--color0', '#353535');
            root.style.setProperty('--color1', '#3c3c3c');
            root.style.setProperty('--color2', 'rgba(60, 60, 60, 0.7)');
            root.style.setProperty('--color3', 'rgba(60, 60, 60, 0.3)');
            root.style.setProperty('--color9', '#434343');
            root.style.setProperty('--color10', '#8B8B8B');
            root.style.setProperty('--color11', '#f5f5f5');
            root.style.setProperty('--color12', '#f5f5f5');
            console.log("Loaded colors " + color);
    }  
}
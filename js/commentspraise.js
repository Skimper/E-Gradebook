function changeComment(x){
    if(x == 'c') {
        document.getElementById("comments").style.display = 'table';
        document.getElementById("praise").style.display = 'none';
        document.getElementById("coments_title").innerHTML = 'Uwagi';
    } else if (x == 'p') {
        document.getElementById("praise").style.display = 'table';
        document.getElementById("comments").style.display = 'none';
        document.getElementById("coments_title").innerHTML = 'Osiągnięcia';
    }
}
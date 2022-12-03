function showGradeInfo(psubject, ptitle, pdescription, pdate, pfrom){
    if(document.getElementById("examinfo").style.display == 'none'){
        document.getElementById("examinfo").style.display = 'block';

        document.getElementById("subject").innerHTML = psubject;
        document.getElementById("title").innerHTML = "<b>Tytuł: </b>" + ptitle;
        document.getElementById("description").innerHTML = "<b>Opis: </b>" + pdescription;
        document.getElementById("date").innerHTML = "<b>Data: </b>" + pdate;
        document.getElementById("from").innerHTML = "<b>Zapowiedziano: </b>" + pfrom;
    } else {
        document.getElementById("subject").innerHTML = psubject;
        document.getElementById("title").innerHTML = "<b>Tytuł: </b>" + ptitle;
        document.getElementById("description").innerHTML = "<b>Opis: </b>" + pdescription;
        document.getElementById("date").innerHTML = "<b>Data: </b>" + pdate;
        document.getElementById("from").innerHTML = "<b>Zapowiedziano: </b>" + pfrom;
    }
    
}
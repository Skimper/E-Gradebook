function showMeetInfo(psubject, ptitle, pdate){
    document.getElementById("meetinfo").style.display = "block";

    document.getElementById("subject").innerHTML = psubject;
    document.getElementById("title").innerHTML = ptitle;
    document.getElementById("date").innerHTML = pdate;
}
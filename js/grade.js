var allgrades = document.getElementsByClassName('grade_info');
function GradeInfo(e){
    console.log(e.childNodes[1]);
    if (e.childNodes[1].style.display == 'block') {
        e.childNodes[1].style.display = 'none';
    } else {
        e.childNodes[1].style.display = 'block';
    }
}
function HideGrade(e){
    e.childNodes[1].style.display = 'none';
}
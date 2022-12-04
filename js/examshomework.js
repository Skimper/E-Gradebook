function changeExams(x) {
    if(x == 'h') {
        document.getElementById("exams").style.display = 'none';
        document.getElementById("homework").style.display = 'table';

        document.getElementById('grades_title').innerHTML = 'Zadania';

        document.getElementById("examinfo").style.display = 'none';
    } else if (x == 'e') {
        document.getElementById("homework").style.display = 'none';
        document.getElementById("exams").style.display = 'table';

        document.getElementById('grades_title').innerHTML = 'Sprawdziany';

        document.getElementById("examinfo").style.display = 'none';
    }
}
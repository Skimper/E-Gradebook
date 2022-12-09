function editStudentsProfile(){
    if (document.getElementById("edit_profile").style.display == 'none'){

        document.getElementById("profile").style.display = 'none';
        document.getElementById("edit_profile").style.display = 'block';
    } else if (document.getElementById("edit_profile").style.display == 'block') {

        document.getElementById("profile").style.display = 'block';
        document.getElementById("edit_profile").style.display = 'none';
    }
}
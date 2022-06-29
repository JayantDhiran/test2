// Sidebar JS Start 

document.getElementById('opt2').addEventListener('click',()=>{
    location.href="create_courses.php";
});
document.getElementById('opt3').addEventListener('click',()=>{
    location.href="courses.php";
});
// Sidebar JS End

document.getElementById('delete').addEventListener('click',(e)=>{
    var ck = document.getElementById('agree').checked;
    if(!(ck)){
        e.preventDefault();
    }
});



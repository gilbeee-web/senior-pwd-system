document.addEventListener("DOMContentLoaded", function (){
    console.log("JS Login Loaded.");


    const form = document.getElementById('login-form');
    const button = document.getElementById('login-btn');

    if(form){
        form.addEventListener('submit', function(){
            button.innerText = "Logging in...";
            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
        });
    }
    

});
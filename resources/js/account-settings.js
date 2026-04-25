document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("accountSettings-btn");
    const dropdown = document.getElementById("accountSettings-dropdown");

    if(btn){
        btn.addEventListener("click", function () {
            dropdown.classList.toggle("hidden");
        });
    }
    

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });

});
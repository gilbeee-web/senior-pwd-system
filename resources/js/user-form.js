document.addEventListener("DOMContentLoaded", function () {

    console.log("JS loaded");

    const userFormWrapper = document.getElementById("user-form-wrapper");

    function toggleUserForm() {
        if (!userFormWrapper) return;
        userFormWrapper.classList.toggle('hidden');
        toggleBarangay();
    }

    const addUserButton = document.getElementById("addUser-btn");
    const closeUserButton = document.getElementById("close-btn");

    if(addUserButton){
        addUserButton.addEventListener("click", toggleUserForm);
    }
    
    if(closeUserButton){
        closeUserButton.addEventListener("click", toggleUserForm);
    } 

    const roleSelect = document.getElementById("role");
    const barangayWrapper = document.getElementById("barangay-wrapper");

    function toggleBarangay() {

        if (!roleSelect || !barangayWrapper){
            return;
        } 

        const barangay = document.getElementById("barangay");

        if (roleSelect.value === "municipal_admin") {
            barangayWrapper.classList.add("hidden");
            if(barangay) barangay.value = "";
        } else {
            barangayWrapper.classList.remove("hidden");
        }
    }

    if(roleSelect){
        roleSelect.addEventListener("change", toggleBarangay);
    } 

    // run on page load
    toggleBarangay();
});
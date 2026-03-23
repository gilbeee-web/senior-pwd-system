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

        if (roleSelect.value === "super_admin") {

            console.log("Municpal admin");

            barangayWrapper.classList.add("hidden");

            if(barangay){
                barangay.value = "";
            } 

        } else {
            barangayWrapper.classList.remove("hidden");
        }
    }

    if(roleSelect){
        roleSelect.addEventListener("change", toggleBarangay);
    } 

    // run on page load
    toggleBarangay();

    document.querySelectorAll('.reset-password-btn').forEach(button => {
        button.addEventListener('click', function () {

            const userId = this.dataset.id; // get data-id value

            Swal.fire({
                title: 'Reset Password?',
                text: "User password will be reset.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reset-password-form-' + userId).submit();
                }
            });

        });
    });

    const profile_button = document.getElementById('profile-btn');
    const profile_file = document.getElementById('profile-file');
    const profile_img = document.getElementById('profile-img');
    
    if(profile_button){
        profile_button.addEventListener('click', () => {
            profile_file.click();
        });
    }
    
    if(profile_file){
        profile_file.addEventListener('change', () => {
            if (profile_file.files.length > 0) {
                const file = profile_file.files[0];
                profile_img.src = URL.createObjectURL(file);
            }
        });
    }
   


});
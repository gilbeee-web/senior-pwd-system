document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("addBeneficiary-btn");
    const dropdown = document.getElementById("beneficiaryDropdown");

    btn.addEventListener("click", function () {
        dropdown.classList.toggle("hidden");
    });

    // Close dropdown when clicking outside
    document.addEventListener("click", function (e) {
        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add("hidden");
        }
    });


    const importPwdBtn = document.getElementById('importPwdBtn');
    const filePwdInput = document.getElementById('pwdFileInput');
    const pwdForm = document.getElementById('importPwdForm');

    importPwdBtn.addEventListener('click', () => {
        filePwdInput.click();
    });

    filePwdInput.addEventListener('change', () => {
        if(filePwdInput.files.length > 0){
            pwdForm.submit();
        }
    });




    



});
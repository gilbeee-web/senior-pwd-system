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

    function populatePwdView(data){

        Object.keys(data).forEach(key => {

            const element = document.querySelector(`[data-field="${key}"]`);

            if(element){
                element.textContent = data[key] ?? "";
            }

        });

    }

    const show_pwdWrapper = document.getElementById('show-pwd-wrapper');

    function togglePwdView() {

        if (!show_pwdWrapper){
            return;
        } 

        show_pwdWrapper.classList.toggle('hidden');
    }

    const closePwdModalButton = document.getElementById("close-pwd-modal-btn");
    
    if(closePwdModalButton){
        closePwdModalButton.addEventListener("click", togglePwdView);
    } 



    document.querySelectorAll('.view-pwd-btn').forEach(button => {
        button.addEventListener('click', async function () {

            console.log("View button clicked");

            const pwdId = this.dataset.pwdId;

            if(!pwdId){
                alert("no PWD selected");
            }

            try {
                
                const showUrl = this.dataset.showUrl;

                const response = await fetch(showUrl + pwdId);
                
                if(!response.ok){
                    console.log("Failed to fetch pwd");
                    throw new Error('Failed to fetch pwd');
                }

                const pwd_details = await response.json();
                console.log("Pwd details: ", pwd_details);

                populatePwdView(pwd_details);

                
                togglePwdView();

            } catch (error) {
                console.log("Failed to fetch the pwd details: ", error);
            }

        });
    });

    



    



    



});
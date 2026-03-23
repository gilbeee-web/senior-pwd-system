document.addEventListener("DOMContentLoaded", function () {

    const pwdBtn = document.getElementById('pwd-content-btn');
    const seniorBtn = document.getElementById('senior-content-btn');

    const pwdTable = document.getElementById('pwd-table-wrapper');
    const seniorTable = document.getElementById('senior-table-wrapper');
    const pwdFilter = document.getElementById('disabilityType-filter');
    const seniorFilter = document.getElementById('seniorType-filter');


    if (pwdBtn && seniorBtn) {
        pwdBtn.addEventListener('click', () => {
            pwdTable.classList.remove('hidden');
            pwdFilter.classList.remove('hidden');

            seniorFilter.classList.add('hidden');
            seniorTable.classList.add('hidden');

            pwdBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            pwdBtn.classList.remove('text-gray-400');
            seniorBtn.classList.remove('border-b-[3px]', 'border-red-500');
            seniorBtn.classList.add('text-gray-400');
        });

        seniorBtn.addEventListener('click', () => {
            seniorTable.classList.remove('hidden');
            seniorFilter.classList.remove('hidden');

            pwdFilter.classList.add('hidden');
            pwdTable.classList.add('hidden');

            seniorBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            seniorBtn.classList.remove('text-gray-400');
            pwdBtn.classList.remove('border-b-[3px]', 'border-red-500');
            pwdBtn.classList.add('text-gray-400');
        });
    }


    const btn = document.getElementById("addBeneficiary-btn");
    const dropdown = document.getElementById("beneficiaryDropdown");

    if(btn){
        btn.addEventListener("click", function () {
            dropdown.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    }
    
    


    const importPwdBtn = document.getElementById('importPwdBtn');
    const filePwdInput = document.getElementById('pwdFileInput');
    const pwdForm = document.getElementById('importPwdForm');

    if(importPwdBtn){
        importPwdBtn.addEventListener('click', () => {
            filePwdInput.click();
        });
    }
    
    if(filePwdInput){
        filePwdInput.addEventListener('change', () => {
            if(filePwdInput.files.length > 0){
                
                importPwdBtn.textContent = "Importing...";

                setTimeout(()=>{
                    pwdForm.submit();
                    importPwdBtn.textContent = "Import PWD";
                }, 3000);

                
            }
        });
    }
    

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
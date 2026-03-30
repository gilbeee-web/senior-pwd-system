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


    const selectAll = document.getElementById('select-all'); //select all button checkbox
    const bulkBtn = document.getElementById('bulk-update-btn');
    const bulkUpdate_modal = document.getElementById('bulkUpdate-modal');
    const closeBulkModalBtn = document.getElementById('close-bulk-modal-btn');
    const bulkForm = document.getElementById('bulk-update-form');
    const selectedCountText = document.getElementById('selected-count');

    if(selectAll){
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
            updateBtnCnt();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBtnCnt();
        }
    });

    //update Button and count
    function updateBtnCnt() {
        const selected = document.querySelectorAll('.row-checkbox:checked');

        // Update count
        selectedCountText.textContent = selected.length + " selected";

        // Enable / Disable button
        if (selected.length > 0) {
            bulkBtn.disabled = false;
            bulkBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            bulkBtn.classList.add('bg-blue-500');
        } else {
            selectedCountText.textContent = "";
            bulkBtn.disabled = true;
            bulkBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            bulkBtn.classList.remove('bg-blue-500');
        }
    }
    
    //open modal function
    if(bulkBtn){
        bulkBtn.addEventListener('click', function(){
            const selected = document.querySelectorAll('.row-checkbox:checked');

            // if (selected.length === 0) {
            //     alert("Please select at least one record.");
            //     return;
            // }

            bulkUpdate_modal.classList.remove('hidden');
        });
    } 
    
    if(closeBulkModalBtn){
        closeBulkModalBtn.addEventListener('click', function(){
            bulkUpdate_modal.classList.add('hidden');
        });
    }

    //form submit handler
    if(bulkForm){
        bulkForm.addEventListener('submit', function(e){

            const selected = document.querySelectorAll('.row-checkbox:checked');

            if (selected.length === 0) {
                e.preventDefault(); // not to refresh entire page
                alert("No records selected.");
                return;
            }
            

            //check if no action selected to apply 
            const resident = document.querySelector('input[name="resident_action"]:checked');
            const status = document.querySelector('input[name="status_action"]:checked');
            const income = document.querySelector('input[name="income_action"]:checked');

            if (!resident && !status && !income) {
                e.preventDefault();
                alert("Please select at least one action to apply.");
                return;
            }

            //remove old id input para pag binuksan ulit modal naka fresh id ma-rrender
            document.querySelectorAll('.bulk-id-input').forEach(el => el.remove());

            //loop to the checkbox and add some attributes especially the name to submit in the controller
            selected.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_pwds[]';
                input.value = cb.value;
                input.classList.add('bulk-id-input');
                bulkForm.appendChild(input);
            });
        });
    }


    
    



    



    



});
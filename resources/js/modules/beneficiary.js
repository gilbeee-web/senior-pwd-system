document.addEventListener("DOMContentLoaded", function () {

    const pwdBtn = document.getElementById('pwd-content-btn');
    const seniorBtn = document.getElementById('senior-content-btn');

    const pwdTable = document.getElementById('pwd-table-wrapper');
    const seniorTable = document.getElementById('senior-table-wrapper');
    const pwdFilter = document.getElementById('disabilityType-filter');
    const seniorFilter = document.getElementById('seniorType-filter');
    const validateField = document.getElementById('validate-field');


    const activeTabInput = document.getElementById('active-tab');

    if (pwdBtn) {
        pwdBtn.addEventListener('click', () => {

            if(validateField) validateField.classList.remove('hidden');

            if (pwdTable) pwdTable.classList.remove('hidden');
            if (pwdFilter) pwdFilter.classList.remove('hidden');

            if (seniorTable) seniorTable.classList.add('hidden');
            if (seniorFilter) seniorFilter.classList.add('hidden');

            document.querySelectorAll('.senior-action-btn').forEach(button => {
                button.classList.add('hidden');
            });

            document.querySelectorAll('.pwd-action-btn').forEach(button => {
                button.classList.remove('hidden');
            });

            pwdBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            pwdBtn.classList.remove('text-gray-400');

            if (seniorBtn) {
                seniorBtn.classList.remove('border-b-[3px]', 'border-red-500');
                seniorBtn.classList.add('text-gray-400');
            }

            if (activeTabInput) activeTabInput.value = 'pwd';
        });
    }

    if (seniorBtn) {
        seniorBtn.addEventListener('click', () => {

            

            if (seniorTable) seniorTable.classList.remove('hidden');
            if (seniorFilter) seniorFilter.classList.remove('hidden');

            if(validateField) validateField.classList.add('hidden');
            if (pwdTable) pwdTable.classList.add('hidden');
            if (pwdFilter) pwdFilter.classList.add('hidden');

            document.querySelectorAll('.pwd-action-btn').forEach(button => {
                button.classList.add('hidden');
            });

            document.querySelectorAll('.senior-action-btn').forEach(button => {
                button.classList.remove('hidden');
            });

            seniorBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            seniorBtn.classList.remove('text-gray-400');

            if (pwdBtn) {
                pwdBtn.classList.remove('border-b-[3px]', 'border-red-500');
                pwdBtn.classList.add('text-gray-400');
            }

            if (activeTabInput) activeTabInput.value = 'senior';
        });
    }


    const addBeneficiarybtn = document.getElementById("addBeneficiary-btn");
    const addBeneficiarydropdown = document.getElementById("beneficiaryDropdown");

    if(addBeneficiarybtn){
        addBeneficiarybtn.addEventListener("click", function () {
            addBeneficiarydropdown.classList.toggle("hidden");
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (!addBeneficiarybtn.contains(e.target) && !addBeneficiarydropdown.contains(e.target)) {
                addBeneficiarydropdown.classList.add("hidden");
            }
        });
    }

    const importBeneficiaryBtn = document.getElementById('importBeneficiary-btn');
    const importBeneficiaryDropdown = document.getElementById('importBeneficiary-dropdown');

    if(importBeneficiaryBtn){
        importBeneficiaryBtn.addEventListener('click', function (){
            importBeneficiaryDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function (e) {
            if (!importBeneficiaryBtn.contains(e.target) && !importBeneficiaryDropdown.contains(e.target)) {
                importBeneficiaryDropdown.classList.add("hidden");
            }
        });

    }


    
    
    //uses class attribute to import files not hardcoded ids
    document.querySelectorAll('.import-form').forEach(form => {

        const button = form.querySelector('.import-btn');
        const fileInput = form.querySelector('.file-input');

        if (!button || !fileInput){
            return;
        } 

        //click button to open file explorer
        button.addEventListener('click', () => {
            fileInput.click();
        });

        // when file selected then submit form
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {

                const originalText = button.textContent;
                button.textContent = "Importing...";
                button.disabled = true;

                form.submit();

                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 3000);
            }
        });


    });

    document.addEventListener('DOMContentLoaded', () => {
        if (activeTabInput && activeTabInput.value === 'senior') {
            seniorBtn.click();
        } else {
            pwdBtn.click();
        }
    });



    // const importPwdBtn = document.getElementById('importPwdBtn');
    // const filePwdInput = document.getElementById('pwdFileInput');
    // const pwdForm = document.getElementById('importPwdForm');

    // if(importPwdBtn){
    //     importPwdBtn.addEventListener('click', () => {
    //         filePwdInput.click();
    //     });
    // }
    
    // if(filePwdInput){
    //     filePwdInput.addEventListener('change', () => {
    //         if(filePwdInput.files.length > 0){
                
    //             importPwdBtn.textContent = "Importing...";

    //             setTimeout(()=>{
    //                 pwdForm.submit();
    //                 importPwdBtn.textContent = "Import PWD";
    //             }, 3000);

                
    //         }
    //     });
    // }
    

    // function populatePwdView(data){

    //     Object.keys(data).forEach(key => {

    //         const element = document.querySelector(`[data-field="${key}"]`);

    //         if(element){
    //             element.textContent = data[key] ?? "";
    //         }

    //     });

    // }

    function populateView(type, data) {

        Object.keys(data).forEach(key => {

            const element = document.querySelector(
                `[data-type="${type}"][data-field="${key}"]`
            );

            if (element) {
                element.textContent = data[key] ?? "";
            }
        });

    }

    function renderFamilyMembers(members) {
        const container = document.getElementById('family-members-container');

        if (!container) return;

        container.innerHTML = '';

        if (!members || members.length === 0) {
            container.innerHTML = `
                <tr>
                    <td colspan="5" class="text-gray-500 py-3">
                        No family members found.
                    </td>
                </tr>
            `;
            return;
        }

        members.forEach(member => {

            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="border px-3 py-2">${member.full_name ?? ''}</td>
                <td class="border px-3 py-2">${member.relationship ?? ''}</td>
                <td class="border px-3 py-2">${member.birthdate ?? ''}</td>
                <td class="border px-3 py-2">${member.civil_status ?? ''}</td>
                <td class="border px-3 py-2">${member.occupation ?? ''}</td>
            `;

            container.appendChild(row);
        });
    }


    // const show_pwdWrapper = document.getElementById('show-pwd-wrapper');

    // function togglePwdView() {

    //     if (!show_pwdWrapper){
    //         return;
    //     } 

    //     show_pwdWrapper.classList.toggle('hidden');
    // }

    function toggleView(type) {
        const wrapper = document.getElementById(`show-${type}-wrapper`);

        if (!wrapper) return;

        wrapper.classList.toggle('hidden');
    }



    // const closePwdModalButton = document.getElementById("close-pwd-modal-btn");
    
    // if(closePwdModalButton){
    //     closePwdModalButton.addEventListener("click", togglePwdView);
    // } 

    //close modal based on the type (pwd or senior) defined in the button
    function setupCloseButtons() {
        document.querySelectorAll('[data-close-modal]').forEach(btn => {
            btn.addEventListener('click', function () {
                const type = this.dataset.type;
                toggleView(type);
            });
        });
    }

    async function handleViewClick(button){

        const id = button.dataset.id;
        const type = button.dataset.type;
        const url = button.dataset.showUrl;

        if (!id) {
            alert(`No ${type} selected`);
            return;
        }

        try {
            const response = await fetch(url + id);

            if (!response.ok) {
                throw new Error(`Failed to fetch ${type}`);
            }

            const data = await response.json();

            populateView(type, data);
            toggleView(type);

            if (type === 'senior') {
                renderFamilyMembers(data.family_members);
            }

        } catch (error) {
            console.error(`Error fetching ${type}:`, error);
        }


    }

    function initViewButtons() {
        document.querySelectorAll('.view-btn').forEach(button => {
            button.addEventListener('click', function () {
                handleViewClick(this);
            });
        });
    }

    initViewButtons(); //initialize view buttons
    setupCloseButtons();






    // document.querySelectorAll('.view-pwd-btn').forEach(button => {
    //     button.addEventListener('click', async function () {

    //         console.log("View button clicked");

    //         const pwdId = this.dataset.pwdId;

    //         if(!pwdId){
    //             alert("no PWD selected");
    //         }

    //         try {
                
    //             const showUrl = this.dataset.showUrl;

    //             const response = await fetch(showUrl + pwdId);
                
    //             if(!response.ok){
    //                 console.log("Failed to fetch pwd");
    //                 throw new Error('Failed to fetch pwd');
    //             }

    //             const pwd_details = await response.json();
    //             console.log("Pwd details: ", pwd_details);

    //             populatePwdView(pwd_details);

                
    //             togglePwdView();

    //         } catch (error) {
    //             console.log("Failed to fetch the pwd details: ", error);
    //         }

    //     });
    // });


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
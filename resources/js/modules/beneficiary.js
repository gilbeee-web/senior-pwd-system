document.addEventListener("DOMContentLoaded", function () {

    const pwdBtn = document.getElementById('pwd-content-btn');
    const seniorBtn = document.getElementById('senior-content-btn');

    const pwdTable = document.getElementById('pwd-table-wrapper');
    const seniorTable = document.getElementById('senior-table-wrapper');

    const pwdFilter = document.getElementById('disabilityType-filter');
    const seniorFilter = document.getElementById('seniorType-filter');

    const activeTabInput = document.getElementById('active-tab');
    const filterForm = document.getElementById('filter-form');

    function setActiveButton(tab) {
        if (!pwdBtn || !seniorBtn) return;

        if (tab === 'pwd') {
            pwdBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            pwdBtn.classList.remove('text-gray-400');

            seniorBtn.classList.remove('border-b-[3px]', 'border-red-500', 'font-bold');
            seniorBtn.classList.add('text-gray-400');
        }

        if (tab === 'senior') {
            seniorBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
            seniorBtn.classList.remove('text-gray-400');

            pwdBtn.classList.remove('border-b-[3px]', 'border-red-500', 'font-bold');
            pwdBtn.classList.add('text-gray-400');
        }
    }

    function setTab(tab) {
        if (activeTabInput) {
            activeTabInput.value = tab;
        }
    }

    if (pwdBtn) {
        pwdBtn.addEventListener('click', (e) => {
            setTab('pwd');
            setActiveButton('pwd');
            filterForm.submit(); 
        });
    }

    if (seniorBtn) {
        seniorBtn.addEventListener('click', (e) => {
            setTab('senior');
            setActiveButton('senior');
            filterForm.submit(); 
        });
    }
   

    // if (pwdBtn) {
    //     pwdBtn.addEventListener('click', () => {

    //         clearSelection('senior');

    //         if (pwdTable) pwdTable.classList.remove('hidden');
    //         if (pwdFilter) pwdFilter.classList.remove('hidden');

    //         if (seniorTable) seniorTable.classList.add('hidden');
    //         if (seniorFilter) seniorFilter.classList.add('hidden');

    //         document.querySelectorAll('.senior-action-btn').forEach(button => {
    //             button.classList.add('hidden');
    //         });

    //         document.querySelectorAll('.pwd-action-btn').forEach(button => {
    //             button.classList.remove('hidden');
    //         });

    //         document.getElementById('pwd-rows-pagination').classList.remove('hidden');
    //         document.getElementById('senior-rows-pagination').classList.add('hidden');

    //         pwdBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
    //         pwdBtn.classList.remove('text-gray-400');

    //         if (seniorBtn) {
    //             seniorBtn.classList.remove('border-b-[3px]', 'border-red-500');
    //             seniorBtn.classList.add('text-gray-400');
    //         }

    //         if (activeTabInput) activeTabInput.value = 'pwd';
    //     });
    // }

    // if (seniorBtn) {
    //     seniorBtn.addEventListener('click', () => {

    //         clearSelection('pwd');

    //         if (seniorTable) seniorTable.classList.remove('hidden');
    //         if (seniorFilter) seniorFilter.classList.remove('hidden');

    //         // if(selectedPwdAction) selectedPwdAction.classList.add('hidden');
    //         if (pwdTable) pwdTable.classList.add('hidden');
    //         if (pwdFilter) pwdFilter.classList.add('hidden');

    //         document.querySelectorAll('.pwd-action-btn').forEach(button => {
    //             button.classList.add('hidden');
    //         });

    //         document.querySelectorAll('.senior-action-btn').forEach(button => {
    //             button.classList.remove('hidden');
    //         });

    //         document.getElementById('pwd-rows-pagination').classList.add('hidden');
    //         document.getElementById('senior-rows-pagination').classList.remove('hidden');

    //         seniorBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
    //         seniorBtn.classList.remove('text-gray-400');

    //         if (pwdBtn) {
    //             pwdBtn.classList.remove('border-b-[3px]', 'border-red-500');
    //             pwdBtn.classList.add('text-gray-400');
    //         }

    //         if (activeTabInput) activeTabInput.value = 'senior';
    //     });
    // }


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


    function toggleView(type) {
        const wrapper = document.getElementById(`show-${type}-wrapper`);

        if (!wrapper) return;

        wrapper.classList.toggle('hidden');
    }



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


    
    const bulkBtn = document.getElementById('bulk-update-btn');
    const bulkUpdate_modal = document.getElementById('bulkUpdate-modal');
    const closeBulkModalBtn = document.getElementById('close-bulk-modal-btn');
    const bulkForm = document.getElementById('bulk-update-form');


    const selectAllCheckBoxes = document.querySelectorAll('.select-all'); //select all button checkbox

    const generateIdForm = document.querySelectorAll('.generate-id-form'); // class

    if(selectAllCheckBoxes){

        selectAllCheckBoxes.forEach(selectAllCb => {
            selectAllCb.addEventListener('change', function(){
                const type = this.dataset.type;

                document.querySelectorAll(`.row-checkbox[data-type="${type}"]`)
                    .forEach(cb => {
                        cb.checked = this.checked;
                    });

                updateBtnCnt(type);
            });
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBtnCnt(e.target.dataset.type);
        }
    });

    //update Button and count
    function updateBtnCnt(type) {

        console.log("UpdateBtnCtn");

        const selected = document.querySelectorAll(
            `.row-checkbox[data-type="${type}"]:checked`
        );

        const countText = document.querySelector(
            `.selected-count[data-type="${type}"]`
        );

        // const actionField = document.querySelector(
        //     `.selected-${type}-action-field`
        // );

        const actionField = document.querySelector(`.selected-${type}-action-field`);

        // update count text
        if (countText) {
            countText.textContent = selected.length
                ? `${selected.length} selected`
                : '';
        }

        console.log("Action Field: ", actionField, "type: ", type);

        // show/hide action buttons
        if (actionField) {
            console.log("Action Field: ", actionField);
            if (selected.length > 0) {
                actionField.classList.remove('hidden');
            } else {
                actionField.classList.add('hidden');
            }

        }
    }


    //clear selected pwds or seniors
    function clearSelection(type) {
        
        // uncheck all checkboxes of that type
        document.querySelectorAll(`.row-checkbox[data-type="${type}"]`)
            .forEach(cb => cb.checked = false);


        // reset select-all checkbox
        const selectAll = document.querySelector(`.select-all[data-type="${type}"]`);
        if (selectAll){
            selectAll.checked = false;
        } 

        // reset UI (count + buttons)
        updateBtnCnt(type);
    }

    

    
    //open modal function to update or validate
    if(bulkBtn){
        bulkBtn.addEventListener('click', function(){
            const selected = document.querySelectorAll('.row-checkbox[data-type="pwd"]:checked');

            if (selected.length === 0) {
                alert("Please select at least one record.");
                return;
            }

            bulkUpdate_modal.classList.remove('hidden');
        });
    } 
    
    //close modal function to update or validate
    if(closeBulkModalBtn){
        closeBulkModalBtn.addEventListener('click', function(){
            bulkUpdate_modal.classList.add('hidden');
        });
    }

    //form submit handler of form to validate field
    if(bulkForm){
        bulkForm.addEventListener('submit', function(e){

            const selected = document.querySelectorAll('.row-checkbox[data-type="pwd"]:checked');

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

    document.addEventListener('submit', function(e){

        const form = e.target;

        if (!form.classList.contains('generate-id-form')) return; 

        e.preventDefault();

        const type = form.dataset.type;

        const selected = document.querySelectorAll(
            `.row-checkbox[data-type="${type}"]:checked`
        );

        if (selected.length === 0) {
            alert("No records selected.");
            return;
        }

        // remove old inputs
        form.querySelectorAll('.bulk-id-input').forEach(el => el.remove());

        // dynamic name based on type
        const inputName = `selected_${type}s[]`;

        selected.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = inputName; // either senior or pwd
            input.value = cb.value;
            input.classList.add('bulk-id-input');
            form.appendChild(input);
        });

        form.submit();

    });

    function setupDropdown(buttonClass, wrapperClass) {
        const buttons = document.querySelectorAll(buttonClass); // get the button class 

        buttons.forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();

                // close all dropdowns
                document.querySelectorAll('.pwd-more-action-wrapper, .senior-more-action-wrapper')
                    .forEach(menu => menu.classList.add('hidden'));

                const wrapper = btn.nextElementSibling;
                wrapper.classList.toggle('hidden');
            });
        });
    }

    // initialize the function
    setupDropdown('.pwd-more-action-btn', '.pwd-more-action-wrapper');
    setupDropdown('.senior-more-action-btn', '.senior-more-action-wrapper');

    // single global listener for hiding when clicking outside the field
    document.addEventListener('click', () => {
        document.querySelectorAll('.pwd-more-action-wrapper, .senior-more-action-wrapper')
            .forEach(menu => menu.classList.add('hidden'));
    });

        
    



});
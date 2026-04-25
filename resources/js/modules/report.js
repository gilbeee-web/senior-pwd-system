document.addEventListener('DOMContentLoaded', function () {

    console.log("Report js loaded");

    const pwdBtn = document.getElementById('pwd-report-content-btn');
    const seniorBtn = document.getElementById('senior-report-content-btn');

    const pwdTable = document.getElementById('pwd-report-table-wrapper');
    const seniorTable = document.getElementById('senior-report-table-wrapper');

    const pwd_filter = document.querySelectorAll('.pwd_filter');
    const senior_filter = document.querySelectorAll('.senior_filter');

    const pwdExport = document.getElementById('pwd_export_settings');
    const seniorExport = document.getElementById('senior_export_settings');

    const activeTabInput = document.getElementById('activeReport-tab');
    const filterForm = document.getElementById('report-filter-form');

    // if (pwdBtn) {
    //     pwdBtn.addEventListener('click', () => {

    //         if (pwdTable) pwdTable.classList.remove('hidden');
    //         if(pwd_filter) pwd_filter.forEach(el => el.classList.remove('hidden'));
    //         if(pwdExport) pwdExport.classList.remove('hidden');
            

    //         if (seniorTable) seniorTable.classList.add('hidden');
    //         if(senior_filter) senior_filter.forEach(el => el.classList.add('hidden'));
    //         if(seniorExport) seniorExport.classList.add('hidden');

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

    //         if (seniorTable) seniorTable.classList.remove('hidden');
    //         if(senior_filter) senior_filter.forEach(el => el.classList.remove('hidden'));
    //         if(seniorExport) seniorExport.classList.remove('hidden');

    //         if (pwdTable) pwdTable.classList.add('hidden');
    //         if(pwd_filter) pwd_filter.forEach(el => el.classList.add('hidden'));
    //         if(pwdExport) pwdExport.classList.add('hidden');

    //         seniorBtn.classList.add('border-b-[3px]', 'border-red-500', 'font-bold');
    //         seniorBtn.classList.remove('text-gray-400');

    //         if (pwdBtn) {
    //             pwdBtn.classList.remove('border-b-[3px]', 'border-red-500');
    //             pwdBtn.classList.add('text-gray-400');
    //         }

    //         if (activeTabInput) activeTabInput.value = 'senior';
    //     });
    // }

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



    document.querySelectorAll('.column-wrapper').forEach(wrapper => {

        const button = wrapper.querySelector('.column-btn');
        const dropdown = wrapper.querySelector('.column-dropdown');
        const selectAll = wrapper.querySelector('.select-all');

        // Toggle dropdown
        button.addEventListener('click', function (e) {
            e.stopPropagation();

            // close all other dropdowns first
            document.querySelectorAll('.column-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.add('hidden');
            });

            dropdown.classList.toggle('hidden');
        });

        // Select all
        selectAll.addEventListener('click', function () {
            const checkboxes = dropdown.querySelectorAll('input[name="columns[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });


    // // Close when clicking outside
    // document.addEventListener('click', function () {
    //     document.querySelectorAll('.column-dropdown').forEach(d => {
    //         d.classList.add('hidden');
    //     });
    // });


});

    
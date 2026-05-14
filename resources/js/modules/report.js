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

    function resetForm(tab) {
        filterForm.querySelectorAll('input, select').forEach(el => {
            if (el.type === 'checkbox' || el.type === 'radio') {
                el.checked = false;
            } else {
                el.value = '';
            }
        });

        // keep tab value
        document.getElementById('activeReport-tab').value = tab;
    }

    if (pwdBtn) {
        pwdBtn.addEventListener('click', (e) => {
            setTab('pwd');
            setActiveButton('pwd');

            resetForm('pwd');
            filterForm.submit(); 
        });
    }

    if (seniorBtn) {
        seniorBtn.addEventListener('click', (e) => {
            setTab('senior');
            setActiveButton('senior');

            resetForm('senior');
            filterForm.submit(); 
        });
    }

    document.querySelectorAll('.modal').forEach(modal => {

        const selectAll = modal.querySelector('.select-all');
        const checkboxes = modal.querySelectorAll('input[name="columns[]"]');

        if (!selectAll) return;

        // Select All
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Individual
        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const allChecked = [...checkboxes].every(c => c.checked);
                selectAll.checked = allChecked;
            });
        });

    });


    function toggleModal(modalId, show = true) {
        const modal = document.getElementById(modalId);

        if (!modal) return;

        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    document.querySelectorAll('.open-export-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.target;
            toggleModal(target, true);
        });
    });

    document.querySelectorAll('.close-export-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            const modal = this.closest('.modal');
            toggleModal(modal.id, false);
        });
    });

    document.querySelectorAll('.export-form').forEach(form => {
        form.addEventListener('submit', function (e) {

            const button = form.querySelector('.export-btn');

            const checked = form.querySelectorAll('input[name="columns[]"]:checked');
            
            if (checked.length < 3) {
                e.preventDefault();
                alert('Please select at least 3 columns to export.');
                return;
            }

            if (button) {
                button.textContent = 'Exporting...';
                button.disabled = true;
                button.classList.add('opacity-50', 'cursor-not-allowed');

                 setTimeout(() => {
                    button.textContent = 'Export Excel';
                    button.disabled = false;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                }, 3000);
            }
        });
    });


});

    
document.addEventListener('DOMContentLoaded', function(){

    console.log("Employee form js loaded");

    const employeeFormWrapper = document.getElementById('authorize-employee-form-wrapper');
    const addEmployeeBtn = document.getElementById('add-employee-btn');


    if(addEmployeeBtn){

        console.log("add employee btn: ", addEmployeeBtn);

        addEmployeeBtn.addEventListener('click', e => {
            console.log("employee wrapper: ", employeeFormWrapper);
            employeeFormWrapper.classList.remove('hidden');
        });
    }


    const closeEmployeeModalFormBtn  = document.getElementById('authorize-close-btn');

    if(closeEmployeeModalFormBtn){
        closeEmployeeModalFormBtn.addEventListener('click', e => {
            employeeFormWrapper.classList.add('hidden');
        });
    }

    const actionButtons = document.querySelectorAll('.authorize-more-action-btn');
    if(actionButtons){

        actionButtons.forEach(btn => {
            btn.addEventListener('click', e => {
                e.stopPropagation();

                // close all dropdowns first
                document.querySelectorAll('.authorize-more-action-wrapper')
                    .forEach(menu => menu.classList.add('hidden'));

                // open current dropdown
                const wrapper = btn.nextElementSibling;
                wrapper.classList.toggle('hidden');
            });
        });

        // close when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.authorize-more-action-wrapper')
                .forEach(menu => menu.classList.add('hidden'));
        });
    }


});
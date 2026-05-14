document.addEventListener('DOMContentLoaded', function(){


    //fetch street
    const senior_barangay = document.getElementById('senior_barangay');
    const senior_streetSelect = document.getElementById('senior_street');

    async function loadStreets(barangayId) {
        senior_streetSelect.innerHTML = '<option value="">Loading...</option>';

        if (!barangayId) {
            senior_streetSelect.innerHTML = '<option value="" disabled hidden selected>Select Street</option>';
            return;
        }

        try {
            const streetUrl = senior_barangay.dataset.streetUrl;

            const response = await fetch(streetUrl + barangayId);

            if (!response.ok) {
                throw new Error('Failed to fetch streets');
            }

            const streets = await response.json();

            console.log("Streets: ", streets);

            senior_streetSelect.innerHTML = '<option value="" disabled hidden>Select Street</option>';

            streets.forEach(street => {
                const option = document.createElement('option');
                option.value = street.id;
                option.textContent = street.name;
                senior_streetSelect.appendChild(option);
            });

        } catch (error) {
            console.log("Failed to fetch the streets: ", error);
            senior_streetSelect.innerHTML = '<option value="">Error loading streets</option>';
        }
    }

    if (senior_barangay) {

        //load street after changing the value of barangay
        senior_barangay.addEventListener('change', function () {
            loadStreets(this.value);
        });

       //initial load for streets if the barangay is pre-defined
        if (senior_barangay.value) {
            loadStreets(senior_barangay.value);
        }
    }


    const has_pension_cb = document.getElementById('has_pension');
    const pensionWrapper = document.getElementById('pensionAmount-wrapper');
    const pensionInput = document.querySelector('input[name="pension_amount"]');

    function togglePension() {
        if(has_pension_cb){
            if (has_pension_cb.checked) {
                pensionWrapper.classList.remove('hidden');
                pensionInput.required = true;
            } else {
                pensionWrapper.classList.add('hidden');
                pensionInput.required = false;
                pensionInput.value = null;
            }
        }
        
    }

    // run on load for editing
    togglePension();

    // run on change
    if(has_pension_cb){
        has_pension_cb.addEventListener('change', togglePension);
    }
    


    const with_family_cb = document.getElementById('with_family');
    const family_container = document.getElementById('family-container');
    const addFamilyBtn = document.getElementById('add-family');
    const family_template = document.getElementById('family-template');

    let family_index = 0;

    function createFamilyItem(data = null){
        const clone = family_template.content.cloneNode(true);
        const item = clone.querySelector('.family-item');

        // assign dynamic names
        item.querySelectorAll('[data-name]').forEach(input => {

            const field = input.dataset.name;
            input.name = `family[${family_index}][${field}]`;

            //populate the data if editing mode na 
            if (data && data[field] !== undefined) {
                input.value = data[field];
            }
        });

        family_index++;

        // remove logic
        item.querySelector('.remove-family').addEventListener('click', () => {
            item.remove();
        });

        return item;

    }

    // family checkbox toggle
    if(with_family_cb){
        with_family_cb.addEventListener('change', () => {
            if (with_family_cb.checked) {
                family_container.classList.remove('hidden');

                if (family_container.querySelectorAll('.family-item').length === 0) {
                    family_container.insertBefore(createFamilyItem(), addFamilyBtn);
                }
            } else {
                family_container.classList.add('hidden');
                family_container.querySelectorAll('.family-item').forEach(e => e.remove());
                family_index = 0;
            }
        });
    }
    

    // add button
    if(addFamilyBtn){
        addFamilyBtn.addEventListener('click', () => {
            family_container.insertBefore(createFamilyItem(), addFamilyBtn);
        });
    }

    if (window.oldFamily && window.oldFamily.length > 0) {
        with_family_cb.checked = true;
        family_container.classList.remove('hidden');

        window.oldFamily.forEach(member => {
            family_container.insertBefore(createFamilyItem(member), addFamilyBtn);
        });
    }
    
    const archiveForm = document.querySelectorAll('.senior-archive-form');

    if(archiveForm){
        archiveForm.forEach(form => {

            form.addEventListener('submit', function(e){

                e.preventDefault();

                Swal.fire({
                    title: 'Archive Record?',
                    text: 'This Senior Citizen beneficiary will be archived.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Archive'
                }).then((result) => {

                    if(result.isConfirmed){
                        form.submit();
                    }

                });

            });

        });
    }


    const seniorForm = document.getElementById('senior_form');

    if (seniorForm) {

        seniorForm.addEventListener('submit', function (e) {

            e.preventDefault();

            const formType = this.dataset.formType;

            let swalTitle = '';
            let swalText = '';
            let swalIcon = '';
            let confirmBtnText = '';

            if (formType === 'create') {

                swalTitle = 'Review Information';
                swalText = 'Please review all entered information before submitting.';
                swalIcon = 'question';
                confirmBtnText = 'Submit';

            } else if (formType === 'update') {

                swalTitle = 'Update Record?';
                swalText = 'Are you sure you want to update this beneficiary information?';
                swalIcon = 'warning';
                confirmBtnText = 'Update';
            }

            Swal.fire({
                title: swalTitle,
                text: swalText,
                icon: swalIcon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmBtnText
            }).then((result) => {

                if (result.isConfirmed) {
                    seniorForm.submit();
                }

            });

        });

    }



});
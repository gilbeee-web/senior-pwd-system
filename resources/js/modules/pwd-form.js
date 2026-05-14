document.addEventListener("DOMContentLoaded", function () {
    console.log("PWD form loaded.");

    //fetch street
    const barangay = document.getElementById('pwd_barangay');
    const streetSelect = document.getElementById('pwd_street');

    async function loadStreets(barangayId) {
        streetSelect.innerHTML = '<option value="">Loading...</option>';

        if (!barangayId) {
            streetSelect.innerHTML = '<option value="" disabled selected hidden>Select Street</option>';
            return;
        }

        try {
            const streetUrl = barangay.dataset.streetUrl;

            const response = await fetch(streetUrl + barangayId);

            if (!response.ok) {
                throw new Error('Failed to fetch streets');
            }

            const streets = await response.json();

            console.log("Streets: ", streets);

            streetSelect.innerHTML = '<option value="" disabled hidden>Select Street</option>';

            streets.forEach(street => {
                const option = document.createElement('option');
                option.value = street.id;
                option.textContent = street.name;
                streetSelect.appendChild(option);
            });

        } catch (error) {
            console.log("Failed to fetch the streets: ", error);
            streetSelect.innerHTML = '<option value="">Error loading streets</option>';
        }
    }

    if (barangay) {

        //load street after changing the value of barangay
        barangay.addEventListener('change', function () {
            loadStreets(this.value);
        });

       //initial load for streets if the barangay is pre-defined
        if (barangay.value) {
            loadStreets(barangay.value);
        }
    }

    const pwdForm = document.getElementById('pwd_form');

    if (pwdForm) {

        pwdForm.addEventListener('submit', function (e) {

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
                    pwdForm.submit();
                }

            });

        });

    }

    const archiveForm = document.querySelectorAll('.pwd-archive-form');

    console.log("Archive form")

    if(archiveForm){
        archiveForm.forEach(form => {

            form.addEventListener('submit', function(e){

                e.preventDefault();

                Swal.fire({
                    title: 'Archive Record?',
                    text: 'This PWD beneficiary will be archived.',
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
    




});
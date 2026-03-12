document.addEventListener("DOMContentLoaded", function () {
    console.log("PWD form loaded.");
    //fetch street
    const barangay = document.getElementById('barangay');

    if(barangay){
        barangay.addEventListener('change', async function() {

            let barangayId = this.value;
            let streetSelect = document.getElementById('street');

            console.log("Barangay ID: " + barangayId);

            streetSelect.innerHTML = '<option value="">Loading...</option>';

            if (!barangayId) {
                streetSelect.innerHTML = '<option value="">Select Street</option>';
                return;
            }


            try {
                
                const streetUrl = barangay.dataset.streetUrl;

                const response = await fetch(streetUrl + barangayId);
                
                if(!response.ok){
                    throw new Error('Failed to fetch streets');
                }

                const streets = await response.json();

                

                console.log("Streets: ", streets);

                streetSelect.innerHTML = '<option value="">Select Street</option>';

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

        });
    }
    

    // console.log("PWD formsss loaded.");
    
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

            } catch (error) {
                console.log("Failed to fetch the pwd details: ", error);
            }

        });
    });


    const form = document.getElementById("pwd_form");
    const submitBtn = document.getElementById("submitBtn");
    const requiredFields = form.querySelectorAll("[required]");

    function checkForm() {
        let allFilled = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                allFilled = false;
            }
        });

        if (allFilled) {
            submitBtn.disabled = false;
            submitBtn.classList.remove("bg-[#FF9793]", "cursor-not-allowed");
            submitBtn.classList.add("bg-green-500", "cursor-pointer");
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove("bg-green-500", "cursor-pointer");
            submitBtn.classList.add("bg-[#FF9793]", "cursor-not-allowed");
        }
    }

    requiredFields.forEach(field => {
        field.addEventListener("input", checkForm);
        field.addEventListener("change", checkForm);
    });








});
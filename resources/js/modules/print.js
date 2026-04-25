document.addEventListener('DOMContentLoaded', function(){
    console.log("Print js loaded");

    const printBtn = document.getElementById('print-btn');
    const switchBtn = document.getElementById('switch-btn');
    const front_id = document.querySelectorAll('.front-id');
    const back_id = document.querySelectorAll('.back-id');
    let activeSection = "front";

    
    if(switchBtn){
        switchBtn.addEventListener('click', function(){
        
            if(activeSection === "front"){

                front_id.forEach(id => {
                    id.classList.add('hidden');
                });

                back_id.forEach(id => {
                    id.classList.remove('hidden');
                });

                // front_id.classList.add('hidden');
                // back_id.classList.remove('hidden');

                activeSection = "back";
                switchBtn.textContent = "Switch to Front";

            } else if(activeSection === "back") {

                console.log("Back");

                front_id.forEach(id => {
                    id.classList.remove('hidden');
                });

                back_id.forEach(id => {
                    id.classList.add('hidden');
                });

                // back_id.classList.add('hidden');
                // front_id.classList.remove('hidden');

                activeSection = "front";
                switchBtn.textContent = "Switch to Back";
            }
        });
        
    }

    if(printBtn){
        printBtn.addEventListener('click', function(){

            if(activeSection === "front"){
                
                front_id.forEach(id => {
                    id.classList.add('print-target');
                });

                back_id.forEach(id => {
                    id.classList.remove('print-target');
                });

                // front_id.classList.add('print-target');
                // back_id.classList.remove('print-target');

            } else {

                front_id.forEach(id => {
                    id.classList.remove('print-target');
                });

                back_id.forEach(id => {
                    id.classList.add('print-target');
                });

                // back_id.classList.add('print-target');
                // front_id.classList.remove('print-target');
            }

            window.print();

            //CLEANUP AFTER PRINT
            setTimeout(() => {
                front_id.classList.remove('print-target');
                back_id.classList.remove('print-target');
            }, 500);
        });
    }


    const phoneNumbers = document.getElementsByClassName('contact_number');

    if (phoneNumbers.length > 0) {
        Array.from(phoneNumbers).forEach(el => {
            const raw = el.textContent.trim();
            el.textContent = formatPhoneNumber(raw);
        });
    }

    function formatPhoneNumber(number) {
        let cleaned = number.replace(/\D/g, '');

        if (cleaned.length === 11) {
            return `(${cleaned.replace(/(\d{4})(\d{3})(\d{4})/, '$1-$2-$3')})`;
        } else {
            return '---------';
        }
    }


}); 
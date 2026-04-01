document.addEventListener('DOMContentLoaded', function(){

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
    



});
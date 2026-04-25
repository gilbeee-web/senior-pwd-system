document.addEventListener('DOMContentLoaded', function(){


    console.log("Archive JS loaded");

    const archiveMoreActionBtn = document.querySelectorAll(".archive-more-action-btn"); // get the button class 

    archiveMoreActionBtn.forEach(btn => {
        btn.addEventListener('click', e => {
            e.stopPropagation();

            // close all dropdowns
            document.querySelectorAll('.archive-more-action-wrapper')
                .forEach(menu => menu.classList.add('hidden'));

            const wrapper = btn.nextElementSibling;
            wrapper.classList.toggle('hidden');
        });
    });

    // single global listener for hiding when clicking outside the field
    document.addEventListener('click', () => {
        document.querySelectorAll('.archive-more-action-wrapper')
            .forEach(menu => menu.classList.add('hidden'));
    });
    


});
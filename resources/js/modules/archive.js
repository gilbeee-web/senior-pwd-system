document.addEventListener('DOMContentLoaded', function(){

    const selectAll = document.getElementById('select-all'); //select all button checkbox

    if(selectAll){
        selectAll.addEventListener('change', function () {
            document.querySelectorAll('.row-checkbox').forEach(cb => {
                cb.checked = this.checked;
            });
            updateBtnCnt();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBtnCnt();
        }
    });

    //update Button and count
    function updateBtnCnt() {
        const selected = document.querySelectorAll('.row-checkbox:checked');

        // Update count
        selectedCountText.textContent = selected.length + " selected";

        // Enable / Disable button
        if (selected.length > 0) {
            bulkBtn.disabled = false;
            bulkBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            bulkBtn.classList.add('bg-blue-500');
        } else {
            selectedCountText.textContent = "";
            bulkBtn.disabled = true;
            bulkBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            bulkBtn.classList.remove('bg-blue-500');
        }
    }
});
document.addEventListener('DOMContentLoaded', function(){
    
    let currentRequestId = null;
    let currentOldData = null;
    let currentNewData = null;

    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', async function(){
            const requestId = this.dataset.id;
            const actionType = this.dataset.type; // delete or archive
            


            if(actionType === 'update'){

                const oldData = JSON.parse(this.dataset.old);
                const newData = JSON.parse(this.dataset.new);

                currentRequestId = requestId;
                currentOldData = oldData;
                currentNewData = newData;


                showUpdateModal(oldData, newData);

                return;
            }

            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "This will archive the record!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Approve',
                cancelButtonText: 'Cancel'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`/requests/approve/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({}) // optional extra data
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire('Done!', data.message, 'success');
                    // Optionally refresh the page or remove the row dynamically
                    location.reload();
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error!', 'Something went wrong.', error);
                console.error(error);
            }

            
        });
    });

    function formatLabel(key) {
        return key
            .replaceAll('.', ' → ')
            .replaceAll('_', ' ')
            .replace(/\b\w/g, c => c.toUpperCase());
    }


    function generateChanges(oldData, newData, parentKey = '') {

        let rows = '';

        for (const key in newData) {

            const fullKey = parentKey ? `${parentKey}.${key}` : key;

            const oldVal = oldData?.[key];
            const newVal = newData[key];

            // Skip null / empty new values
            if (newVal === null || newVal === undefined || newVal === '') {
                continue;
            }

            // Nested object (recursive)
            if (typeof newVal === 'object' && !Array.isArray(newVal)) {
                rows += generateChanges(oldVal || {}, newVal, fullKey);
                continue;
            }

            // Only show if changed
            if (oldVal != newVal) {
                rows += `
                    <tr>
                        <td class="border px-3 py-2 font-medium text-gray-700">
                            ${formatLabel(fullKey)}
                        </td>
                        <td class="border px-3 py-2 text-red-500 line-through">
                            ${oldVal ?? '-'}
                        </td>
                        <td class="border px-3 py-2 text-green-600 font-semibold">
                            ${newVal}
                        </td>
                    </tr>
                `;
            }
        }

        return rows;
    }

    const reviewChangesWrapper = document.getElementById('review-changes-wrapper');

    function showUpdateModal(oldData, newData){

        if(!reviewChangesWrapper){
            return;
        }

        reviewChangesWrapper.classList.remove('hidden');
        const container = reviewChangesWrapper.querySelector('#changes-container');
        container.innerHTML = generateChanges(oldData, newData);
    }


    document.querySelectorAll('.close-modal-btn').forEach(btn => {
        btn.addEventListener('click', function(){
            reviewChangesWrapper.classList.add('hidden');
        });
    });


    const approveChangesBtn = document.getElementById('approve-changes-btn');

    if (approveChangesBtn) {
        
        approveChangesBtn.addEventListener('click', async function () {

            try {
                const response = await fetch(`/requests/approve/${currentRequestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: JSON.stringify({
                        type: 'update',
                        old: currentOldData,
                        new: currentNewData
                    })
                });

                const data = await response.json();

                if (data.success) {
                    await Swal.fire('Approved!', data.message, 'success');

                    // close modal
                    document.getElementById('review-changes-wrapper')
                        .classList.add('hidden');

                    location.reload();
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }

            } catch (error) {
                console.error(error);
                Swal.fire('Error!', 'Something went wrong.', 'error');
            }
        });
    }


   

});
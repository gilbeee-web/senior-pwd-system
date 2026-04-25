import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function(){

    console.log("Dashboard js loaded");


    const superAdmin_barangay_ctx = document.getElementById('superAdmin_barangayChart');

    if(superAdmin_barangay_ctx){
        console.log("Super admin ctx");
        new Chart(superAdmin_barangay_ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Seniors',
                        data: seniors,
                        borderWidth: 1
                    },
                    {
                        label: 'PWD',
                        data: pwd,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Beneficiaries per Barangay'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    

    function createBarangayChart(canvasId, labels, data, labelText, titleText) {

        const ctx = document.getElementById(canvasId);

        if (!ctx) return;

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: labelText,
                        data: data,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: titleText
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    const senior_barangay_ctx = document.getElementById('senior_barangayChart');
    const pwd_barangay_ctx = document.getElementById('pwd_barangayChart');

    if(senior_barangay_ctx){
        console.log("Senior barangay chart");
        createBarangayChart(
            'senior_barangayChart',
            labels,
            values,
            'Seniors',
            'Senior Citizens per Barangay'
        );
    }

    if(pwd_barangay_ctx){
        console.log("PWD barangay chart");
        createBarangayChart(
            'pwd_barangayChart',
            labels,
            values,
            'PWD'
        );
    }
    


    const reg_ctx = document.getElementById('registrationChart');

    if(reg_ctx){
        new Chart(reg_ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: reg_labels,
                datasets: [{
                    label: 'Registrations (Last 2 Months)',
                    data: reg_values,
                    tension: 0.3, // smooth curve
                    fill: false,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Registrations'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }


    


        

});
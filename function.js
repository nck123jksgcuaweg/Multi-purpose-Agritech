// 🟢 Chart.js Pie Chart with different colors
function createPieChart(ctx, label, value, color) {
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [label, 'Remaining'],
            datasets: [{
                data: [value, 100 - value],
                backgroundColor: [color, '#ddd'],
            }]
        },
        options: { 
            responsive: true, 
            cutout: '70%',
            animation: { animateScale: true }
        }
    });
}

// 🟢 Fetch table data from API
async function fetchTableData() {
    try {
        const response = await fetch("http://192.168.254.132/status"); 
        const data = await response.json(); 

        console.log("Fetched Data:", data); // Debugging Log

        updateMachineOperations(data.operations);
        updateSeedSowingLog(data.seedLog);
        updateWaterSprinklingLog(data.waterLog);
        updateErrorLog(data.errors);

    } catch (error) {
        console.error("Error fetching table data:", error);
    }
}





// 🔄 Fetch table data every 5 seconds
setInterval(fetchTableData, 5000);

// 🟢 Fetch data on page load
fetchTableData();

// 🟢 Function to upload table data to Firebase
function uploadTableData() {
    const rows = document.querySelectorAll("#machineOperations tbody tr");

    rows.forEach(row => {
        const operation = row.cells[0].textContent;
        const startTime = row.cells[1].textContent;
        const endTime = row.cells[2].textContent;
        const status = row.cells[3].textContent;

        // Push to Firebase
        database.ref("machineOperations").push({
            operation,
            startTime,
            endTime,
            status
        });
    });
}

// 🟢 Event listener for button to upload data
document.getElementById("addDataButton")?.addEventListener("click", uploadTableData);

// 🟢 Firebase real-time listener for updates
database.ref("machineOperations").on("child_added", function(snapshot) {
    const data = snapshot.val();

    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${data.operation}</td>
        <td>${data.startTime}</td>
        <td>${data.endTime}</td>
        <td>${data.status}</td>
    `;
    document.querySelector("#machineOperations tbody").appendChild(newRow);
});

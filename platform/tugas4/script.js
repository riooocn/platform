document.getElementById("inputForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission
    var jumlahPilihan = parseInt(document.getElementById("jumlahPilihan").value);
    var pilihanContainer = document.getElementById("pilihanContainer");
    
    // Clear previous inputs
    pilihanContainer.innerHTML = "";
    
    // Create input fields for choices
    for (var i = 1; i <= jumlahPilihan; i++) {
        var label = document.createElement("label");
        label.textContent = "Pilihan " + i + " : ";
        pilihanContainer.appendChild(label);
        
        var input = document.createElement("input");
        input.type = "text";
        input.name = "pilihan" + i;
        pilihanContainer.appendChild(input);
        pilihanContainer.appendChild(document.createElement("br"));
    }
    
    // Show the container
    pilihanContainer.style.display = "block";
});
var inputNama = document.querySelector('#name');
var inputPilihan = document.querySelector('#pilihan');
var container = document.querySelector('.contain')
const btn = document.querySelector('#btn');

var temp = [];
var pilihan;

btn.addEventListener('click', tombolTekan);

function tombolTekan() {
    var name = inputNama.value.trim();
    pilihan = inputPilihan.value;
    if (name == '' || pilihan == '') {
        alert('Form Tidak Boleh Kosong');
    } else {
        inputPilih();
    }
}

function inputPilih() {
    btn.remove();
    const element = document.querySelectorAll('.form-group')
    element.forEach(function(e) {
        e.parentNode.removeChild(e);
    });

    var batas = parseInt(inputPilihan.value.trim());
    for (let index = 0; index < batas; index++) {
        const pilih = document.createElement('div');
        pilih.classList.add('form-group');

        const label = document.createElement('label');
        label.textContent = 'Pilihan ' + (index + 1) + ':';
        label.setAttribute('for', 'pilihan_' + index);

        const input = document.createElement('input');
        input.type = 'text';
        input.setAttribute('id', 'pilihan_' + index);


        pilih.appendChild(label);
        pilih.appendChild(input);
        container.appendChild(pilih);
    }
    const ok = document.createElement('button');
    ok.type = 'SUBMIT';
    ok.setAttribute('id', 'btnOK');
    ok.textContent = 'OK';
    container.appendChild(ok);

    const okb = document.querySelector('#btnOK');
    okb.addEventListener('click', function(e) {
        const inp = document.querySelectorAll('[id^=pilihan]')
        for (let index = 0; index < inp.length; index++) {
            temp[index] = inp[index].value;

        }
        pilihPilihan(); 
        ok.disabled = true;
    });
}

function pilihPilihan() {
    const containDrop = document.createElement('div');
    containDrop.setAttribute('class', 'form-group');

    const pilihanLabel = document.createElement('label');
    pilihanLabel.textContent = 'Pilihan';
    pilihanLabel.setAttribute('for', 'pilihan');

    const pilihanSelect = document.createElement('select');
    pilihanSelect.setAttribute('id', 'pilihan');

    // Menggunakan pilihan yang disiapkan oleh pengguna
    for (let i = 0; i < temp.length; i++) {
        const optionElement = document.createElement('option');
        optionElement.textContent = temp[i];
        pilihanSelect.appendChild(optionElement);
    }

    containDrop.appendChild(pilihanLabel);
    containDrop.appendChild(pilihanSelect);
    container.appendChild(containDrop);

    const ok1 = document.createElement('button');
    ok1.type = 'submit';
    ok1.setAttribute('id', 'btn_ok');
    ok1.textContent = 'Submit';
    container.appendChild(ok1);

    const tombol_OK = document.querySelector('#btn_ok');
    tombol_OK.addEventListener('click', function(e) {
    const name = inputNama.value;
    const jmlpil = temp.length;
    var txtARy = '';

    for (let i = 0; i < temp.length; i++) {
        txtARy += temp[i];
        if (i !== temp.length - 1) {
            txtARy += ', ';
        }
    }

    const pilihan = document.getElementById('pilihan');
    const selectedPilihan = pilihan.value;
    const txt = "<p> Hallo, nama saya " + name + ", saya mempunyai sejumlah " + jmlpil + " pilihan yaitu " + txtARy + ", dan saya memilih " + selectedPilihan + "</p>";
    container.innerHTML = txt;
});

}

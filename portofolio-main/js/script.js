// init Isotope
var $grid = $(".collection-list").isotope({
  // options
});

// filter items on button click
$(".filter-button-group").on("click", "button", function () {
  var filterValue = $(this).attr("data-filter");
  resetFilterBtns();
  $(this).addClass("active-filter-btn");
  $grid.isotope({ filter: filterValue });
});

var filterBtns = $(".filter-button-group").find("button");
function resetFilterBtns() {
  filterBtns.each(function () {
    $(this).removeClass("active-filter-btn");
  });
}
/// Fungsi untuk melakukan pencarian item berdasarkan teks
function cariItem(teks) {
  // Ubah teks pencarian menjadi huruf kecil untuk pencocokan yang tidak peka terhadap besar kecilnya huruf
  var teksPencarian = teks.toLowerCase();
  
  // Dapatkan semua item koleksi
  var $itemKoleksi = $(".collection-list .col-md-6");
  
  // Loop melalui setiap item
  $itemKoleksi.each(function() {
    // Dapatkan teks dari setiap item
    var teksItem = $(this).text().toLowerCase();
    
    // Periksa apakah teks pencarian cocok dengan teks item
    if (teksItem.indexOf(teksPencarian) !== -1) {
      // Tampilkan item yang cocok
      $(this).show();
    } else {
      // Sembunyikan item yang tidak cocok
      $(this).hide();
    }
  });
  
  // Pindahkan fokus ke bagian koleksi setelah pencarian dilakukan
  $("#collection")[0].scrollIntoView({ behavior: 'smooth' });
}

// Event listener untuk saat pengguna mengetik pada input pencarian
$("#navbarSupportedContent").find('input[type="search"]').on("input", function() {
  // Dapatkan teks yang dimasukkan pengguna
  var teksPencarian = $(this).val();
  
  // Panggil fungsi pencarian
  cariItem(teksPencarian);
});

// Panggil fungsi pencarian saat halaman dimuat untuk menampilkan semua item secara default
$(document).ready(function() {
  cariItem(""); // Panggil dengan argumen kosong untuk menampilkan semua item
});







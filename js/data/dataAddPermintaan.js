$(document).ready(function () {
  loadData();

  function loadData() {
    let dataSelected = "";
    $("#nama_barang").on("change", function () {
      dataSelected = this.value;

      $.ajax({
        type: "POST",
        url: "./controller/permintaan/getGambar.php",
        data: {
          kode_barang: dataSelected,
        },
        success: function (response) {
          let pictureImage = $(".picture-image");
          pictureImage.html("");

          $.each(response, function (key, value) {
            let photoSrc = value.data.photo
              ? `./images/barang/${value.data.photo}`
              : "./images/barang/replika.png";

            pictureImage.append(`
                        <div class="card">
                            <div class="card-body card-body-replica">
                                <div class="picture-replica">
                                    <img src="${photoSrc}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>`);
          });
        },
      });
    });
  }
});

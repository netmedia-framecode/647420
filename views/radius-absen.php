<?php require_once("../controller/radius-absen.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Radius Absen";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
  </div>

  <?php if (mysqli_num_rows($views_radius_absen) == 0) { ?>
    <div class="row">
      <div class="col-lg-3">
        <div class="accordion" id="accordionExample" style="height: 140vh; overflow-y: auto;">
          <div class="card">
            <div class="card-header shadow" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Tambah Radius Absen
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <form action="" method="post">
                  <div class="form-group">
                    <label for="radius">Radius (meter)</label>
                    <input type="number" name="radius" class="form-control" id="radius" required>
                  </div>
                  <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" class="form-control" id="latitude" required>
                  </div>
                  <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" class="form-control" id="longitude" required>
                  </div>
                  <button type="submit" name="add" class="btn btn-primary btn-sm">Tambah</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div id="map" class="shadow" style="width: 100%; height: 500px;"></div>

        <script>
          var map = L.map('map').setView([-8.6870678, 122.1945125], 13);
          var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

          // Get coordinate location inputs
          var latInput = document.querySelector("[name=latitude]");
          var lngInput = document.querySelector("[name=longitude]");
          var curLocation = [-8.6870678, 122.1945125];

          map.attributionControl.setPrefix(false);

          var marker = L.marker(curLocation, {
            draggable: true,
          }).addTo(map);

          marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            marker.setLatLng(position, {
              draggable: true
            }).bindPopup(position).update();
            latInput.value = position.lat;
            lngInput.value = position.lng;
          });

          map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            if (!marker) {
              marker = L.marker(e.latlng, {
                draggable: true
              }).addTo(map);
            } else {
              marker.setLatLng(e.latlng);
            }
            latInput.value = lat;
            lngInput.value = lng;
          });
        </script>
      </div>
    </div>
  <?php } else {
    $data = mysqli_fetch_assoc($views_radius_absen); ?>
    <div class="row">
      <div class="col-lg-3">
        <div class="accordion" id="accordionExample" style="height: 140vh; overflow-y: auto;">
          <div class="card">
            <div class="card-header shadow" id="headingOne">
              <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Tambah Radius Absen
                </button>
              </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body">
                <form action="" method="post">
                  <div class="form-group">
                    <label for="radius">Radius (meter)</label>
                    <input type="number" name="radius" value="<?= $data['radius'] ?>" class="form-control" id="radius" required>
                  </div>
                  <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" value="<?= $data['latitude'] ?>" class="form-control" id="latitude" required>
                  </div>
                  <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" value="<?= $data['longitude'] ?>" class="form-control" id="longitude" required>
                  </div>
                  <button type="submit" name="edit" class="btn btn-warning btn-sm">Ubah</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-9">
        <div id="map" class="shadow" style="width: 100%; height: 500px;"></div>

        <script>
          var map = L.map('map').setView([-8.6870678, 122.1945125], 13);
          var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);

          // Get coordinate location inputs
          var latInput = document.querySelector("[name=latitude]");
          var lngInput = document.querySelector("[name=longitude]");
          var curLocation = [-8.6870678, 122.1945125];

          map.attributionControl.setPrefix(false);

          var marker = L.marker(curLocation, {
            draggable: true,
          }).addTo(map);

          marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            marker.setLatLng(position, {
              draggable: true
            }).bindPopup(position).update();
            latInput.value = position.lat;
            lngInput.value = position.lng;
          });

          map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;
            if (!marker) {
              marker = L.marker(e.latlng, {
                draggable: true
              }).addTo(map);
            } else {
              marker.setLatLng(e.latlng);
            }
            latInput.value = lat;
            lngInput.value = lng;
          });
        </script>
      </div>
    </div>
  <?php } ?>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>
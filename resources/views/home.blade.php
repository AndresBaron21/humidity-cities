<!DOCTYPE html>
<html>
<head>
 <title>Humidity Map</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map { 
         height: 400px; 
        }
        .custom-height {
         height: 300px;
         overflow-y: scroll;
        }
        .border {
         border-radius: 9px;
        }
        @import url('https://fonts.googleapis.com/css?family=Exo:400,700');

        *{
            margin: 0px;
            padding: 0px;
        }

        body{
            font-family: 'Exo', sans-serif;
        }


        .context {
            width: 100%;
            position: absolute;
            top:50vh;
            
        }

        .context h1{
            text-align: center;
            color: #fff;
            font-size: 50px;
        }


        .area{
         background: rgb(255,255,255);
         background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(0,38,255,1) 90%, rgba(255,255,255,1) 100%); 
         width: 100%;
        }

        .circles{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circles li{
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.2);
            animation: animate 25s linear infinite;
            bottom: -150px;
            
        }

        .circles li:nth-child(1){
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }


        .circles li:nth-child(2){
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3){
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4){
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5){
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6){
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7){
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8){
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9){
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10){
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @media (min-width: 768px) {
         .area{
          height: 120vh;
         }
        }
        @media (max-width: 767px) {
         
        }

        @keyframes animate {

            0%{
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }

            100%{
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }

        }

     
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>
 <div class="area" >
  <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
  </ul>
  <div class="container">
   <div class="row">
    <h2 class="col-md-8 col-sm-12 mt-4">Humidity Map</h2>
    <button onclick="location.reload()" type="button" class="btn btn-light col-md-4 col-sm-12 mt-4">Save to history</button>
    <div class="col-md-12 mt-4">
        <div id="map" class="border"></div>
    </div>
     <div class="col-md-6 col-sm-12 mt-4">
       <h2>Current Humidity Data</h2>
          <table class="table">
              <thead>
                  <tr>
                      <th>City</th>
                      <th>Humidity (%)</th>
                  </tr>
              </thead>
              <tbody>
                  @forelse ($humidityData as $city => $humidity)
                      <tr>
                          <td>{{ $city }}</td>
                          <td>{{ $humidity }}</td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="2">No data available</td>
                      </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
     <div class="col-md-6 col-sm-12 mt-4">
      <h2>Historical Data</h2>
       <div class="custom-height">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>City</th>
                    <th>Humidity (%)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($historicalData as $data)
                    <tr>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->city }}</td>
                        <td>{{ $data->humidity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No data available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
       </div>
     </div>
   </div>
 
  </div>
</div >
    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([25.7617, -80.1918], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18
        }).addTo(map);

        var markers = [
            { city: 'Miami', position: [25.7617, -80.1918], humidity: 80 },
            { city: 'Orlando', position: [28.5383, -81.3792], humidity: 70 },
            { city: 'New York', position: [40.7128, -74.0060], humidity: 60 }
        ];

        markers.forEach(function(markerData) {
            L.marker(markerData.position)
                .bindPopup(`<strong>${markerData.city}</strong><br>Humidity: ${markerData.humidity}%`)
                .addTo(map);
        });
    </script>


</body>
</html>

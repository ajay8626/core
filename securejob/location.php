<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDGF84XMdcGpo5P6V3Gq0Nscrvc_R1R9c0"></script>
<script type="text/javascript">

var geocoder = new google.maps.Geocoder();
var address = "new york";
//.console.log(geocoder);
geocoder.geocode( { 'address': address}, function(results, status) {

  if (status == google.maps.GeocoderStatus.OK) {
    var latitude = results[0].geometry.location.lat();
    var longitude = results[0].geometry.location.lng();
    console.log(latitude);
  } 
}); 
</script>
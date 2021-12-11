<template>
    <div>
        <gmap-map
        :center="center"
        :zoom="16"
        style="width:100%;  height: 400px;"
        :options="{
            zoomControl: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            rotateControl: false,
            fullscreenControl: true,
            disableDefaultUI: false
        }"
        @click="mark"
        >
        >
        <gmap-marker
            :key="index"
            v-for="(m, index) in markers"
            :position="m.position"
            @click="center=m.position"
        ></gmap-marker>
        </gmap-map>
  </div>
</template>

<script>
export default {
  name: "admMapAdmin",
  data() {
    return {
      center: { lat: 33.8122590630062, lng: -6.0823744986984085 },
      markers: [],
    };
  },
  props: {
      edit: {type: Boolean, default: false}
  },
  mounted() {
      if(this.edit){
          this.auto_geolocate()
      }else{
          this.geolocate()
      }
  },
    methods: {
        mark(event){
            const marker = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            };
            this.markers=[{ position: marker }];
            this.$emit('map', marker)
        },
        async auto_geolocate(){
            let location = null

            await axios.get('/my_location')
            .then(response => {

                if(response.status == 200){
                    location = {
                        lat : Number(response.data.lat),
                        lng : Number(response.data.long)
                    }
                }else{
                    navigator.geolocation.getCurrentPosition(position => {
                        location = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                    });
                }

                this.center = location;
                this.markers.push({ position: location });
                this.$emit('map', location)
            })
            .catch(error => {
                console.log(error);
            })
        },
        geolocate(){
            navigator.geolocation.getCurrentPosition(position => {
            const marker = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            this.center = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            this.markers.push({ position: marker });
            this.$emit('map', marker)
        });
        },
    },
};
</script>

<style lang="scss" scoped>

</style>
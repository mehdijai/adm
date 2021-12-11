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
    name: "admMapUser",
    data() {
        return {
            center: { lat: 33.82478817274051, lng: -6.082740006468199 },
            markers: [],
        };
    },
    props: {
        lat: Number,
        lng: Number
    },
    mounted() {
        this.geolocate();
    },

    methods: {
        geolocate: function() {
            const marker = {
                lat: this.lat,
                lng: this.lng
            };
            this.center = {
                lat: this.lat,
                lng: this.lng
            };
            this.markers = [{ position: marker }];
        }
    }
};
</script>

<style lang="scss" scoped>

</style>
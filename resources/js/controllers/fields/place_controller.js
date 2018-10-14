import {Controller} from 'stimulus';

export default class extends Controller {
    /**
     *
     */
    connect() {

        const slug = this.data.get('slug');
        const key = this.data.get('key');

        window.loadGoogleMaps = {
            "load": () => {
                if (window.google === undefined || window.google.maps === undefined) {
                    window.loadGoogleMaps.status = true;
                    $.getScript(`https://maps.googleapis.com/maps/api/js?libraries=places&key=${key}`, () => {
                        document.documentElement.dispatchEvent(new Event("googleMapsLoad"));
                    });

                }
            },
            "status": false
        };


        if (!window.loadGoogleMaps.status) {
            window.loadGoogleMaps.load();
        }

        document.addEventListener('turbolinks:load', () => {
            if (!window.loadGoogleMaps.status) {
                window.loadGoogleMaps.load();
            }
        });


        document.documentElement.addEventListener('googleMapsLoad', () => {
            const input = document.getElementById(`place-${slug}`);
            const autocomplete = new google.maps.places.Autocomplete(input);


            autocomplete.addListener('place_changed', () => {
                const cors = autocomplete.getPlace().geometry.location;
                $(`#lat-${slug}`).val(cors.lat());
                $(`#lng-${slug}`).val(cors.lng());
            });


            $(`#map-place-${slug}`).on('show.bs.modal', () => {


                setTimeout(() => {
                    const myLatLng = {
                        lat: parseFloat($(`#lat-${slug}`).val()),
                        lng: parseFloat($(`#lng-${slug}`).val())
                    };

                    const map = new google.maps.Map(document.getElementById(`map-place-${slug}-canvas`), {
                        center: myLatLng,
                        zoom: 12
                    });

                    new google.maps.Marker({
                        map,
                        position: myLatLng,
                        title: $(`#place-${slug}`).val()
                    });

                }, 300);


            });

        });


    }
}

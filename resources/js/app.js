const { default: axios } = require('axios');
require('./bootstrap');
window.Vue = require('vue').default;

   
window.onscroll = function() {
    let mybutton = document.getElementById('to-top')

    if (document.body.scrollTop > 500 || document.documentElement.scrollTop > 500) {
        mybutton.style.display = 'flex';
    } else {
        mybutton.style.display = 'none';
    }
};

document.getElementById('to-top').addEventListener('click', (e) => {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
})

if (process.env.MIX_ENV_MODE === 'production') {
    Vue.config.devtools = false;
    Vue.config.debug = false;
    Vue.config.silent = true; 
}

/* ---- Google Maps ---- */
import * as VueGoogleMaps from "vue2-google-maps";

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyBKUcb6MiVd-t00ppccFkIgo4FPL_wwfAI",
    region: "MA"
  }
});

/* ---- USER ---- */
import admUserMap from './components/mapUser'
/* ---- AGENCE ---- */
import admAdminMap from './components/mapAdmin'

/* ---- Google Maps ---- */

const adminMap = new Vue({
    el: '#admin-map',
    components: {
        admAdminMap
    },
    data() {
        return {
            locSaved: false,
            savedKey: 0,
        }
    },
    methods: {

        getLocation(location){
            Livewire.emit('getLocationForInput', JSON.stringify({
                lat: location.lat,
                long: location.lng
            }))
        },
    }
});

const userMap = new Vue({
    el: '#user-map',
    components: {
        admUserMap
    }
});

const register = new Vue({
    el: '#register-form',
    data() {
        return {
            cities: [],
            secteurs: [],
            city: "",
            secteur: "",
            match_c: [],
            match_s: [],
        }
    },
    components: {
        admAdminMap,
    },
    mounted() {
        this.getCitiesSecteurs()
    },
    methods: {
        
        async getLocation(location){
            await this.setLocationJSON(location)
        },
        setLocationJSON(location){
            document.getElementById('map_locale').value = JSON.stringify({
                lat: String(location.lat),
                long: String(location.lng)
            })
        },
        getCitiesSecteurs(){
            axios.get('/api/cities')
            .then((response) => {
                this.cities = Object.values(response.data.cities)
                this.secteurs = Object.values(response.data.secteurs)
            })
            .catch((err) => {
                console.log(err);
            })
        },
        optimizeArr(list, size = 2){
            return list.slice(0, size)
        },
        autocomplete_c(){

            this.match_c = this.optimizeArr(
                this.cities.filter((db_city) => {
                    return db_city.toLowerCase().includes(this.city.toLowerCase())
                })
            )
        },
        autocomplete_s(){
            this.match_s = this.optimizeArr(
                this.secteurs.filter((db_secteur) => {
                    return db_secteur.toLowerCase().includes(this.secteur.toLowerCase())
                })
            )
        },
        setC(match){
            
            this.city = match
            this.match_c = []
        },
        setS(match){
            this.secteur = match
            this.match_s = []
        }
    },
});

const addVeh = new Vue({
    el: '#vehs-form',
    data() {
        return {
            marques: [],
            gammes: [],
            ac_options: [],
            match_m: [],
            match_g: [],
            match_o: [],
            options: [],
            marque: "",
            gamme: "",
            option: "",
            g_el: null,
            m_el: null,
            o_el: null,
            matinfo: false,

            /* DropZone */
            active: false, 
            dropzoneFiles: [],
            activeimg: null,
            errors: [],
            showAction: null,
            /* DropZone */

            defaults: [],
            oldImgs: [],
            oldOpts: [],
            changed: false,
            deleted_images: [],
            form_type: "",
            thumbnail_changed: false,
            to_upload: [],
        }
    },
    mounted() {
        this.getMarquesGammes()
        this.getOptions()

        if(document.getElementById('route-link')){
            this.form_type = document.getElementById('route-link').value
        }

        if(this.form_type.includes("update")){

            this.setOldImages()
            this.setOldOptions()
            this.setDefaults()
            document.getElementById('submit-create').disabled = !this.changed

            let reqs = document.getElementById("vehs-form").querySelectorAll("[required]")

            reqs.forEach(element => {
                element.addEventListener('change', (e) => {
                    this.check_change(e.target.name, e.target.value)
                })
            });
        }
        
    },
    methods: {
        setDefaults(){
            let requireds = document.getElementById("vehs-form").querySelectorAll("[required]")
            
            requireds.forEach(element => {
                let key = element.name
                let val = element.value
                this.defaults[key] = val
            });

            this.defaults.options = this.oldOpts
            this.defaults.images = this.oldImgs
            this.oldImgs.forEach(img => {
                if(img.is_thumbnail){
                    this.defaults.thumbnail = img.id
                }
            })
        },
        check_attachements(){
            
            let to_existed = null
            let data = null

            if(this.thumbnail_changed){

                for (let index = 0; index < this.dropzoneFiles.length; index++) {
                    if(this.dropzoneFiles[index].is_thumbnail){
                        if(("file" in this.dropzoneFiles[index])){
                            to_existed = false
                            data = index
                        }else{
                            to_existed = true
                            data = this.dropzoneFiles[index].url
                        }
                    }
                }
            }

            return {to_existed: to_existed, data: data}
        
        },
        check_change(item, value){
            
            if(!this.form_type.includes("update")){
                return 0
            };

            let def = this.defaults[item]
            let tmp_changed = false

            if(item == 'options'){

                if(def.length != value.length){
                    tmp_changed = true
                }else{
                    tmp_changed = false
                    for (let i = 0; i < def.length; i++) {
                        for (let j = 0; j < value.length; j++) {
                            if(value[j] != def[i]) tmp_changed = true
                        }
                    }
                }

                if(this.changed == false) this.changed = tmp_changed

                return false
            }

            if(item == 'images'){

                /* thumbnail changed */
                
                for (let i = 0; i < def.length; i++) {
                    for (let j = 0; j < value.length; j++) {
                        if(value[j].is_thumbnail != def[i].is_thumbnail) {
                            tmp_changed = true
                        }
                    }
                }

                /* image deleted or new image added */
                if(def.length != value.length){
                    tmp_changed = true
                }

                if(this.changed == false) this.changed = tmp_changed
                
                return false
            }

            if(this.defaults[item] != value){
                this.changed = true
            }else{
                this.changed = false
            }
        },
        setOldOptions(){
            let oldOptions = document.getElementById('old_options').value
            let optArr = JSON.parse(oldOptions)
            this.oldOpts = optArr
            this.options.push(...optArr)
        },
        setOldImages(){
            let oldImages = document.getElementById('old_images').value
            let imgsArr = JSON.parse(oldImages)

            imgsArr.forEach(img => {
                img.id = this.makeid()
                if(img.is_thumbnail == 1){
                    img.is_thumbnail = true
                    this.activeimg = img.id
                }else{
                    img.is_thumbnail = false
                }
            });

            this.oldImgs = imgsArr
            this.dropzoneFiles.push(...imgsArr)
        },
        load(loading){
            document.getElementById('submit-create').disabled = loading
        },
        /* DropZone */
        toggleActive() {
            this.active = !this.active;
        },
        set_thumbnail(id){
            this.activeimg = id
        
            this.dropzoneFiles.map(file => {
                file.is_thumbnail = false
                return file
            })

            for (let index = 0; index < this.dropzoneFiles.length; index++) {
                if(this.dropzoneFiles[index].id == id){
                    this.dropzoneFiles[index].is_thumbnail = true
                }
            }

            if(this.defaults.thumbnail != id){
                this.thumbnail_changed = true
            }else{
                this.thumbnail_changed = false
            }

            this.check_change("images", this.dropzoneFiles)

        },
        remove(id){
            let file_index = null

            for (let index = 0; index < this.dropzoneFiles.length; index++) {
                if(this.dropzoneFiles[index].id == id){
                    file_index = index
                }
            }

            if(file_index != null){

                if(this.dropzoneFiles[file_index].id == this.activeimg){
                    this.activeimg = null
                }

                if(!("file" in this.dropzoneFiles[file_index])){
                    this.deleted_images.push(this.dropzoneFiles[file_index])
                }
                this.dropzoneFiles.splice(file_index, 1)
            }

            this.check_change("images", this.dropzoneFiles)
        },
        drop(e){
            this.toggleActive()
            this.getFilesData(e.dataTransfer.files)
            this.check_change("images", this.dropzoneFiles)
        },
        selectedFile(e){
            this.getFilesData(e.target.files)
            this.check_change("images", this.dropzoneFiles)
        },
        getFilesData(files){
    
            for (let index = 0; index < files.length; index++) {
                let id = this.makeid();
                if(this.validate(files[index])){
        
                this.dropzoneFiles.push({
                    id: id,
                    url: URL.createObjectURL(files[index]),
                    file: files[index],
                    is_thumbnail: false
                });
                }
            }
        
            if(this.activeimg == null && this.dropzoneFiles.length > 0){
                this.activeimg = this.dropzoneFiles[0].id
                this.dropzoneFiles[0].is_thumbnail = true
            }
        
        },
        makeid(length=20) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        },
        validate(file){
            const acceptedTypes = ['png', 'jpg','jpeg']
        
            let accepted = false
        
            acceptedTypes.forEach(tp => {
                if(file.type == tp){
                accepted = true
                this.errors.push('Le fichier "' + file.name + '" n\'est pas une image')
                }
            });
        
            if(file.size <= 5000000){
                accepted = true
            }else{
                accepted = false
                this.errors.push('Le fichier "' + file.name + '" a exité la taille maximum de l\'image; 5 MB')
            }
        
            return accepted    
        },

        /* DropZone */

        submitform(){

            if(this.formValid()){
                this.load(true)

                let to_existed = null
                let data = null

                let formdata = new FormData()

                document.getElementById("vehs-form").querySelectorAll("[required]").forEach(element => {
                    formdata.append(element.name, element.value)
                });

                if(this.form_type.includes('update')){
                    if(this.check_attachements()){
                        to_existed = this.check_attachements().to_existed
                        data = this.check_attachements().data
                    }

                    for (let index = 0; index < this.dropzoneFiles.length; index++) {
                        if(("file" in this.dropzoneFiles[index])){
                            formdata.append('files[' + index + ']', this.dropzoneFiles[index].file)
                        }
                    }

                    switch(to_existed){
                        case true: 
                            formdata.append('thumb_type', "existed")
                            formdata.append('thumb', data)
                            break;
                        case false: 
                            formdata.append('thumb_type', "new")
                            formdata.append('thumb', data)
                            break;
                        case null: 
                            formdata.append('thumb_type', "not_changed")
                            formdata.append('thumb', data)
                            break;
                    }
    
                    for (let index = 0; index < this.deleted_images.length; index++) {
                        formdata.append('deleted_images[' + index + ']', this.deleted_images[index].url)
                    }

                    formdata.append('id', document.getElementById('veh-id').value)
                }else{
                    for (let index = 0; index < this.dropzoneFiles.length; index++) {
                        formdata.append('files[' + index + ']', this.dropzoneFiles[index].file)
                    }
                    for (let index = 0; index < this.dropzoneFiles.length; index++) {
                        formdata.append('isthumb[' + index + ']', this.dropzoneFiles[index].is_thumbnail)
                    }
                }

                formdata.append('options', JSON.stringify(this.options))
                
                let config = {
                    headers : {
                        'Content-Type' : 'multipart/form-data',
                        'X-CSRF-TOKEN' : document.head.querySelector("[name=csrf-token]").content
                    }
                }

                let routeLink = this.form_type
                
                if(routeLink != null && routeLink != ""){
                    axios.post(routeLink, formdata, config)
                    .then(response => {
                        if(response.data.error){
                            /* Alerts */
                            let element = document.getElementById("matricule")
                            this.setErrorInput(element, response.data.error)
                            this.load(false)
                        }

                        if(response.data.redirect){
                            /* Redirect */
                            window.location.replace(response.data.redirect);
                        }
                    })
                    .catch(error => {
                        this.load(false)
                        console.log(error);
                        // alert("Il y avait un problème ! merci de rafraîchir la page et de réessayer.")
                    })
                }
            }
            
        },
        formValid(){
            let required = document.getElementById("vehs-form").querySelectorAll("[required]")
            let valid = true
            let firstInvalid = null

            required.forEach(element => {
                if(element.value == ""){
                    valid = false
                    if(!firstInvalid){
                        firstInvalid = element
                    }
                }
            });

            if(this.dropzoneFiles.length < 5){
                valid = false
                if(!firstInvalid){
                    this.errors.push('Vous devez choisir au minimum 5 images')
                    firstInvalid = document.getElementById('dropzonediv')
                }
            }

            /* Set Alert */
            if(firstInvalid){
                this.setErrorInput(firstInvalid)
            }

            return valid
        },
        setErrorInput(element, message = "ce champ est obligatoire!"){
            let errText = document.createElement('span')
            errText.classList.add('error-message')
            errText.innerHTML = message
            element.parentNode.insertBefore(errText, element.nextSibling);
            element.classList.add('input-error')
            element.scrollIntoView()

            setTimeout(() => {
                element.classList.remove('input-error')
                element.parentNode.removeChild(errText)
                this.errors = []
            }, 5000);
        },
        openinfo(){
            this.matinfo = true
        },
        closeinfo(){
            this.matinfo = false
        },
        getMarquesGammes(){
            axios.get('/api/marques')
            .then((response) => {
                this.marques = Object.values(response.data.marques)
                this.gammes = Object.values(response.data.gammes)
            })
            .catch((err) => {
                console.log(err);
            })
        },
        getOptions(){
            axios.get('/api/options')
            .then((response) => {
                this.ac_options = Object.values(response.data.options)
            })
            .catch((err) => {
                console.log(err);
            })
        },
        optimizeArr(list, size = 2){
            return list.slice(0, size)
        },
        autocomplete_m(e){
            this.m_el = e.target
            this.marque = e.target.value

            this.match_m = this.optimizeArr(
                this.marques.filter((db_city) => {
                    if(this.marque != ""){
                        return db_city.toLowerCase().includes(this.marque.toLowerCase())
                    }
                })
            )
        },
        autocomplete_g(e){
            this.g_el = e.target
            this.gamme = e.target.value

            this.match_g= this.optimizeArr(
                this.gammes.filter((db_secteur) => {
                    if(this.gamme != ""){
                        return db_secteur.toLowerCase().includes(this.gamme.toLowerCase())
                    }
                    
                })
            )
        },
        autocomplete_o(){

            this.match_o= this.optimizeArr(
                this.ac_options.filter((db_secteur) => {
                    if(this.option != ""){
                        return db_secteur.toLowerCase().includes(this.option.toLowerCase())
                    }
                    
                })
            )
        },
        setM(match){
            this.m_el.value = match
            this.match_m = []
        },
        setG(match){
            this.g_el.value = match
            this.match_g = []
        },
        setO(match){
            this.option = match
            this.addOption()
            this.match_o = []
        },
        addOption(){
            if(this.option != ""){
                this.options.push(this.option)
                this.option = ""

                this.check_change("options", this.options)
            }
        },
        deleteOption(option){
            let index = this.options.indexOf(option)
            if (index > -1) {
                this.options.splice(index, 1);
                this.check_change("options", this.options)
            }
        },
    },
    computed: {
        opts(){
            return JSON.stringify(this.options)
        },
        
    },
    watch: {
        "changed" (to) {
            document.getElementById('submit-create').disabled = !to
        }
    }
});
<x-app-layout>

    @section('title', 'Ajouter véhicule')

    <div class="auth-page" id="vehsAdd">

        <div class="auth-form">
            <span class="h1 text-center">
                Ajouter une véhicule
            </span>

            <x-jet-validation-errors class="error-status" />

            <form id="vehs-form" class="filter-form" ref="createform">
                
                @csrf

                <input type="hidden" id="route-link" value="{{$form_type}}">
                <input type="hidden" required name="user_id" value="{{$user_id}}">

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="VehiculeClass">Voiture / Minibus</x-jet-label>
                    <select required id="VehiculeClass" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="VehiculeClass">
                        <option value="" selected>Voiture ou Minibus?</option>
    
                        @foreach ($types as $type)
                            <option value="{{$type}}">{{ucfirst($type)}}</option>
                        @endforeach
    
                    </select>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="marque" value="La marque" />
                    <x-jet-input v-on:keyup="autocomplete_m" id="marque" placeholder="Peugeot" type="text" name="marque" :value="old('marque')" required autocomplete="off" />
                    
                    <div class="autocomplete">
                        <span v-for = "(match, index) in match_m" :key="'m' + index" v-on:click = "setM(match)">@{{match}}</span>
                    </div>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="gamme" value="La gamme" />
                    <x-jet-input v-on:keyup="autocomplete_g" id="gamme" placeholder="305" type="text" name="gamme" :value="old('gamme')" required autocomplete="off" />
                    
                    <div class="autocomplete">
                        <span v-for = "(match, index) in match_g" :key="'g' + index" v-on:click = "setG(match)">@{{match}}</span>
                    </div>
                </div>
    
                <div class="filter-inputs" >
                    <div class="flex align-center">
                        <x-jet-label class="labels wight-500 color-blue" for="matricule" value="{{ __('Matricule') }}" />

                        <div class="MatInfo">
                            <x-heroicon-o-information-circle id="infoBtn" class="ml-2 mb-1 color-blue cursor-pointer x-icon" @mouseover="openinfo" @mouseleave="closeinfo"/>

                            <div class="list" v-if="matinfo">
                                <ul>
                                    <li>
                                        <span>أ : A </span>
                                    </li>
                                    <li>
                                        <span>ب : B </span>
                                    </li>
                                    <li>
                                        <span>د : C </span>
                                    </li>
                                    <li>
                                        <span>هـ : D </span>
                                    </li>
                                    <li>
                                        <span>و : E </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                    
                    <x-jet-input id="matricule" placeholder="exemple: 15 B 26560" type="text" name="matricule" :value="old('matricule')" required autocomplete="off" />
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="prix" value="{{ __('Prix') }}" />
                    <x-jet-input id="prix" placeholder="Prix juste en nombre: 250, 300..." type="number" name="prix" :value="old('prix')" required autocomplete="off" />
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="assurance">Type d'assurance</x-jet-label>
                    <select required id="assurance" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="assurance">
                        <option value="" selected>Type d'assurance</option>
                        @foreach ($asss as $ass)
                            <option value="{{$ass}}">{{ucfirst($ass)}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="carb">Type de carburant</x-jet-label>
                    <select required id="carb" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="carb">
                        <option value="" selected>Type de carburant</option>
                        @foreach ($carbs as $carb)
                            <option value="{{$carb}}">{{ucfirst($carb)}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-inputs">
                    <x-jet-label class="labels wight-500 color-blue" for="bdv">Type de boite de vitesse</x-jet-label>
                    <select required id="bdv" class="w-full focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-sm bgc-white-full inputTxt" name="bdv">
                        <option value="" selected>Type de boite de vitesse</option>
                        @foreach ($bdvs as $bdv)
                            <option value="{{$bdv}}">{{ucfirst($bdv)}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-inputs" id="description">
                    <x-jet-label class="labels wight-500 color-blue" for="desc" value="Déscription" />
                    <x-jet-input id="desc" placeholder="Décrire l'offre ou la véhicule" type="text" name="desc" required/>
                </div>
                
                <div class="filter-options">

                    <div class="filter-inputs">
                        <x-jet-label class="labels wight-500 color-blue" for="options">Options</x-jet-label>
                        <div class="flex align-center">
                            <x-jet-input v-model="option" v-on:keyup="autocomplete_o" id="options" placeholder="Ajouter des options (multiple)" type="text" name="options" />
                            
                            <div @click="addOption" class="iconBtn ml-2">
                                <x-heroicon-s-plus class="icon" />
                            </div>

                        </div>

                        <div class="autocomplete">
                            <span v-for = "(match, index) in match_o" :key="'o' + index" v-on:click = "setO(match)">@{{match}}</span>
                        </div>
                        
                    </div>
    
                    <input v-model="opts" type="hidden" name="options">
    
                    <div v-for="(option, index) in options" class="option bgc-blue hover" :key="index">
                        <span class="optionTxt color-white label">@{{option}}</span>
                        <x-heroicon-s-x-circle v-on:click="deleteOption(option)" class="icon color-white hover"/>
                    </div>
                </div>

                <div class="filter-submit">
                    
                    {{-- <drop-zone @images-selected="setFiles"/> --}}

                    <div class="flex flex-column image-container">
                        <span class="title color-blue mb-1">
                          Images
                        </span>
                    
                        <span class="paragraph mb-1">
                          Sélectionnez l'image qui apparaîtra en premier en cliquant dessus 
                        </span>

                        <span class="paragraph mb-3">
                          Séléctionnez au minimum 5 images
                        </span>
                    
                        <div class="errors" v-if="errors.length > 0">
                          <ul>
                            <li v-for="(error, index) in errors" :key="'li-' + index">@{{error}}</li>
                          </ul>
                        </div>
                    
                        <div
                            @dragenter.prevent="toggleActive"
                            @dragleave.prevent="toggleActive"
                            @dragover.prevent
                            @drop.prevent="drop"
                            :class="{ 'active-dropzone': active }"
                            class="dropzone" id="dropzonediv"
                        >
                          <div v-if="dropzoneFiles.length > 0" class="thumbnails">
                              <div class="thumbnail" v-for="(file, index) in dropzoneFiles" @mouseenter="showAction = index" @mouseleave="showAction = null" :class=" (file.id == activeimg) ? 'active' : ''" :key="index">
                                  <img :src="file.url">
                                  
                                  <div v-if="showAction == index" class="actions">
                                    <span class="actionBtn" @click="remove(file.id)">Supprimer</span>
                                    <span class="actionBtn" @click="set_thumbnail(file.id)">Pricipale</span>
                                  </div>
                              </div>
                          </div>
                    
                          <div v-else class="flex flex-column justify-center items-center">
                            <span>Drag or Drop Fichiers</span>
                            <span>Ou</span>        
                          </div>
                    
                            <label class="fileBtn" for="dropzoneFile">Séléctioner des images</label>
                            <input type="file" @change="selectedFile" id="dropzoneFile" ref="files" accept="image/*" multiple class="dropzoneFile" />
                        </div>
                    
                    </div>
                </div>

                <div class="filter-submit">

                    <div class="btnCnt">
                        <x-jet-button id="submit-create" type="button" @click="submitform" class="buttonTxt">Ajouter la véhicule</x-jet-button>
                        <x-jet-secondary-button type="button" class="buttonTxt"><a href="{{url()->previous()}}">Annuler</a></x-jet-secondary-button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>

</x-app-layout>

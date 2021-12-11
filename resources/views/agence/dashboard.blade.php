<x-app-layout>

    @section('title', 'Mes véhicules')

    <div class="row vehicules bgc-white-lighter">
    
        @foreach ($vehicules as $vehicule)
            <div align="center">
                    
                <div class="car-card bgc-white">

                    <div class="cc-name" align="left">
                        <span class="card-name color-black">{{ucfirst($vehicule->marque->marque . ' ' . $vehicule->marque->gamme)}}</span>
                        <div class="settings" 
                        x-data="{open: false}" @click.away="open = false" @close.stop="open = false">
                            <div id="s-trigger" @click="open = ! open">
                                <x-heroicon-s-dots-horizontal class="icon" />
                            </div>
                            <input type="hidden" id="vehicule-id" value="{{$vehicule->id}}">
                            <div id="s-list"
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            style="display: none;"
                            @click="open = false">
                                <div class="item">
                                    <form method="POST" action="{{route('vehs.delete')}}" onsubmit="return confirm('Si vous confirmez la suppression, vous perdrez les données de ce véhicule!')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$vehicule->id}}">
                                        <button style="background-color: transparent; padding:0; margin:0;" type="submit" id="delete-btn" class="color-black navLinks">Supprimer</button>
                                    </form>
                                </div>
                                <div class="item" onclick="window.open('/vehs/edit/' + {{$vehicule->id}}, '_self')">
                                    <span class="color-black navLinks">Modifer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="cc-img" onclick="window.open('/veh/' + {{$vehicule->id}}, '_self')">
                        <img src="{{$vehicule->pics()->where('is_thumbnail', true)->get()[0]->image_path}}" alt="{{ucfirst($vehicule->marque->marque . ' ' . $vehicule->marque->gamme)}}">
                    </div>
                
                    <div class="cc-footer">
                
                        <div class="cc-city">
                            <span class="card-city color-black">{{ucfirst($vehicule->agence->city->city . ' - ' . $vehicule->agence->city->secteur)}}</span>
                        </div>
                
                        <div class="cc-price">
                            <span class="card-price color-red">{{$vehicule->prix}} Dhs</span>
                        </div>
                
                    </div>
                </div>
            </div>
    
        @endforeach
 
    </div>
    <div>
        {{$vehicules->links()}}
    </div>

    @if (count($vehicules) === 0)
        <div class="no-result text-center w-100">
            <span class="h1">Vous n'avez pas encore des véhicules</span>
            <x-jet-button onclick="window.open( '{{route('vehs.create')}}' , '_self')" class="buttonTxt mt-2">Ajouter des véhicules</x-jet-button>
        </div>
    @else
        <span class="addVeh" onclick="window.open( '{{route('vehs.create')}}' , '_self')">
            <x-heroicon-s-view-grid-add class="icon" />
        </span>
    @endif

    {{-- <script>

        let modalDelete = document.getElementById('delete-modal')
        let deleteBtn = document.getElementById('delete-btn')
        let deleteConfirm = document.getElementById('delete-confirm')
        let deleteCancel = document.getElementById('delete-cancel')
        let vehiculeId = document.getElementById('vehicule-id')
        let idInput = document.getElementById('id-input')
    
        deleteBtn.addEventListener('click', () => {
            idInput.value = vehiculeId.value
            modalDelete.style.display = "flex"
        })
    
        deleteCancel.addEventListener('click', () => {
            idInput.value = ""
            modalDelete.style.display = "none"
        })
    
    </script> --}}

</x-app-layout>


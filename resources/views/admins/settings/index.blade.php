<x-app-layout>

    @section('title', 'Settings')


    <div class="admin-layout">
        <div class="header">
            <span class="h1 color-red weight-700">Settings</span>
        </div>

        <div class="settings-container">
            <div class="list table-list">
                <table class="content">
                    <thead>
                        <td>Type</td>
                        <td>Name</td>
                        <td>Value</td>
                    </thead>
                        @php

                            $providers = $settings_list->getProvider();
                            $contacts = $settings_list->getContact();

                        @endphp
                        @while ($provider = current($providers))
                        <tr x-data='{open: false, val: "{{$provider}}", 
                            save(){
                                this.$refs.provider_form.submit()
                            },
                        }'>
                            @if ($provider == array_values($providers)[0])
                                <td rowspan="{{count($providers)}}">Bank Provider</td>
                            @endif
                            <td>{{key($providers)}}</td>
                            <td>
                                <form x-show="open" x-ref="provider_form" action="{{route('admin.settings.providers')}}" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <input type="hidden" name="provider-name" value="{{key($providers)}}">
                                    <input type="text" x-model="val" name="provider-data">
                                    <span @click="save()" class="btn bgc-success color-white">Save</span>
                                    <span @click="open = false" class="btn bgc-info color-white">Cancel</span>
                                </form>
                                <span x-show="!open">
                                    {{$provider}}
                                </span>    
                            </td>
                            <td>
                                <x-heroicon-s-pencil-alt x-show="!open" @click="open = true"  class="icon color-info"/>
                            </td>
                        </tr>

                        @php
                            next($providers);
                        @endphp
                        @endwhile
                        @while ($contact = current($contacts))
                        <tr x-data='{open: false, val: "{{$contact}}", 
                            save(){
                                this.$refs.contact_form.submit()
                            },
                        }'>
                            @if ($contact == array_values($contacts)[0])
                                <td rowspan="{{count($contacts)}}">Contacts</td>
                            @endif
                            <td>{{key($contacts)}}</td>
                            <td class="contact-value">
                                <form x-show="open" x-ref="contact_form" action="{{route('admin.settings.contacts')}}" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <input type="hidden" name="contact-name" value="{{key($contacts)}}">
                                    <input type="text" x-model="val" name="contact-data">
                                    <span @click="save()" class="btn bgc-success color-white">Save</span>
                                    <span @click="open = false" class="btn bgc-info color-white">Cancel</span>
                                </form>
                                <span x-show="!open">
                                    {{$contact}}
                                </span>
                            </td>
                            <td>
                                <x-heroicon-s-pencil-alt x-show="!open" @click="open = true" class="icon color-info"/>
                            </td>
                        </tr>

                        @php
                            next($contacts);
                        @endphp
                        @endwhile
                </table>
            </div>

            <div>

                <div class="tags" x-data="{mod: false}">
                    <div class="parameter">
                        <div x-show="!mod" class="display">
                            <div class="header">
                                <span class="title color-red">External tags</span>
                                <x-heroicon-s-pencil-alt class="icon color-info" @click="mod = true" />
                            </div>
                            <div class="data">
                                <code>{{$tags}}</code>
                            </div>
                        </div>

                        <div x-show="mod" class="edit">

                            <div class="header">
                                <span class="title color-red">External tags</span>
                                <x-heroicon-o-x class="icon color-info" @click="mod = false" />
                            </div>
                            <form method="POST" action="{{route('admin.settings.tags')}}">
                                @csrf
                                <textarea name="tags" rows="10" required autofocus>{{$tags}}</textarea>
                                <button type="submit" class="btn bgc-success color-white-lighter weight-600">Save</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
                    
                <div class="settings">

                    @foreach ($settings as $set)
                    
                    <div class="parameter" id="param-type" x-data="{edit: null,ctype: '', types: {{ $set->data }},
                        addToTypes(){
                            if(this.ctype != ''){
                                this.types.push(this.ctype)
                                this.ctype = ''
                                document.getElementById('{{$set->name}}-json').value = JSON.stringify(this.types)
                            }

                        },
                        deleteType(type){
                            if(this.type != ''){
                                let index = this.types.indexOf(type)
                                if (index > -1) {
                                    this.types.splice(index, 1);
                                }
                                document.getElementById('{{$set->name}}-json').value = JSON.stringify(this.types)
                            }
                        },
                        submitForm(){
                            document.getElementById('{{$set->name}}-form').submit();
                        },
                    }">
                        <div x-show="edit!='type'" class="display">
                            <div class="header">
                                <span class="title color-red">{{$set->name}}</span>
                                <x-heroicon-s-pencil-alt class="icon color-info" @click="edit = 'type'" />
                            </div>
                            <div class="data">
                                <template x-for="type in types">
                                    <span class="item"> <span x-text="type"></span></span>
                                </template>
                            </div>
                        </div>
                        <div x-show="edit=='type'" class="edit">

                            <form method="POST" action="{{route('admin.settings.update')}}" id="{{$set->name}}-form">
                                @csrf
                                <input type="hidden" name="name" value="{{$set->name}}">
                                <input type="hidden" id="{{$set->name}}-json" name="data" value="{{ $set->data }}">
                            </form>

                            <div class="header">
                                <span class="title color-red">{{$set->name}}</span>
                                <span @click="submitForm()" class="btn bgc-success color-white">Save</span>
                                <span @click="edit = null" class="btn bgc-info color-white">Cancel</span>
                            </div>
                            <div class="form">
                                <x-jet-label class="labels wight-500 color-blue" for="settings-type" value="{{ __('Add a new one') }}" />
                                <div class="flex">
                                    <x-jet-input x-model="ctype" id="inp" placeholder="Add new type" id="settings-type" type="text" name="settings-type" required autofocus autocomplete="off" />
                                    <span @click="addToTypes" id="add-type">Add <x-heroicon-s-plus class="icon ml-1"/></span>
                                </div>
                                <div class="data">
                                    <template x-for="type in types">
                                        <span class="item"> <span x-text="type"></span> <x-heroicon-s-x-circle @click="deleteType(type)" class="icon ml-1 color-danger hover"/> </span>
                                    </template>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
        
    </div>
</x-app-layout>

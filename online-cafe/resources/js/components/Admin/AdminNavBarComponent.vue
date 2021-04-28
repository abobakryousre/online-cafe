<template>
     <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm mb-5">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto " >
                        <li class="p-2">
                            <router-link to="/home" class="navbar-brand links">online-cafe</router-link>
                        </li >
                        <li class="p-2">
                            <router-link to="/home" class="navbar-brand links">Home</router-link>
                        </li>
                        <li class="p-2">
                            <router-link :to="{name: 'allProducts'}" class="navbar-brand links">Products</router-link>
                        </li>
                        <li class="p-2">
                            <router-link :to="{name: 'alluser'}" class="navbar-brand links">Users</router-link>
                        </li>

                        <li class="p-2">
                            <router-link to="/checks" class="navbar-brand links">Checks</router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <img  v-if="expression==true" :src="user.avatar " :alt=" user.name "  style=" width: 25%; margin-left: 100%; " />
                            <img  v-if="expression==false" :src="imageServerURL+user.avatar " :alt=" user.name " style="    width: 25%; margin-left: 100%; "/>
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" style="margin-left: 100%;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >{{ user.name}}</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="left: 100%;">
                                <a class="dropdown-item" href="/logout" @click.prevent="logout()">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </nav>

        <div class="container">
            <router-view col-md-12></router-view>
        </div>
</template>
<script>
import urls from '../services/apiURLs' ; 
import axios from 'axios';
axios.defaults.withCredentials =true;
axios.defaults.baseURL = 'http://localhost:8000';

export default {
    data() {
        return {
        //    user:null,
           expression :true,
           imageServerURL:'',
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(res => {
                window.location = "/"
                }).catch(err =>console.error(err));
        },
    },
    props: ['user'],
    beforeMount(){
        console.log(this.user.avatar);
        this.imageServerURL = urls.imageServerURL ;
        const regex = /^http/ig;
        this.expression = this.user.avatar.match(regex) ? true:false ;       
    }
}
</script>


<style scoped>

    .links:hover {
        color: blue ;
        transform: scale(1.5);
    
    }
</style>
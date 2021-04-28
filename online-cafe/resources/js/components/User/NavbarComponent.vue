<template>
     <nav class="navbar navbar-expand-md navbar-light bg-info shadow-sm">
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto" >
                        <li class="p-2">
                            <router-link to="/home" class="navbar-brand links">online-cafe</router-link>
                        </li >
                        <li class="p-2">
                            <router-link to="/home" class="navbar-brand links">Home</router-link>
                        </li>
                        <li class="p-2">
                            <router-link to="/create-order" class="navbar-brand links">Create Order</router-link>
                        </li>
                         <li class="p-2">
                            <router-link to="/my-order" class="navbar-brand links">My-Order</router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <img  v-if="expression==true" :src="user.avatar " :alt=" user.name " style=" width: 95px; margin-left: 100%; height: 124px; border-radius: 10px;" />
                            <img  v-if="expression==false" :src="imageServerURL+user.avatar " :alt=" user.name " style=" width: 95px; margin-left: 100%; height: 124px;  border-radius: 10px;" />
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" style="margin-left: 100%;" aria-haspopup="true" aria-expanded="false" >{{ user.name}}</a>
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
</template>
<script>
import axios from 'axios';
axios.defaults.withCredentials =true;
axios.defaults.baseURL = 'http://localhost:8000';
import urls from '../services/apiURLs' ; 

export default {
    data() {
        return {
           expression :true,
           imageServerURL:'',
        //    user:user
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
    text-decoration: underline;
}
</style>
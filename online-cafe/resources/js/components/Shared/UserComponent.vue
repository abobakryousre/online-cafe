<template>
    <div>
        <Navbar  v-if="user" :user="user"/>
        <div class="row justify-content-center">
            <div class="container col-12 py-4">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import Navbar from '../User/NavbarComponent.vue';

    export default {
        created() {
            axios.get('/api/user').then(response => {
                this.user = response.data;
            })
        },
        data(){
            return {
                user: null,
            }
        },
        components: {
            Navbar,
        }
    
    }
</script>

<style scoped>

</style>
<template>
    <div class="container">
        <div class="row">
            <LatestOrderComponenet/>
            <CreatedOrderComponent/>
        </div>
    </div>
</template>

<script>
import LatestOrderComponenet from '../User/LatestOrderComponent.vue';
import CreatedOrderComponent from '../User/CreateOrderComponent.vue';
import {user}  from '../../app';
    export default {
        mounted() {
            console.log('Home Component mounted.');
        },
        data(){
            return {
                user: user,
            }
        },
        components: {
            LatestOrderComponenet,
            CreatedOrderComponent,
        }
    }
</script>
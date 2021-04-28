<template>
    <div class="container">

        <!-- Date Filter End -->
        <h1>My Order </h1>
        <div >
            <form class="row m-2" @submit.prevent="getOrderByDate()">                
                <label for="startDate" class="col-sm-2 col-form-label">Date From</label>

                <div class="col-sm-3 d-inline-block"> <!-- Start Date -->
                    <input @change="submitForm()"  v-model="startDate"  required id="startDate" aria-placeholder="Date From" type="datetime-local" class="form-check-input">
                </div>

                    <label for="endDate" class="col-sm-2 col-form-label" aria-placeholder="Date To">Date To</label>

                <div class="col-sm-3 d-inline-block"> <!-- End Date -->
                    <input v-model="endDate" @change="submitForm()" required id="endDate" type="datetime-local" class="form-check-input">
                </div>

                <div class="col-sm-2 d-inline-block"> <!-- End Date -->
                    <button type="submit" hidden id="submit-form"  class="btn btn-info">Get</button>
                </div>
            </form>

        </div>
        <div class="row" v-if="message.error || message.info">
            <div :class="['alert', message.error ? 'alert-danger': 'alert-info' ,'m-auto']">
                <p class="p-1" v-if="message.error">{{message.error}}</p>
                <p class="p-1" v-if="message.info">{{message.info}}</p>
            </div>
        </div>
        <!-- Date Filter End -->


        
        <!-- Orders Start  -->
        <div class="row m-2">
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Order Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Amoutn</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clickable"  v-for="order in orders.data" :key="order.id" >
                        <td @click="displayDetails(order.id)">{{changeDateFormat(order.created_at)}}</td>
                        <td @click="displayDetails(order.id)">{{order.status}}</td>
                        <td @click="displayDetails(order.id)">{{formatPrice(order.total_price)}}</td>
                        <td><button @click="cancleOrder(order.id)" class="btn btn-danger" v-if="order.status=== 'processing'">Cancel</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Orders  End -->

        <!--  -->
            <PaginationComponent v-if="orders.links" :links="orders.links" @paginate="getData"/>
        <!--  -->
       <!-- Order start  End -->
        <div class="row justify-content-center">
            <div class="col-md-8" v-if="orderDetails">
                <div class="card">
                    <div class="card-header">Order Details </div>
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="card m-2 " style="width: 12rem;" v-for="product in orderDetails.products" :key="product.id">
                                        <img
                                                :src="imageServerURL+product.image"
                                                class="card-img-top img"
                                                style="height: 200px;"
                                                alt="..."
                                        />

                                          <div class="d-flex w-100 justify-content-between mb-3 align-baseline">
                                            <div class="row col-6 ">
                                                <div style="align-self: center; font-family: fantasy; font-size: x-large; padding-left: 7%;color: crimson;"> {{product.name}}</div> 
                                            
                                                
                                            </div>
                                            
                                            <div class="row col-6">
                                                <div class="" style="align-self: center;">{{ formatPrice(product.price) }}</div>
                                                <div class="" style="align-self: center;">Qty: {{product.pivot.quantity}}</div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            <div class="card-footer">
                                    <small class="text-right text-muted ">Total Price {{formatPrice(orderDetails.total_price)}}</small>
                            </div>
                                
                    </div>
                </div>
              
            </div>
        </div>
        
    </div>
</template>

<script>
import {user} from '../../app';
import service from '../../services/orders';
import PaginationComponent from '../Shared/PaginationComponent.vue';

import urls from '../services/apiURLs';
import formater from '../../helper/formater';
import validate from '../../helper/validate';
export default {
    async created(){
        
        this.imageServerURL = urls.imageServerURL ;
        const orders = await service.getOrders(user.id);
        this.orders = orders.data;
    },
    data(){
        return{
            orders: "",
            user: user,
            startDate: null,
            endDate: null,
            orderDetails: false,
            message: {error: null, info: null},
            imageServerURL:''
        }
    },
    components: {
        PaginationComponent,
    },
    methods: {
        formatPrice(price){
            return formater.formatPrice(price);
        },
        async displayDetails(orderId){
            const products = await this.getOrderProducts(orderId);
            console.log(products.data);
            this.orderDetails = this.getOrderFromAllOrders(orderId);
            this.orderDetails.products = products.data;            
        },
        async cancleOrder(orderId){
            const res = await service.cancleOrder(orderId);
            const order = this.getOrderFromAllOrders(orderId)
            if(res.status == 200) order.status = "done";            
        },
        getOrderFromAllOrders(orderId){
            return this.orders.data.find((order) => order.id === orderId);
        },
        async getOrderProducts(orderId){
            return await service.getOrderProducts(orderId); 
        },
        async getData(orders){
            this.updateCurrentOrders(orders);
        },

        async getOrderByDate(){
            // verify the two date is not null, but the max date as the last created one,
            if(!validate.isStartDateBeforeEndDate(this.startDate, this.endDate)) return this.message.error = "The start date must be before end date!";

            const date = {start_date: this.startDate, end_date: this.endDate}
            const orders = await service.getOrders(this.user.id,date);
            this.cleareDateMessages();
            // is there any order this the give date 
            if(orders.data.data.length > 0){
                this.updateCurrentOrders(orders);
            }else{
                this.message.info = "No Orders within this date!"
            }
        },
        changeDateFormat(date){
            return formater.formatDate(date);
        },
        cleareDateMessages(){
            this.message.error = null;
            this.message.info = null;
        },
        updateCurrentOrders(orders){
            this.orders = orders.data;

        },
        submitForm(){
            document.getElementById('submit-form').click();
        }
    }
}
</script>



<style scoped>
.clickable:hover{
    cursor: pointer;
    background-color: lightskyblue;
}
</style>

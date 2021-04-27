<template>
    <div class="container" >
       
       <div v-if="products.length > 0">
        
        <div class="row">
            <form class="col-lg-4 p-3 border" @submit.prevent="confirmOrder()">
                <!-- Dispaly all User For Admin Start-->

                <div class="row" v-if="curUesr.is_admin">
                    <div class="col-lg-12 align-baseline m-2">
                        <label for="all-users" class="col-lg-form-label text">Select User </label>
                        <select required v-model="order.user" name="all-users" class="m-2" >        
                                <template v-for="user in allUsers"  :key="user.id">
                                   <option v-if="!user.is_admin" :value="user" >{{user.name}}</option>
                                </template>
                        </select>
                    </div>
                </div>

                <!-- Dispaly all User For Admin end-->
                <div class="row  align-content-center" v-for="product in order.products" :key="product.id"> <!-- contorles -->
                    <div class="col-lg-2 text-dark m-auto"><label for="" class="text">{{ product.name }}</label></div> <!-- Product name !-->
                    <div class="col-lg-1 text-success m-auto">
                        <label for="" class="text text-center">{{ product.quantity }}</label>
                        </div> <!-- Product Quantity !-->
                    <div class="col-lg-4 text-center m-auto">
                        <button class="btn btn-success btn-m m-1" @click.prevent="increaseQuantity(product.id)">+</button>
                        <button class="btn btn-warning btn-m m-1" @click.prevent="decreaseQuantity(product.id)">-</button>
                        </div> <!-- Action !-->
                    <div class="col-lg-5 text-dark m-auto align-baseline ">
                        <label for="text" class="text">{{ formatPrice(product.price * product.quantity) }}</label>
                     <button class="btn btn-danger"  @click.prevent="removeProduct(product.id)">X</button>
                     </div> <!-- Delete  Product !-->
                </div>
                
                
                <div class="row py-3 "> <!-- Notes -->
                    <div class="col-lg-12 ">
                     <label for="notes" class="text" >Notes</label>
                        <textarea name="notes" id="order-notes" cols="35" rows="10" v-model="order.notes"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <label for="notes" class="text " >Rooms</label>
                        <select required v-model="order.room" name="rooms" id="rooms" class="float-right">
                            <option v-for="room in rooms" :key="room.id">{{room.name}}</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="d-flex flex-column float-right mr-2 text-center
                        "> 
                            <label for="total-price">{{ formatPrice(order.totalPrice) }}</label>
                            <button type="submit" class="btn btn-success m-auto">Confirm</button>
                        </div>
                    </div>
                </div>
            </form> <!-- create order  -->
            <div class="col-1"></div>
            <div id="products" class="col-lg-7 py-3  border">
                <div class="row justify-content-center">
                    <div v-for="product in products" :key="product.id" >
                    <div class="card m-2 " style="width: 12rem;  height: 95%;" v-if="product.available">
                        <img
                                :src="imageServerURL+product.image"
                                class="card-img-top img"
                                style="height: 200px;"
                                alt="..."
                                @click="addProduct(product.id)"
                        />
                        <div class="card-body "  style="padding: 0%;">
                            <div class="d-flex w-100 justify-content-between mb-3 align-baseline">
                                <div class="row col-6 ">
                                    <div style="font-family: fantasy; font-size: x-large; padding-left: 7%;color: crimson;">{{product.name}}</div> 
                                   
                                    
                                </div>
                                
                                <div class="row col-6">
                                    <div class="" style="align-self: center;">{{ formatPrice(product.price) }}</div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                             <button href="#" @click.prevent="addProduct(product.id)" class="btn btn-primary btn-block" style="position: absolute; bottom: 0; right: 0%; "
                                    >Add </button
                                    >
                        </div>
                        </div>
                    </div>

                </div>
            </div><!-- display products !-->
        </div>
        </div>
        <div v-if="products.length < 1 ">
             
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center text-dark"></div>
                        <div class="card-body">
                            <h3 class="aler alert-info text-center">  Unfortunately, there is no available products Right Now ... </h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>

<script>
import services  from '../../services/orders';
import userServices from '../../services/users';
import {user} from '../../app';
import urls from '../services/apiURLs' ; 
export default {
    async created(){

        this.imageServerURL = urls.imageServerURL ;
        this.getData();
        if(user.is_admin){
            this.getAllUsers();
        }
    }
    ,data() {
        return {
            order: {
                products: [],
                notes: "",
                totalPrice: 0,
                room: null,
                user: user,
            },
            products: [],
            rooms: [],
            allUsers: null,
            imageServerURL:'',
            curUesr:user,
        }    
    },
    methods:{
        async getAllUsers(){
            const users = await userServices.getAllUsers();

            this.allUsers = users.data;
        },
        getProductFromOrder(productId){
            return this.order.products.find((product) => product.id === productId);
        },
        increaseQuantity(productId){
            const product = this.getProductFromOrder(productId);
            this.order.totalPrice += product.price;
            product.quantity += 1

        },
        decreaseQuantity(productId){
            const product = this.getProductFromOrder(productId);
            if(product.quantity > 0)  {
                product.quantity -= 1
                this.order.totalPrice -= product.price;
            }
            
        },
        formatPrice(price){
            const formater = Intl.NumberFormat('eg-SA',{
                   style: 'currency', currency: 'EGP' 
                   })
            return formater.format(price);
        },
        removeProduct(productId){
            // const productIndex = this.order.products.findIndex((product) => product.id === productId);
            let productIndex;
            for(let index = 0; index < this.order.products.length; index++){
                if(this.order.products[index].id == productId) {
                    productIndex = index;
                    break;
                }
            }
                            console.log("removing", productIndex);

            const product = this.getProductFromOrder(productId);
            if(productIndex !== -1){
                console.log("removing", productIndex);
                this.order.totalPrice -= (product.price *  product.quantity);
                this.order.products.splice(productIndex, 1);
            }else{
                console.log("Error removing INdex -1");
            }

        },
        addProduct(productId){
            const product2 = this.getProductFromOrder(productId)
            if(product2){
                product2.quantity += 1;
                this.order.totalPrice += product2.price;
            }else{
                const product = this.products.find(product => product.id === productId);
                this.order.products.push({"quantity": 1,...product});
                this.order.totalPrice += product.price; 
            }
            
        },
        confirmOrder(){
            if(this.order.products.length > 0) {
                // attach the room object to order insted of name
                const room = this.rooms.find(room => room.name == this.order.room);
                this.order.room = room;
                this.submitOrder()

            }else {
                console.log("Order With No Products Selected");
            }
        },
        async submitOrder(){
            console.log(this.order.user)
            try {
                const res =  await services.submitOrder(this.order);
                 console.log(res.data);
                 window.location = "/home";
            } catch (error) {
                console.log("Submiting Order error \n \n \n ", error);
            }
            
           
        },
        async getProducts(){
            const products = await services.getProducts();
            this.products = products.data;
            console.log(products.data);
        },
        async getRooms(){
            const products = await services.getRooms();
            this.rooms = products.data;
            console.log(products.data);

        },
        async getData(){
            this.getRooms();
            this.getProducts();
        }

    },

}
</script>

<style scoped>
.text{
    font-size: large;
    font-weight: 500;
}

.img:hover{
    transform: scale(1.2);
    cursor: pointer;
}
</style>
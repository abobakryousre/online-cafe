<template>
    <div class="container mb-2" >
        <div class="row justify-content-center">
            <div class="col-md-8" v-if="latestOrder">
                <div class="card">
                    <div class="card-header bg-info">Latest Order</div>
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="card m-2 " style="width: 12rem;" v-for="product in latestOrder.products" :key="product.id">
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
                                    <small class="text-right text-muted ">Total Price {{formatPrice(latestOrder.order.total_price)}}</small>
                            </div>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { user } from '../../app'
import services from '../../services/orders';
import urls from '../services/apiURLs' ; 
export default {
    async created(){
        this.imageServerURL = urls.imageServerURL;
        if(! this.user.is_admin){
            const latestOrder = await services.getLatestOrder(this.user.id);
            this.latestOrder = latestOrder.data;
        }
       
    },
    data() {
        return {
            user: user,
            latestOrder: false,
            imageServerURL:'',
        }
    },
    methods: {
        formatPrice(price){
            const formater = Intl.NumberFormat('eg-SA',{
            style: 'currency', currency: 'EGP' 
            })
            return formater.format(price);
        },
    },
}
</script>
<template >
<div v-if="specificOrder != null">
    <h1>Order</h1>
    <br>
    <table class="table table-striped mt-3 text-center">
            <thead class="bg-info">   
              <tr>
                <th scope="col">Order Date</th>
                <th scope="col">Name</th>
                <th scope="col">Room</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>

              </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{changeDateFormat(specificOrder.order.created_at)}}</td>
                    <td>{{specificOrder["user"].name}}</td>
                    <td>{{specificOrder["room"].name}}</td>
                    <td>{{specificOrder["order"].status}}</td>
                    <td><button
                    type="button"
                    class="btn btn-success"
                    @click="changeStatus(specificOrder['order'].id)"
                    :disabled="specificOrder['order'].status == 'done'"
                  
                  >
                    Finish Order
                  </button></td>


                </tr>
            </tbody>
    </table>
    <br><br>
    <h1>Order Details</h1>
        <br>
    <table class="table table-striped mt-3 text-center">
            <thead class="bg-info">   
              <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                

              </tr>
            </thead>
            <tbody>
                <tr v-for="product in specificOrder['products']" :key="product.id">
                    <td>{{product.name}}</td>
                    <td>{{product.pivot.quantity}}</td>
                    <td>{{formatPrice(product.price)}}</td>
                    

                </tr>
                <!-- <tr ><td ><h3 style="color:#00FF80">Total Price={{specificOrder["order"].total_price}}</h3></td></tr> -->
            </tbody>
    </table>


    <div class="container mb-2" >
        <div class="row justify-content-center">
            <div class="col-md-8" >
                <div class="card">
                    <div class="card-header bg-info">Order Details</div>
                            <div class="card-body p-0">
                                <div class="row justify-content-center">
                                    <div class="card m-2 " style="width: 12rem;" v-for="product in specificOrder['products']" :key="product.id">
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
                                    <small class="text-right text-muted ">Total Price {{formatPrice(specificOrder["order"].total_price)}}</small>
                            </div>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</template>

<script>
import axios from "axios";
axios.defaults.withCredentials = true;
axios.defaults.baseURL = "http://localhost:8000";
import urls from '../services/apiURLs' ; 
import formater from '../../helper/formater';
export default {
  data() {
    return {
        id:this.$route.params.id,
        specificOrder:null,
        imageServerURL:'',
      
    };
  },
  
  methods: {
       getOrder() {
         const that = this ;
      axios
        .post("/api/checkOrder",{'orderId':that.id})
        .then((response) => {
          
          that.specificOrder = response.data;
          console.log(that.specificOrder['order']);
        })
        .catch(() => {
          console.log("Error...");
        });
    },
    changeStatus(ID){
         axios
        .put("/api/checkOrder",{orderId:this.id})
        .then((response) => {
          alert("done");
          this.$router.push({ name: 'checks' })
          
          
        })
        .catch(() => {
          console.log("Error...");
        });
        
    },
    formatPrice(price){
            const formater = Intl.NumberFormat('eg-SA',{
                   style: 'currency', currency: 'EGP' 
                   })
            return formater.format(price);
        },
        changeDateFormat(date){
          return formater.formatDate(date);
      },
    
  },
  created() {
    this.imageServerURL = urls.imageServerURL;
    this.getOrder();
  },
};
</script>
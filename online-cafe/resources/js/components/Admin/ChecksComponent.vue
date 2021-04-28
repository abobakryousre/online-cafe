<template>
  <div>
    <h1>Checks</h1>
    <br>
    <form action="/api/checks" method="POST" @submit.prevent="submitform">
      <div class="form-row">
        <div class="col">
          <label for="start_date">Start Date</label>
          <input
            type="date"
            class="form-control"
            name="start"
            v-model="start"
            required
          />
        </div>
        <div class="col">
          <label for="end_date">End Date</label>
          <input required type="date" class="form-control" name="end" v-model="end" />
        </div>
      </div>
      <!-- Date messages  Start -->
      <div class="row p-3" v-if="message.error || message.info">
            <div :class="['alert', message.error ? 'alert-danger': 'alert-info' ,'m-auto']">
                <p class="p-1" v-if="message.error">{{message.error}}</p>
                <p class="p-1" v-if="message.info">{{message.info}}</p>
            </div>
        </div>
      <!-- Date messages  End -->

      <br /><br />
      <div class="form-row">
        <div class="col">
          <label for="user">User</label>
          <select
            class="form-control"
            id="exampleFormControlSelect1"
            name="selectedUser"
            v-model="selectedUser"
            required
          >
     
            <template v-for="user in users"  :key="user.id">
                <option v-if="!user.is_admin"  >{{user.name}}</option>
            </template>

          </select>
        </div>
      </div>
      <br />
      <button type="submit" class="btn btn-warning" style="float: right">
        Submit
      </button>
    </form>
    <br /><br />

    <table class="table table-striped text-center">
      <thead class="bg-info">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Total Amount</th>
        </tr>
      </thead>
     
        <tbody v-if="userDisplay == true">
          <tr>
            <td>
              <button
                type="button"
                class="btn btn-info"
                @click="orderDisplay = true"
              >
                {{ data_of_user['user'].name }}
              </button>
            </td>
            <th >{{ data_of_user['totalAmount'] }}</th>
          </tr>
        </tbody>
     
    </table>

    <div v-if="orderDisplay">
      <table class="table table-hover table-primary mt-5 text-center">
        <thead>
          <tr>
            <th scope="col">Order Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          
          <tr v-for="order in data_of_user['orders']['data']" :key="order.id">
            <td>
              <button
                type="submit"
                class="btn btn-primary"
                @click="orderClicked(order.id)"
              >
                {{formatDate(order.created_at)}}
              </button>
            </td>
            <td>{{order.total_price}}</td>
            <td><router-link class="btn btn-info" v-bind:to="'/checkOrder/'+order.id">Details</router-link></td>
          </tr>
          
          
        </tbody>
      </table>
      <button
        type="button"
        class="btn btn-danger"
        style="float: right"
        @click="orderDisplay = false"
      >
        Hide
      </button>
            <pagination v-if="data_of_user['orders']" :links="data_of_user['orders']['links']" @paginate="getDate"/>

    </div>

    <div  v-if="orderDetailsDisplay == true"
>
      <div
        class="p-3 mb-2 mt-5 text-primary"
        style="background-color: #F0F0F0"
      >
        <div class="d-flex flex-row">
          <div class="p-2" v-for="product in selectedOrderProducts" :key="product.id" style="display:inline">
            <h4 >{{product.name}} </h4>
            <p >{{product.pivot.quantity}}</p>
          </div>
        </div>
              

      </div>
      <button 
              type="button"
              class="btn btn-danger"
              style="float:right"
              @click="orderDetailsDisplay = false"
            >
              Hide
      </button>
      </div>
  </div>


 
</template>

<script>
import axios from "axios";
import formater from '../../helper/formater';
import validate from '../../helper/validate';
import pagination from "../Shared/PaginationComponent.vue";

export default {
  components: {
    pagination,
  },
  data() {
    return {
      orderDetailsDisplay: false,
      orderDisplay: false,
      userDisplay: false,
      users: [],
      start: "",
      end: "",
      selectedUser: "",
      data_of_user: [],
      selectedOrderId:"",
      selectedOrderProducts:[],
      message: {error: null, info: null}
    };
  },
  methods: {
    getUsers() {
      axios
        .get("/api/users")
        .then((response) => {
          this.users = response.data;
        })
        .catch(() => {
          console.log("Error...");
        });
    },
    getDate(resData){
      this.data_of_user['orders'] = resData.data;
    },
    formatDate(date){
      return formater.formatDate(date);
    },
    cleareDateMessages(){
      this.message.error = null;
      this.message.info = null;
    },
    submitform() {
      
      this.cleareDateMessages();
      // validate date, foramte date
      if(!validate.isStartDateBeforeEndDate(this.start, this.end)){
        return  this.message.error = "The start date must be before end date!"
      }
      axios.post(`/api/checks?selectedUser=${this.selectedUser}&start=${this.start}&end=${this.end}`, {
          selectedUser: this.selectedUser,
          start: this.start,
          end: this.end,
        })
        .then((response) => {
          this.userDisplay=true;
          this.data_of_user = response.data;
          
        })
        .catch(() => {
          console.log("Error...");
        });
    },
    orderClicked(order_id)
    {
      this.orderDetailsDisplay=true;
      this.selectedOrderId=order_id;
      
      axios
        .post("/api/checks/products", {
          selectedOrderId: this.selectedOrderId,
        })
        .then((response) => {
          this.selectedOrderProducts=response.data
          
        })
        .catch(() => {
          console.log("Error...");
        });
    }
    
  },
  created() {
    this.getUsers();
  },
};
</script>
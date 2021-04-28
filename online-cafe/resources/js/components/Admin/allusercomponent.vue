<template>
<div class="container">
<div class="row">
<table class="table table-striped table-bordered  table-hover  text-center col-12 ">
<thead>
    <tr>
        <th >Name</th>
        <th>Rooms</th>
        <th>Image</th>
         <td>Edit</td>
        <td>Delete</td>
    </tr>
</thead>
<tbody>

<tr v-for="user in users" :key="user.id">
    <td>{{user.name}}</td>
    <td>
    <details>
  <summary>Rooms</summary>
 <ul >
 <li v-for="room in user.rooms" :key="room.id">
     {{ room.name }}
 </li>
 </ul>
</details>
    </td>
    <td v-if="user.avatar.match(/^http/ig)"><img   :src="user.avatar " :alt=" user.name "  style="height: 40px; width: 40px" class="profile-user-img img-fluid img-circle"/></td>
    <td v-if="!user.avatar.match(/^http/ig)"><img   :src="imageServerURL+user.avatar " :alt=" user.name " style="height: 40px; width: 40px" class="profile-user-img img-fluid img-circle" /></td>
 

  <td><router-link :to="'/edit/'+user.id"  class="btn btn-success">Edit</router-link></td> 

      <td>
       <a type="button"
          class="btn btn-danger"
         @click="deleteUser(user.id)">Delete </a>
          </td>
    </tr>

</tbody>


 </table>
  <td><router-link :to="'/userstore'"  class="btn btn-success">Add New user </router-link></td> 
</div>
</div>

</template>

<script>

import axios from 'axios'
axios.defaults.withCredentials =true
axios.defaults.baseURL = 'http://localhost:8000'
import urls from '../services/apiURLs' ; 
    export default {
     data(){
         return{
              users: [],
              imageServerURL:''
                  }
             },
    methods:{

      getUsers() {
            axios
                .get("/api/userindex")
                .then((data) => (this.users = data.data))
                .catch(() => {
                    console.log("Error...");
                });
                     }, // end of getuser method

         deleteUser(id) {
            axios
                .delete(`/api/userdelete/${id}`)
                .then((response) => {
                    let i = this.users.map((data) => data.data).indexOf(id);
                    this.users.splice(i, 1);
                });
                        }, // end of delete method 

             }, //end of methods

     created(){    
        this.getUsers();
        this.imageServerURL = urls.imageServerURL ;

        },
    }

      




</script>

<style>

</style>

      

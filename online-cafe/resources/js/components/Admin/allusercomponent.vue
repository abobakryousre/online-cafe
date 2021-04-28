<template>
<div class="container">
       <router-link class="btn btn-success mb-2 float-right" :to="'/userstore'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg>
    </router-link>

 

<table class="table table-striped  text-center col-12 ">
<thead class="bg-info">
    <tr>
        <th >Name</th>
        <th>Rooms</th>
        <th>Image</th>
         <td>Edit</td>
        <td>Delete</td>
    </tr>
</thead>
<tbody>

<tr class="clickable" v-for="user in users" :key="user.id">
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
    <td v-if="user.avatar.match(/^http/ig)"><img   :src="user.avatar " :alt=" user.name "  style="height: 40px; width: 40px; border-radius: 50%;" class="profile-user-img img-fluid img-circle"/></td>
    <td v-if="!user.avatar.match(/^http/ig)"><img   :src="imageServerURL+user.avatar " :alt=" user.name " style="height: 40px; width: 40px; border-radius: 50%;" class="profile-user-img img-fluid img-circle" /></td>
 

  <td><router-link :to="'/edit/'+user.id"  class="btn btn-success">Edit</router-link></td> 

      <td>
       <a type="button"
          class="btn btn-danger"
         @click="deleteUser(user.id)">Delete </a>
          </td>
    </tr>

</tbody>


 </table>
   

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

<style scoped>
th, td {
    text-align: center;
    vertical-align: middle;
}
.clickable:hover{
    background-color: lightskyblue;
}
</style>

      

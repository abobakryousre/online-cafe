<template>
    <div class="container">
   
        
  
</div>




<div class="card">
            <div class="card-header bg-info">
                Add User
            </div>
            <form v-on:submit.prevent="onSubmit">
            <div class="card-body">
              
                
            <div class="form-group">
                <lable>Name</lable>
                <input type="text" class="form-control" name="name" v-model="form.name" />
            </div>

            <div class="form-group">
                <lable>email</lable>
                <input type="email" class="form-control" name="email" v-model="form.email" />
            </div>

             <div class="form-group">
                <lable>Password</lable>
                <input type="password" class="form-control" name="password" v-model="form.password" />
            </div>

             <div class="form-group">
                <lable>Password Cofirm</lable>
                <input type="password" class="form-control" name="password" v-model="form.confirmpassword" />
            </div>


           

           
        <!-- ///////////////////////////////////////////////////////////////////////////////////////////////// -->
        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#exampleModal">
                Add Room
        </button>
<!-- Button trigger modal -->
        

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form  @submit="addRoom" >
                    <div class="modal-body hustify-content-center">
                        <input type="text" v-model="roomName" placeholder="Room Name" required >
                        <div style="color: red;">
                                {{roomErr}}  
                        </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
            
        

        <!--  -->

        <select class="custom-select" id="validatedInputGroupSelect" v-model="form.rooms" multiple required >
         <option v-for="room in rooms" :key="room.id" :value="room.id" :selected="room.id === form.rooms" >{{room.name}}</option>
             
        </select> 
        <br>            
        <br>
        <br>

         <div class="custom-file mb-3">
                <input type="file" name="avatar" class="custom-file-input" v-on:change="onChange" id="validatedCustomFile" accept="image/*"  required>
                <label class="custom-file-label"  for="validatedCustomFile">{{imageName}}</label>
                <div class="invalid-feedback">Cover Photo</div> 
                <div id="preview" style="margin-top: 1%;">
                    <img v-if="url" :src="url" />
                </div>
         </div>


            <br>            
            <br>
            <br>
          

            
      
            </div>
            <div class="card-footer text-muted">
                <button type="submit" name="submit" class="btn btn-info btn-block mg-5">Add User</button>
            </div>
            </form>
        </div>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials =true
axios.defaults.baseURL = 'http://localhost:8000'



 export default {
        data() {
            return {
                // user: {}
                rooms:[],
              form:{
                        name:'',
                        email:'',
                        avatar:'',
                        password:'',
                        confirmpassword:'' , 
                        rooms:[],
                    },
                    imageName:'Upload Cover Photo',
                    url: null,
                    roomName:'',
                    roomErr:''
            }
        },
          mounted(){
               this.getRooms();
          },
        methods: {

          onChange(e) {
                this.form.avatar = e.target.files[0];
                this.imageName = e.target.files[0].name; 
                this.url = URL.createObjectURL(this.form.avatar);
                console.log(this.form);
            },

            onSubmit(e) {
                const existingObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }  
                if(this.form.confirmpassword==this.form.password){
                    const formData = new FormData()
                    formData.append('avatar', this.form.avatar)
                    formData.append('name', this.form.name)
                    formData.append('email', this.form.email)
                    formData.append('password', this.form.password)
                    formData.append('rooms', this.form.rooms)
                    axios.post("/api/userstore", formData,config)
                    .then((res) => {
                    console.log(res.data)
                        existingObj.$router.push({
                            name: "alluser",
                        });
                    }).catch(function (err) {
                            existingObj.output = err;
                        });
                }          
               
                e.preventDefault();

            },
            getRooms() {
                const that = this ;
                axios
                .get("/api/rooms")
                .then((data) => {
                    that.rooms = data.data
                    console.log(data.data)
                    })
                   
                .catch(() => {
                    console.log("Error...");
                });
            },
            addRoom(e){
                const roomList = this.rooms.map(value => value.name.toLowerCase());
                const found = roomList.includes(this.roomName) ;
                if(!found){
                    axios.post('/api/rooms', {name:this.roomName}).then(function (res) {
                        console.log(res);
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
                }
                else{
                    this.roomErr = `This room "${this.categoryName}" is already exist ...`;
                    e.preventDefault();
                }
                
                this.roomName = '';
                
               
                
            }  


        },
    }
    
</script>



<style scoped>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}
</style>
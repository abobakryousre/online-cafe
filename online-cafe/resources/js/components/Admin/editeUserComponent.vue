<template>
    <div>
        <h3 class="text-center">Edit User</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateuser">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name">
                    </div>

        <select class="custom-select" id="validatedInputGroupSelect" v-model="form.rooms" multiple required >
         <option v-for="room in allrooms" :key="room.id" :value="room.id" :selected="room.id === allrooms.id" >{{room.name}}</option>
        </select> 
                    
                <div class="custom-file mb-3">
                <label for="Image">Your Profile</label>
                <div class="imagePreviewWrapper"  ></div>
                <input type="file" name="avatar" class="" v-on:change="onChange" id="validatedCustomFile" accept="image/*" required>
                </div>
                    <br>
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    
</template>
 
<script>
import axios from 'axios'
axios.defaults.withCredentials =true
axios.defaults.baseURL = 'http://localhost:8000'

    export default {
        data() {
            return {
                form:{
                        name:'',
                        avatar:'',
                        rooms:[],
                    },

                    allrooms:[],


}
        },
        created() {
            axios
                .get(`/api/usershow/${this.$route.params.id}`)
                .then((res) => {
                    this.form = res.data;
                });
        },
         mounted(){
               this.getRooms();
          },
        methods: {

            updateuser() {

            const formData = new FormData()
            formData.append("_method", "patch");
            formData.append('avatar', this.form.avatar)
            formData.append('name', this.form.name)
            formData.append('rooms', this.form.rooms)

            axios
                .post(`/api/useredit/${this.$route.params.id}`, formData)
                .then((res) => {
                    this.$router.push({
                        name: "alluser",
                    });
                    //  this.user = res.data;
                });
            },

            onChange(e) {
                this.form.avatar = e.target.files[0];
                this.imageName = e.target.files[0].name;
                this.url = URL.createObjectURL(this.form.avatar);
                console.log(this.form);
            },

            getRooms() {
                const that = this ;
                // console.log('hhhhhhhhhhhhhhh')
                axios
                .get("/api/rooms")
                .then((data) => {
                    that.allrooms = data.data
                    console.log(data.data)
                    })
                    
                .catch(() => {
                    console.log("Error...");
                });
            }
        }, 
        }
</script>
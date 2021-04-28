

<template>
        <div class="card">
            <div class="card-header bg-info">
                Add Product
            </div>
             <form  @submit.prevent="onSubmit" >
            <div class="card-body">
              
                    <div class="mb-3">
                            <div class="input-group is-invalid">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="validatedInputGroupPrepend">Product</span>
                            </div>
                            <input type="text" v-model="form.name" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" required>
                            </div>
                            <div class="invalid-feedback">
                            
                            </div>
                    </div>
                    
                    <div class="mb-3">
                            <div class="input-group is-invalid">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="validatedInputGroupPrepend">Price</span>
                            </div>
                            <input type="number" v-model.number="form.price" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend"  min="1" required>
                            </div>
                            <div class="invalid-feedback">
                            
                            </div>
                    </div>

                     <div class="mb-3">

                        <button type="button" class="btn btn-success mb-1" data-toggle="modal" data-target="#exampleModal">
                            Add Category
                        </button>

                        <div class="input-group is-invalid">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="validatedInputGroupSelect">Category</label>
                        </div>
                     
     
                     
                     <!-- Button trigger modal -->
                        

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form  @submit="addCategory" >
                                <div class="modal-body">
                                    <input type="text" v-model="categoryName" placeholder="Category Name" required >
                                    <div style="color: red;">
                                         {{categoryErr}}  
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
                        <select class="custom-select" id="validatedInputGroupSelect" v-model="form.category_id"  required>
                            <option v-for="category in categories" :key="category.id" :value="category.id" :selected="category.id === form.category_id" >{{category.name}}</option>
                            
                        </select>
                        </div>
                        <div class="invalid-feedback">
                        
                        </div>
                    </div>


                                            


                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input" v-on:change="onChange" id="validatedCustomFile" accept="image/*"  required>
                        <label class="custom-file-label"  for="validatedCustomFile">{{imageName}}</label>
                        <div class="invalid-feedback">Cover Photo</div> 
                        <div id="preview" style="margin-top: 1%;">
                            <img v-if="url" :src="url" />
                        </div>
                    </div>
                    
                    
                
            </div>
            <div class="card-footer text-muted">
                <button class="btn btn-info btn-block" >Add Product</button>
            </div>
            </form>
        </div>
</template>

<script>
import axios from 'axios'
axios.defaults.withCredentials =true
axios.defaults.baseURL = 'http://localhost:8000'
import urls from '../services/apiURLs.js'

    export default {
        data(){
                return{                    
                    products:[],
                    categories:[],
                    form:{
                        name:'',
                        price:1,
                        category_id:1,
                        image:null
                    },
                    imageName:'Upload Cover Photo',
                    url: null,
                    categoryName: "",
                    categoryErr:"",
                        
                    
                }    
                
            },
        beforeCreate() {
            console.log('Component mounted.');
            axios.get(`${urls.getCategoriesURL}`).then(categoryResponse => {
                this.categories = categoryResponse.data;
                console.log(this.categories)
            })
        },
        methods:{
            onChange(e) {
                this.form.image = e.target.files[0];
                this.imageName = e.target.files[0].name; 
                this.url = URL.createObjectURL(this.form.image);
                console.log(this.form);
            },
            onSubmit(e) {
                e.preventDefault();
                const existingObj = this;

                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }            
                const formData = new FormData()
                formData.append('image', this.form.image)
                formData.append('name', this.form.name)
                formData.append('price', this.form.price)
                formData.append('category_id', this.form.category_id)
                  for (var pair of formData.entries()) {
                    console.log(pair[0]+ ', ' + pair[1]); 
                }
                axios.post(`${urls.postProductURL}`, formData,config).then(function (res) {
                    console.log(res);
                    existingObj.$router.push({ name: 'allProducts' })
                  
                })
                .catch(function (err) {
                    console.log(err);
                });
            },
            addCategory(e){
                const categoryList = this.categories.map(value => value.name.toLowerCase());
                const found = categoryList.includes(this.categoryName) ;
                if(!found){
                    axios.post(`${urls.postCategoryURL}`, {name:this.categoryName}).then(function (res) {
                        console.log(res);
                    })
                    .catch(function (err) {
                        console.log(err);
                    });
                }
                else{
                    this.categoryErr = `This category "${this.categoryName}" is already exist ...`;
                    e.preventDefault();
                }
                
                this.categoryName = '';
                
               
                
            }  
        }
        
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
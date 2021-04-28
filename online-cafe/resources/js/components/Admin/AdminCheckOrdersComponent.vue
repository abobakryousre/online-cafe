<template>
    <div>
         <router-link class="btn btn-success mb-2 float-right" :to="{name: 'addProduct'}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
      </svg>
    </router-link>
   
    <table class="table text-center table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <tr  v-for="product in products" :key="product.id" >
                <td style="vertical-align: middle;">{{product.name}}</td>
                <td>{{product.category_id.name}}</td>
                <td>{{product.price}}</td>                
                <td style="width:25%"><img :src="imageServerURL+product.image" style="width:25% ;" :alt="product.name"></td>
                <td>
                    <button class="btn btn-warning mr-1" @click="visable(product.id)" v-if="product.available==1">
                          <svg xmlns="http://www.w3.org/2000/svg" id="Capa_1" enable-background="new 0 0 510 510" width="16" height="16" fill="currentColor" viewBox="0 0 510 510" ><path d="m506.597 245.486c-46.353-56.474-144.49-122.379-251.597-122.379-107.491 0-205.632 66.353-251.597 122.379-4.538 5.531-4.538 13.497 0 19.028 47.452 57.84 145.819 122.38 251.597 122.38 109.537 0 207.256-68.357 251.597-122.379 4.538-5.532 4.538-13.498 0-19.029zm-149.704 9.514c0 56.184-45.709 101.894-101.894 101.894-56.186 0-101.894-45.713-101.894-101.894 0-56.184 45.709-101.894 101.894-101.894 56.19.001 101.894 45.716 101.894 101.894zm-321.631.004c16.883-17.547 57.591-55.416 114.736-79.721-35.862 47.122-35.876 112.273-.017 159.412-43.449-18.415-83.811-47.509-114.719-79.691zm324.74 79.713c35.862-47.123 35.875-112.273.017-159.412 43.447 18.415 83.81 47.51 114.719 79.69-16.883 17.549-57.591 55.416-114.736 79.722z"/><path d="m204 255c0 28.122 22.878 51 51 51 28.121 0 51-22.878 51-51s-22.879-51-51-51c-28.122 0-51 22.878-51 51zm72 0c0 11.58-9.421 21-21 21-11.58 0-21-9.42-21-21s9.42-21 21-21c11.579 0 21 9.42 21 21z"/><path d="m255 65c8.284 0 15-6.716 15-15v-35c0-8.284-6.716-15-15-15s-15 6.716-15 15v35c0 8.284 6.716 15 15 15z"/><path d="m344.5 85.062c7.192 4.102 16.355 1.601 20.461-5.599l19.962-35c4.104-7.196 1.599-16.356-5.598-20.461-7.198-4.104-16.356-1.599-20.461 5.599l-19.962 35c-4.104 7.195-1.598 16.356 5.598 20.461z"/><path d="m145.039 79.463c4.104 7.196 13.264 9.702 20.461 5.598 7.196-4.104 9.702-13.265 5.598-20.461l-19.962-35c-4.104-7.196-13.266-9.702-20.461-5.598-7.196 4.104-9.702 13.265-5.598 20.461z"/><path d="m255 445c-8.284 0-15 6.716-15 15v35c0 8.284 6.716 15 15 15s15-6.716 15-15v-35c0-8.284-6.716-15-15-15z"/><path d="m165.5 424.939c-7.196-4.103-16.356-1.598-20.461 5.598l-19.962 35c-4.104 7.196-1.598 16.357 5.598 20.461 7.197 4.104 16.357 1.597 20.461-5.598l19.962-35c4.105-7.196 1.598-16.357-5.598-20.461z"/><path d="m364.961 430.537c-4.104-7.197-13.267-9.701-20.461-5.599-7.196 4.104-9.702 13.265-5.598 20.461l19.962 35c4.103 7.196 13.263 9.703 20.461 5.599 7.196-4.104 9.702-13.265 5.598-20.461z"/></svg>
                    </button>

                    <button class="btn btn-info mr-1" @click="visable(product.id)" v-if="product.available==0">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"  width="16" height="16" fill="currentColor" viewBox="0 0 572.098 572.098" style="enable-background:new 0 0 572.098 572.098;" xml:space="preserve">
                            <g>
                                <path d="M99.187,398.999l44.333-44.332c-24.89-15.037-47.503-33.984-66.763-56.379c29.187-33.941,66.053-60.018,106.947-76.426    c-6.279,14.002-9.853,29.486-9.853,45.827c0,16.597,3.696,32.3,10.165,46.476l35.802-35.797    c-5.698-5.594-9.248-13.36-9.248-21.977c0-17.02,13.801-30.82,30.82-30.82c8.611,0,16.383,3.55,21.971,9.248l32.534-32.534    l36.635-36.628l18.366-18.373c-21.206-4.186-42.896-6.469-64.848-6.469c-107.663,0-209.732,52.155-273.038,139.518L0,298.288    l13.011,17.957C36.83,349.116,66.151,376.999,99.187,398.999z"/>
                                <path d="M459.208,188.998l-44.854,44.854c30.539,16.071,58.115,37.846,80.986,64.437    c-52.167,60.662-128.826,96.273-209.292,96.273c-10.3,0-20.533-0.6-30.661-1.744l-52.375,52.375    c26.903,6.887,54.762,10.57,83.036,10.57c107.663,0,209.738-52.154,273.038-139.523l13.011-17.957l-13.011-17.956    C532.023,242.995,497.844,212.15,459.208,188.998z"/>
                                <path d="M286.049,379.888c61.965,0,112.198-50.234,112.198-112.199c0-5.588-0.545-11.035-1.335-16.402L269.647,378.56    C275.015,379.349,280.461,379.888,286.049,379.888z"/>
                                <path d="M248.815,373.431L391.79,230.455l4.994-4.994l45.796-45.796l86.764-86.77c13.543-13.543,13.543-35.502,0-49.046    c-6.77-6.769-15.649-10.159-24.523-10.159s-17.754,3.384-24.522,10.159l-108.33,108.336l-22.772,22.772l-29.248,29.248    l-48.14,48.14l-34.456,34.456l-44.027,44.027l-33.115,33.115l-45.056,45.055l-70.208,70.203    c-13.543,13.543-13.543,35.502,0,49.045c6.769,6.77,15.649,10.16,24.523,10.16s17.754-3.385,24.523-10.16l88.899-88.898    l50.086-50.086L248.815,373.431z"/>
                            </g>
                        </svg>
                    </button>

                    <router-link class="btn btn-success mr-1" :to="{name: 'updateProduct', params: { productId: product.id }}">
                      
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                        </svg>
                    </router-link>
                    <button class="btn btn-danger" @click="remove(product.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                    </button>
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
import urls from '../services/apiURLs.js'
    export default {
        data(){
                return{                    
                    products:[],
                    categories:[],
                    imageServerURL:urls.imageServerURL,
                }    
                
            },
        beforeCreate() {
            console.log('Component mounted.');
            axios.get(`${urls.getProductsURL}`).then(productResponse => {
            this.products = productResponse.data;
            })
        },
        methods:{
            remove(id){
                console.log(this.products);
                
                axios.delete(`${urls.deleteProductURL}${id}`).then(productResponse => {
                        let i = this.products.findIndex(item => item.id === id );
                        console.log(i);
                        this.products.splice(i,1);
                        console.log(productResponse);
                        console.log(this.products);
                } )          
            },
            visable(id){
                const that = this;
                let i = this.products.findIndex(item => item.id === id );
                console.log(this.products[i]);
                that.products[i].available = this.products[i].available ? 0 : 1;
                console.log(that.products[i].available);
                axios.put(`${urls.putProductAvailableURL}${id}`,{'available':that.products[i].available},{}).then(productResponse => {
                        console.log(productResponse);
                        console.log(this.products);
                } )
            }
        
        }
        
    }
</script>



<style scoped>
th, td {
    text-align: center;
    vertical-align: middle;
}
</style>
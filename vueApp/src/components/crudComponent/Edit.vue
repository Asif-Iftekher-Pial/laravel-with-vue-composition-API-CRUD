<template>
    <div>
        <h2>Update Product</h2>
        <form @submit.prevent="update" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" v-model="product.name" id="exampleFormControlInput1"
                    placeholder="name">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" v-model="product.description" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label mb-0">Image</label>
                <br>See previous image <a :href="product.image_url" target="_blank">click here</a>
                <input type="file" class="form-control" v-on:change="onChange"  id="exampleFormControlInput1">
            </div>
            <button type="submit" class="btn btn-sm btn-success">Save</button>
        </form>

    </div>
</template>

<script lang="ts">
import apiClient from '../../router/axios';
export default {
    data(){
        return {
            product:{
                name:'',
                description:'',
                image:'',
                image_url:''
            }
        }
    },
    async mounted(){
        
        const data = await apiClient.get('/api/edit-products/'+this.$route.params.id)
        // console.log(data.data);
        // console.log(this.$route.params.id);
        this.product = data.data;
    },
    methods:{
        onChange(e){
            this.product.image = e.target.files[0]
            // console.log(this.product.image);
        },

        update(){

            const config = {
                headers: {
                    'content_type': 'multipart/form-data'
                }
            }
            const formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('image', this.product.image);


            apiClient.post('/api/update-products/'+this.$route.params.id, formData, config)
            .then(response => {
                // console.log(response);
                this.$router.push('/product-list')
            })
            .catch(error => {
                console.log(error);
            });
        }
        
    }
    
}
</script>

<style lang="scss" scoped>

</style>
<template>
    <div>
        <h2>Product List</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <th scope="row">{{ item.id }}</th>
                    <td><img :src="item.image_url" alt="Product Image" width="80" height="80"></td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.description }}</td>
                    <td>
                        <router-link :to="'/product-edit/' + item.id">
                            <button class="btn btn-sm btn-outline-warning">edit</button>
                        </router-link>

                        <button class="btn btn-sm btn-outline-danger ms-2" @click="deleteData(item.id)">delete</button>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import apiClient from '../router/axios';
export default {
    name: "ProductList",
    data() {
        return {
            items: []
        }
    },
    methods: {
        async getData() {
            apiClient.get('/api/all-products')
                .then(response => {
                    // console.log(response);
                    this.items = response.data.data
                })
                .catch(error => {
                    console.log(error);
                })
        },
        deleteData(id) {
            // console.log(id);
            apiClient.get('/api/delete-product/'+id)
            .then(response => {
                console.log(response);
                this.getData()
            })
            .catch(error => {
                console.log(error);
            })
        }

    },
    mounted() {
        this.getData()
    }
}
</script>

<style lang="scss" scoped></style>
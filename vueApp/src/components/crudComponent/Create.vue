<template>
    <div>
        <h2>Create Product</h2>
        <form @submit.prevent="save" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" class="form-control" v-model="product.name" id="exampleFormControlInput1"
                    placeholder="name">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" v-model="product.description" id="exampleFormControlTextarea1"
                    rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Image</label>
                <input type="file" class="form-control" v-on:change="onChange" id="exampleFormControlInput1">
            </div>
            <button type="submit" class="btn btn-sm btn-success">Save</button>
        </form>

    </div>
</template>

<script>
import apiClient from '../../router/axios';
export default {
    data() {
        return {
            product: {
                name: '',
                description: '',
                image: null,
            }
        }
    },
    methods: {
        onChange(e) {
            this.product.image = e.target.files[0];
        },
        save() {
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }

            const formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('description', this.product.description);
            formData.append('image', this.product.image);

            apiClient.post('/api/product-create', formData, config)
                .then(response => {
                    // console.log(response);
                    this.resetFields();
                    this.$router.push('/product-list');
                })
                .catch(error => {
                    console.log(error);
                })
        },
        resetFields() {
            this.product.name = '';
            this.product.description = '';
            this.product.image = null;
        }
    }
}
</script>

<style lang="scss" scoped></style>
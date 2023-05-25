<template>
    <button data-bs-toggle="modal" data-bs-target="#addProductModal">Add</button>
    <h2>dashboard</h2>

    <div v-if="deleteMessage" :class="{'alert': true, 'alert-danger': !deleteMessage.isSuccess, 'alert-success': deleteMessage.isSuccess}">
        <strong>{{ deleteMessage.message }}</strong>
    </div>

    <!-- <table class="table table-striped"> -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Created_at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="product in products" :key="product">
                <td>{{ product.product_id }}</td>
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
                <td>{{ product.description }}</td>
                <td>{{ formatDate(product.created_at) }}</td>
                <td>
                    <a href="" @click="viewSpecificProduct(product.product_id)" data-bs-toggle="modal" data-bs-target="#viewProductModal"><i class="bi bi-eye-fill"></i> View</a>
                    <a href=""><i class="bi bi-pencil-square"></i> Edit</a>
                    <a href="" @click="deleteProduct(product.product_id)"><i class="bi bi-trash-fill"></i> Delete</a>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Modal for Adding Product -->
    <div class="modal fade" id="addProductModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">test</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div v-if="resultMessage" :class="{'alert': true, 'alert-danger': !resultMessage.isSuccess, 'alert-success': resultMessage.isSuccess}">
                    <strong>{{ resultMessage.message }}</strong>
                </div>
                <form action="/action_page.php">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" placeholder="Enter name" v-model="name">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="text" class="form-control" placeholder="Enter price" v-model="price">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description:</label>
                        <textarea class="form-control" rows="5" v-model="description"></textarea> 
                    </div>
                    <div class="d-grid">
                        <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                            <span class="spinner-grow spinner-grow-sm"></span>
                            Adding...
                        </button>
                        <button v-else @click.prevent="addProduct" type="submit" class="btn btn-primary btn-block">Add</button>
                    </div>
                </form> 
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>

    <!-- Modal for Viewing Product -->
    <div class="modal fade" id="viewProductModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">View</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">{{ this.viewProduct.product_id }}</li>
                    <li class="list-group-item">{{ this.viewProduct.name }}</li>
                    <li class="list-group-item">{{ this.viewProduct.price }}</li>
                    <li class="list-group-item">{{ this.viewProduct.description }}</li>
                    <li class="list-group-item">{{ this.viewProduct.created_at }}</li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>

</template>

<script>
import axiosRes from '@/main';

export default {
    data() {
        return {
            loadingState: false,
            name: '',
            price: '',
            description: '',
            resultMessage: '',
            deleteMessage: '',
            products: '',
            viewProduct: ''
        }
    },
    methods: {
        deleteProduct(ID) {
            const formData = new FormData();
            formData.append('productID', ID)

            if(confirm('Are you sure you want to delete?')) {
                axiosRes.post('/deleteProduct', formData).then(res => {
                    if(res.data.success) {
                        this.deleteMessage = {
                            message: res.data.result,
                            isSuccess: true
                        };
                    }else {
                        return;
                    }
                });
            }else {
                return
            }
        },
        viewSpecificProduct(ID) {
            this.products.forEach(res => {
                if(res.product_id === ID) {
                    this.viewProduct = res;
                }
            });
        },
        addProduct() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('price', this.price);
            formData.append('description', this.description);

            axiosRes.post('/addProduct', formData).then(res => {
                this.loadingState = false;
                this.resultMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.name = '';
                    this.price = '';
                    this.description = '';
                }
            });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const formattedDate = date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            });
            return formattedDate;
        }
    },
    mounted() {
        axiosRes.get('/fetchProduct').then(res => {
            this.products = res.data.result;
        });
    }
}
</script>

<style scoped>
.alert{text-align: center;}
</style>
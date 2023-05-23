<template>
    <div class="container">
        <div class="form_wrap">
            <h2>Register</h2>
            <div v-if="errorMessage" class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>{{ errorMessage }}</strong>
            </div>
            <div v-if="successMessage" class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong>{{ successMessage }}</strong>
            </div>
            <form>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" v-model="password" class="form-control" placeholder="Password">
                </div>
                <div class="d-grid">
                    <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button v-else @click.prevent="register" type="submit" class="btn btn-primary btn-block">Submit</button>
                </div>
            </form> 
        </div>
    </div>
</template>

<script>
import axiosRes from '@/main';

export default {
    data() {
        return {
            loadingState: false,
            email: '',
            password: '',
            errorMessage: '',
            successMessage: ''
        }
    },
    methods: {
        register() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);

            axiosRes.post('/register', formData).then(res => {
                if(!res.data.success) {
                    this.errorMessage = res.data.result; 
                    this.loadingState = false;
                    return;
                }

                this.loadingState = false;
                this.successMessage = res.data.result;
                this.email = '';
                this.password = '';
            });
        },
    }
}
</script>

<style scoped>
.form_wrap{width: 400px; max-width: 100%; position: absolute; top: 50%; transform: translateY(-50%); box-shadow: 0px 0px 5px #e1e1e1; padding: 12px; border-radius: 12px;}
.input-group{margin: 12px 0;}
</style>
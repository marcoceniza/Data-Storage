<template>
    <div class="container">
        <div class="form_wrap">
            <div v-if="resultMessage" :class="{'alert': true, 'alert-danger': !resultMessage.isSuccess, 'alert-success': resultMessage.isSuccess}">
                <strong>{{ resultMessage.message }}</strong>
            </div>
            <h2>Login</h2>
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
                    <button v-else @click.prevent="login" type="submit" class="btn btn-primary btn-block">Login</button>
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
            resultMessage: '',
        }
    },
    methods: {
        login() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);

            axiosRes.post('/login', formData).then(res => {
                this.loadingState = false;
                this.resultMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) setTimeout(() => { this.$router.push('/orders') }, 1000);
            });
        },
    }
}
</script>

<style scoped>
.form_wrap{width: 400px; max-width: 100%; position: absolute; top: 50%; transform: translateY(-50%); box-shadow: 0px 0px 5px #e1e1e1; padding: 12px; border-radius: 12px;}
.input-group{margin: 12px 0;}
.alert{text-align: center;}
</style>
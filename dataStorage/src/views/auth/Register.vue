<template>
    <div class="container">
        <div class="form_wrap">
            <div v-if="resultMessage" :class="{'alert': true, 'alert-danger': !resultMessage.isSuccess, 'alert-success': resultMessage.isSuccess}">
                <strong>{{ resultMessage.message }}</strong>
            </div>
            <h2>Register</h2>
            <hr>
            <form>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input :type="inputType" v-model="password" class="form-control" placeholder="Password">
                    <p class="showPassIcon">
                        <i @click="showPassHandler" v-if="inputType == 'password'" class="bi bi-eye-fill"></i>
                        <i @click="showPassHandler" v-else class="bi bi-eye-slash-fill"></i>
                    </p>
                </div>
                <div class="d-grid">
                    <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Loading...
                    </button>
                    <button v-else @click.prevent="register" type="submit" class="btn btn-primary btn-block">Sign Up</button>
                </div>
                <p>Already Registered? <a href="javascript:;" @click="$router.push('/')">Sign In</a></p>
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
            inputType: 'password'
        }
    },
    methods: {
        showPassHandler() {
            this.inputType == 'password' ? this.inputType = 'text' : this.inputType = 'password';
        },
        register() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('email', this.email);
            formData.append('password', this.password);

            axiosRes.post('/register', formData).then(res => {
                this.loadingState = false;
                this.resultMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };
            });
        },
    }
}
</script>

<style scoped>
form{margin-top: 30px;}
.form_wrap{width: 320px; max-width: 100%; position: absolute; top: 50%; transform: translateY(-50%); box-shadow: 0px 0px 5px #e1e1e1; padding: 12px; border-radius: 12px;left: 0; right: 0; margin: 0 auto;}
.form_wrap p{text-align: center; margin: 25px auto 0; font-size: 12px;}
.form_wrap p a{color: #ff1212; font-weight: bold;}
.form_wrap p a:hover{text-decoration: none; background: none;}
.form_wrap h2{text-align: center; font-size: 25px;}
.input-group{margin: 15px 0;}
.alert{text-align: center;}
.d-grid{margin-top: 25px;}
.showPassIcon i{position: absolute; right: 8px; top: 10px; z-index: 12; background: #fff; padding-left: 4px;cursor: pointer;}
</style>
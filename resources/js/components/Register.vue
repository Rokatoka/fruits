<template>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form">
                            <h3 class="text-center text-info">Register</h3>
                            <div class="form-group">
                                <label class="text-info">
                                    Name:
                                </label><br>
                                <input type="text" class="form-control" :class="{'is-invalid': errors.name}" v-model="name">
                            </div>
                            <div class="form-group">
                                <label class="text-info">
                                    Email:
                                </label><br>
                                <input type="text" class="form-control" :class="{'is-invalid': errors.email}" v-model="email">
                            </div>
                            <div class="form-group">
                                <label class="text-info">
                                    Password:
                                </label><br>
                                <input type="password" class="form-control" :class="{'is-invalid': errors.password}" v-model="password">
                            </div>
                            <div class="form-group">
                                <label class="text-info">Repeat Password:</label><br>
                                <input type="password" class="form-control" v-model="repeat_password">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-info btn-md"
                                        :disabled="password !== repeat_password"
                                        @click.prevent="register()">
                                    Submit
                                </button>
                            </div>
                            <div id="register-link" class="text-right">
                                <router-link :to="{name: 'login'}">Login</router-link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{
                name: '',
                email: '',
                password: '',
                repeat_password: '',
                errors: {}
            }
        },

        methods:{
            register(){
                let _this = this;
                _this.errors = {};
                let form = {
                    name: _this.name,
                    email: _this.email,
                    password: _this.password
                };
                axios.post('/api/register', form).then(()=>{
                    _this.newUserInit()
                }).catch((error)=>{
                    _this.errors = error.response.data.message;
                });
            },

            newUserInit(){
                let _this = this;
                let secret = document.head.querySelector('meta[name="client-secret"]');
                let data = {
                    client_id: 2,
                    client_secret: secret.content,
                    grant_type: 'password',
                    username: _this.email,
                    password: _this.password
                };
                axios.post('/oauth/token', data).then((response)=>{
                    _this.error = false;
                    localStorage.setItem('access_token', response.data.access_token);
                    let get_user = _this.$auth.setUser();
                    get_user.then((val) => {
                        _this.$router.push({name: 'fruitApplication'})
                    })
                }).catch(()=>{
                    _this.error = true;
                });
            }
        }
    }
</script>

<style scoped>
    body {
        margin: 0;
        padding: 0;
        background-color: #17a2b8;
        height: 100vh;
    }
    #login .container #login-row #login-column #login-box {
        margin-top: 120px;
        max-width: 600px;
        height: 480px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
    }
    #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
    }
    #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -50px;
    }
</style>
